<?php

namespace App\Http\Controllers;

use App\Models\AkunGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $akuns = AkunGame::where('penjual', $user->username)->orderBy('created_at', 'desc')->get();
        $totalIklan = $akuns->where('status', 'Tersedia')->count();
        $totalTerjual = $akuns->where('status', 'Terjual')->count();

        return view('profile', compact('totalIklan', 'totalTerjual'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $oldUsername = $user->username;

        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $filename);
            
            // Delete old photo if it exists
            if ($user->foto && file_exists(public_path('uploads/profiles/' . $user->foto))) {
                unlink(public_path('uploads/profiles/' . $user->foto));
            }
            
            $user->foto = $filename;
        }

        $user->save();

        if ($oldUsername !== $user->username) {
            AkunGame::where('penjual', $oldUsername)->update(['penjual' => $user->username]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function myPosts()
    {
        $user = Auth::user();
        $akuns = AkunGame::where('penjual', $user->username)->orderBy('created_at', 'desc')->get();
        return view('myposts', compact('akuns'));
    }

    public function myGames()
    {
        $user = Auth::user();
        $akuns = AkunGame::where('pembeli', $user->username)->orderBy('updated_at', 'desc')->get();
        return view('mygames', compact('akuns'));
    }
}
