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

function viewAddGame(event) {
    event.stopPropagation();

    let html = `
    <div class="container mt-5 mb-5 pb-5">
        <h1 class="mb-4">Add a New Game</h1>
        <form>
        <!-- Title -->
        <div class="mb-3 w-50">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" placeholder="Enter game title" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="4" placeholder="Enter game description" required></textarea>
        </div>

        <!-- Gameplay Description -->
        <div class="mb-3">
            <label for="gameplayDesc" class="form-label">Gameplay Description</label>
            <textarea class="form-control" id="gameplayDesc" rows="6" placeholder="Enter gameplay description" required></textarea>
        </div>

        <!-- Price -->
        <div class="mb-3 w-25">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" placeholder="Enter game price" step="0.01" required>
        </div>

        <!-- Genres -->
        <div class="mb-3 w-100">
            <label class="form-label">Genres</label>
            <div class="d-flex">
                <select class="form-select w-25 me-3" required>
                    <option value="Action">Action</option>
                    <option value="Adventure">Adventure</option>
                    <option value="RPG">RPG</option>
                    <option value="Shooter">Shooter</option>
                    <option value="Sports">Sports</option>
                    <option value="Simulation">Simulation</option>
                    <option value="Horror">Horror</option>
                    <option value="Platformer">Platformer</option>
                    <option value="Fighting">Fighting</option>
                    <option value="Battle Royale">Battle Royale</option>
                </select>
                <select class="form-select w-25" required>
                    <option value="Action">Action</option>
                    <option value="Adventure">Adventure</option>
                    <option value="RPG">RPG</option>
                    <option value="Shooter">Shooter</option>
                    <option value="Sports">Sports</option>
                    <option value="Simulation">Simulation</option>
                    <option value="Horror">Horror</option>
                    <option value="Platformer">Platformer</option>
                    <option value="Fighting">Fighting</option>
                    <option value="Battle Royale">Battle Royale</option>
                </select>
                <div class="ms-3">
                    <button id="add-genre" type="button" class="btn btn-primary"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            <small class="form-text text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple genres.</small>
        </div>

        <!-- Cover Image -->
        <div class="mb-3">
            <label for="coverImage" class="form-label">Cover Image</label>
            <input type="file" class="form-control" id="coverImage" accept="image/*" required>
        </div>

        <!-- Hero Image -->
        <div class="mb-3">
            <label for="heroImage" class="form-label">Hero Image</label>
            <input type="file" class="form-control" id="heroImage" accept="image/*" required>
        </div>

        <!-- Screenshots -->
        <div class="mb-3">
            <label for="screenshots" class="form-label">Screenshots</label>
            <input type="file" class="form-control" id="screenshots" accept="image/*" multiple required>
            <small class="form-text text-muted">You can upload multiple screenshots.</small>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Add Game</button>
        </form>
    </div>
    `;

    $("#details").html(html);
}