<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JadwalPeriksa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return redirect()->route('dokter.profile.edit');
    }

    public function edit()
    {
        $user = User::findOrFail(Auth::user()->id);
        $jadwalPeriksas = JadwalPeriksa::where('id_dokter', $user->id)->get();
        return view('dokter.profile.edit', compact('user', 'jadwalPeriksas'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'alamat' => 'nullable|string|max:255',
            'no_ktp' => 'nullable|string|max:20',
            'no_hp' => 'nullable|string|max:20',
            'no_rm' => 'nullable|string|max:20',
            'poli' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update user data
        $user->update($validated);

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully');
    }
}