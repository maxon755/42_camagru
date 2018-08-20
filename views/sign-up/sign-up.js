window.onload = function () {
    "use strict";

    var inputFields = document.getElementsByClassName("signup__input");
    var submitButton = document.getElementById("signup__submit");


    HTMLCollection.prototype.addEvent = function (eventName, handler) {
        for (var i = 0; i < this.length; i++) {
            this[i].addEventListener(eventName, handler);
        }
    }

    function handleResponse(response, input, validation){
        if (response){
            input.classList.remove("invalid-input");
            input.classList.add("valid-input");
            validation.classList.remove("invalid-message");
            validation.classList.add("valid-message");
        }
        else {
            input.classList.remove("valid-input");
            input.classList.add("invalid-input");
            validation.classList.remove("valid-message");
            validation.classList.add("invalid-message");
        }
    }

    submitButton.addEventListener("click", function (event) {
        event.preventDefault();

        var isFormValid = checkInputFields();

        if (!isFormValid)
            return ;


        var userInput = {
            'userName': "Maxsim",
            'password': "7777",
            'email': "maks@gmail.com",
            'firstName': "Максим",
            'secondName': "Гайдук"
        }
        console.log("clicked");
    })

    function checkInputFields() {
        var isFormValid = true;

        var inputChecker = new InputChecker();

        isFormValid = checkUsername();
        isFormValid = checkEmail();
        isFormValid = checkPassword();
        isFormValid = checkRepeatPassword();

        return isFormValid;

        function checkUsername() {
            var inputField = document.getElementById("signup__username");
            if (inputField.classList.contains("invalid-input"))
                return false;

            var username = inputField.value;
            var validationField = inputField.nextElementSibling;


            var response = inputChecker.checkUsernameField(username);
            if (!response.status) {
                validationField.textContent = response.message;
                handleResponse(response.status, inputField, validationField)
            }
            return response.status;
        }

        function checkEmail() {
            var inputField = document.getElementById("signup__email");
            if (inputField.classList.contains("invalid-input"))
                return false;

            var email = inputField.value;
            var validationField = inputField.nextElementSibling;


            var response = inputChecker.checkEmailField(email);
            if (!response.status) {
                validationField.textContent = response.message;
                handleResponse(response.status, inputField, validationField)
            }
            return response.status;
        }

        function checkPassword() {
            var inputField = document.getElementById("signup__password");
            if (inputField.classList.contains("invalid-input"))
                return false;

            var password = inputField.value;
            var validationField = inputField.nextElementSibling;

            var response = inputChecker.checkPasswordField(password);
            if (!response.status) {
                validationField.textContent = response.message;
                handleResponse(response.status, inputField, validationField)
            }
            return response.status;
        }

        function checkRepeatPassword() {
            var inputField = document.getElementById("signup__repeat-password");
            if (inputField.classList.contains("invalid-input"))
                return false;

            var passwordField = document.getElementById("signup__password");
            var password = passwordField.value;
            var passwordRepeat = inputField.value;
            var validationField = inputField.nextElementSibling;

            var response = inputChecker.checkUsernameField(passwordRepeat);
            if (!response.status) {
                validationField.textContent = response.message;
                handleResponse(response.status, inputField, validationField)
            }
            return response.status;
        }
    }


    /*
        Username input handling
     */
    var usernameField = document.getElementById("signup__username");
    var timerIdUser;
    var timerIdUserInput;

    usernameField.addEventListener("input", function (event) {
        clearTimeout(timerIdUser);
        clearTimeout(timerIdUserInput);

        var inputField = this;
        var username = this.value;
        var validationField = this.nextElementSibling;

        timerIdUserInput = setTimeout (function () {
            var inputChecker = new InputChecker();

            var response = inputChecker.checkUsernameField(username);
            validationField.textContent = response.message;
            if (!response.status) {
                handleResponse(response.status, inputField, validationField)
                return;
            }
            else {
                timerIdUser = setTimeout(function () {
                    checkUserNameOnServer(username, inputField, validationField);
                }, 1000);
            }
        }, 1000)
    });

    function checkUserNameOnServer(username, inputField, validationField) {
        var formData = new FormData();
        var xhr = new XMLHttpRequest();

        (function (xhr, inputField, validationField) {
            xhr.onload = function () {
                console.log(this.responseText)
                try {
                    var response = JSON.parse(this.responseText);
                }
                catch (e) {
                    return;
                }
                handleResponse(response['available'], inputField, validationField)
                if (response['available'])
                    validationField.textContent = "Username is available";
                else
                    validationField.textContent = "Username is unavailable";
            };
        }(xhr, inputField, validationField));

        formData.append('username', username);
        xhr.open('post', 'sign-up/check-username');
        xhr.send(formData);
    };

    /*
        Email input handling
     */
    var emailField = document.getElementById("signup__email");
    var timerIdEmail;
    var timerIdEmailInput;

    emailField.addEventListener("input", function (event) {
        clearTimeout(timerIdEmail);
        clearTimeout(timerIdEmailInput);

        var inputField = this;
        var email = this.value;
        var validationField = this.nextElementSibling;

        timerIdEmailInput = setTimeout(function () {
            var inputChecker = new InputChecker();
            var response = inputChecker.checkEmailField(email);
            validationField.textContent = response.message;
            if (!response.status) {
                handleResponse(response.status, inputField, validationField)
                return;
            }
            else {
                timerIdEmail = setTimeout(function () {
                    checkEmailOnServer(email, inputField, validationField);
                }, 1000);
            }
        }, 1000);
    });

    function checkEmailOnServer(email, inputField, validationField) {
        var formData = new FormData();
        var xhr = new XMLHttpRequest();

        (function (xhr, usernameValidation) {
            xhr.onload = function () {
                try {
                    var response = JSON.parse(this.responseText);
                }
                catch (e) {
                    return;
                }
                handleResponse(response['available'], inputField, validationField);
                if (response['available'])
                    validationField.textContent = "Email is available";
                else
                    validationField.textContent = "Email is already used";
            };
        }(xhr, inputField, validationField));

        formData.append('email', email);
        xhr.open('post', 'sign-up/check-email');
        xhr.send(formData);
    };

    /*
        First name input handling
     */
    var firstNameField = document.getElementById("signup__first-name");
    var timerIdFirstNameInput;

    firstNameField.addEventListener("input", function (event) {
        clearTimeout(timerIdFirstNameInput);

        var inputField = this;
        var firstName = this.value;
        var validationField = this.nextElementSibling;

        timerIdFirstNameInput = setTimeout(function () {
            var inputChecker = new InputChecker();
            var response = inputChecker.checkNameField(firstName);
            validationField.textContent = response.message;
            handleResponse(response.status, inputField, validationField)
            if (!response.status) {
                return;
            }
        }, 1000);
    });

    /*
    Last name input handling
 */
    var lastNameField = document.getElementById("signup__last-name");
    var timerIdLastNameInput;

    lastNameField.addEventListener("input", function (event) {
        clearTimeout(timerIdLastNameInput);

        var inputField = this;
        var lastName = this.value;
        var validationField = this.nextElementSibling;

        timerIdLastNameInput = setTimeout(function () {
            var inputChecker = new InputChecker();
            var response = inputChecker.checkNameField(lastName);
            validationField.textContent = response.message;
            handleResponse(response.status, inputField, validationField)
            if (!response.status) {
                return;
            }
        }, 1000);
    });

    /*
        Password input handling
     */
    var passwordField = document.getElementById("signup__password");
    var timerIdPasswordInput;

    passwordField.addEventListener("input", function (event) {
        clearTimeout(timerIdPasswordInput);

        var inputField = this;
        var password = this.value;
        var validationField = this.nextElementSibling;

        timerIdPasswordInput = setTimeout(function () {
            var inputChecker = new InputChecker();
            var response = inputChecker.checkPasswordField(password);
            validationField.textContent = response.message;
            handleResponse(response.status, inputField, validationField)
            if (!response.status) {
                return;
            }
        }, 1000);
    });

    /*
        Password repeat handling
     */
    var passwordRepeatField = document.getElementById("signup__repeat-password");
    var timerIdPasswordRepeatInput;

    passwordRepeatField.addEventListener("input", function (event) {
        clearTimeout(timerIdPasswordRepeatInput);

        var passwordField = document.getElementById("signup__password");

        var inputField = this;
        var password = passwordField.value;
        var passwordRepeat = this.value;
        var validationField = this.nextElementSibling;

        timerIdPasswordInput = setTimeout(function () {
            var inputChecker = new InputChecker();
            var response = inputChecker.
                        checkPasswordRepeatField(password, passwordRepeat);
            validationField.textContent = response.message;
            handleResponse(response.status, inputField, validationField)
            if (!response.status) {
                return;
            }
        }, 1000);
    });
};



