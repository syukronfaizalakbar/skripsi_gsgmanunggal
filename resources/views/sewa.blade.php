@extends('layouts.app')

@section('title', 'Sewa Lapangan')

@section('content')
    <style>
        body {
            /* Sesuaikan padding-top dengan tinggi navbar (sekitar 56px) + tinggi fixed-container (sekitar 110px) */
            padding-top: 170px; /* 56px (navbar) + 110px (lapangan-container-fixed) + sedikit margin */
            margin: 0;
        }

        .lapangan-container-fixed {
            display: flex;
            gap: 15px;
            padding: 10px 15px;
            background-color: #f8f9fa;
            position: relative;
            top: -100px; /* Di bawah navbar */
            left: 0;
            width: 100%;
            z-index: 100;
            justify-content: center; /* Membuat kotak berada di tengah */
            max-height: 500px; /* Atur sesuai kebutuhan */
            overflow: auto;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Tambahkan shadow agar terlihat terpisah */
        }

        .card-fixed {
            border: 1px solid #d4a373;
            border-radius: 6px;
            padding: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            background-color: #edca9d;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 150px; /* Lebar kotak */
            min-height: 90px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-sizing: border-box;
            flex-shrink: 0;
        }

        .card-fixed.active {
            background-color: #d4a373;
            color: white;
        }

        .card-fixed.active .card-title-fixed,
        .card-fixed.active .card-text-fixed,
        .card-fixed.active .card-price-fixed {
            color: white;
        }

        .card-title-fixed {
            font-size: 0.9em;
            font-weight: bold;
            color: #333;
            margin-bottom: 3px;
            text-align: center;
        }

        .card-text-fixed {
            font-size: 0.8em;
            color: #555;
            margin-bottom: 3px;
            text-align: center;
        }

        .card-price-fixed {
            font-size: 0.9em;
            font-weight: bold;
            color: #28a745;
            text-align: center;
        }

        .container-sewa {
            margin-top: 60px;
            padding-bottom: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            display: none; /* Hilangkan judul "Pilih Jadwal Sewa" */
            text-align: center;
            margin-bottom: 10px;
            margin-top: 10px;
            font-size: 1.8em;
        }

        .jadwal-sewa-container {
            margin-top: -200px; /* Lebih dekat ke kotak */
            width: 95%;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            padding-top: 40px;
            background-color: #f9f9f9;
            overflow-x: auto;
            display: none; /* Akan diubah menjadi 'block' oleh JS saat lapangan dipilih */
            flex-direction: column;
            align-items: center;
            z-index: 10;
            position: relative;
            max-height: 500px; /* Atur sesuai kebutuhan */
            overflow: auto;
        }

        .jadwal-sewa-container h2 {
            display: none; /* Menghilangkan judul jadwal */
            text-align: center;
            margin-bottom: 10px;
            font-size: 1.4em;
            color: #333;
            align-self: stretch;
        }

        .jadwal-table {
            width: auto;
            border-collapse: collapse;
        }

        .jadwal-table thead tr {
            position: sticky;
            top: 0;
            z-index: 5;
            background-color: #f0f0f0; /* Tambahkan background-color agar header menutupi konten yang di-scroll di bawahnya */
        }

        .jadwal-table thead th {
            font-weight: bold;
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
            font-size: 0.8em;
            white-space: nowrap;
        }

        .jadwal-table th:first-child {
            position: sticky;
            left: 0;
            z-index: 6;
            background-color: #f0f0f0;
        }

        .jadwal-table tbody td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
            font-size: 0.8em;
            white-space: nowrap;
        }

        .jadwal-table tbody td:first-child {
            position: sticky;
            left: 0;
            background-color: #f9f9f9; /* Warna background tbody */
            z-index: 3;
            background-color: #f0f0f0;
        }

        .jadwal-table td.available {
            cursor: pointer;
            background-color: #e6ffe6;
        }

        .jadwal-table td.available.selected {
            background-color: #aaffaa;
        }
        .jadwal-table td.booked-menunggu {
            background-color: #ffff00; 
            cursor: not-allowed;
        }

        .jadwal-table td.booked-konfirmasi {
            background-color: #8B4513; 
            cursor: not-allowed;
        }


        #fitur-selanjutnya {
            display: none !important;
            margin-top: 10px;
            text-align: center;
            align-self: stretch;
        }

        .btn-sewa-sekarang {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1em;
            text-decoration: none;
            transition: background-color 0.2s ease-in-out;
            margin-top: 15px;
            margin-left: auto;
            margin-right: auto;
            display: block;
            align-self: center;
        }

        .btn-sewa-sekarang:hover {
            background-color: #1e7e34;
        }
    </style>

    <div class="lapangan-container-fixed">
        @foreach ($lapangans as $lapangan)
            <div class="card-fixed" data-lapangan-id="{{ $lapangan['id'] }}">
                <h2 class="card-title-fixed">{{ $lapangan['nama'] }}</h2>
                {{-- Menggunakan fasilitas_singkat jika ada, jika tidak, batasi fasilitas --}}
                <p class="card-text-fixed">{{ $lapangan['fasilitas_singkat'] ?? \Illuminate\Support\Str::limit($lapangan['fasilitas'], 30) }}</p>
                <p class="card-price-fixed">Rp {{ number_format($lapangan['harga_per_jam'], 0, ',', '.') }}</p>
            </div>
        @endforeach
    </div>

    <div class="container-sewa">
        <h1 style="display: none;">Pilih Jadwal Sewa</h1>
        <div class="jadwal-sewa-container" id="jadwal-container">
            <h2 style="display: none;">Jadwal Sewa - <span id="nama-lapangan"></span></h2>
            <table class="jadwal-table" id="jadwal-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        @for ($hour = 6; $hour <= 23; $hour++)
                            <th>{{ sprintf('%02d:00', $hour) }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    {{-- Tabel akan diisi oleh JavaScript --}}
                </tbody>
            </table>
            <div id="fitur-selanjutnya" style="display: none !important;">
                <p>Anda telah memilih jadwal pada tanggal <span id="selected-date"></span> pukul <span id="selected-time"></span>.</p>
            </div>
            <button class="btn-sewa-sekarang" id="btn-lanjut-sewa">Sewa Sekarang</button>
        </div>
    </div>

    <script>
        const daftarLapanganFixed = document.querySelectorAll('.lapangan-container-fixed .card-fixed');
        const jadwalContainer = document.getElementById('jadwal-container');
        const namaLapanganSpan = document.getElementById('nama-lapangan');
        const jadwalTableBody = document.getElementById('jadwal-table').getElementsByTagName('tbody')[0];
        const fiturSelanjutnyaDiv = document.getElementById('fitur-selanjutnya');
        const selectedDateSpan = document.getElementById('selected-date');
        const selectedTimeSpan = document.getElementById('selected-time');
        const btnLanjutSewa = document.getElementById('btn-lanjut-sewa');

        let selectedLapanganId = null;
        let selectedSlots = []; // Array untuk menyimpan semua slot waktu yang dipilih (misal: ["2025-06-05 08:00", "2025-06-05 09:00"])
        let activeCardElement = null; // Untuk melacak kartu lapangan yang sedang aktif

        // Data tanggal yang diteruskan dari controller
        const datesFromController = @json($dates);
        const jadwalSewaStatus = @json($jadwalSewa);


        // Event listener untuk klik pada kartu lapangan
        daftarLapanganFixed.forEach(card => {
            card.addEventListener('click', function() {
                // Hapus kelas 'active' dari kartu sebelumnya yang aktif
                if (activeCardElement) {
                    activeCardElement.classList.remove('active');
                }
                // Tambahkan kelas 'active' ke kartu yang baru diklik
                this.classList.add('active');
                activeCardElement = this; // Simpan referensi kartu yang aktif

                selectedLapanganId = this.dataset.lapanganId;
                const namaLapangan = this.querySelector('.card-title-fixed').textContent;
                namaLapanganSpan.textContent = namaLapangan;

                // Tampilkan container jadwal
                jadwalContainer.style.display = 'flex'; // Mengubah dari 'block' menjadi 'flex' untuk centering
                fiturSelanjutnyaDiv.style.display = 'none'; // Sembunyikan fitur selanjutnya saat lapangan baru dipilih

                // Reset slot yang dipilih saat lapangan baru dipilih
                selectedSlots = [];
                // Hapus kelas 'selected' dari semua sel yang sebelumnya terpilih
                document.querySelectorAll('.jadwal-table td.selected').forEach(cell => {
                    cell.classList.remove('selected');
                });

                renderJadwal(selectedLapanganId);
            });
        });

        // Fungsi untuk merender tabel jadwal
                function renderJadwal(lapanganId) {
            jadwalTableBody.innerHTML = ''; // Kosongkan tabel sebelum mengisi ulang

            const jamMulai = 6;
            const jamSelesai = 23;

            // Iterasi tanggal dari controller
            datesFromController.forEach(dateString => {
                const row = jadwalTableBody.insertRow();
                const tanggalCell = row.insertCell();
                tanggalCell.textContent = new Date(dateString).toLocaleDateString('id-ID', {
                    day: '2-digit', month: '2-digit', year: 'numeric'
                });

                for (let hour = jamMulai; hour <= jamSelesai; hour++) {
                    const timeString = `${String(hour).padStart(2, '0')}:00`;
                    const dateTimeFull = `${dateString} ${timeString}`;

                    const cell = row.insertCell();
                    cell.dataset.tanggal = dateString;
                    cell.dataset.waktu = timeString;

                    const slotDateTime = new Date(`${dateString}T${timeString}`);
                    const now = new Date();
                    const nowWithoutSeconds = new Date(now.getFullYear(), now.getMonth(), now.getDate(), now.getHours(), 0, 0);

                        if (slotDateTime < nowWithoutSeconds) {
                        cell.classList.add('available'); // Tetap berwarna hijau muda
                        cell.title = 'Waktu telah berlalu';
                        cell.dataset.expired = 'true'; // Tambahkan penanda agar nanti dicek di klik
                    } else {
                        const statusSewa = jadwalSewaStatus[lapanganId]?.[dateTimeFull];
                        if (statusSewa === 'menunggu') {
                            cell.classList.add('booked-menunggu');
                            cell.title = 'Menunggu Konfirmasi';
                        } else if (statusSewa === 'konfirmasi' || statusSewa === 'disewa') {
                            cell.classList.add('booked-konfirmasi');
                            cell.title = 'Sudah Dikonfirmasi';
                        } else {
                            cell.classList.add('available');
                        }
                    }

                }
            });
        }

        // Klik pada sel tabel jadwal
        jadwalTableBody.addEventListener('click', function(event) {
           const clickedCell = event.target.closest('td.available');
            if (clickedCell && clickedCell.dataset.expired !== 'true') {
                const tanggal = clickedCell.dataset.tanggal;
                const waktu = clickedCell.dataset.waktu;
                const dateTimeFull = `${tanggal} ${waktu}`;

                if (clickedCell.classList.contains('selected')) {
                    clickedCell.classList.remove('selected');
                    selectedSlots = selectedSlots.filter(slot => slot !== dateTimeFull);
                } else {
                    clickedCell.classList.add('selected');
                    selectedSlots.push(dateTimeFull);
                }

                console.log('Slot yang dipilih:', selectedSlots);
            }
        });

        // Klik tombol Sewa Sekarang
        btnLanjutSewa.addEventListener('click', function() {
            if (!selectedLapanganId) {
                alert('Mohon pilih lapangan terlebih dahulu!');
                return;
            }
            if (selectedSlots.length === 0) {
                alert('Mohon pilih setidaknya satu slot waktu!');
                return;
            }

            selectedSlots.sort((a, b) => new Date(a) - new Date(b));
            const waktuSewaJson = JSON.stringify(selectedSlots);
            const url = `{{ route('form.sewa') }}?lapangan_id=${selectedLapanganId}&waktu=${encodeURIComponent(waktuSewaJson)}`;
            window.location.href = url;
        });

        // Klik otomatis lapangan pertama saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const firstLapanganCard = document.querySelector('.lapangan-container-fixed .card-fixed');
            if (firstLapanganCard) {
                firstLapanganCard.click();
            }
        });

    </script>
@endsection
