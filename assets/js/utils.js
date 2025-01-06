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
            $(button).replaceWith(`<button disabled type="button" class="btn btn-primary position-absolute m-2">In Cart</button>`);
        }
    });
}