document.addEventListener('DOMContentLoaded', function () {
    const signupForm = document.getElementById('signupForm');
    const fnameInput = document.getElementById('fname');
    const lnameInput = document.getElementById('lname');
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

    fnameInput.addEventListener('input', () => validateInput(fnameInput));
    lnameInput.addEventListener('input', () => validateInput(lnameInput));
    emailInput.addEventListener('input', () => validateInput(emailInput));
    passwordInput.addEventListener('input', () => validateInput(passwordInput));

    signupForm.addEventListener('submit', function (event) {
        const isFnameValid = validateInput(fnameInput);
        const isLnameValid = validateInput(lnameInput);
        const isEmailValid = validateInput(emailInput);
        const isPasswordValid = validateInput(passwordInput);

        if (!isFnameValid || !isLnameValid || !isEmailValid || !isPasswordValid) {
            event.preventDefault();
            alert('Veuillez remplir tous les champs correctement.');
        }
    });
});
