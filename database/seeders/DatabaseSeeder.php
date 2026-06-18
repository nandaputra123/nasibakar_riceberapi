<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database dengan data awal
     */
    public function run(): void
    {
        // Seed Users (Admin dan Customer)
        User::create([
            'name' => 'Admin Rice Berapi',
            'email' => 'admin@riceberapi.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Jl. Nasi Bakar No. 1, Jakarta Selatan',
        ]);

        User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi@test.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
            'phone' => '08987654321',
            'address' => 'Jl. Mawar No. 5, Jakarta Timur',
        ]);

        // Seed Products (7 menu nasi bakar)
        $products = [
            [
                'name' => 'Nasi Bakar Ayam Kemangi',
                'description' => 'Nasi bakar dengan isian ayam suwir berbumbu kemangi yang harum. Dibungkus daun pisang dan dibakar sempurna hingga aroma asapnya meresap.',
                'price' => 18000,
                'stock' => 50,
                'category' => 'ayam',
                'is_active' => true,
            ],
            [
                'name' => 'Nasi Bakar Ikan Tongkol Pedas',
                'description' => 'Nasi bakar isi ikan tongkol yang sudah dimasak dengan bumbu pedas merah. Cocok untuk pecinta seafood dan makanan pedas.',
                'price' => 16000,
                'stock' => 40,
                'category' => 'seafood',
                'is_active' => true,
            ],
            [
                'name' => 'Nasi Bakar Jamur Crispy',
                'description' => 'Pilihan sehat untuk vegetarian! Nasi bakar dengan isian jamur crispy yang gurih dan renyah berpadu dengan bumbu rempah.',
                'price' => 15000,
                'stock' => 35,
                'category' => 'vegetarian',
                'is_active' => true,
            ],
            [
                'name' => 'Nasi Bakar Udang Pedas',
                'description' => 'Nasi bakar dengan isian udang segar yang dimasak dengan sambal pedas. Segar, gurih, dan bikin nagih!',
                'price' => 20000,
                'stock' => 25,
                'category' => 'seafood',
                'is_active' => true,
            ],
            [
                'name' => 'Nasi Bakar Original',
                'description' => 'Nasi bakar klasik dengan isian ayam kampung, tempe, dan bumbu khas. Pilihan sederhana yang selalu enak.',
                'price' => 13000,
                'stock' => 60,
                'category' => 'original',
                'is_active' => true,
            ],
            [
                'name' => 'Nasi Bakar Cumi Hitam',
                'description' => 'Nasi bakar unik dengan isian cumi masak tinta hitam. Tampilan gelap dengan cita rasa gurih dan sedikit manis yang khas.',
                'price' => 20000,
                'stock' => 20,
                'category' => 'seafood',
                'is_active' => true,
            ],
            [
                'name' => 'Nasi Bakar Ayam Geprek',
                'description' => 'Nasi bakar dengan isian ayam geprek crispy dan sambal bawang pedas. Favorit anak muda yang suka pedas dan crispy!',
                'price' => 17000,
                'stock' => 45,
                'category' => 'ayam',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@riceberapi.com / admin123');
        $this->command->info('Customer: andi@test.com / customer123');
    }
}
