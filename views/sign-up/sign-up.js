window.onload = function () {
    "use strict";

    var inputFields = document.getElementsByClassName("signup__input");
    var submitButton = document.getElementsByClassName("signup__submit")[0];

    console.log(inputFields);

    console.log(document.getElementsByClassName("signup")[0].checkValidity());

    submitButton.addEventListener("click", function (event) {
        event.preventDefault();

        console.log("clicked");
    })
};
