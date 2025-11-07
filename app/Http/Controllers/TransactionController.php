<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id());

        // Filter berdasarkan tipe
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'ILIKE', '%' . $request->search . '%')
                  ->orWhere('description', 'ILIKE', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan tanggal
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
                             ->paginate(20);

        // Data untuk statistik
        $totalIncome = Transaction::where('user_id', auth()->id())
                                  ->where('type', 'income')
                                  ->sum('amount');
        
        $totalExpense = Transaction::where('user_id', auth()->id())
                                   ->where('type', 'expense')
                                   ->sum('amount');

        $balance = $totalIncome - $totalExpense;

        return view('transactions.index', compact('transactions', 'totalIncome', 'totalExpense', 'balance'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['user_id'] = auth()->id();

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('transactions', 'public');
        }

        Transaction::create($validated);

        return redirect()->route('transactions.index')
                        ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function show(Transaction $transaction)
    {
        // Pastikan user hanya bisa melihat transaksi miliknya
        if ($transaction->user_id != auth()->id()) {
            abort(403);
        }

        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        // Pastikan user hanya bisa mengedit transaksi miliknya
        if ($transaction->user_id != auth()->id()) {
            abort(403);
        }

        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        // Pastikan user hanya bisa mengupdate transaksi miliknya
        if ($transaction->user_id != auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($transaction->image) {
                Storage::disk('public')->delete($transaction->image);
            }
            $validated['image'] = $request->file('image')->store('transactions', 'public');
        }

        $transaction->update($validated);

        return redirect()->route('transactions.index')
                        ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        // Pastikan user hanya bisa menghapus transaksi miliknya
        if ($transaction->user_id != auth()->id()) {
            abort(403);
        }

        // Hapus gambar jika ada
        if ($transaction->image) {
            Storage::disk('public')->delete($transaction->image);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
                        ->with('success', 'Transaksi berhasil dihapus!');
    }

    public function statistics()
    {
        $userId = auth()->id();

        // Total per kategori
        $categoryStats = Transaction::where('user_id', $userId)
            ->selectRaw('category, type, SUM(amount) as total')
            ->groupBy('category', 'type')
            ->get();

        // Transaksi bulanan (6 bulan terakhir)
        $monthlyStats = Transaction::where('user_id', $userId)
            ->selectRaw("TO_CHAR(transaction_date, 'YYYY-MM') as month, type, SUM(amount) as total")
            ->where('transaction_date', '>=', now()->subMonths(6))
            ->groupBy('month', 'type')
            ->orderBy('month')
            ->get();

        return view('transactions.statistics', compact('categoryStats', 'monthlyStats'));
    }
}