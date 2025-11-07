<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finance App - Catatan Keuangan</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <div class="relative min-h-screen flex items-center justify-center px-4 py-12">
        <!-- Background Decorations -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
        </div>

        <!-- Main Content -->
        <div class="relative max-w-6xl w-full">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-lg mb-6 transform hover:scale-110 transition-transform duration-300">
                    <span class="text-4xl">💰</span>
                </div>
                <h1 class="text-6xl font-bold text-gray-900 mb-4 bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                    Finance App
                </h1>
                <p class="text-2xl text-gray-600 font-light">Kelola Keuangan Anda dengan Mudah</p>
            </div>

            <!-- Feature Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Feature 1 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105 border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                        <span class="text-2xl">✅</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Pencatatan Lengkap</h3>
                    <p class="text-sm text-gray-600">Catat pemasukan dan pengeluaran dengan detail lengkap</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105 border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                        <span class="text-2xl">📊</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Statistik Visual</h3>
                    <p class="text-sm text-gray-600">Lihat pola keuangan dengan grafik interaktif</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105 border border-gray-100">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                        <span class="text-2xl">🔍</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Filter & Pencarian</h3>
                    <p class="text-sm text-gray-600">Temukan transaksi dengan cepat dan mudah</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 hover:scale-105 border border-gray-100">
                    <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center mb-4">
                        <span class="text-2xl">📷</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Upload Bukti</h3>
                    <p class="text-sm text-gray-600">Simpan foto struk atau bukti transaksi</p>
                </div>
            </div>

            <!-- CTA Buttons -->
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl p-12 text-center border border-gray-100">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Mulai Kelola Keuangan Anda Sekarang!</h2>
                <p class="text-gray-600 mb-8 text-lg">Daftar gratis dan dapatkan kendali penuh atas keuangan Anda</p>
                
                @if (Route::has('login'))
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        @auth
                            <a href="{{ route('transactions.index') }}" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl hover:from-blue-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <span class="mr-2">📱</span>
                                Buka Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <span class="mr-2">🔐</span>
                                Login
                            </a>
                            
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white bg-gradient-to-r from-green-600 to-green-700 rounded-xl hover:from-green-700 hover:to-green-800 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                    <span class="mr-2">✨</span>
                                    Daftar Gratis
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif

                <!-- Additional Info -->
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="text-4xl font-bold text-blue-600 mb-2">100%</div>
                        <div class="text-gray-600">Gratis Selamanya</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-purple-600 mb-2">🔒</div>
                        <div class="text-gray-600">Data Aman Terlindungi</div>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-green-600 mb-2">📱</div>
                        <div class="text-gray-600">Akses Kapan Saja</div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-12">
                <p class="text-gray-600">
                    Made with <span class="text-red-500">❤️</span> for better financial management
                </p>
            </div>
        </div>
    </div>
</body>
</html>