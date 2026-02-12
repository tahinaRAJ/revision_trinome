document.addEventListener('DOMContentLoaded', function () {
    const signupForm = document.getElementById('signupForm');
    const fnameInput = document.getElementById('fname');
    const lnameInput = document.getElementById('lname');
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

    const isName = (v) => /^[A-Za-zÀ-ÖØ-öø-ÿ '\-]{2,}$/.test(v.trim());
    const isEmail = (v) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    const isPassword = (v) => v.trim().length >= 6;

    const validateName = (input) => {
        const v = input.value;
        if (v.trim() === '' || !isName(v)) {
            setInvalid(input);
            return false;
        }
        setValid(input);
        return true;
    };

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

    fnameInput.addEventListener('input', () => validateName(fnameInput));
    lnameInput.addEventListener('input', () => validateName(lnameInput));
    emailInput.addEventListener('input', validateEmail);
    passwordInput.addEventListener('input', validatePassword);

    signupForm.addEventListener('submit', function (event) {
        const okF = validateName(fnameInput);
        const okL = validateName(lnameInput);
        const okE = validateEmail();
        const okP = validatePassword();

        if (!okF || !okL || !okE || !okP) {
            event.preventDefault();
            alert('Veuillez corriger les champs en rouge.');
        }
    });
});
