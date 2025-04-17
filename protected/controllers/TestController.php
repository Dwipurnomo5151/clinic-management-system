<?php

class TestController extends Controller
{
    public function actionIndex()
    {
        // Test current user's permissions
        $user = Yii::app()->user;
        $auth = Yii::app()->authManager;
        
        echo "<h2>SRBAC Test Results</h2>";
        
        if($user->isGuest) {
            echo "<p>Status: Not logged in</p>";
            return;
        }
        
        echo "<p>Logged in as: " . $user->name . "</p>";
        echo "<p>Role: " . $user->getState('role') . "</p>";
        
        echo "<h3>Permissions:</h3>";
        echo "<ul>";
        
        $permissions = array(
            'manageUsers' => 'Manage Users',
            'managePasien' => 'Manage Patients',
            'managePendaftaran' => 'Manage Registration',
            'managePemeriksaan' => 'Manage Medical Checkup',
            'managePembayaran' => 'Manage Payments'
        );
        
        foreach($permissions as $permission => $label) {
            $hasAccess = $user->checkAccess($permission);
            echo "<li>" . $label . ": " . ($hasAccess ? "✓" : "✗") . "</li>";
        }
        
        echo "</ul>";
    }
} 