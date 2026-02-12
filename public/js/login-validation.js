document.getElementById('loginForm').addEventListener('submit', function (event) {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    if (email.trim() === '' || password.trim() === '') {
        alert('Veuillez remplir tous les champs.');
        event.preventDefault();
    }
});
