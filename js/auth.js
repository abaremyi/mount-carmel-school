// js/auth.js
// Authentication JavaScript Functions

class AuthManager {
    constructor() {
        this.debugEnabled = false;
        this.BASE_URL = window.BASE_URL || '';
        this.API_URL = this.BASE_URL + '/api/auth';
        this.init();
    }

    init() {
        this.debugLog('=== AUTH MANAGER INITIALIZED ===');
        this.attachEventListeners();
        this.checkExistingToken();
    }

    // Debug logging
    debugLog(message) {
        if (this.debugEnabled) {
            console.log('[Auth]', message);
            const debugLog = document.getElementById('debugLog');
            if (debugLog) {
                const timestamp = new Date().toLocaleTimeString();
                debugLog.innerHTML += `<div>${timestamp}: ${message}</div>`;
            }
        }
    }

    toggleDebug() {
        this.debugEnabled = !this.debugEnabled;
        const debugPanel = document.getElementById('debugPanel');
        if (debugPanel) {
            debugPanel.style.display = this.debugEnabled ? 'block' : 'none';
        }
        this.debugLog(`Debug ${this.debugEnabled ? 'enabled' : 'disabled'}`);
    }

    // Event Listeners
    attachEventListeners() {
        // Login form submission
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', (e) => this.handleLogin(e));
            this.debugLog('Login form listener attached');
        }

