function logout() {
    $.ajax("login.php", {
        method: "post",
        data: {
            action: "logout"
        },
        success: function(e) {
            window.location.href = "login.php";
        }
    });
}