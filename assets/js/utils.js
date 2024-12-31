function viewDetails(id) {
    window.location = "../../pages/Game_details.php?id=" + id;
}

function addToCart(button, id) {
    console.log(id);

    $.ajax("../../pages/homePage.php", {
        method: "post",
        data: {
            action: "add_to_cart",
            id: id
        },
        success: function (result) {
            button.disabled = true;
        }
    });
}