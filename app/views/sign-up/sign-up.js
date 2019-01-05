window.onload = function () {
    "use strict";

    var submitButton = document.getElementById("sign_up__submit");

    var inputFields = {
        usernameField       : new InputField("sign_up__username", true),
        firstNameField      : new InputField("sign_up__first-name"),
        lastNameField       : new InputField("sign_up__last-name"),
        emailField          : new InputField("sign_up__email", true),
        passwordField       : new InputField("sign_up__password"),
        repeatPasswordField : new InputField("sign_up__repeat-password")
    };
};


function InputField(elementId, shouldSend) {

    var self = this;

    this.shouldSend         = shouldSend;
    this.elementId          = elementId;
    this.element            = document.getElementById(elementId);
    this.type               = elementId.split('__')[1];
    this.validationField    = this.element.nextElementSibling;
    this.isAvailable        = false;

    var inputChecker = new InputChecker("sign_up__password");

    this.checkValue = inputChecker.getRelatedCheckingMethod(elementId);

    this.element.addEventListener("input", function (event) {
        clearTimeout(self.inputTimerId);
        clearTimeout(self.ajaxTimerId);
        self.isAvailable = false;

        self.inputTimerId = setTimeout(function () {

            if (self.check() && self.shouldSend) {
                self.ajaxTimerId = setTimeout(function() {
                    self.checkAvailability();
                }, 1500);
            }
        }, 1000);
    });

    this.check = function () {
        var inputValue  = self.element.value;
        var response    = self.checkValue(inputValue);
        self.validationField.textContent = response.message;
        self.handleResponse(response.status);
        return response.status;
    };

    this.checkAvailability = function () {
        if (self.element.classList.contains("invalid-input"))
            return ;
        var inputValue = self.element.value;

        var formData    = new FormData();
        var xhr         = new XMLHttpRequest();


        (function (xhr, inputField, validationField) {
            xhr.onload = function () {
                try {
                    var response = JSON.parse(this.responseText);
                }
                catch (e) {
                    return;
                }
                self.isAvailable = response['available'];
                self.handleResponse(response['available'])
                self.validationField.textContent =
                    getMessage(response['available'], self.type)
            };
        }(xhr, self.element, self.validationField));

        formData.append('type', self.type);
        formData.append('value', inputValue);
        xhr.open('post', '/sign-up/check-availability');
        xhr.send(formData);
    };

    this.handleResponse = function(response){
        if (response){
            self.element.classList.remove("invalid-input");
            self.element.classList.add("valid-input");
            self.validationField.classList.remove("invalid-message");
            self.validationField.classList.add("valid-message");
        }
        else {
            self.element.classList.remove("valid-input");
            self.element.classList.add("invalid-input");
            self.validationField.classList.remove("valid-message");
            self.validationField.classList.add("invalid-message");
        }
    };

    function getMessage(available, type){
        type = ucFirst(type);
        if (available)
            return`${type} is available`;
        return `${type} is unavailable`
    };

    function ucFirst(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    };

    this.wasChecked = function() {
        return self.element.classList.contains("valid-input") ||
                self.element.classList.contains("invalid-input");
    };

    this.isValid = function() {
        return self.element.classList.contains("valid-input");
    };
}

function InputChecker(passwordFieldId) {
    var self = this;

    this.passwordFieldId = passwordFieldId;

    var MAX_LENGTH      = 32;
    var PW_MIN_LENGTH   = 8;

    var EMPTY_FIELD         = "Empty field.";

    var LENGTH_ERROR        = "Maximum field length is " + MAX_LENGTH + " characters";
    var INCORRECT_USERNAME  = "Incorrenct username. " +
        "It should be an alphanumeric ASCII word. " +
        "Optionally splitted with an underscore.";

    var INCORRECT_EMAIL     = "Incorect email";

    var PW_LENGTH_ERROR     = "Minimum length is " + PW_MIN_LENGTH + " symbols";
    var PW_CAPITAL_ERROR    = "The password must contain at least one capital letter";
    var PW_DIGIT_ERROR      = "The password must contain at least one digit";

    var DISMATCH_ERROR      = "The password is not match the previous one";
    var EQUAL_PASSWORDS     = "The passwords are equal";

    function formResponse(status, message) {
        return {
            status  : status,
            message : message
        }
    };

    function getCorrectMethodName(elementId) {
        var methodName = elementId.split('__')[1];
        methodName = methodName.replace(/\b\w/g, function(l) {
            return l.toUpperCase()
        });
        methodName = methodName.replace('-', '');
        methodName = `check${methodName}Field`;

        return methodName;
    };

    this.getRelatedCheckingMethod = function (elementId) {
        var methodName = getCorrectMethodName(elementId);
        return this[methodName];
    };

    function lengthCheck (value) {
        if (!value)
            return EMPTY_FIELD;
        if (value.length > MAX_LENGTH)
            return LENGTH_ERROR;
    };

    this.checkUsernameField = function(username) {
        username = username.trim();

        var lengthError = lengthCheck(username);
        if (lengthError)
            return formResponse(false, lengthError);

        if (!username.match(/^\w+$/))
            return formResponse(false, INCORRECT_USERNAME);

        return formResponse(true, "");
    };

    this.checkFirstNameField = function (name) {
        if (name.length > MAX_LENGTH)
            return formResponse(false, LENGTH_ERROR);

        return formResponse(true, "");
    };

    this.checkLastNameField = this.checkFirstNameField;

    this.checkEmailField = function(email) {
        email = email.trim();
        var lengthError = lengthCheck(email);
        if (lengthError)
            return formResponse(false, lengthError);

        if (!email.match(/^.+@[a-z]+\.[a-z]+/))
            return formResponse(false, INCORRECT_EMAIL);

        return formResponse(true, "");
    };

    this.checkPasswordField = function(password) {
        var lengthError = lengthCheck(password);
        if (lengthError)
            return formResponse(false, lengthError);

        if (password.length < 8)
            return formResponse(false, PW_LENGTH_ERROR);

        if (!password.match(/[А-ЯA-Z]/))
            return formResponse(false, PW_CAPITAL_ERROR);

        if (!password.match(/[0-9]/))
            return formResponse(false, PW_DIGIT_ERROR);

        return formResponse(true, "");
    };

    this.checkRepeatPasswordField = function(passwordRepeat) {
        if (!passwordRepeat)
            return formResponse(false, EMPTY_FIELD);
        var password = document.getElementById(self.passwordFieldId).value;
        if (password === passwordRepeat)
            return formResponse(true, EQUAL_PASSWORDS);
        else
            return formResponse(false, DISMATCH_ERROR);
    }
}
