<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finance App - Catatan Keuangan</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg mb-4">
                <span class="text-3xl">💰</span>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Finance App</h1>
            <p class="text-gray-600">Kelola Keuangan Anda dengan Mudah</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-6">
            @if (Route::has('login'))
                @auth
                    <!-- Jika sudah login -->
                    <div class="text-center">
                        <div class="mb-6">
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang Kembali!</h2>
                            <p class="text-gray-600 mb-6">Anda sudah login sebagai <span class="font-semibold">{{ Auth::user()->name }}</span></p>
                        </div>
                        <a href="{{ route('transactions.index') }}" class="block w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            <span class="text-lg">📊 Buka Dashboard</span>
                        </a>
                    </div>
                @else
                    <!-- Jika belum login -->
                    <div class="space-y-4">
                        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Mulai Sekarang</h2>
                        
                        <!-- Login Button -->
                        <a href="{{ route('login') }}" class="block w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200 text-center">
                            <div class="flex items-center justify-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                <span class="text-lg">Login</span>
                            </div>
                        </a>

                        <!-- Divider -->
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500 font-medium">atau</span>
                            </div>
                        </div>

                        @if (Route::has('register'))
                            <!-- Register Button -->
                            <a href="{{ route('register') }}" class="block w-full bg-white hover:bg-gray-50 text-gray-800 font-bold py-4 px-6 rounded-xl border-2 border-gray-300 hover:border-indigo-500 shadow-md hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-center">
                                <div class="flex items-center justify-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    <span class="text-lg">Daftar Akun Baru</span>
                                </div>
                            </a>
                        @endif
                    </div>

                    <!-- Info Text -->
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500">Gratis dan mudah digunakan</p>
                    </div>
                @endauth
            @endif
        </div>

        <!-- Features -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-6 shadow-lg">
            <h3 class="text-sm font-bold text-gray-700 mb-4 text-center uppercase tracking-wide">Fitur Utama</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <span class="text-2xl">📝</span>
                    </div>
                    <p class="text-xs text-gray-600 font-medium">Catat Transaksi</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <span class="text-2xl">📊</span>
                    </div>
                    <p class="text-xs text-gray-600 font-medium">Lihat Statistik</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <span class="text-2xl">🔍</span>
                    </div>
                    <p class="text-xs text-gray-600 font-medium">Filter Data</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <span class="text-2xl">📷</span>
                    </div>
                    <p class="text-xs text-gray-600 font-medium">Upload Bukti</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-sm text-gray-600">
                Made with <span class="text-red-500">❤️</span> for better financial management
            </p>
        </div>
    </div>
</body>
</html>