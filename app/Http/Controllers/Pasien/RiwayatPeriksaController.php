<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JanjiPeriksa;

/**
 * Controller untuk mengelola riwayat pemeriksaan pasien
 * 
 * @package App\Http\Controllers\Pasien
 */
class RiwayatPeriksaController extends Controller
{
    /**
     * Menampilkan daftar riwayat pemeriksaan pasien
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    { 
        $no_rm = Auth::user()->no_rm; 
        $janjiPeriksas = JanjiPeriksa::where('id_pasien', Auth::user()->id)->get(); 
 
        return view('pasien.riwayat-periksa.index')->with([ 
            'no_rm' => $no_rm, 
            'janjiPeriksas' => $janjiPeriksas, 
        ]); 
    } 
 
    /**
     * Menampilkan detail riwayat pemeriksaan pasien
     * 
     * @param int $id ID janji periksa
     * @return \Illuminate\Http\Response
     */
    public function detail($id) 
    { 
        $janjiPeriksa = JanjiPeriksa::with(['jadwalPeriksa.dokter'])->findOrFail($id); 
 
        return view('pasien.riwayat-periksa.detail')->with([ 
            'janjiPeriksa' => $janjiPeriksa, 
        ]); 
    } 
 
    /**
     * Menampilkan detail riwayat pemeriksaan pasien dengan data dokter
     * 
     * @param int $id ID janji periksa
     * @return \Illuminate\Http\Response
     */
    public function riwayat($id) 
    { 
        $janjiPeriksa = JanjiPeriksa::with([
            'jadwalPeriksa.dokter',
            'periksa.detailPeriksas.obat'
        ])->findOrFail($id);

        return view('pasien.riwayat-periksa.riwayat')->with([
            'janjiPeriksa' => $janjiPeriksa,
        ]);
    }
}
