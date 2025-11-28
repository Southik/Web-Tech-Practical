document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const username = document.getElementById("username");
    const password = document.getElementById("password");

    // helper functions to mark fields
    function setValid(field) {
        field.classList.remove("invalid");
        field.classList.add("valid");
    }

    function setInvalid(field) {
        field.classList.remove("valid");
        field.classList.add("invalid");
    }

    // validate username (email format)
    function validateUsername() {
        if (username.validity.valid) {
            setValid(username);
            return true;
        } else {
            setInvalid(username);
            return false;
        }
    }

    // validate password (same rules as registration)
    function validatePassword() {
        const pass = password.value;
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        if (regex.test(pass)) {
            setValid(password);
            return true;
        } else {
            setInvalid(password);
            return false;
        }
    }

    // validate **only on submit**
    form.addEventListener("submit", function (e) {
        const validUsername = validateUsername();
        const validPassword = validatePassword();

        if (!validUsername || !validPassword) {
            e.preventDefault();
            alert("Please correct the red highlighted fields.");
        }
    });
});
