<?php

namespace App\Http\Controllers;

use App\Models\AkunGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class AkunGameController extends Controller
{
    public function index(Request $request)
    {
        $query = AkunGame::where('status', 'Tersedia')->orderBy('created_at', 'desc');
        
        if ($request->has('game') && !empty($request->game)) {
            $query->where('game', $request->game);
        }

        $akuns = $query->get();
        return view('home', compact('akuns'));
    }

    public function checkout($id_akun)
    {
        $akun = AkunGame::findOrFail($id_akun);
        
        if ($akun->status !== 'Tersedia') {
            return redirect()->route('home')->with('error', 'Account is no longer available.');
        }

        if ($akun->penjual === Auth::user()->username) {
            return redirect()->route('home')->with('error', 'You cannot buy your own account.');
        }

        return view('checkout', compact('akun'));
    }

    public function processCheckout(Request $request, $id_akun)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $akun = AkunGame::findOrFail($id_akun);
        $buyer = Auth::user();

        if ($akun->status !== 'Tersedia') {
            return redirect()->route('home')->with('error', 'Account is no longer available.');
        }

        if ($akun->penjual === $buyer->username) {
            return redirect()->route('home')->with('error', 'You cannot buy your own account.');
        }

        if ($buyer->points < $akun->harga) {
            return redirect()->back()->with('error', 'Insufficient Game Vault Points. Please top up.');
        }

        DB::beginTransaction();
        try {
            // Deduct from buyer
            $buyer->points -= $akun->harga;
            $buyer->save();

            // Add to seller
            $seller = User::where('username', $akun->penjual)->first();
            if ($seller) {
                $seller->points += $akun->harga;
                $seller->save();
            }

            // Update account
            $akun->status = 'Terjual';
            $akun->pembeli = $buyer->username;
            $akun->email_pembeli = $request->email;
            $akun->save();

            DB::commit();

            return redirect()->route('mygames')->with('success', 'Purchase successful! Account details will be sent to your email.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred during purchase. Please try again.');
        }
    }

    public function create()
    {
        return view('jualakun');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_akun'      => 'required|string|max:100',
            'game'           => 'required|string|max:100',
            'level'          => 'nullable|integer',
            'rank'           => 'nullable|string|max:50',
            'harga'          => 'required|integer',
            'kontak'         => 'required|string|max:50',
            'foto'           => 'nullable|array|max:5',
            'foto.*'         => 'image|max:5120', // max 5MB per file
            'deskripsi'      => 'nullable|string',
            'login_email'    => 'required|string|max:255',
            'login_password' => 'required|string|max:255'
        ]);

        $fotoNames = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $fotoName = time() . '_' . uniqid() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('uploads'), $fotoName);
                $fotoNames[] = $fotoName;
            }
        }

        AkunGame::create([
            'id_akun'        => Str::random(10),
            'nama_akun'      => $validated['nama_akun'],
            'game'           => $validated['game'],
            'level'          => $validated['level'] ?? null,
            'rank'           => $validated['rank'] ?? null,
            'harga'          => $validated['harga'],
            'tanggal'        => date('Y-m-d'),
            'penjual'        => Auth::user()->username,
            'kontak'         => $validated['kontak'],
            'foto'           => !empty($fotoNames) ? $fotoNames : null,
            'deskripsi'      => $validated['deskripsi'] ?? null,
            'login_email'    => $validated['login_email'],
            'login_password' => $validated['login_password'],
            'status'         => 'Tersedia'
        ]);

        return redirect()->route('home')->with('success', 'Akun berhasil ditambahkan!');
    }

    public function markAsSold($id_akun)
    {
        $akun = AkunGame::where('id_akun', $id_akun)->where('penjual', Auth::user()->username)->firstOrFail();
        $akun->update(['status' => 'Terjual']);
        return back()->with('success', 'Status akun diubah menjadi Terjual!');
    }

    public function edit($id_akun)
    {
        $akun = AkunGame::where('id_akun', $id_akun)->where('penjual', Auth::user()->username)->firstOrFail();
        return view('editakun', compact('akun'));
    }

    public function update(Request $request, $id_akun)
    {
        $akun = AkunGame::where('id_akun', $id_akun)->where('penjual', Auth::user()->username)->firstOrFail();

        $validated = $request->validate([
            'nama_akun' => 'required|string|max:100',
            'game'      => 'required|string|max:100',
            'level'     => 'nullable|integer',
            'rank'      => 'nullable|string|max:50',
            'harga'     => 'required|integer',
            'kontak'    => 'required|string|max:50',
            'foto'      => 'nullable|array|max:5',
            'foto.*'    => 'image|max:5120', // max 5MB per file
            'deskripsi' => 'nullable|string'
        ]);

        if ($request->hasFile('foto')) {
            $fotoNames = [];
            foreach ($request->file('foto') as $foto) {
                $fotoName = time() . '_' . uniqid() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('uploads'), $fotoName);
                $fotoNames[] = $fotoName;
            }
            $akun->foto = $fotoNames;
        }

        $akun->nama_akun = $validated['nama_akun'];
        $akun->game      = $validated['game'];
        $akun->level     = $validated['level'];
        $akun->rank      = $validated['rank'];
        $akun->harga     = $validated['harga'];
        $akun->kontak    = $validated['kontak'];
        $akun->deskripsi = $validated['deskripsi'];
        $akun->save();

        return redirect()->route('profile')->with('success', 'Iklan akun berhasil diperbarui!');
    }
}
