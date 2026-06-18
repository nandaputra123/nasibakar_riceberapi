<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Updating product images...\n";
echo "================================================\n";

// Mapping products to their images
$updates = [
    1 => 'assets/menu/nasibakar_ayam kemangi.webp',
    2 => 'assets/menu/nasibakar_ikan tongkol.jpg',
    3 => 'assets/menu/nasibakar_mix.jpeg',
    4 => 'assets/menu/nasibakar_udang.jpeg',
    5 => 'assets/menu/nasibakar_ayam suwir.jpg',
    6 => 'assets/menu/nasibakar_ikan teri.avif',
    7 => 'assets/menu/nasibakar_petai.jpg',
];

foreach ($updates as $id => $imagePath) {
    DB::table('products')
        ->where('id', $id)
        ->update(['image' => $imagePath]);
    
    $product = DB::table('products')->where('id', $id)->first();
    echo "✓ Updated: {$product->name} → {$imagePath}\n";
}

echo "\n✅ All product images updated successfully!\n";
