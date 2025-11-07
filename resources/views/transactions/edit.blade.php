<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Transaksi') }}
            </h2>
            <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('transactions.update', $transaction) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Tipe Transaksi -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Tipe Transaksi <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="income" 
                                           {{ old('type', $transaction->type) == 'income' ? 'checked' : '' }} 
                                           class="mr-2" required>
                                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded">💰 Pemasukan</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="type" value="expense" 
                                           {{ old('type', $transaction->type) == 'expense' ? 'checked' : '' }} 
                                           class="mr-2" required>
                                    <span class="px-4 py-2 bg-red-100 text-red-800 rounded">💸 Pengeluaran</span>
                                </label>
                            </div>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Judul -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Transaksi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" 
                                   value="{{ old('title', $transaction->title) }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                   placeholder="Contoh: Gaji Bulanan, Belanja Bulanan" required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jumlah -->
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="amount" id="amount" 
                                   value="{{ old('amount', $transaction->amount) }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                   placeholder="0" step="0.01" min="0" required>
                            @error('amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="category" id="category" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Pilih Kategori</option>
                                <optgroup label="Pemasukan">
                                    <option value="Gaji" {{ old('category', $transaction->category) == 'Gaji' ? 'selected' : '' }}>Gaji</option>
                                    <option value="Bonus" {{ old('category', $transaction->category) == 'Bonus' ? 'selected' : '' }}>Bonus</option>
                                    <option value="Investasi" {{ old('category', $transaction->category) == 'Investasi' ? 'selected' : '' }}>Investasi</option>
                                    <option value="Freelance" {{ old('category', $transaction->category) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                    <option value="Lainnya" {{ old('category', $transaction->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </optgroup>
                                <optgroup label="Pengeluaran">
                                    <option value="Makanan" {{ old('category', $transaction->category) == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                    <option value="Transportasi" {{ old('category', $transaction->category) == 'Transportasi' ? 'selected' : '' }}>Transportasi</option>
                                    <option value="Belanja" {{ old('category', $transaction->category) == 'Belanja' ? 'selected' : '' }}>Belanja</option>
                                    <option value="Tagihan" {{ old('category', $transaction->category) == 'Tagihan' ? 'selected' : '' }}>Tagihan</option>
                                    <option value="Hiburan" {{ old('category', $transaction->category) == 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
                                    <option value="Kesehatan" {{ old('category', $transaction->category) == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                    <option value="Pendidikan" {{ old('category', $transaction->category) == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                    <option value="Lainnya" {{ old('category', $transaction->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </optgroup>
                            </select>
                            @error('category')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal -->
                        <div class="mb-4">
                            <label for="transaction_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Transaksi <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="transaction_date" id="transaction_date" 
                                   value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @error('transaction_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi dengan Trix Editor -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi/Catatan
                            </label>
                            <input id="description" type="hidden" name="description" value="{{ old('description', $transaction->description) }}">
                            <trix-editor input="description" class="rounded-md border-gray-300 shadow-sm"></trix-editor>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gambar Saat Ini -->
                        @if($transaction->image)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Gambar Saat Ini
                                </label>
                                <img src="{{ asset('storage/' . $transaction->image) }}" alt="Current Image" class="max-w-xs rounded-lg shadow">
                                <p class="text-sm text-gray-500 mt-1">Upload gambar baru untuk menggantinya</p>
                            </div>
                        @endif

                        <!-- Upload Gambar Baru -->
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                                Bukti Transaksi (Gambar Baru)
                            </label>
                            <input type="file" name="image" id="image" accept="image/*"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   onchange="previewImage(event)">
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, GIF (Max: 2MB)</p>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            
                            <!-- Preview Image -->
                            <div id="imagePreview" class="mt-3 hidden">
                                <img id="preview" src="" alt="Preview" class="max-w-xs rounded-lg shadow">
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex gap-2 mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                💾 Update Transaksi
                            </button>
                            <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        // Disable file attachments in Trix editor
        document.addEventListener("trix-file-accept", function(e) {
            e.preventDefault();
        });
    </script>
</x-app-layout>