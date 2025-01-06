$('#passwordForm').submit(function(e) {
    let currentPassword = $('#currentPassword');
    let newPassword = $('#newPassword');
    let confirmPassword = $('#confirmPassword');

    let isValid = true; // Track overall form validity

    if (currentPassword.val() == "") {
        setError(currentPassword, "Current Password is Required");
        isValid = false;
    } else {
        setSuccess(currentPassword);
    }

    if (newPassword.val() == "") {
        setError(newPassword, "New Password is Required");
        isValid = false;
    } else {
        setSuccess(newPassword);
    }

    if (confirmPassword.val() == "") {
        setError(confirmPassword, "Password Confirmation is Required");
        isValid = false;
    } else {
        setSuccess(confirmPassword);
    }

    if (newPassword.val() != confirmPassword.val() && newPassword.val() !== "" && confirmPassword.val() !== "") {
        setError(confirmPassword, "New Password and Password Confirmation Must Match");
        isValid = false;
    }

    if (!isValid) e.preventDefault();
});

function setError(element, message) {
    if (element) {
        $(element).addClass("border-danger");
        $(element).removeClass("border-success");
    }
    $("#error").text(message).show();
}

function setSuccess(element) {
    if (element) {
        $(element).removeClass("border-danger");
        $(element).addClass("border-success");
    }
    $("#error").hide();
}
