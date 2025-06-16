<!-- 
    View ini menampilkan halaman utama manajemen janji periksa pasien dengan dua bagian utama:
    1. Form untuk membuat janji periksa baru
    2. Daftar riwayat janji periksa yang sudah dibuat

    Fungsi utama:
    - Memungkinkan pasien membuat janji periksa baru dengan dokter
    - Menampilkan daftar janji periksa yang sudah dibuat
    - Menampilkan status pemeriksaan (belum/sudah diperiksa)
    - Menampilkan detail pemeriksaan termasuk obat yang diresepkan
    - Menampilkan biaya pemeriksaan
--> 

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Janji Periksa') }}
        </h2>
    </x-slot>

    <!-- Form untuk membuat janji periksa baru -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <!-- Bagian form baru -->
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Buat Janji Periksa') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Atur jadwal pertemuan dengan dokter untuk mendapatkan layanan konsultasi dan pemeriksaan kesehatan sesuai kebutuhan Anda.') }}
                            </p>
                        </header>

                        <!-- Form untuk membuat janji periksa -->
                        <form class="mt-6" action="{{ route('pasien.janji-periksa.store') }}" method="POST">
                            @csrf
                            <!-- Input nomor rekam medis -->
                            <div class="form-group">
                                <label for="formGroupExampleInput">Nomor Rekam Medis</label>
                                <input type="text" class="form-control rounded" id="formGroupExampleInput" placeholder="Example input" value="{{ $no_rm }}" readonly>
                            </div>
                            <!-- Select dokter dengan jadwal -->
                            <div class="form-group">
                                <label for="dokterSelect">Dokter</label>
                                <select class="form-control" name="id_dokter" id="dokterSelect" required>
                                    <option>Pilih Dokter</option>
                                    @foreach ($dokters as $dokter)
                                        @foreach ($dokter->jadwalPeriksas as $jadwal)
                                            <option value="{{ $dokter->id }}">
                                                {{ $dokter->nama }} - Spesialis {{ $dokter->poli }} | 
                                                {{ $jadwal->hari }},
                                                {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H.i') }} - 
                                                {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H.i') }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <!-- Input keluhan -->
                            <div class="form-group">
                                <label for="keluhan">Keluhan</label>
                                <textarea class="form-control" name="keluhan" id="keluhan" rows="3" required></textarea>
                            </div>
                            <!-- Button submit -->
                            <div class="flex items-center gap-4">
                                <button type="submit" class="btn btn-primary">Submit</button>

                                @if (session('status') === 'janji-periksa-created')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                                        {{ __('Berhasil Dibuat.') }}
                                    </p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>