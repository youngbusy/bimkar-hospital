<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Profil Dokter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <header class="flex items-center justify-between">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Informasi Profil') }}
                    </h2>

                    <div class="flex-col items-center justify-center text-center">
                        <!-- Tombol Edit Modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">
                            Edit Profil
                        </button>

                        @if (session('success'))
                            <p x-data="{ show: true }" x-show="show" x-transition
                               x-init="setTimeout(() => show = false, 3000)"
                               class="text-sm text-gray-600 mt-1">
                                {{ session('success') }}
                            </p>
                        @endif
                    </div>
                </header>

                <!-- Tabel Informasi -->
                <div class="mt-6">
                    <table class="table table-bordered w-full text-sm text-left text-gray-700">
                        <tbody>
                            <tr><th class="w-1/3">Nama</th><td>{{ $user->nama }}</td></tr>
                            <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                            <tr><th>Alamat</th><td>{{ $user->alamat ?? '-' }}</td></tr>
                            <tr><th>No. KTP</th><td>{{ $user->no_ktp ?? '-' }}</td></tr>
                            <tr><th>No. HP</th><td>{{ $user->no_hp ?? '-' }}</td></tr>
                            <tr><th>No. RM</th><td>{{ $user->no_rm ?? '-' }}</td></tr>
                            <tr><th>Poli</th><td>{{ $user->poli ?? '-' }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title font-weight-bold">Edit Profil</h5>
                        <p class="mt-1 text-sm text-gray-600">Perbarui informasi profil Anda di bawah ini.</p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="formEditProfile" action="{{ route('dokter.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ $user->alamat }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="no_ktp" class="form-label">No. KTP</label>
                            <input type="text" name="no_ktp" class="form-control" value="{{ $user->no_ktp }}">
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No. HP</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ $user->no_hp }}">
                        </div>

                        <div class="mb-3">
                            <label for="no_rm" class="form-label">No. RM</label>
                            <input type="text" name="no_rm" class="form-control" value="{{ $user->no_rm }}">
                        </div>

                        <div class="mb-3">
                            <label for="poli" class="form-label">Poli</label>
                            <input type="text" name="poli" class="form-control" value="{{ $user->poli }}">
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary"
                            onclick="document.getElementById('formEditProfile').submit();"
                            data-dismiss="modal">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
