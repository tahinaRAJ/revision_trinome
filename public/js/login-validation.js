document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    const validateInput = (input) => {
        if (input.value.trim() === '') {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            return false;
        } else {
            input.classList.add('is-valid');
            input.classList.remove('is-invalid');
            return true;
        }
    };

    emailInput.addEventListener('input', () => validateInput(emailInput));
    passwordInput.addEventListener('input', () => validateInput(passwordInput));

    loginForm.addEventListener('submit', function (event) {
        const isEmailValid = validateInput(emailInput);
        const isPasswordValid = validateInput(passwordInput);

        if (!isEmailValid || !isPasswordValid) {
            event.preventDefault();
            alert('Veuillez remplir tous les champs correctement.');
        }
    });
});
