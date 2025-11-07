<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Catatan Keuangan') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('transactions.statistics') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    📊 Statistik
                </a>
                <a href="{{ route('transactions.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    ➕ Tambah Transaksi
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Card Ringkasan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-green-100 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-green-800">Total Pemasukan</h3>
                    <p class="text-3xl font-bold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
                <div class="bg-red-100 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-red-800">Total Pengeluaran</h3>
                    <p class="text-3xl font-bold text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>
                <div class="bg-blue-100 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-blue-800">Saldo</h3>
                    <p class="text-3xl font-bold {{ $balance >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                        Rp {{ number_format($balance, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- Filter & Search -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari transaksi..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipe</label>
                        <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Semua</option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
                            Filter
                        </button>
                        <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tabel Transaksi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($transactions->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Tanggal</th>
                                        <th class="px-4 py-2 text-left">Judul</th>
                                        <th class="px-4 py-2 text-left">Kategori</th>
                                        <th class="px-4 py-2 text-left">Tipe</th>
                                        <th class="px-4 py-2 text-right">Jumlah</th>
                                        <th class="px-4 py-2 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-4 py-2">{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2">{{ $transaction->title }}</td>
                                            <td class="px-4 py-2">
                                                <span class="px-2 py-1 bg-gray-200 rounded text-sm">{{ $transaction->category }}</span>
                                            </td>
                                            <td class="px-4 py-2">
                                                <span class="px-2 py-1 rounded text-sm {{ $transaction->type == 'income' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                    {{ $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2 text-right font-semibold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <div class="flex justify-center gap-2">
                                                    <a href="{{ route('transactions.show', $transaction) }}" class="text-blue-600 hover:text-blue-900">👁️</a>
                                                    <a href="{{ route('transactions.edit', $transaction) }}" class="text-yellow-600 hover:text-yellow-900">✏️</a>
                                                    <button onclick="deleteTransaction({{ $transaction->id }})" class="text-red-600 hover:text-red-900">🗑️</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">Belum ada transaksi. Silakan tambah transaksi baru.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Form Delete (Hidden) -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        // SweetAlert untuk sukses message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        // Function untuk delete dengan konfirmasi
        function deleteTransaction(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data transaksi akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('delete-form');
                    form.action = '/transactions/' + id;
                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>