document.getElementById('watchlist').addEventListener('click', addToWatchlist);

function addToWatchlist(event) {

    event.preventDefault();
    // Get the link object you click in the DOM
    let watchlistLink = event.currentTarget;
    let link = watchlistLink.href;

    // Send an HTTP request with fetch to the URI defined in the href

    fetch(link)

        // Extract the JSON from the response

        .then(res => res.json())

        // Then update the icon

        .then(function(res) {

            let watchlistIcon = watchlistLink.firstElementChild;

            if (res.isInWatchList) {

                watchlistIcon.classList.remove('bi-heart'); // Remove the .bi-heart (empty heart) from classes in <i> element

                watchlistIcon.classList.add('bi-heart-fill'); // Add the .bi-heart-fill (full heart) from classes in <i> element

            } else {

                watchlistIcon.classList.remove('bi-heart-fill'); // Remove the .bi-heart-fill (full heart) from classes in <i> element

                watchlistIcon.classList.add('bi-heart'); // Add the .bi-heart (empty heart) from classes in <i> element

            }

        });
}