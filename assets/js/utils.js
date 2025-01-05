function viewDetails(id) {
    window.location = "../../pages/Game_details.php?id=" + id;
}

function addToCart(button, id) {
    $.ajax("../../pages/index.php", {
        method: "post",
        data: {
            action: "add_to_cart",
            id: id
        },
        success: function (result) {
            button.remove();
        }
    });
}