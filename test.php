<?php
// test.php - Remove this file after testing
echo "Testing .htaccess rules...<br>";

// Test 1: Can access this file directly?
echo "Direct access to test.php: Should be blocked by .htaccess<br>";

// Test 2: API access
echo "<br>Test API endpoints:<br>";
$endpoints = [
    '/modules/Authentication/api/authApi.php',
    '/modules/Dashboard/api/dashboardApi.php',
    '/modules/Contact/api/contactApi.php'
];

foreach ($endpoints as $endpoint) {
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $endpoint)) {
        echo "$endpoint: ✓ Exists<br>";
    } else {
        echo "$endpoint: ✗ Missing<br>";
    }
}
?>