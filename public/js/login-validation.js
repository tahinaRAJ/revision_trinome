document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    const setValid = (input) => {
        input.classList.add('is-valid');
        input.classList.remove('is-invalid');
    };

    const setInvalid = (input) => {
        input.classList.add('is-invalid');
        input.classList.remove('is-valid');
    };

    const isEmail = (v) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    const isPassword = (v) => v.trim().length >= 6;

    const validateEmail = () => {
        const v = emailInput.value.trim();
        if (v === '' || !isEmail(v)) {
            setInvalid(emailInput);
            return false;
        }
        setValid(emailInput);
        return true;
    };

    const validatePassword = () => {
        const v = passwordInput.value;
        if (v.trim() === '' || !isPassword(v)) {
            setInvalid(passwordInput);
            return false;
        }
        setValid(passwordInput);
        return true;
    };

    emailInput.addEventListener('input', validateEmail);
    passwordInput.addEventListener('input', validatePassword);

    loginForm.addEventListener('submit', function (event) {
        const okEmail = validateEmail();
        const okPass = validatePassword();
        if (!okEmail || !okPass) {
            event.preventDefault();
            alert('Veuillez corriger les champs en rouge.');
        }
    });
});
