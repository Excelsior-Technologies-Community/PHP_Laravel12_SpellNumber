<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversion;
use Rmunate\Utilities\SpellNumber;

class SpellNumberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $history = Conversion::when($search, function ($query) use ($search) {
                $query->where('number', 'like', "%$search%")
                      ->orWhere('words', 'like', "%$search%");
            })
            ->oldest()
            ->paginate(4);

        return view('spellnumber', compact('history', 'search'));
    }

    public function convert(Request $request)
    {
        $request->validate([
            'number' => 'required|numeric'
        ]);

        $number = $request->number;
        $spell = SpellNumber::value($number)->toLetters();

        Conversion::create([
            'number' => $number,
            'words' => $spell,
        ]);

        return redirect()->back()->with('success', 'Converted successfully!');
    }

    public function destroy($id)
    {
        Conversion::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully!');
    }

    public function clearAll()
    {
        Conversion::truncate();
        return redirect()->back()->with('success', 'All history cleared!');
    }
}