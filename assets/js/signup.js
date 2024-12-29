$("form").submit(function (e) { 
    let usernameField = $("#username");
    let emailField = $("#email");
    let passwordField = $("#password");

    if (usernameField.val() === "") {
        usernameField.addClass("border-danger");
        e.preventDefault();
    } else usernameField.removeClass("border-danger");
    if (emailField.val() === "") {
        emailField.addClass("border-danger");
        e.preventDefault();
    } else emailField.removeClass("border-danger");
    if (passwordField.val() === "") {
        passwordField.addClass("border-danger");
        e.preventDefault();
    } else passwordField.removeClass("border-danger");
});