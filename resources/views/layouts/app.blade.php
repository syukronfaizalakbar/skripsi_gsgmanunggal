<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'GSG Manunggal')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding-top: 56px; /* Tinggi navbar agar konten tidak tertutup */
            display: flex;
            flex-direction: column; /* Agar navbar dan container tertata vertikal */
            min-height: 100vh; /* Minimal tinggi viewport */
        }

        .top-navbar {
            background-color: #0d6efd;
            color: white;
            padding: 10px 20px;
            position: fixed; /* Agar navbar tetap di atas */
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000; /* Memastikan di atas konten lain */
        }

        .navbar-container {
            display: flex;
            justify-content: space-between; /* Logo kiri, menu kanan */
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .navbar-brand {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-links nav {
            display: flex; /* Menata link menu secara horizontal */
            gap: 20px; /* Memberikan jarak antar link */
            align-items: center; /* Menyusun item secara vertikal di tengah */
        }

        .nav-links nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        .nav-links nav a:hover {
            text-decoration: underline;
        }

        .admin-nav-button button {
            background-color: #212529; /* Warna dark dari Bootstrap */
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .admin-nav-button button:hover {
            opacity: 0.8;
        }

        .container {
            flex-grow: 1;
            padding: 20px;
            margin-top: -20px; /* Ruang agar tidak tertutup navbar fixed */
        }
    </style>
</head>
<body>

    <header class="top-navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="/">GSG Manunggal</a>
            <div class="nav-links">
                <nav>
                    <a href="/">Beranda</a>
                    <a href="/panduan">Panduan</a>
                    <a href="/sewa">Sewa Lapangan</a>
                    <a href="{{ url('/tentang') }}">Tentang</a>
                </nav>
                <div class="admin-nav-button">
                    <button id="openAdminLogin" class="btn btn-dark">Admin</button>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        @yield('content')
    </div>

    <div class="modal fade" id="adminLoginModal" tabindex="-1" aria-labelledby="adminLoginLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminLoginLabel">Login Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div id="loginError" class="text-danger mb-2"></div>
                    <form id="adminLoginForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Username</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('openAdminLogin').addEventListener('click', () => {
            const modal = new bootstrap.Modal(document.getElementById('adminLoginModal'));
            modal.show();
        });

        document.getElementById('adminLoginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const errorBox = document.getElementById('loginError');

            try {
                const response = await fetch("{{ route('admin.login.submit') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                if (response.ok) {
                    window.location.href = "{{ route('admin.dashboard') }}";
                } else {
                    const data = await response.json();
                    errorBox.textContent = data.message || "Login gagal.";
                }

            } catch (err) {
                errorBox.textContent = "Terjadi kesalahan saat mengirim data.";
            }
        });
    </script>

</body>
</html>