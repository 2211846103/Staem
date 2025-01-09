function viewDetails(id) {
    $.ajax("publisher_catalog.php", {
        method: "post",
        data: {
            action: "retrieve-info",
            id: id
        }, success: function (response) {
            let info = JSON.parse(response);
            setInfo(info);
        }
    });
}

function formatPrice(num) {
    const scales = [
        { limit: 999, divisor: 1, label: "" },
        { limit: 9999, divisor: 100, label: "Hundred" },
        { limit: 9999999, divisor: 1_000, label: "Thousand" },
        { limit: 9999999999, divisor: 1_000_000, label: "Million" },
        { limit: Infinity, divisor: 1_000_000_000, label: "Billion" }
    ];

    const { divisor, label } = scales.find(({ limit }) => num < limit);
    const formattedValue = (num / divisor).toFixed(1);
    return label ? `${formattedValue} ${label}` : formattedValue;
}

function formatNumber(num) {
    const scales = [
        { limit: 999, divisor: 1, label: "" },
        { limit: 9999, divisor: 100, label: "Hundred" },
        { limit: 9999999, divisor: 1_000, label: "Thousand" },
        { limit: 9999999999, divisor: 1_000_000, label: "Million" },
        { limit: Infinity, divisor: 1_000_000_000, label: "Billion" }
    ];

    const { divisor, label } = scales.find(({ limit }) => num < limit);
    const formattedValue = (num / divisor).toFixed(0);
    return label ? `${formattedValue} ${label}` : formattedValue;
}

function setInfo(game) {
    let rating = (Math.round(game["details"]["rating"] * 100) / 100).toFixed(1);
    rating = rating == 0 ? "5.0" : rating;

    let copies = formatNumber(game["stats"]["copies_sold"]);
    let refunds = formatNumber(game["stats"]["refunds"]);
    let revenue = formatPrice(game["stats"]["net_revenue"]);

    let html = `
    <div id="game-overview-container" class="w-100 h-50 d-flex flex-column justify-content-around p-4 bg-body-tertiary">
        <h1 class="display-5">${game["details"]["title"]}</h1>
        <div class="d-flex h-25">
            <div class="h-100 w-75">
                <h5>Description</h5>
                <p class="text-body-secondary text-truncate ">
                    ${game["details"]["description"]}
                </p>
            </div>
            <div class="p-3 w-25 d-flex flex-column align-items-start justify-content-center">
                <div class="w-100 d-flex">
                    <span class="fw-bold me-auto">Avg Ratings:</span>
                    <span>${rating} <i class="fa-solid fa-star text-info"></i></span>
                </div>
                <div class="w-100 d-flex">
                    <span class="fw-bold me-auto">Price:</span>
                    <span>$${game["details"]["price"]}</span>
                </div>
            </div>
        </div>
    </div>
    <div id="game-statistics-container" class="border-top py-4 px-5 vh-100">
        <h4 class="display-6">Report:</h4>
        <div class="w-100 row">
            <div class="col-4">
                <div class="card h-100 border bg-body-secondary">
                    <div class="card-body">
                        <h4 class="card-title">Total Purchases:</h4>
                        <h2 class="card-text text-primary">${copies}</h2>
                        <h5 class="card-subtitle text-body-secondary">Copies were sold</h5>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card h-100 border bg-body-secondary">
                    <div class="card-body">
                        <h4 class="card-title">Total Refunds:</h4>
                        <h2 class="card-text text-primary">${refunds}</h2>
                        <h5 class="card-subtitle text-body-secondary">People have Refunded</h5>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card h-100 border bg-body-secondary">
                    <div class="card-body">
                        <h4 class="card-title">Net Revenue:</h4>
                        <h2 class="card-text text-primary">$${revenue}</h2>
                        <h5 class="card-subtitle text-body-secondary">In Net Revenue</h5>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="display-6 mt-5">Reviews:</h4>
        <div class="card container border-0  overflow-y-auto overflow-x-hidden">
            <div id="reviews" class="card-body"></div>
        </div>
    </div>
    `;

    $("#details").html(html);
    fillReviews(game["reviews"]);
}

function fillReviews(reviews) {
    let html = "";
    for (review of reviews) {
        let rating = review["rating"] ? review["rating"] : "None";
        let body = review["body"] ? review["body"] : "None";

        html += `
        <div class="card border mb-3">
            <div class="card-header">Author: ${review["username"]}</div>
            <div class="card-body d-flex align-items-center">
                <div class="card-text me-auto w-75">${body}</div>
                <div class="w-25 d-flex">
                    <span class="fw-bold me-auto">Rating:</span>
                    <span>${rating} <i class="fa-solid fa-star text-info"></i></span>
                </div>
            </div>
        </div>
        `;
    }

    if (reviews.length === 0) {
        html += "<h5 class='text-body-secondary'>No One Has Reviewed Your Game Yet</h5>";
    }

    $("#reviews").html(html);
}

function createElement(tag) {
    return $(document.createElement(tag));
}

