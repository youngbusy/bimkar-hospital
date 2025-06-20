<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request; 

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::orderBy('nama_obat')->paginate(10); // Obat aktif
        $obatTerhapus = Obat::onlyTrashed()->get(); // Obat yang di-soft delete

        return view('dokter.obat.index', compact('obats', 'obatTerhapus'));
    }

    public function create()
    {
        return view('dokter.obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:50',
            'kemasan' => 'required|string|max:35',
            'harga' => 'required|integer|min:0',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
        ]);

        return redirect()->route('dokter.obat.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    public function edit(Obat $obat)
    {
        return view('dokter.obat.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'nama_obat' => 'required|string|max:50',
            'kemasan' => 'required|string|max:35',
            'harga' => 'required|integer|min:0',
        ]);

        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
        ]);

        return redirect()->route('dokter.obat.index')
            ->with('success', 'Obat berhasil diperbarui');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();
        return redirect()->route('dokter.obat.index')
            ->with('success', 'Obat berhasil dihapus');
    }

    public function restoreAll()
    {
        Obat::onlyTrashed()->restore();

        return redirect()->route('dokter.obat.index')
        ->with('success', 'Semua obat berhasil dipulihkan.');
    }

    public function restore($id)
    {
        $obat = Obat::onlyTrashed()->findOrFail($id);
        $obat->restore();

        return redirect()->route('dokter.obat.index')
            ->with('success', 'Obat berhasil dipulihkan');
    }

    public function forceDelete($id)
    {
        $obat = Obat::onlyTrashed()->findOrFail($id);
        $obat->forceDelete();

        return redirect()->route('dokter.obat.index')
            ->with('success', 'Obat dihapus permanen');
    }
}
