/* wait for the page to load - script is in the head so the button doesn't exist yet */
window.addEventListener("DOMContentLoaded", function () {

    /* the lookup button */
    const lookupButton = document.getElementById("lookup");

    /* exercise 5 - the lookup cities button */
    const citiesButton = document.getElementById("lookup-cities");

    /* the text field the user types the country in */
    const countryField = document.getElementById("country");

    /* the div where the results go */
    const resultDiv = document.getElementById("result");

    /* exercise 5 - moved the ajax request into a function so both buttons can use it */
    /* extra gets added to the end of the url e.g. "&lookup=cities" */
    function getResults(extra) {

        /* get what the user typed - trim takes off extra spaces */
        const country = countryField.value.trim();

        /* encodeURIComponent makes the text safe to put in the url */
        const url = "world.php?country=" + encodeURIComponent(country) + extra;

        /* ajax request to world.php */
        fetch(url)
            .then(function (response) {

                /* something went wrong on the server */
                if (!response.ok) {
                    throw new Error("Request failed");
                }

                /* php sends back html so read it as text */
                return response.text();
            })
            .then(function (data) {

                /* put the html from php inside the result div */
                resultDiv.innerHTML = data;
            })
            .catch(function (error) {

                /* show a message if the request didn't work */
                resultDiv.textContent = "There was a problem getting the results.";
                console.log(error);
            });
    }

    /* exercise 3 - lookup country - runs when the lookup button is clicked */
    lookupButton.addEventListener("click", function (event) {

        /* stop the page from reloading */
        event.preventDefault();

        /* exercise 5 - nothing extra in the url so we get countries */
        getResults("");
    });

    /* exercise 5 - lookup cities - runs when the lookup cities button is clicked */
    citiesButton.addEventListener("click", function (event) {

        /* stop the page from reloading */
        event.preventDefault();

        /* tell world.php we want cities */
        getResults("&lookup=cities");
    });

});
