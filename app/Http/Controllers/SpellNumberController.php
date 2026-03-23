<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversion;
use Rmunate\Utilities\SpellNumber;

class SpellNumberController extends Controller
{
    public function index()
    {
        $history = Conversion::latest()->get();
        return view('spellnumber', compact('history'));
    }

    public function convert(Request $request)
    {
        $request->validate([
            'number' => 'required|numeric'
        ]);

        $number = $request->input('number');

        $spell = SpellNumber::value($number)->toLetters();

        // Save to database
        Conversion::create([
            'number' => $number,
            'words' => $spell,
        ]);

        return redirect()->back()->with('success', "The number {$number} is spelled as: {$spell}");
    }
}
