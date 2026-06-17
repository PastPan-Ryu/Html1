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
            'amount' => 'required|integer|min:10|max:1000000',
        ]);

        $user = Auth::user();
        $user->points += $validated['amount'];
        $user->save();

        return redirect()->route('topup')->with('success', 'Berhasil melakukan topup sebesar 💎 ' . number_format($validated['amount'], 0, ',', '.') . ' Point!');
    }

    public function withdraw(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'withdraw_amount'  => 'required|integer|min:100|max:' . $user->points,
            'withdraw_method'  => 'required|string',
            'withdraw_account' => 'required|string',
        ]);

        if ($user->points < $validated['withdraw_amount']) {
            return redirect()->route('topup')->with('error', 'Saldo tidak cukup untuk melakukan penarikan.');
        }

        $user->points -= $validated['withdraw_amount'];
        $user->save();

        return redirect()->route('topup')->with('success', 'Berhasil menarik 💎 ' . number_format($validated['withdraw_amount'], 0, ',', '.') . ' Point ke ' . $validated['withdraw_account'] . '!');
    }
}
