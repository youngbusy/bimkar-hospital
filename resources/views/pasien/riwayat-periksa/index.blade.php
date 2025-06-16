<x-app-layout> 
    <x-slot name="header"> 
        <h2 class="text-xl font-semibold leading-tight text-gray-800"> 
            {{ __('Riwayat Periksa') }} 
        </h2> 
    </x-slot> 
 
    <div class="py-12"> 
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8"> 
            <!-- Daftar riwayat janji periksa -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Riwayat Janji Periksa') }}
                        </h2>
                    </header>

                    <!-- Tabel riwayat janji periksa -->
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
                                        <!-- Status pemeriksaan -->
                                        @if (is_null($janjiPeriksa->periksa))
                                            <span class="badge badge-pill badge-warning">Belum Diperiksa</span>
                                        @else
                                            <span class="badge badge-pill badge-success">Sudah Diperiksa</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-start">
                                        <!-- Aksi untuk janji yang belum diperiksa -->
                                        @if (is_null($janjiPeriksa->periksa))
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#detailModal-{{ $janjiPeriksa->id }}">Detail</button>

                                            <!-- Modal detail untuk janji yang belum diperiksa -->
                                            <div class="modal fade" id="detailModal-{{ $janjiPeriksa->id }}" tabindex="-1" role="dialog" aria-labelledby="detailModalTitle-{{ $janjiPeriksa->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title font-weight-bold" id="detailModalTitle-{{ $janjiPeriksa->id }}">Detail Riwayat Pemeriksaan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- List detail janji -->
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
                                        <!-- Aksi untuk janji yang sudah diperiksa -->
                                        @else
                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalRiwayatPeriksa-{{ $janjiPeriksa->id }}">Riwayat</button>

                                            <!-- Modal riwayat untuk janji yang sudah diperiksa -->
                                            <div class="modal fade" id="modalRiwayatPeriksa-{{ $janjiPeriksa->id }}" tabindex="-1" aria-labelledby="modalRiwayatPeriksaLabel-{{ $janjiPeriksa->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title font-weight-bold" id="modalRiwayatPeriksaLabel-{{ $janjiPeriksa->id }}">Riwayat Pemeriksaan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span>&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Informasi pemeriksaan -->
                                                            <ul class="list-group mb-3">
                                                                <li class="list-group-item">
                                                                    <strong>Tanggal Periksa:</strong> {{ \Carbon\Carbon::parse($janjiPeriksa->periksa->tgl_periksa)->translatedFormat('d F Y H.i') }}
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Keluhan:</strong> {{ $janjiPeriksa->keluhan }}
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <strong>Catatan:</strong> {{ $janjiPeriksa->periksa->catatan }}
                                                                </li>
                                                            </ul>

                                                            <!-- Daftar obat yang diresepkan -->
                                                            <h6 class="font-weight-bold mb-3">Daftar Obat Diresepkan:</h6>
                                                            <ul class="list-group mb-3">
                                                                @foreach ($janjiPeriksa->periksa->detailPeriksas as $detailPeriksa)
                                                                    <li class="list-group-item">
                                                                        {{ $detailPeriksa->obat->nama_obat }} {{ $detailPeriksa->obat->kemasan }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>

                                                            <!-- Informasi biaya -->
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