        // Register form submission
        const registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', (e) => this.handleRegister(e));
            this.debugLog('Register form listener attached');
        }

        // Forgot password
        const forgotPasswordBtn = document.getElementById('forgotPassword');
        if (forgotPasswordBtn) {
            forgotPasswordBtn.addEventListener('click', (e) => this.handleForgotPassword(e));
            this.debugLog('Forgot password listener attached');
        }

        // Reset password
        const resetForm = document.getElementById('resetForm');
        if (resetForm) {
            resetForm.addEventListener('submit', (e) => this.handleResetPassword(e));
            this.debugLog('Reset password listener attached');
        }

        // Toggle between login and register forms
        const registerBtn = document.getElementById('register');
        const loginBtn = document.getElementById('login');
        if (registerBtn && loginBtn) {
            registerBtn.addEventListener('click', () => this.toggleForms('register'));
            loginBtn.addEventListener('click', () => this.toggleForms('login'));
            this.debugLog('Form toggle listeners attached');
        }
    }

    // Toggle between login and register forms
    toggleForms(formType) {
        const container = document.getElementById('container');
        if (container) {
            if (formType === 'register') {
                container.classList.add('active');
            } else {
                container.classList.remove('active');
            }
            this.debugLog(`Switched to ${formType} form`);
        }
    }

    // Handle Login
    async handleLogin(e) {
        e.preventDefault();
        
        const identifier = document.getElementById('identifier').value.trim();
        const password = document.getElementById('password').value;
        const remember = document.getElementById('remember').checked;

        // Validation
        if (!identifier || !password) {
            this.showAlert('error', 'Error', 'Please fill in all fields');
            return;
        }

        this.debugLog(`Attempting login for: ${identifier}`);

        try {
            const loadingSwal = await this.showLoading('Logging in...');
            
            const response = await fetch(`${this.API_URL}?action=login`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ identifier, password })
            });

            const result = await response.json();
            
            if (loadingSwal) loadingSwal.close();

            if (result.success) {
                this.debugLog('Login successful');
                
                // Store token and user data
                localStorage.setItem('auth_token', result.token);
                localStorage.setItem('user', JSON.stringify(result.user));

                // Set cookie if remember me is checked
                if (remember) {
                    document.cookie = `auth_token=${result.token}; path=/; max-age=86400; SameSite=Strict`;
                }

                await this.showAlert('success', 'Success!', result.message, 1500);
                
                // Redirect based on role
                this.redirectBasedOnRole(result.user);
            } else {
                this.showAlert('error', 'Login Failed', result.message);
            }
        } catch (error) {
            this.debugLog(`Login error: ${error.message}`);
            this.showAlert('error', 'Network Error', 'Cannot connect to server. Please check your connection.');
        }
    }

    // Handle Registration
    async handleRegister(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        const userData = {
            firstname: formData.get('firstname').trim(),
            lastname: formData.get('lastname').trim(),
            email: formData.get('email').trim(),
            phone: formData.get('phone').trim(),
            password: formData.get('password'),
            confirmPassword: formData.get('confirmPassword')
        };

        // Validation
        const errors = this.validateRegistration(userData);
        if (errors.length > 0) {
            this.showAlert('error', 'Validation Error', errors.join('<br>'));
            return;
        }

        // Remove confirm password before sending
        delete userData.confirmPassword;
        userData.username = userData.email; // Use email as username for now

        this.debugLog(`Attempting registration for: ${userData.email}`);

        try {
            const loadingSwal = await this.showLoading('Registering...');
            
            const response = await fetch(`${this.API_URL}?action=register`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(userData)
            });

            const result = await response.json();
            
            if (loadingSwal) loadingSwal.close();

            if (result.success) {
                this.debugLog('Registration successful');
                
                await this.showAlert('success', 'Success!', result.message, 2000);
                
                // Auto login after registration
                await this.handleLogin({
                    preventDefault: () => {},
                    target: {
                        querySelector: (selector) => {
                            if (selector === '#identifier') return { value: userData.email };
                            if (selector === '#password') return { value: formData.get('password') };
                            if (selector === '#remember') return { checked: true };
                        }
                    }
                });
            } else {
                this.showAlert('error', 'Registration Failed', result.message);
            }
        } catch (error) {
            this.debugLog(`Registration error: ${error.message}`);
            this.showAlert('error', 'Network Error', 'Cannot connect to server. Please try again.');
        }
    }

    // Validate registration data
    validateRegistration(data) {
        const errors = [];
        
        // Name validation
        if (!data.firstname || data.firstname.length < 2) {
            errors.push('First name must be at least 2 characters');
        }
        
        if (!data.lastname || data.lastname.length < 2) {
            errors.push('Last name must be at least 2 characters');
        }
        
        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(data.email)) {
            errors.push('Please enter a valid email address');
        }
        
        // Phone validation (simple check)
        if (!data.phone || data.phone.length < 10) {
            errors.push('Please enter a valid phone number');
        }
        
        // Password validation
        if (!data.password || data.password.length < 6) {
            errors.push('Password must be at least 6 characters');
        }
        
        if (data.password !== data.confirmPassword) {
            errors.push('Passwords do not match');
        }
        
        return errors;
    }

    // Handle Forgot Password
    async handleForgotPassword(e) {
        e.preventDefault();
        
        const email = document.getElementById('forgotEmail')?.value || 
                      prompt('Enter your email address:');
        
        if (!email) return;

        try {
            const response = await fetch(`${this.API_URL}?action=forgot-password`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email })
            });

            const result = await response.json();

            if (result.success) {
                this.showAlert('success', 'Email Sent', 'Please check your email for reset instructions');
            } else {
                this.showAlert('error', 'Error', result.message);
            }
        } catch (error) {
            this.debugLog(`Forgot password error: ${error.message}`);
            this.showAlert('error', 'Network Error', 'Cannot connect to server.');
        }
    }

    // Handle Reset Password
    async handleResetPassword(e) {
        e.preventDefault();
        
        const email = document.getElementById('resetEmail').value;
        const password = document.getElementById('resetPassword').value;
        const confirmPassword = document.getElementById('resetConfirmPassword').value;
        const token = document.getElementById('resetToken').value;

        if (password !== confirmPassword) {
            this.showAlert('error', 'Error', 'Passwords do not match');
            return;
        }

        try {
            const loadingSwal = await this.showLoading('Resetting password...');
            
            const response = await fetch(`${this.API_URL}?action=reset-password`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password, token })
            });

            const result = await response.json();
            
            if (loadingSwal) loadingSwal.close();

            if (result.success) {
                this.showAlert('success', 'Password Reset', 'Your password has been reset successfully!');
                setTimeout(() => {
                    window.location.href = this.BASE_URL + '/login';
                }, 2000);
            } else {
                this.showAlert('error', 'Error', result.message);
            }
        } catch (error) {
            this.debugLog(`Reset password error: ${error.message}`);
            this.showAlert('error', 'Network Error', 'Cannot connect to server.');
        }
    }

    // Check existing token
    async checkExistingToken() {
        const token = localStorage.getItem('auth_token');
        if (token) {
            this.debugLog('Found existing token, validating...');
            
            try {
                const response = await fetch(`${this.API_URL}?action=validate`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    if (result.success) {
                        this.debugLog('Token valid, redirecting...');
                        this.redirectBasedOnRole(result.user);
                    } else {
                        this.clearLocalStorage();
                    }
                } else {
                    this.clearLocalStorage();
                }
            } catch (error) {
                this.debugLog(`Token validation error: ${error.message}`);
                this.clearLocalStorage();
            }
        }
    }

    // Redirect based on user role
    redirectBasedOnRole(user) {
        const dashboards = {
            1: this.BASE_URL + '/admin',      // Super Admin
            2: this.BASE_URL + '/dashboard',  // Administrator
            3: this.BASE_URL + '/teacher',    // Teacher
            4: this.BASE_URL + '/parent',     // Parent
            5: this.BASE_URL + '/student'     // Student
        };

        const targetUrl = dashboards[user.role_id] || this.BASE_URL + '/dashboard';
        this.debugLog(`Redirecting to: ${targetUrl} (role_id: ${user.role_id})`);
        window.location.href = targetUrl;
    }

    // Clear local storage
    clearLocalStorage() {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user');
        document.cookie = 'auth_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
    }

    // Show loading indicator
    async showLoading(message = 'Processing...') {
        if (typeof Swal !== 'undefined') {
            return Swal.fire({
                title: message,
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => Swal.showLoading()
            });
        }
        return null;
    }

    // Show alert
    async showAlert(icon, title, text, timer = null) {
        if (typeof Swal !== 'undefined') {
            const config = {
                icon,
                title,
                text,
                timer: timer ? timer : undefined,
                showConfirmButton: !timer
            };
            return Swal.fire(config);
        } else {
            alert(`${title}: ${text}`);
        }
    }
}

// Initialize Auth Manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.authManager = new AuthManager();
    
    // Add debug toggle button if debug panel exists
    const debugToggle = document.getElementById('debugToggle');
    if (debugToggle) {
        debugToggle.addEventListener('click', () => window.authManager.toggleDebug());
    }
});