<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Telur Ayam Ras Grade A',
                'image' => 'ternakayam.jpg',
                'supplier' => 'UD. AdeSaputra Farm',
                'grade' => 'A',
                'unit' => 'kg',
                'price_min' => 26000,
                'price_max' => 28000,
                'moq' => 50,
                'stock' => 1200,
                'description' => 'Telur ayam ras grade A dengan ukuran seragam, cocok untuk retail dan kebutuhan harian.',
            ],
            [
                'name' => 'Telur Ayam Ras Grade B',
                'image' => 'ternakayam1.jpg',
                'supplier' => 'UD. AdeSaputra Farm',
                'grade' => 'B',
                'unit' => 'kg',
                'price_min' => 23000,
                'price_max' => 25000,
                'moq' => 50,
                'stock' => 980,
                'description' => 'Grade B untuk kebutuhan volume besar dengan harga lebih efisien.',
            ],
            [
                'name' => 'Telur Omega',
                'image' => 'ternakayam2.jpg',
                'supplier' => 'UD. AdeSaputra Farm',
                'grade' => 'Premium',
                'unit' => 'kg',
                'price_min' => 30000,
                'price_max' => 33000,
                'moq' => 30,
                'stock' => 620,
                'description' => 'Telur premium dengan nutrisi tinggi untuk segmen kesehatan dan horeka.',
            ],
            [
                'name' => 'Paket Telur 1 Peti',
                'image' => 'ternakayam3.jpg',
                'supplier' => 'UD. AdeSaputra Farm',
                'grade' => 'Peti',
                'unit' => 'peti',
                'price_min' => 900000,
                'price_max' => 950000,
                'moq' => 1,
                'stock' => 140,
                'description' => 'Paket peti untuk distribusi cepat dan volume besar.',
            ],
        ];

        foreach ($products as $data) {
            $product = Product::updateOrCreate(
                ['name' => $data['name']],
                [
                    'supplier' => $data['supplier'],
                    'grade' => $data['grade'],
                    'unit' => $data['unit'],
                    'price_min' => $data['price_min'],
                    'price_max' => $data['price_max'],
                    'moq' => $data['moq'],
                    'stock' => $data['stock'],
                    'image' => $data['image'],
                    'description' => $data['description'],
                    'is_active' => true,
                ]
            );

        }
    }
}
