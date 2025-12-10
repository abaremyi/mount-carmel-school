<!DOCTYPE html>
<html lang="en">
<?php
// Include paths configuration
$root_path = dirname(dirname(dirname(dirname(__FILE__))));
require_once $root_path . "/config/paths.php";

?>

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login - Mount Carmel School</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
   <style>
      body {
         background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
         min-height: 100vh;
         display: flex;
         align-items: center;
         justify-content: center;
      }

      .login-card {
         background: white;
         border-radius: 20px;
         box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
         overflow: hidden;
         width: 100%;
         max-width: 400px;
      }

      .login-header {
         background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
         color: white;
         padding: 30px;
         text-align: center;
      }

      .login-body {
         padding: 30px;
      }

      .school-logo {
         width: 80px;
         height: 80px;
         border-radius: 50%;
         background: white;
         display: flex;
         align-items: center;
         justify-content: center;
         margin: 0 auto 15px;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      }

      .school-logo i {
         font-size: 40px;
         color: #764ba2;
      }

      .form-control:focus {
         border-color: #764ba2;
         box-shadow: 0 0 0 0.25rem rgba(118, 75, 162, 0.25);
      }

      .btn-login {
         background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
         border: none;
         color: white;
         padding: 12px;
         font-weight: 600;
         transition: all 0.3s;
      }

      .btn-login:hover {
         transform: translateY(-2px);
         box-shadow: 0 10px 20px rgba(118, 75, 162, 0.3);
      }
   </style>
</head>

