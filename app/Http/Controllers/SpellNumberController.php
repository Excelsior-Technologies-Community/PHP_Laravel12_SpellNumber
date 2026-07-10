<?php

namespace App\Http\Controllers;

use App\Models\Conversion;
use Illuminate\Http\Request;
use Rmunate\Utilities\SpellNumber;

class SpellNumberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'newest');
        $filter = $request->input('filter', 'all');
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');

        $query = Conversion::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('number', 'like', "%$search%")
                  ->orWhere('words', 'like', "%$search%");
            });
        }

        if ($filter === 'favorites') {
            $query->where('is_favorite', true);
        }

        if ($date_from) {
            $query->whereDate('created_at', '>=', $date_from);
        }
        if ($date_to) {
            $query->whereDate('created_at', '<=', $date_to);
        }

        switch ($sort) {
            case 'oldest':
                $query->orderBy('id', 'asc');
                break;
            case 'num_asc':
                $query->orderBy('number', 'asc');
                break;
            case 'num_desc':
                $query->orderBy('number', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $history = $query->paginate(12)->withQueryString();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'html' => view('partials.history-items', compact('history'))->render(),
                'pagination' => $history->links()->render()
            ]);
        }

        return view('spellnumber', compact('history', 'search', 'sort', 'filter', 'date_from', 'date_to'));
    }

    public function convert(Request $request)
    {
        $request->validate([
            'number' => 'required|numeric'
        ]);

        $number = (float) $request->input('number');
        $locale = $request->input('locale', 'en');
        $mode = $request->input('mode', 'plain');
        $currency = $request->input('currency', 'USD');

        try {
            $spellInstance = SpellNumber::value($number)->locale($locale);
            
            if ($mode === 'currency') {
                if ($currency === 'INR') {
                    $spell = $spellInstance->toCurrencyINR();
                } elseif ($currency === 'EUR') {
                    $spell = $spellInstance->toCurrencyEUR();
                } elseif ($currency === 'GBP') {
                    $spell = $spellInstance->toCurrencyGBP();
                } else {
                    $spell = $spellInstance->toCurrencyUSD();
                }
            } else {
                $spell = $spellInstance->toLetters();
            }
        } catch (\Exception $e) {
            $spell = "Conversion configuration error: " . $e->getMessage();
        }

        $conversion = Conversion::create([
            'number' => $number,
            'words' => $spell,
            'locale' => $locale,
            'mode' => $mode,
            'currency' => $mode === 'currency' ? $currency : null,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Number processed successfully!',
                'data' => $conversion
            ]);
        }

        return redirect()->back()->with('success', 'Converted successfully!');
    }

    public function livePreview(Request $request)
    {
        $number = $request->input('number');
        if (!is_numeric($number)) {
            return response()->json(['words' => '']);
        }

        $number = (float) $number;
        $locale = $request->input('locale', 'en');
        $mode = $request->input('mode', 'plain');
        $currency = $request->input('currency', 'USD');

        try {
            $spellInstance = SpellNumber::value($number)->locale($locale);
            
            if ($mode === 'currency') {
                if ($currency === 'INR') {
                    $words = $spellInstance->toCurrencyINR();
                } elseif ($currency === 'EUR') {
                    $words = $spellInstance->toCurrencyEUR();
                } elseif ($currency === 'GBP') {
                    $words = $spellInstance->toCurrencyGBP();
                } else {
                    $words = $spellInstance->toCurrencyUSD();
                }
            } else {
                $words = $spellInstance->toLetters();
            }
        } catch (\Exception $e) {
            $words = 'Processing current notation layout...';
        }

        return response()->json(['words' => $words]);
    }

    public function toggleFavorite($id)
    {
        $conversion = Conversion::findOrFail($id);
        $conversion->is_favorite = !$conversion->is_favorite;
        $conversion->save();

        return response()->json([
            'success' => true,
            'is_favorite' => $conversion->is_favorite
        ]);
    }

    public function destroy($id)
    {
        Conversion::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Record removed successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            Conversion::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Selected items cleared.']);
        }
        return response()->json(['success' => false, 'message' => 'No items selected.'], 420);
    }

    public function clearAll()
    {
        Conversion::truncate();
        return redirect()->back()->with('success', 'All history structural variants wiped!');
    }

    public function exportCsv()
    {
        $records = Conversion::orderBy('id', 'desc')->get();
        $csvFileName = 'conversions_export_' . time() . '.csv';
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Number', 'Spelled Words', 'Locale', 'Mode', 'Currency', 'Timestamp'];

        $callback = function() use($records, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($records as $record) {
                fputcsv($file, [
                    $record->id,
                    $record->number,
                    $record->words,
                    $record->locale,
                    $record->mode,
                    $record->currency ?? 'N/A',
                    $record->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}