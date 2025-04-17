<?php
// Change directory to protected folder
chdir(dirname(__FILE__));

// Include Yii
$yii = dirname(__FILE__).'/../../../../framework/yii.php';
require_once($yii);

// Include local config
$config = dirname(__FILE__).'/../config/main.php';
$local = require($config);

// Create application instance
Yii::createWebApplication($local);

// Test function
function testUserAccess($username, $password) {
    echo "\nTesting user: $username\n";
    echo "----------------------------------------\n";
    
    $identity = new UserIdentity($username, $password);
    if($identity->authenticate()) {
        echo "✓ Login berhasil\n";
        
        // Create user session
        Yii::app()->user->login($identity);
        
        // Test permissions
        $permissions = array(
            'manageUsers',
            'managePasien',
            'managePendaftaran',
            'managePemeriksaan',
            'managePembayaran'
        );
        
        echo "\nHak Akses:\n";
        foreach($permissions as $permission) {
            $hasAccess = Yii::app()->user->checkAccess($permission);
            echo ($hasAccess ? "✓" : "✗") . " $permission\n";
        }
        
        // Get role
        echo "\nRole: " . $identity->getRole() . "\n";
        
        // Logout
        Yii::app()->user->logout();
    } else {
        echo "✗ Login gagal\n";
    }
    echo "\n";
}

// Test all user types
echo "\nTesting SRBAC Implementation\n";
echo "====================================\n";

testUserAccess('admin', 'admin123');
testUserAccess('petugas', 'admin123');
testUserAccess('dokter', 'admin123');
testUserAccess('kasir', 'admin123'); 