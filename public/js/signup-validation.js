document.getElementById('signupForm').addEventListener('submit', function (event) {
    var fname = document.getElementById('fname').value;
    var lname = document.getElementById('lname').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    if (fname.trim() === '' || lname.trim() === '' || email.trim() === '' || password.trim() === '') {
        alert('Veuillez remplir tous les champs.');
        event.preventDefault();
    }
});
