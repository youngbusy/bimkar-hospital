<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Janji Periksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Buat Janji Periksa') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Atur jadwal pertemuan dengan dokter untuk mendapatkan layanan konsultasi dan pemeriksaan kesehatan sesuai kebutuhan Anda.') }}
                            </p>
                        </header>

                        <form class="mt-6" action="{{ route('pasien.janji-periksa.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="formGroupExampleInput">Nomor Rekam Medis</label>
                                <input type="text" class="form-control rounded" id="formGroupExampleInput" placeholder="Example input" value="{{ $no_rm }}" readonly>
                            </div>
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
                            <div class="form-group">
                                <label for="keluhan">Keluhan</label>
                                <textarea class="form-control" name="keluhan" id="keluhan" rows="3" required></textarea>
                            </div>
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

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Riwayat Janji Periksa') }}
                        </h2>
                    </header>

                    <table class="table table-hover rounded overflow-hidden mt-6">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Poliklinik</th>
                                <th scope="col">Dokter</th>
                                <th scope="col">Hari</th>
                                <th scope="col">Mulai</th>
                                <th scope="col">Selesai</th>
                                <th scope="col">Antrian</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($janjiPeriksas as $janjiPeriksa)
                                <tr>
                                    <th scope="row" class="align-middle text-start">{{ $loop->iteration }}</th>
                                    <td class="align-middle text-start">{{ $janjiPeriksa->jadwalPeriksa->dokter->poli }}</td>
                                    <td class="align-middle text-start">{{ $janjiPeriksa->jadwalPeriksa->dokter->nama }}</td>
                                    <td class="align-middle text-start">{{ $janjiPeriksa->jadwalPeriksa->hari }}</td>
                                    <td class="align-middle text-start">{{ \Carbon\Carbon::parse($janjiPeriksa->jadwalPeriksa->jam_mulai)->format('H.i') }}</td>
                                    <td class="align-middle text-start">{{ \Carbon\Carbon::parse($janjiPeriksa->jadwalPeriksa->jam_selesai)->format('H.i') }}</td>
                                    <td class="align-middle text-start">{{ $janjiPeriksa->no_antrian }}</td>
                                    <td class="align-middle text-start">
                                        @if (is_null($janjiPeriksa->periksa))
                                            <span class="badge badge-pill badge-warning">Belum Diperiksa</span>
                                        @else
                                            <span class="badge badge-pill badge-success">Sudah Diperiksa</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-start">
                                        @if (is_null($janjiPeriksa->periksa))
                                            <button type="submit" class="btn btn-info" data-toggle="modal" data-target="#detailModal">Detail</button>

                                            <div class="modal fade bd-example-modal-lg" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title font-weight-bold" id="riwayatModalLabel">Detail Riwayat Pemeriksaan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <ul class="list-group">
                                                                <li class="list-group-item">
                                                                    <strong>Poliklinik:</strong> {{ $janjiPeriksa->jadwalPeriksa->dokter->poli }}
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Nama Dokter:</strong> {{ $janjiPeriksa->jadwalPeriksa->dokter->nama }}
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Hari Pemeriksaan:</strong> {{ $janjiPeriksa->jadwalPeriksa->hari }}
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Jam Mulai:</strong> {{ \Carbon\Carbon::parse($janjiPeriksa->jadwalPeriksa->jam_mulai)->format('H.i') }}
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Jam Selesai:</strong> {{ \Carbon\Carbon::parse($janjiPeriksa->jadwalPeriksa->jam_selesai)->format('H.i') }}
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>No Antrian:</strong> {{ $janjiPeriksa->no_antrian }}
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Keluhan:</strong> {{ $janjiPeriksa->keluhan }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <button type="submit" class="btn btn-secondary" data-toggle="modal" data-target="#modalRiwayatPeriksa">Riwayat</button>

                                            <div class="modal fade" id="modalRiwayatPeriksa" tabindex="-1" aria-labelledby="modalRiwayatPeriksaLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title font-weight-bold" id="modalRiwayatPeriksaLabel">Riwayat Pemeriksaan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="list-group mb-3">
                                                                <li class="list-group-item">
                                                                    <strong>Tanggal Periksa:</strong> {{ \Carbon\Carbon::parse($janjiPeriksa->periksa->tgl_periksa)->translatedFormat('d F Y H.i') }}
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Catatan:</strong> {{ $janjiPeriksa->periksa->catatan }}
                                                                </li>
                                                            </ul>

                                                            <h6 class="font-weight-bold mb-3">Daftar Obat Diresepkan:</h6>
                                                            <ul class="list-group mb-3">
                                                                @foreach ($janjiPeriksa->periksa->detailPeriksas as $detailPeriksa)
                                                                    <li class="list-group-item">
                                                                        {{ $detailPeriksa->obat->nama_obat }} {{ $detailPeriksa->obat->kemasan }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>

                                                            <div class="alert alert-info">
                                                                <strong>Biaya Periksa:</strong> {{ 'Rp' . number_format($janjiPeriksa->periksa->biaya_periksa, 0, ',', '.') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>