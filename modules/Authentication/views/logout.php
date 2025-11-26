<?php
// Clear the JWT token by setting the cookie's expiration to the past
setcookie('jwtToken', '', time() - 3600, '/', '', false, true); // Expire the JWT token cookie

// Redirect to the login page after logging out
header("Location: ../../Authentication/views/login.php");
exit();