function viewAddGame(event) {
    event.stopPropagation();

    let title = createElement("div").addClass("mb-3 w-50");
    title.append('<label for="title" class="form-label">Title:</label>');
    title.append('<input type="text" class="form-control" id="title" placeholder="Enter game title" required>');

    let description = createElement("div").addClass("mb-3");
    description.append('<label for="description" class="form-label">Description:</label>');
    description.append('<textarea class="form-control" id="description" rows="4" placeholder="Enter game description" required></textarea>');

    let gameplayDesc = createElement("div").addClass("mb-3");
    gameplayDesc.append('<label for="gameplay-desc" class="form-label">Gameplay Description:</label>');
    gameplayDesc.append('<textarea class="form-control" id="gameplay-desc" rows="4" placeholder="Enter gameplay description" required></textarea>');

    let price = createElement("div").addClass("mb-3 w-25");
    price.append('<label for="price" class="form-label">Price:</label>');
    price.append(`
        <div class="d-flex align-items-center w-100">
            <div class="h4 me-2 mt-1">$</div>
            <input type="number" class="form-control" id="price" placeholder="Enter Price" required>
        </div>
    `);

    let genres = createElement("div").addClass("mb-3");
    genres.append(`
        <label id="genres" class="form-label">Genres: </label>
        <div class="d-flex">
            <select id="genre-select" class="form-select w-25 me-3">
                <option value="Action">Action</option>
                <option value="Adventure">Adventure</option>
                <option value="RPG">RPG</option>
                <option value="Shooter">Shooter</option>
                <option value="Sports">Sports</option>
                <option value="Simulation">Simulation</option>
                <option value="Horror">Horror</option>
                <option value="Survival">Survival</option>
                <option value="Platformer">Platformer</option>
                <option value="Open World">Open World</option>
                <option value="Battle Royale">Battle Royale</option>
                <option value="Fighting">Fighting</option>
                <option value="Racing">Racing</option>
                <option value="MMORPG">MMORPG</option>
                <option value="Party">Party</option>
            </select>
            <div class="ms-3">
                <button id="add-genre" type="button" class="btn btn-primary"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>
        <div id="error" class="text-danger d-none">Please Choose a Genre</div>
        <small>Choose a Genre then Hit (+) (Max 3)</small>
    `);
    let selectedGenres = new Set();
    genres.find("button").click(function (e) {
        let value = genres.find("select").val();
        if (selectedGenres.size >= 3) return;
        if (selectedGenres.has(value)) return;
        selectedGenres.add(value);
        genres.find("#genres").append(value + ", ");
    });

    let coverField = createElement("div").addClass("mb-3 w-50");
    coverField.append('<label for="coverImage" class="form-label">Cover Image</label>');
    coverField.append('<input type="file" class="form-control" id="coverImage" accept="image/*" required>');

    let heroField = createElement("div").addClass("mb-3 w-50");
    heroField.append('<label for="heroImage" class="form-label">Hero Image</label>');
    heroField.append('<input type="file" class="form-control" id="heroImage" accept="image/*" required>');

    let screenshotsField = createElement("div").addClass("mb-3 w-50");
    screenshotsField.append('<label for="screenshots" class="form-label">Screenshots</label>');
    screenshotsField.append('<input type="file" class="form-control" id="screenshots" accept="image/*" multiple required>');

    let form = createElement("form").attr("enctype", "multipart/form-data");
    form.append(
        title, description, gameplayDesc, price,
        genres, coverField, heroField, screenshotsField
    );
    form.append('<button type="submit" class="btn btn-primary">Add Game</button>');

    form.submit(function (e) {
        e.preventDefault();

        selectedGenresArr = Array.from(selectedGenres);
        if (selectedGenresArr.length == 0) {
            $("#genre-select").addClass("border-danger");
            $("#error").removeClass("d-none");
            return;
        }

        let formData = new FormData();
        formData.append("action", "add-game");
        formData.append("title", $("#title").val());
        formData.append("desc", $("#description").val());
        formData.append("gameDesc", $("#gameplay-desc").val());
        formData.append("price", $("#price").val());
        formData.append("genres", JSON.stringify(selectedGenresArr));
        formData.append("cover", $("#coverImage")[0].files[0]);
        formData.append("hero", $("#heroImage")[0].files[0]);
        let files = $("#screenshots").prop('files');
        for (let i = 0; i < files.length; i++) {
            formData.append("screenshot[]", files[i]);
        }

        $.ajax("publisher_catalog.php", {
            method: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                window.location.reload();
            }
        });
    });

    let container = createElement("div").addClass("container my-5 pb-5");
    container.append('<h1 class="mb-4">Add a New Game</h1>');
    container.append(form);

    $("#details").html(container);
}

$(".delete-btn").click(function (e) {
    e.stopPropagation();
    e.preventDefault();

    $.ajax("publisher_catalog.php", {
        method: "post",
        data: {
            action: "delete-game",
            id: $(this).val()
        },
        success: function (response) {
            window.location.reload();
        }
    });
});