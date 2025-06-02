<x-app-layout> 
    <x-slot name="header"> 
        <h2 class="text-xl font-semibold leading-tight text-gray-800"> 
            {{ __('Jadwal Periksa') }} 
        </h2> 
    </x-slot> 

    <div class="py-12"> 
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8"> 
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg"> 
                <header class="flex items-center justify-between"> 
                    <h2 class="text-lg font-medium text-gray-900"> 
                        {{ __('Daftar Jadwal Periksa') }} 
                    </h2> 

                    <div class="flex-col items-center justify-center text-center"> 
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createJadwalModal">Tambah Jadwal Periksa</button> 

                        @if (session('status') === 'jadwal-periksa-created') 
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Created.') }}</p> 
                        @endif 
                        @if (session('status') === 'jadwal-periksa-exists')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Exists.') }}</p> 
                        @endif 
                    </div> 

                    {{-- Modal Tambah --}}
                    <div class="modal fade bd-example-modal-lg" id="createJadwalModal" tabindex="-1" role="dialog" aria-labelledby="detailModalTitle" aria-hidden="true"> 
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document"> 
                            <div class="modal-content"> 
                                <div class="modal-header">
                                    <div>
                                        <h5 class="modal-title font-weight-bold">Tambah Jadwal Periksa</h5>
                                        <p class="mt-1 text-sm text-gray-600">Silahkan isi form di bawah ini untuk menambahkan jadwal periksa</p>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body"> 
                                    <form id="formJadwal" action="{{ route('dokter.jadwal-periksa.store') }}" method="POST"> 
                                        @csrf 
                                        <div class="mb-3 form-group"> 
                                            <label for="hariSelect">Hari</label>
                                            <select class="form-control" name="hari" id="hariSelect" required> 
                                                <option value="">Pilih Hari</option> 
                                                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                                    <option>{{ $hari }}</option>
                                                @endforeach
                                            </select> 
                                        </div> 

                                        <div class="mb-3 form-group"> 
                                            <label for="jamMulai">Jam Mulai</label> 
                                            <input type="time" class="form-control" id="jamMulai" name="jam_mulai" required> 
                                        </div> 

                                        <div class="mb-4 form-group"> 
                                            <label for="jamSelesai">Jam Selesai</label> 
                                            <input type="time" class="form-control" id="jamSelesai" name="jam_selesai" required> 
                                        </div> 
                                    </form> 
                                </div> 
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('formJadwal').submit();" data-dismiss="modal">Simpan</button>
                                </div>
                            </div> 
                        </div> 
                    </div> 
                </header> 

                <table class="table mt-6 overflow-hidden rounded table-hover"> 
                    <thead class="thead-light"> 
                        <tr> 
                            <th>No</th> 
                            <th>Hari</th> 
                            <th>Mulai</th> 
                            <th>Selesai</th> 
                            <th>Status</th> 
                            <th>Aksi</th> 
                        </tr> 
                    </thead> 
                    <tbody> 
                        @foreach ($jadwalPeriksas as $jadwalPeriksa) 
                            <tr> 
                                <th scope="row">{{ $loop->iteration }}</th> 
                                <td>{{ $jadwalPeriksa->hari }}</td> 
                                <td>{{ \Carbon\Carbon::parse($jadwalPeriksa->jam_mulai)->format('H:i') }}</td> 
                                <td>{{ \Carbon\Carbon::parse($jadwalPeriksa->jam_selesai)->format('H:i') }}</td> 
                                <td>
                                    @if ($jadwalPeriksa->status) 
                                        <span class="badge badge-pill badge-success">Aktif</span> 
                                    @else 
                                        <span class="badge badge-pill badge-danger">Tidak Aktif</span> 
                                    @endif 
                                </td> 
                                <td class="d-flex gap-2">

                                    <!-- Tombol Status Aktif/Nonaktif -->
                                    <form action="{{ route('dokter.jadwal-periksa.update', $jadwalPeriksa->id) }}" method="POST" class="d-inline">
                                        @csrf 
                                        @method('PATCH') 
                                        @if (!$jadwalPeriksa->status) 
                                            <button type="submit" class="btn btn-success btn-sm">Aktifkan</button> 
                                        @else 
                                            <button type="submit" class="btn btn-danger btn-sm">Nonaktifkan</button> 
                                        @endif 
                                    </form>

                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#editJadwalModal{{ $jadwalPeriksa->id }}">Edit</button>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editJadwalModal{{ $jadwalPeriksa->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $jadwalPeriksa->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div>
                                                        <h5 class="modal-title font-weight-bold">Edit Jadwal</h5>
                                                        <p class="mt-1 text-sm text-gray-600">Perbarui jadwal periksa di bawah ini.</p>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <form id="formEditJadwal{{ $jadwalPeriksa->id }}" action="{{ route('dokter.jadwal-periksa.edit', $jadwalPeriksa->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-3 form-group">
                                                            <label>Hari</label>
                                                            <select class="form-control" name="hari" required>
                                                                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                                                    <option value="{{ $hari }}" {{ $jadwalPeriksa->hari == $hari ? 'selected' : '' }}>{{ $hari }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3 form-group">
                                                            <label>Jam Mulai</label>
                                                            <input type="time" class="form-control" name="jam_mulai" value="{{ $jadwalPeriksa->jam_mulai }}" required>
                                                        </div>

                                                        <div class="mb-3 form-group">
                                                            <label>Jam Selesai</label>
                                                            <input type="time" class="form-control" name="jam_selesai" value="{{ $jadwalPeriksa->jam_selesai }}" required>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="document.getElementById('formEditJadwal{{ $jadwalPeriksa->id }}').submit();" data-dismiss="modal">
                                                        Simpan Perubahan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('dokter.jadwal-periksa.destroy', $jadwalPeriksa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td> 
                            </tr> 
                        @endforeach 
                    </tbody> 
                </table> 
            </div> 
        </div> 
    </div> 
</x-app-layout>
