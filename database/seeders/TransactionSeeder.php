<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password')
            ]);
        }

        $categories = [
            'income' => ['Gaji', 'Bonus', 'Freelance', 'Investasi'],
            'expense' => ['Makanan', 'Transportasi', 'Belanja', 'Tagihan', 'Hiburan', 'Kesehatan']
        ];

        // Generate 50 transactions
        for ($i = 0; $i < 50; $i++) {
            $type = fake()->randomElement(['income', 'expense']);
            $category = fake()->randomElement($categories[$type]);
            
            Transaction::create([
                'user_id' => $user->id,
                'type' => $type,
                'title' => $type == 'income' ? "Pemasukan $category" : "Pengeluaran $category",
                'amount' => fake()->numberBetween(50000, 5000000),
                'description' => fake()->sentence(10),
                'transaction_date' => fake()->dateTimeBetween('-6 months', 'now'),
                'category' => $category,
            ]);
        }
    }
}