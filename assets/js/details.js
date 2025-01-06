function setMainImage(url) {
    $("#mainImage").attr("src", url);
}

function addToCart(button, id) {
    $.ajax("../../pages/Game_details.php", {
        method: "post",
        data: {
            action: "add_to_cart",
            id: id
        },
        success: function (response) {
            $(button).replaceWith(`<button disabled type="button" class="btn btn-primary btn-lg">In Cart</button>`);
        }
    });
}

function refund(button, id) {
    $.ajax("../../pages/Game_details.php", {
        method: "post",
        data: {
            action: "refund",
            id: id
        },
        success: function (response) {
            $(button).replaceWith(`<button type="button" class="btn btn-primary btn-lg1" onclick="addToCart(this, ${id})">Add to Cart</button>`);
        }
    });
}

function updateRating(value) {
    $("#rating").val(value);  
}