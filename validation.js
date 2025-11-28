document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    const firstname = document.getElementById("firstname");
    const lastname = document.getElementById("lastname");
    const email = document.getElementById("email");
    const tel = document.getElementById("tel");
    const dob = document.getElementById("dob");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm-password");
    const address = document.getElementById("address");

    // helper functions to mark fields
    function setValid(field) {
        field.classList.remove("invalid");
        field.classList.add("valid");
    }
    function setInvalid(field) {
        field.classList.remove("valid");
        field.classList.add("invalid");
    }

    function validateName(field) {
        if (field.value.trim().length >= 2) {
            setValid(field);
            return true;
        } else {
            setInvalid(field);
            return false;
        }
    }

    function validateEmail() {
        if (email.validity.valid) {
            setValid(email);
            return true;
        } else {
            setInvalid(email);
            return false;
        }
    }

    function validateTel() {
        const regex = /^\+\d{6,15}$/;
        if (regex.test(tel.value.trim())) {
            setValid(tel);
            return true;
        } else {
            setInvalid(tel);
            return false;
        }
    }

    function validateDob() {
        if (dob.validity.valid) {
            setValid(dob);
            return true;
        } else {
            setInvalid(dob);
            return false;
        }
    }

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

    function validateConfirmPassword() {
        if (confirmPassword.value === password.value && confirmPassword.value !== "") {
            setValid(confirmPassword);
            return true;
        } else {
            setInvalid(confirmPassword);
            return false;
        }
    }

    function validateAddress() {
        const regex = /^[A-Za-z\s]+\s\d{1,3}$/;
        if (regex.test(address.value.trim())) {
            setValid(address);
            return true;
        } else {
            setInvalid(address);
            return false;
        }
    }

    // validate all fields on submit
    form.addEventListener("submit", function (e) {
        const validFirstname = validateName(firstname);
        const validLastname = validateName(lastname);
        const validEmail = validateEmail();
        const validTel = validateTel();
        const validDob = validateDob();
        const validPassword = validatePassword();
        const validConfirmPassword = validateConfirmPassword();
        const validAddress = validateAddress();

        if (
            !validFirstname ||
            !validLastname ||
            !validEmail ||
            !validTel ||
            !validDob ||
            !validPassword ||
            !validConfirmPassword ||
            !validAddress
        ) {
            e.preventDefault();
            alert("Please correct the highlighted fields.");
        }
    });
});
