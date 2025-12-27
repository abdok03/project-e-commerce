document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
    const strengthLevel = document.getElementById('strengthLevel');
    const strengthText = document.getElementById('strengthText');
    const passwordMatch = document.getElementById('passwordMatch');
    
    // Password rules elements
    const lengthRule = document.getElementById('lengthRule');
    const uppercaseRule = document.getElementById('uppercaseRule');
    const numberRule = document.getElementById('numberRule');
    const specialRule = document.getElementById('specialRule');
    
    // Toggle password visibility
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }
    
    if (toggleConfirmPasswordBtn) {
        toggleConfirmPasswordBtn.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }
    
    // Password strength checker
    function checkPasswordStrength(password) {
        let strength = 0;
        
        // Length
        if (password.length >= 8) strength += 25;
        if (password.length >= 12) strength += 10;
        
        // Character types
        if (/[A-Z]/.test(password)) strength += 20;
        if (/[0-9]/.test(password)) strength += 20;
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 25;
        
        strength = Math.min(strength, 100);
        
        return strength;
    }
    
    function updateStrengthDisplay(strength) {
        strengthLevel.style.width = `${strength}%`;
        
        if (strength < 40) {
            strengthLevel.style.backgroundColor = '#e74c3c';
            strengthText.textContent = 'Weak';
        } else if (strength < 70) {
            strengthLevel.style.backgroundColor = '#f39c12';
            strengthText.textContent = 'Medium';
        } else if (strength < 90) {
            strengthLevel.style.backgroundColor = '#3498db';
            strengthText.textContent = 'Strong';
        } else {
            strengthLevel.style.backgroundColor = '#2ecc71';
            strengthText.textContent = 'Very Strong';
        }
    }
    
    function checkPasswordRules(password) {
        const hasLength = password.length >= 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        
        // Update rule indicators
        updateRuleIndicator(lengthRule, hasLength);
        updateRuleIndicator(uppercaseRule, hasUppercase);
        updateRuleIndicator(numberRule, hasNumber);
        updateRuleIndicator(specialRule, hasSpecial);
    }
    
    function updateRuleIndicator(ruleElement, isValid) {
        if (isValid) {
            ruleElement.classList.add('valid');
        } else {
            ruleElement.classList.remove('valid');
        }
    }
    
    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        
        if (confirmPassword.length === 0) {
            passwordMatch.classList.remove('visible', 'valid');
            return;
        }
        
        const isMatch = password === confirmPassword;
        
        if (isMatch && password.length > 0) {
            passwordMatch.textContent = 'Passwords match';
            passwordMatch.classList.add('visible', 'valid');
        } else if (password.length > 0) {
            passwordMatch.textContent = 'Passwords do not match';
            passwordMatch.classList.add('visible');
            passwordMatch.classList.remove('valid');
        }
    }
    
    // Event listeners
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const strength = checkPasswordStrength(this.value);
            updateStrengthDisplay(strength);
            checkPasswordRules(this.value);
            checkPasswordMatch();
        });
    }
    
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    }
    
    // // Form submission
    // const form = document.getElementById('signupForm');
    // if (form) {
    //     form.addEventListener('submit', function(e) {
    //         e.preventDefault();
            
    //         const password = passwordInput.value;
    //         const confirmPassword = confirmPasswordInput.value;
    //         const terms = document.getElementById('terms').checked;
            
    //         if (password !== confirmPassword) {
    //             alert('Passwords do not match!');
    //             return;
    //         }
            
    //         if (!terms) {
    //             alert('Please agree to the Terms of Service and Privacy Policy');
    //             return;
    //         }
            
    //         alert('Account created successfully! Redirecting to login page...');
    //     });
    // }
});