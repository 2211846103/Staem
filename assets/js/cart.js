$(document).ready(function () {
    updateCart();
});

function updateCart() {
    $.ajax("../../pages/cart.php", {
        method: "post",
        data: {
            action: "get_games"
        },
        success: function (response) {
            let results = JSON.parse(response);
            viewItemsandTotal(results);
        }
    });
}

function viewItemsandTotal(items) {
    let html = `<h2 class="mb-4">My Cart</h2>`;
    let total = 0;
    
    for (game of items) {
        total += game["price"];
        html = html.concat(`
            <div class="card mb-3 cart-item bg-body-secondary h-25">
                <div class="row g-0 align-items-center h-100">
                    <div class="col-2 d-flex justify-content-center">
                        <img src="${game["cover"]}"
                        alt="Product Image">
                    </div>
                    <div class="col-6">
                        <div class="card-body">
                            <h5 class="card-title">${game["title"]}</h5>
                            <p class="card-text text-muted">Base Game</p>
                        </div>
                    </div>
                    <div class="col-2">
                        <p class="card-text">$${game["price"]}</p>
                    </div>
                    <div class="col-2 text-center">
                        <button class="btn btn-sm btn-danger" onclick="removeFromCart(${game["id"]})"><i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `);
    }
    if (items.length === 0) {
        html = html.concat("<h5 class='text-body-secondary'>You haven't Added Any Items to the Cart Yet!</h5>");
    }

    $("#cart_items").html(html);
    $("#total").text("$"+(Math.round(total * 100) / 100).toFixed(2));
}

function removeFromCart(id) {
    $.ajax("../../pages/cart.php", {
        method: "post",
        data: {
            action: "remove-from-cart",
            id: id
        },
        success: function (response) {
            console.log(response);
        }
    });

    updateCart();
}

function cancelOrder() {
    $.ajax("cart.php", {
        method: "post",
        data: {
            action: "cancel-order"
        },
        success: function (response) {
            window.location.href = "index.php";
        }
    });
}

function checkout() {
    $.ajax("cart.php", {
        method: "post",
        data: {
            action: "checkout"
        },
        success: function (response) {
            window.location.href = "Library.php";
        }
    });
}