<body>
   <div class="login-card">
      <div class="login-header">
         <div class="school-logo">
            <i class="fas fa-school"></i>
         </div>
         <h3>Mount Carmel School</h3>
         <p class="mb-0">Management System</p>
      </div>
      <div class="login-body">
         <form id="loginForm">
            <div class="mb-3">
               <label for="identifier" class="form-label">
                  <i class="fas fa-user me-2"></i>Email or Phone Number
               </label>
               <input type="text" class="form-control" id="identifier" required placeholder="Enter email or phone">
               <div class="invalid-feedback">Please enter your email or phone</div>
            </div>
            <div class="mb-3">
               <label for="password" class="form-label">
                  <i class="fas fa-lock me-2"></i>Password
               </label>
               <input type="password" class="form-control" id="password" required placeholder="Enter password">
               <div class="invalid-feedback">Please enter your password</div>
            </div>
            <div class="mb-3 form-check">
               <input type="checkbox" class="form-check-input" id="remember">
               <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn btn-login w-100 mb-3">
               <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>

            <!-- Register and Forgot Password Links -->
            <div class="row g-2">
               <div class="col-6">
                  <a href="<?= url('register') ?>" class="btn btn-outline-primary w-100">
                     <i class="fas fa-user-plus me-1"></i>Register
                  </a>
               </div>
               <div class="col-6">
                  <a id="forgotPassword" href="<?= url('forgot-password') ?>" class="btn btn-outline-secondary w-100">
                     <i class="fas fa-key me-1"></i>Forgot Password?
                  </a>
               </div>
            </div>

            <!-- Demo credentials notice -->
            <div class="alert alert-info mt-3 mb-0" role="alert">
               <small>
                  <i class="fas fa-info-circle me-1"></i>
                  Demo: Use email "info@mountcarmel.ac.rw" and password "admin123"
               </small>
            </div>
         </form>
      </div>
   </div>

   <!-- Debug panel - will show at bottom of page -->
   <div id="debugPanel"
      style="position: fixed; bottom: 0; left: 0; right: 0; background: #333; color: white; padding: 10px; font-family: monospace; font-size: 12px; display: none; z-index: 9999;">
      <div><strong>Debug Console:</strong> <button onclick="document.getElementById('debugPanel').style.display='none'"
            style="float: right;">X</button></div>
      <div id="debugLog"></div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
      // Debug function to log messages
      function debugLog(message) {
         console.log(message);
         const debugLog = document.getElementById('debugLog');
         if (debugLog) {
            debugLog.innerHTML += '<div>' + new Date().toLocaleTimeString() + ': ' + message + '</div>';
         }
      }

      // Show debug panel immediately
      document.addEventListener('DOMContentLoaded', function () {
         const debugPanel = document.getElementById('debugPanel');
         if (debugPanel) {
            debugPanel.style.display = 'block';
         }
         debugLog('Page loaded - DOMContentLoaded fired');
      });

      // Put this at the VERY BEGINNING of your script
      debugLog('=== STARTING LOGIN SCRIPT ===');

      try {
         document.addEventListener('DOMContentLoaded', function () {
            debugLog('DOMContentLoaded callback executing');

            const loginForm = document.getElementById('loginForm');
            const forgotPassword = document.getElementById('forgotPassword');

            debugLog('loginForm element: ' + (loginForm ? 'Found' : 'NOT FOUND'));
            debugLog('forgotPassword element: ' + (forgotPassword ? 'Found' : 'NOT FOUND'));

            // Get base URL dynamically
            const BASE_URL = '<?= url() ?>';
            // CORRECT API URL - based on your router configuration
            const API_URL = BASE_URL + '/api/auth';

            debugLog('BASE_URL from PHP: ' + BASE_URL);
            debugLog('API_URL: ' + API_URL);

            // Test if elements exist before adding event listeners
            if (!loginForm) {
               debugLog('ERROR: loginForm not found!');
               Swal.fire({
                  icon: 'error',
                  title: 'JavaScript Error',
                  text: 'Login form element not found'
               });
               return;
            }

            // Handle login form submission
            loginForm.addEventListener('submit', async function (e) {
               e.preventDefault();
               debugLog('Login form submitted');

               const identifier = document.getElementById('identifier').value.trim();
               const password = document.getElementById('password').value;
               const remember = document.getElementById('remember').checked;

               debugLog('Form data - Identifier: ' + identifier + ', Password length: ' + password.length + ', Remember: ' + remember);

               // Basic validation
               if (!identifier || !password) {
                  debugLog('Validation failed - missing fields');
                  Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: 'Please fill in all fields'
                  });
                  return;
               }

               // Show loading
               const loadingSwal = Swal.fire({
                  title: 'Logging in...',
                  allowOutsideClick: false,
                  showConfirmButton: false,
                  willOpen: () => {
                     Swal.showLoading();
                  }
               });

               try {
                  const loginURL = `${API_URL}?action=login`;
                  debugLog('Attempting fetch to: ' + loginURL);

                  const response = await fetch(loginURL, {
                     method: 'POST',
                     headers: {
                        'Content-Type': 'application/json',
                     },
                     body: JSON.stringify({
                        identifier: identifier,
                        password: password
                     })
                  });

                  debugLog('Response received. Status: ' + response.status + ' ' + response.statusText);

                  // First, get the response as text to see what we're getting
                  const responseText = await response.text();
                  debugLog('Raw response (first 200 chars): ' + responseText.substring(0, 200));

                  // Try to parse as JSON
                  try {
                     const result = JSON.parse(responseText);
                     debugLog('Parsed result successfully');

                     if (result.success) {
                        debugLog('Login successful! Token received: ' + (result.token ? 'Yes' : 'No'));

                        // Store token in localStorage
                        localStorage.setItem('auth_token', result.token);
                        localStorage.setItem('user', JSON.stringify(result.user));

                        // Set cookie if remember me is checked
                        if (remember) {
                           document.cookie = `auth_token=${result.token}; path=/; max-age=86400; SameSite=Strict`;
                        }

                        loadingSwal.close();

                        Swal.fire({
                           icon: 'success',
                           title: 'Success!',
                           text: result.message,
                           timer: 1500,
                           showConfirmButton: false
                        }).then(() => {
                           // Redirect based on role
                           redirectBasedOnRole(result.user);
                        });
                     } else {
                        loadingSwal.close();
                        debugLog('Login failed: ' + result.message);
                        Swal.fire({
                           icon: 'error',
                           title: 'Login Failed',
                           text: result.message
                        });
                     }
                  } catch (jsonError) {
                     loadingSwal.close();
                     debugLog('Failed to parse JSON: ' + jsonError.message);

                     Swal.fire({
                        icon: 'error',
                        title: 'Invalid Response',
                        html: `
                        <p>Server returned unexpected response.</p>
                        <p>This might be:</p>
                        <ul>
                           <li>PHP error on server</li>
                           <li>Wrong file being served</li>
                           <li>Syntax error in PHP code</li>
                        </ul>
                        <small>Check browser console for details</small>
                     `
                     });
                  }
               } catch (error) {
                  loadingSwal.close();
                  debugLog('Fetch error: ' + error.message);
                  console.error('Login error:', error);

                  Swal.fire({
                     icon: 'error',
                     title: 'Network Error',
                     text: 'Cannot connect to server. Please check your connection.'
                  });
               }
            });

            function redirectBasedOnRole(user) {
               debugLog('Redirecting user with role_id: ' + user.role_id);
               if (user.is_super_admin || user.role_id === 1) {
                  const DASH_URL = '<?= url('admin') ?>';
                  window.location.href = `${DASH_URL}`;
               } else if (user.role_id === 2) { // Administrator
                  window.location.href = `${BASE_URL}/dashboard`;
               } else if (user.role_id === 3) { // Teacher
                  window.location.href = `${BASE_URL}/teacher`;
               } else if (user.role_id === 4) { // Parent
                  window.location.href = `${BASE_URL}/parent`;
               } else if (user.role_id === 5) { // Student
                  window.location.href = `${BASE_URL}/student`;
               } else {
                  // window.location.href = BASE_URL;
                  const DASH_URL = '<?= url('admin') ?>';
                  window.location.href = `${DASH_URL}`;
               }
            }

            // Handle forgot password if element exists
            if (forgotPassword) {
               forgotPassword.addEventListener('click', function (e) {
                  e.preventDefault();
                  debugLog('Forgot password clicked');

                  // Use API_URL instead of BASE_URL + '/api/auth'
                  Swal.fire({
                     title: 'Reset Password',
                     input: 'email',
                     inputLabel: 'Enter your email address',
                     inputPlaceholder: 'your.email@example.com',
                     showCancelButton: true,
                     confirmButtonText: 'Send Reset Link',
                     showLoaderOnConfirm: true,
                     preConfirm: async (email) => {
                        try {
                           const response = await fetch(`${API_URL}?action=forgot-password`, {
                              method: 'POST',
                              headers: {
                                 'Content-Type': 'application/json',
                              },
                              body: JSON.stringify({ email: email })
                           });

                           const result = await response.json();

                           if (!result.success) {
                              throw new Error(result.message);
                           }

                           return result;
                        } catch (error) {
                           Swal.showValidationMessage(`Request failed: ${error}`);
                        }
                     },
                     allowOutsideClick: () => !Swal.isLoading()
                  }).then((result) => {
                     if (result.isConfirmed) {
                        Swal.fire({
                           icon: 'success',
                           title: 'Email Sent',
                           text: 'Please check your email for reset instructions'
                        }).then(() => {
                           window.location.href = `${BASE_URL}/forgot-password?email=${encodeURIComponent(result.value.email)}`;
                        });
                     }
                  });
               });
            } else {
               debugLog('WARNING: forgotPassword element not found, event listener not added');
            }

            // Check for existing token on page load
            const token = localStorage.getItem('auth_token');
            debugLog('Checking existing token: ' + (token ? 'Token exists' : 'No token'));
            if (token) {
               validateExistingToken(token);
            }

            async function validateExistingToken(token) {
               try {
                  debugLog('Validating existing token');
                  const response = await fetch(`${API_URL}?action=validate`, {
                     headers: {
                        'Authorization': `Bearer ${token}`
                     }
                  });

                  if (!response.ok) {
                     throw new Error('Token validation failed');
                  }

                  const result = await response.json();

                  if (result.success && result.user) {
                     debugLog('Token valid, redirecting user');
                     redirectBasedOnRole(result.user);
                  } else {
                     // Clear invalid tokens
                     debugLog('Token invalid, clearing storage');
                     localStorage.removeItem('auth_token');
                     localStorage.removeItem('user');
                  }
               } catch (error) {
                  debugLog('Token validation error: ' + error.message);
                  console.error('Token validation error:', error);
                  localStorage.removeItem('auth_token');
                  localStorage.removeItem('user');
               }
            }

            debugLog('=== LOGIN SCRIPT INITIALIZATION COMPLETE ===');
         });
      } catch (error) {
         debugLog('FATAL ERROR in main script: ' + error.message);
         console.error('Fatal error:', error);
      }
   </script>
</body>

</html>