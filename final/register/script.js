document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.classList.remove('bi-eye-slash');
            this.classList.add('bi-eye');
        } else {
            passwordInput.type = 'password';
            this.classList.remove('bi-eye');
            this.classList.add('bi-eye-slash');
        }
    });

    document.getElementById('toggleRepeatPassword').addEventListener('click', function() {
        const repeatPasswordInput = document.getElementById('repeat-password');
        if (repeatPasswordInput.type === 'password') {
            repeatPasswordInput.type = 'text';
            this.classList.remove('bi-eye-slash');
            this.classList.add('bi-eye');
        } else {
            repeatPasswordInput.type = 'password';
            this.classList.remove('bi-eye');
            this.classList.add('bi-eye-slash');
        }
    });
});

$(document).ready(function() {
    $('#registrationForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'register.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                var alertContainer = $('#alertContainer');
                alertContainer.removeClass('d-none').html(`<div class="alert alert-${response.status == 'success' ? 'success' : 'danger'}" role="alert">${response.message}</div>`);
            }
        });
    });
});