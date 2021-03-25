//hide an element when close button clicked
function hide(element_id) {
    document.getElementById(element_id).style.display = "none";
}

//function to show an element
function show(element_id) {
    document.getElementById(element_id).style.display = "block";
}

//function to change delete button to confirm, to confirm delete operation
function deleteConfirmation() {
    let button = document.getElementById("delete-button");
    if (button.value == "Delete") {
        button.value = "Confirm"; //change button to 'Confirm'
        return false; //form won't be submitted
    } else {
        return true; //form will be submitted
    }
}

//function to validate time to ensure start time is earlier than end time
function validateTime(start_time,end_time) {
    let time1 = document.getElementById(start_time).value;
    let time2 = document.getElementById(end_time).value;

    if (time1 > time2) {
        alert("Start time must be earlier than end time");
        return false;
    } else {
        return true;
    }
}

//function to check if two passwords match
function checkPasswordMatch() {
    let new_password = document.getElementById("new_password").value;
    let confirm_password = document.getElementById("confirm_password").value;

    if (new_password == confirm_password) {
        return checkPasswordLength();
    } else {
        alert("Passwords do not match.");
        return false;
    }

}

//check if password length less than 8 characters
function checkPasswordLength() {
    let new_password = document.getElementById("new_password").value;
    let new_length = new_password.length;

    if (new_length < 8) {
        alert("New password length must be greater than 7.");
        return false;
    } else {
        return checkPasswordSAO();
    }
}

//function to check if the new password is the same as the old password
function checkPasswordSAO() {
    let current_password = document.getElementById("current_password").value;
    let new_password = document.getElementById("new_password").value;

    if (current_password == new_password) {
        alert("New password same as old password.");
        return false;
    } else {
        return true;
    }
}

