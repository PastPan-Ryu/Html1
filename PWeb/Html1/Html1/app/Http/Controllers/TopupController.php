<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    public function index()
    {
        return view('topup');
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:100|max:1000000',
        ]);

        $user = Auth::user();
        $user->points += $validated['amount'];
        $user->save();

        return redirect()->route('topup')->with('success', 'Berhasil melakukan topup sebesar 💎 ' . number_format($validated['amount'], 0, ',', '.') . ' Point!');
    }
}
