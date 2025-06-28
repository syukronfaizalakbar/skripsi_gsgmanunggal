@extends('layouts.app')

@section('title', 'Form Penyewaan')

@section('content')
    <style>
        body {
            margin-top: 0;
        }
        .form-container {
            margin-top: 50px;
            margin-left: auto;
            margin-right: auto;
            padding: 20px;
            max-width: 900px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            grid-template-areas:
                'title title'
                'detail rekening'
                'nama qris'
                'alamat qris'
                'wa bukti'
                'submit submit';
        }

        .form-title {
            grid-area: title;
            font-weight: bold;
            font-size: 28px;
            margin-bottom: 10px;
            text-align: center;
            color: #333;
        }

        .detail-sewa {
            grid-area: detail;
            margin-bottom: 10px;
        }

        .detail-sewa label {
            font-weight: 600;
            display: block;
            margin-bottom: 2px;
            color: #555;
            font-size: 0.9em;
        }

        .info-display {
            background-color: #e9ecef;
            padding: 6px;
            border-radius: 5px;
            font-weight: 500;
            color: #495057;
            font-size: 0.85em;
        }

        .info-display strong {
            color: #000;
        }

        .rekening-section {
            grid-area: rekening;
            text-align: left;
        }

        .rekening-section label {
            font-size: 1em;
            font-weight: bold;
            display: block;
            margin-bottom: 2px;
        }

        .rekening-list {
            font-size: 0.85em;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3px 10px;
        }

        .rekening-list div {
            /* Biarkan default */
        }

        .qrcode-container {
            grid-area: qris;
            text-align: center;
            margin-top: 5px;
        }

        .qrcode-image {
            max-width: 200px;
            height: auto;
        }

        .form-group {
            margin-bottom: 8px;
        }

        .form-group label {
            font-weight: 600;
            display: block;
            margin-bottom: 2px;
            color: #555;
            font-size: 0.9em;
        }

        .form-group input.form-control,
        .form-group textarea.form-control,
        .form-group input[type="file"].form-control {
            width: 100%;
            padding: 5px 7px;
            font-size: 0.85em;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        .form-group .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.75em;
            margin-top: 2px;
            display: block;
        }

        #nama-group { grid-area: nama; }
        #alamat-group { grid-area: alamat; }
        #wa-group { grid-area: wa; }
        .bukti-transfer-section { grid-area: bukti; }

        .btn-primary {
            padding: 8px 15px;
            font-size: 0.9em;
            border-radius: 5px;
            background-color: #0d6efd;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            grid-area: submit;
            text-align: center;
            margin-top: 10px;
            justify-self: center;
        }

        .form-text {
            font-size: 0.7em;
            color: #6c757d;
            margin-top: 2px;
        }
    </style>
            <form action="{{ route('sewa.proses') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-container">
                    <div class="form-title">Form Penyewaan Lapangan</div>
                    {{-- Notifikasi error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" style="grid-column: 1 / -1;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- DETAIL SEWA --}}
                    <div class="detail-sewa">
                        <label>Detail Sewa</label>
                        <div class="info-display">
                            Tanggal & Waktu: <strong id="display-waktu-sewa"></strong>
                            <input type="hidden" id="input-waktu-sewa" name="waktu_sewa" value="{{ old('waktu_sewa') }}">
                            <input type="hidden" id="input-lapangan-id" name="lapangan_id" value="{{ old('lapangan_id') }}">
                        </div>

                        <label style="margin-top: 8px;">Total Harga</label>
                        <div class="info-display">
                            <strong><span id="total-harga-display">Rp -</span></strong>
                            <input type="hidden" name="total_harga" id="total-harga" value="">
                        </div>

                        @error('waktu_sewa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- REKENING --}}
                    <div class="rekening-section">
                        <label><strong>Silakan transfer ke rekening berikut:</strong></label>
                        <div class="rekening-list">
                            <div><strong>BRI:</strong> 123456789</div>
                            <div><strong>Mandiri:</strong> 123456789</div>
                            <div><strong>BNI:</strong> 123456789</div>
                            <div><strong>DANA:</strong> 123456789</div>
                            <div><strong>BCA:</strong> 123456789</div>
                            <div><strong>GoPay:</strong> 123456789</div>
                        </div>
                            <p style="font-size: 0.85em; margin-top: 5px;"><em>Semua rekening a.n GSG Manunggal</em></p>
                    </div>

                    {{-- NAMA --}}
                    <div class="form-group" id="nama-group">
                        <label for="nama_pemesan">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama_pemesan') is-invalid @enderror" id="nama_pemesan" name="nama_pemesan" value="{{ old('nama_pemesan') }}" required>
                        @error('nama_pemesan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- QRIS --}}
                    <div class="qrcode-container">
                        <img src="{{ asset('qris.jpg') }}" alt="QRIS" class="qrcode-image">
                    </div>

                    {{-- ALAMAT --}}
                    <div class="form-group" id="alamat-group">
                        <label for="alamat_pemesan">Alamat</label>
                        <textarea class="form-control @error('alamat_pemesan') is-invalid @enderror" id="alamat_pemesan" name="alamat_pemesan" rows="2" required>{{ old('alamat_pemesan') }}</textarea>
                        @error('alamat_pemesan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- BUKTI TRANSFER --}}
                    <div class="form-group bukti-transfer-section">
                        <label for="bukti_transfer">Unggah Bukti Transfer</label>
                        <input required type="file" class="form-control @error('bukti_transfer') is-invalid @enderror" id="bukti_transfer" name="bukti_transfer">
                        <small class="form-text text-muted">Format yang diperbolehkan: JPG, PNG, JPEG.</small>
                        @error('bukti_transfer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                   {{-- NOMOR WA --}}
                    <div class="form-group" id="wa-group">
                        <label for="no_wa_pemesan">Nomor WhatsApp</label>
                        <input type="text" 
                            class="form-control @error('no_wa_pemesan') is-invalid @enderror" 
                            id="no_wa_pemesan" 
                            name="no_wa_pemesan" 
                            value="{{ old('no_wa_pemesan') }}" 
                            required 
                            pattern="\d{11,13}" 
                            maxlength="13"
                            title="Masukkan 11 sampai 13 digit angka tanpa spasi atau simbol">
                        @error('no_wa_pemesan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- SUBMIT --}}
                    <button type="submit" class="btn-primary"><strong>Kirim Permohonan Sewa</strong></button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const urlParams = new URLSearchParams(window.location.search);
                    const waktuSewaJson = urlParams.get('waktu');
                    const lapanganId = urlParams.get('lapangan_id');

                    // Cek apakah ada data old() dari redirect sebelumnya
                    const oldWaktuSewa = document.getElementById('input-waktu-sewa').value;
                    const oldLapanganId = document.getElementById('input-lapangan-id').value;

                    // Jika ada data old(), gunakan itu. Jika tidak, gunakan dari URL.
                    const finalWaktuSewaJson = oldWaktuSewa || waktuSewaJson;
                    const finalLapanganId = oldLapanganId || lapanganId;

                    // Display waktu sewa
                    if (finalWaktuSewaJson) {
                        try {
                            const waktuSewaArray = JSON.parse(finalWaktuSewaJson);
                            const formattedWaktu = waktuSewaArray.map(waktu => {
                                const date = new Date(waktu);
                                const options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', hour12: false };
                                return date.toLocaleDateString('id-ID', options);
                            }).join(', ');
                            document.getElementById('display-waktu-sewa').textContent = formattedWaktu;
                            document.getElementById('input-waktu-sewa').value = finalWaktuSewaJson;
                            const hargaPerJamMap = {
                            1: 150000, // Aula Gedung
                            2: 50000,   // Bola Voli
                            3: 100000,  // Sepak Bola
                            4: 75000    // Tenis
                            };
                            const idLapangan = parseInt(finalLapanganId);
                            const hargaPerJam = hargaPerJamMap[idLapangan] || 0;
                            const totalHarga = hargaPerJam * waktuSewaArray.length;
                            const formatter = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                minimumFractionDigits: 0
                            });
                            document.getElementById('total-harga-display').textContent = formatter.format(totalHarga);
                            document.getElementById('total-harga').value = totalHarga;

                        } catch (e) {
                            console.error('Error parsing waktu sewa JSON:', e);
                            document.getElementById('display-waktu-sewa').textContent = 'Format waktu tidak valid';
                            document.getElementById('input-waktu-sewa').value = '';
                        }
                    } else {
                        document.getElementById('display-waktu-sewa').textContent = 'Belum dipilih';
                        document.getElementById('input-waktu-sewa').value = '';
                    }

                    // Set nilai lapangan_id ke input tersembunyi
                    if (finalLapanganId) {
                        document.getElementById('input-lapangan-id').value = finalLapanganId;
                    } else {
                        console.warn('lapangan_id tidak ditemukan di URL atau old data. Input lapangan_id diset kosong.');
                        document.getElementById('input-lapangan-id').value = '';
                    }
                });
            </script>
        @endsection
