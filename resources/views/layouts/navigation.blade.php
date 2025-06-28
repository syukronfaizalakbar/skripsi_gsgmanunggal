<nav class="bg-white border-b border-gray-100 fixed top-0 w-full z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <span style="font-weight: bold; font-size: 18px;">GSG Manunggal</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="/" class="text-gray-800 font-semibold hover:text-gray-600">Beranda</a>
                    <a href="/panduan" class="text-gray-800 font-semibold hover:text-gray-600">Panduan</a>
                    <a href="/sewa" class="text-gray-800 font-semibold hover:text-gray-600">Sewa Lapangan</a>
                    <a href="/kontak" class="text-gray-800 font-semibold hover:text-gray-600">Kontak</a>
                </div>
            </div>

            <div class="flex items-center">
                @if (!session('admin'))
                <a href="{{ route('admin.login.form') }}" class="text-gray-800 font-semibold hover:text-gray-600">Admin</a>
                @endif
            </div>
        </div>
    </div>
</nav>

<div class="pt-16">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                Selamat Datang di Website Gedung Serba Guna Manunggal

                </div>
        </div>
    </div>
</div>