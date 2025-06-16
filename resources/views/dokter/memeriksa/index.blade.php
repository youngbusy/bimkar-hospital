<x-app-layout> 
    <x-slot name="header"> 
        <h2 class="text-xl font-semibold leading-tight text-gray-800"> 
            {{ __('Memeriksa') }} 
        </h2> 
    </x-slot> 

    <div class="py-12"> 
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8"> 
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg"> 
                <section> 
                    <header class="flex items-center justify-between"> 
                        <h2 class="text-lg font-medium text-gray-900"> 
                            {{ __('Daftar Periksa Pasien') }} 
                        </h2> 
                    </header> 

                    <table class="table mt-6 overflow-hidden rounded table-hover"> 
                        <thead class="thead-light"> 
                            <tr> 
                                <th scope="col">No Urut</th> 
                                <th scope="col">Nama Pasien</th> 
                                <th scope="col">Keluhan</th> 
                                <th scope="col">Aksi</th> 
                            </tr> 
                        </thead> 
                        <tbody> 
                            @foreach ($janjiPeriksas as $janjiPeriksa) 
                                <tr> 
                                    <th scope="row" class="align-middle text-start">{{ $janjiPeriksa->no_antrian }}</th> 
                                    <td class="align-middle text-start">{{ $janjiPeriksa->pasien->nama }}</td> 
                                    <td class="align-middle text-start">{{ $janjiPeriksa->keluhan }}</td> 
                                    <td class="align-middle text-start"> 
                                        @if (is_null($janjiPeriksa->periksa)) 
                                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#periksaModal{{ $janjiPeriksa->id }}">Periksa</button>
                                        @else 
                                            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#editModal{{ $janjiPeriksa->id }}">Edit</button>
                                        @endif 
                                    </td> 
                                </tr> 

                                <!-- Modal Periksa -->
                                @if (is_null($janjiPeriksa->periksa))
                                    <div class="modal fade" id="periksaModal{{ $janjiPeriksa->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('dokter.memeriksa.store', $janjiPeriksa->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Form Pemeriksaan</h5>
                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama Pasien</label>
                                                            <input type="text" class="form-control" value="{{ $janjiPeriksa->pasien->nama }}" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tanggal Periksa</label>
                                                            <input type="datetime-local" class="form-control tgl_periksa" name="tgl_periksa" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Catatan</label>
                                                            <textarea class="form-control" name="catatan" rows="3"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Obat</label>
                                                            <select class="form-control" name="obat" id="obat_select_{{ $janjiPeriksa->id }}" onchange="hitungBiaya({{ $janjiPeriksa->id }})">
                                                                <option value="">-- Pilih Obat --</option>
                                                                @foreach ($obats as $obat)
                                                                    <option value="{{ $obat->id }}" data-harga="{{ $obat->harga }}">{{ $obat->nama_obat }} - Rp{{ number_format($obat->harga, 0, ',', '.') }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Biaya Pemeriksaan</label>
                                                            <input type="text" class="form-control" name="biaya_periksa" id="biaya_{{ $janjiPeriksa->id }}" value="150000" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Modal Edit Pemeriksaan -->
                                    <div class="modal fade" id="editModal{{ $janjiPeriksa->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('dokter.memeriksa.update', $janjiPeriksa->periksa->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Pemeriksaan</h5>
                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama Pasien</label>
                                                            <input type="text" class="form-control" value="{{ $janjiPeriksa->pasien->nama }}" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tanggal Periksa</label>
                                                            <input type="datetime-local" class="form-control tgl_periksa" name="tgl_periksa"
                                                                   value="{{ date('Y-m-d\TH:i', strtotime($janjiPeriksa->periksa->tgl_periksa)) }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Catatan</label>
                                                            <textarea class="form-control" name="catatan" rows="3">{{ $janjiPeriksa->periksa->catatan }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Obat</label>
                                                            <select class="form-control" name="obat" id="obat_select_{{ $janjiPeriksa->id }}" onchange="hitungBiaya({{ $janjiPeriksa->id }})">
                                                                <option value="">-- Pilih Obat --</option>
                                                                @foreach ($obats as $obat)
                                                                    <option value="{{ $obat->id }}" data-harga="{{ $obat->harga }}" {{ $obat->id == $janjiPeriksa->periksa->obat_id ? 'selected' : '' }}>
                                                                        {{ $obat->nama_obat }} - Rp{{ number_format($obat->harga, 0, ',', '.') }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Biaya Pemeriksaan</label>
                                                            <input type="text" class="form-control" name="biaya_periksa" id="biaya_{{ $janjiPeriksa->id }}" value="{{ $janjiPeriksa->periksa->biaya_periksa }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach 
                        </tbody> 
                    </table> 
                </section> 
            </div> 
        </div> 
    </div>

    <!-- Script Biaya Pemeriksaan dan Set Tanggal -->
    <script>
    function hitungBiaya(id) {
        const base = 150000;
        const select = document.getElementById("obat_select_" + id);
        const selected = select.options[select.selectedIndex];
        const harga = parseInt(selected.getAttribute("data-harga")) || 0;
        document.getElementById("biaya_" + id).value = base + harga;
    }

    // Set datetime lokal (WIB)
    document.addEventListener('DOMContentLoaded', () => {
        const datetimeInputs = document.querySelectorAll('.tgl_periksa');
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const localDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

        datetimeInputs.forEach(input => {
            if (!input.value) {
                input.value = localDateTime;
            }
        });
    });
</script>
</x-app-layout>
