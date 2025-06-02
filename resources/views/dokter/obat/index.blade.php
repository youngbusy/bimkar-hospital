<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Daftar Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <header class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Tabel Obat') }}
                    </h2>

                    <div class="flex-col items-center justify-center text-center">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createObatModal">
                            Tambah Obat
                        </button>

                        @if (session('success'))
                            <p x-data="{ show: true }" x-show="show" x-transition
                               x-init="setTimeout(() => show = false, 3000)"
                               class="text-sm text-gray-600 mt-1">
                               {{ session('success') }}
                            </p>
                        @endif
                    </div>

                    <!-- Modal Tambah -->
                    <div class="modal fade bd-example-modal-lg" id="createObatModal" tabindex="-1" role="dialog" aria-labelledby="obatModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <div>
                                        <h5 class="modal-title font-weight-bold">Tambah Obat</h5>
                                        <p class="mt-1 text-sm text-gray-600">Isi form berikut untuk menambahkan obat baru.</p>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form id="formObat" action="{{ route('dokter.obat.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3 form-group">
                                            <label for="nama_obat">Nama Obat</label>
                                            <input type="text" name="nama_obat" class="form-control" required>
                                        </div>

                                        <div class="mb-3 form-group">
                                            <label for="kemasan">Kemasan</label>
                                            <input type="text" name="kemasan" class="form-control" required>
                                        </div>

                                        <div class="mb-4 form-group">
                                            <label for="harga">Harga</label>
                                            <input type="number" name="harga" class="form-control" required min="0">
                                        </div>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-primary"
                                        onclick="document.getElementById('formObat').submit();" data-dismiss="modal">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <table class="table mt-6 overflow-hidden rounded table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Kemasan</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($obats as $obat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $obat->nama_obat }}</td>
                                <td>{{ $obat->kemasan }}</td>
                                <td>Rp {{ number_format($obat->harga, 0, ',', '.') }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-sm btn-warning text-white"
                                            data-toggle="modal" data-target="#editObatModal{{ $obat->id }}">
                                        Edit
                                    </button>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editObatModal{{ $obat->id }}" tabindex="-1" role="dialog"
                                         aria-labelledby="editModalLabel{{ $obat->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div>
                                                        <h5 class="modal-title font-weight-bold">Edit Obat</h5>
                                                        <p class="mt-1 text-sm text-gray-600">Perbarui informasi obat di bawah ini.</p>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <form id="formEdit{{ $obat->id }}" action="{{ route('dokter.obat.update', $obat) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mb-3 form-group">
                                                            <label for="nama_obat">Nama Obat</label>
                                                            <input type="text" name="nama_obat" class="form-control" value="{{ $obat->nama_obat }}" required>
                                                        </div>

                                                        <div class="mb-3 form-group">
                                                            <label for="kemasan">Kemasan</label>
                                                            <input type="text" name="kemasan" class="form-control" value="{{ $obat->kemasan }}" required>
                                                        </div>

                                                        <div class="mb-4 form-group">
                                                            <label for="harga">Harga</label>
                                                            <input type="number" name="harga" class="form-control" value="{{ $obat->harga }}" required min="0">
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="document.getElementById('formEdit{{ $obat->id }}').submit();"
                                                        data-dismiss="modal">
                                                        Simpan Perubahan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('dokter.obat.destroy', $obat) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus obat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500">Tidak ada data obat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $obats->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
