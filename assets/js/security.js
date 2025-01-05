$(document).ready(function() {
    $('#passwordForm').on('submit', function(e) {
        let currentPassword = $('#currentPassword').val();
        let newPassword = $('#newPassword').val();
        let confirmPassword = $('#confirmPassword').val();
        let errorMassage = $('#error');

        if (newPassword !== confirmPassword) {
            errorMassage.text("new passowrd do not match!");
            setError();
            e.preventDefault();
        }else setSuccess();

        if (currentPassword == "" || newPassword == "" || confirmPassword == "") {
            errorMassage.text("please fill the empty filds!");
            setError();
            e.preventDefault();
        }else setSuccess();
        
    });
});

const setError = () => {
    $("#error").addClass("d-none");
}

const setSuccess = () => {
    $("#error").reomveClass("d-none");
}