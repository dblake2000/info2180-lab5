/* wait for the page to load - script is in the head so the button doesn't exist yet */
window.addEventListener("DOMContentLoaded", function () {

    /* the lookup button */
    const lookupButton = document.getElementById("lookup");

    /* the text field the user types the country in */
    const countryField = document.getElementById("country");

    /* the div where the results go */
    const resultDiv = document.getElementById("result");

    /* exercise 3 - lookup country - runs when the lookup button is clicked */
    lookupButton.addEventListener("click", function (event) {

        /* stop the page from reloading */
        event.preventDefault();

        /* get what the user typed - trim takes off extra spaces */
        const country = countryField.value.trim();

        /* encodeURIComponent makes the text safe to put in the url */
        const url = "world.php?country=" + encodeURIComponent(country);

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
                resultDiv.textContent = "There was a problem getting the countries.";
                console.log(error);
            });
    });

});
