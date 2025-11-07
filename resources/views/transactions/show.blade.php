<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Transaksi') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('transactions.edit', $transaction) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    ✏️ Edit
                </a>
                <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header Info -->
                    <div class="border-b pb-4 mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $transaction->title }}</h1>
                                <div class="flex gap-2 items-center">
                                    <span class="px-3 py-1 rounded text-sm font-semibold {{ $transaction->type == 'income' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                        {{ $transaction->type == 'income' ? '💰 Pemasukan' : '💸 Pengeluaran' }}
                                    </span>
                                    <span class="px-3 py-1 bg-gray-200 text-gray-800 rounded text-sm">
                                        {{ $transaction->category }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-4xl font-bold {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Tanggal Transaksi</h3>
                            <p class="text-lg text-gray-800">📅 {{ $transaction->transaction_date->format('d F Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 mb-1">Dibuat Pada</h3>
                            <p class="text-lg text-gray-800">🕐 {{ $transaction->created_at->format('d F Y H:i') }}</p>
                        </div>
                        @if($transaction->created_at != $transaction->updated_at)
                            <div>
                                <h3 class="text-sm font-semibold text-gray-500 mb-1">Terakhir Diupdate</h3>
                                <p class="text-lg text-gray-800">🔄 {{ $transaction->updated_at->format('d F Y H:i') }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Deskripsi -->
                    @if($transaction->description)
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-500 mb-2">Deskripsi/Catatan</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="prose max-w-none">
                                    {!! $transaction->description !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Gambar -->
                    @if($transaction->image)
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-500 mb-2">Bukti Transaksi</h3>
                            <img src="{{ asset('storage/' . $transaction->image) }}" 
                                 alt="{{ $transaction->title }}" 
                                 class="max-w-full rounded-lg shadow-lg cursor-pointer"
                                 onclick="openImageModal(this.src)">
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex gap-2 mt-6 pt-6 border-t">
                        <a href="{{ route('transactions.edit', $transaction) }}" 
                           class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-6 rounded">
                            ✏️ Edit Transaksi
                        </a>
                        <button onclick="deleteTransaction({{ $transaction->id }})" 
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded">
                            🗑️ Hapus Transaksi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk gambar full -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50" onclick="closeImageModal()">
        <div class="max-w-4xl max-h-screen p-4">
            <img id="modalImage" src="" alt="Full Image" class="max-w-full max-h-full rounded-lg">
        </div>
    </div>

    <!-- Form Delete (Hidden) -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').style.display = 'flex';
        }

        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
        }

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