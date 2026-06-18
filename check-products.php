<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Products in database:\n";
echo "================================================\n";

$products = DB::table('products')->select('id', 'name', 'image')->get();

foreach ($products as $product) {
    echo "ID: {$product->id}\n";
    echo "Name: {$product->name}\n";
    echo "Image: {$product->image}\n";
    echo "------------------------------------------------\n";
}
