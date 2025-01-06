function search() {
    const query = $("#query").val();

    $.ajax("Search_result.php", {
        method: "get",
        data: {
            action: "retrieve",
            query: query
        },
        success: function (response) {
            let list = Object.values(JSON.parse(response));
            viewResults(list);
        }
    });
}

function viewResults(list) {
    let html = "";
    for (game of list) {
        let cartButton = "";
        if (game["state"] == "available")
            cartButton = `<button class="add-to-cart btn btn-primary" value="${game["id"]}"><i class="fa-solid fa-cart-shopping"></i></button>`;
        else if (game["state"] == "in_cart")
            cartButton = `<button class="btn btn-primary" disabled>In Cart</button>`;

        html += `
        <div class="result border rounded d-lg-flex mb-4 h-50" onclick="viewDetails(${game["id"]})">
            <div class="col-lg-2 col-12 rounded-start overflow-hidden">
                <img src="${game["cover"]}" class="h-100 w-100 object-fit-cover">
            </div>
            <div class="card-body col-10 p-4">
                <h5 class="card-title fs-1">${game["title"]}</h5>
                <h5 class="card-text fs-4">$${game["price"]}</h5>
                ${cartButton}
                <p class="card-text mt-3">${game["description"]}</p>
            </div>
        </div>
        `;
    }

    $("#results").html(html);
}

$(".add-to-cart").click(function(e) {
    e.stopPropagation();

    $.ajax("../../pages/Search_result.php", {
        method: "post",
        data: {
            action: "add-to-cart",
            id: $(e.target).val()
        },
        success: function (result) {
            $(e.target).replaceWith(`<button disabled type="button" class="btn btn-primary">In Cart</button>`);
        }
    });
});