function InputChecker() {

    var MAX_LENGTH = 32;

    var EMPTY_FIELD = "Empty field.";
    var LENGTH_ERROR = "Maximum field length is " + MAX_LENGTH + " characters";
    var INCORRECT_USERNAME = "Incorrenct username. " +
        "It should be an alphanumeric ASCII word. " +
        "Optionally splitted with an underscore.";
    var INCORECT_EMAIL = "Incorect email";
    var INCORECT_LENGTH = "Minimum length is 8 symbols"
    var CAPITAL_ERROR = "The password must contain at least " +
        "one capital letter";
    var DIGIT_ERROR = "The password must contain at least " +
        "one digit";
    var DISMATCH_ERROR = "The password is not match the previous one";
    var EQUAL_PASSWORDS = "The passwords are equal";

    function formResponse(status, message) {
        return {
            status: status,
            message: message
        }
    }

    this.checkUsernameField = function(username) {
        username = username.trim();
        if (!username)
            return formResponse(false, EMPTY_FIELD);
        if (username.length > MAX_LENGTH)
            return formResponse(false, LENGTH_ERROR);

        if (!username.match(/^\w+$/))
            return formResponse(false, INCORRECT_USERNAME);

        return formResponse(true, "");
    }

    this.checkNameField = function (name) {
        if (name.length > MAX_LENGTH)
            return formResponse(false, LENGTH_ERROR);

        return formResponse(true, "");
    }

    this.checkEmailField = function(email) {
        email = email.trim();
        if (!email)
            return formResponse(false, EMPTY_FIELD);
        if (email.length > MAX_LENGTH)
            return formResponse(false, LENGTH_ERROR);

        if (!email.match(/^.+@[a-z]+\.[a-z]+/))
            return formResponse(false, INCORECT_EMAIL);

        return formResponse(true, "");
    }

    this.checkPasswordField = function(password) {
        if (!password)
            return formResponse(false, EMPTY_FIELD);
        if (password.length > MAX_LENGTH)
            return formResponse(false, LENGTH_ERROR);

        if (password.length < 8)
            return formResponse(false, INCORECT_LENGTH);

        if (!password.match(/[А-ЯA-Z]/))
            return formResponse(false, CAPITAL_ERROR);

        if (!password.match(/[0-9]/))
            return formResponse(false, DIGIT_ERROR);

        return formResponse(true, "");
    }

    this.checkPasswordRepeatField = function(password, passwordRepeat) {
        if (!passwordRepeat)
            return formResponse(false, EMPTY_FIELD);
        if (password != passwordRepeat)
            return formResponse(false, DISMATCH_ERROR);
        else
            return formResponse(true, EQUAL_PASSWORDS);
    }
}
