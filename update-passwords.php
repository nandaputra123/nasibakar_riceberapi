<?php

// Script untuk update password user ke Bcrypt hash
// Jalankan: php update-passwords.php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

try {
    // Update password admin
    DB::table('users')
        ->where('email', 'admin@riceberapi.com')
        ->update(['password' => Hash::make('admin123')]);
    
    echo "✓ Admin password updated\n";
    
    // Update password customer
    DB::table('users')
        ->where('email', 'andi@test.com')
        ->update(['password' => Hash::make('customer123')]);
    
    echo "✓ Customer password updated\n";
    
    echo "\n✅ All passwords updated successfully!\n\n";
    echo "Demo Credentials:\n";
    echo "Admin: admin@riceberapi.com / admin123\n";
    echo "Customer: andi@test.com / customer123\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
