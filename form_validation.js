// form-validation.js
document.addEventListener('DOMContentLoaded', function() {
    // Registration form validation
    const registrationForm = document.querySelector('form[action="register_process.php"]');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long!');
                return false;
            }
        });
    }
    
    // User data form validation
    const userDataForm = document.querySelector('form[action="save_user_data.php"]');
    if (userDataForm) {
        userDataForm.addEventListener('submit', function(e) {
            const weight = parseFloat(document.getElementById('weight').value);
            const height = parseFloat(document.getElementById('height').value);
            const age = parseInt(document.getElementById('age').value);
            
            if (weight <= 0 || weight > 500) {
                e.preventDefault();
                alert('Please enter a valid weight!');
                return false;
            }
            
            if (height <= 0 || height > 300) {
                e.preventDefault();
                alert('Please enter a valid height!');
                return false;
            }
            
            if (age <= 0 || age > 120) {
                e.preventDefault();
                alert('Please enter a valid age!');
                return false;
            }
        });
    }
    
    // Profile form validation and submission
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('update_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Profile updated successfully!');
                } else {
                    alert('Error updating profile: ' + data.error);
                }
            })
            .catch(error => {
                alert('Error updating profile: ' + error);
            });
        });
    }
});