
function toggleForm(formId) {
    var form = document.getElementById(formId);

    // Check the current state of the form and toggle accordingly
    if (form.classList.contains('show')) {
        form.classList.remove('show');
    } else {
        // Hide all other forms
        var allForms = document.querySelectorAll('.form');
        allForms.forEach(function (f) {
            if (f !== form) {
                f.classList.remove('show');
            }
        });

        form.classList.add('show');
    }
}
function validateInsert() {
    if (document.getElementById("field1").value == "") {
        alert('Add field');
        return false
    }
    if (document.getElementById("field2").value == "") {
        alert('Add field');
        return false
    }
    if (document.getElementById("field3").value == "") {
        alert('Add field');
        return false
    }
    if (document.getElementById("field4").value == "") {
        alert('Add field');
        return false
    }
    var fileInput = document.getElementById("imageUpload");
    var formData = new FormData(document.getElementById("form1"));
    if (fileInput.files.length > 0) {

        var selectedFile = fileInput.files[0];
        var fileName = selectedFile.name;
        var newPath = "assets/Car Images/" + fileName;
        formData.append("image_path", newPath);
    }
    else {
        return false;
    }
    return true;
}

function validateModify() {
    if (document.getElementById("field5").value == "") {
        alert('Add field');
        return false
    }
    if (document.getElementById("field6").value == "") {
        alert('Add field');
        return false
    }
    return true;
}

function validateReservation() {
    if (document.getElementById("field7").value == "") {
        alert('Add field');
        return false
    }
}
function validateDelete() {
    if (document.getElementById("field8").value == "") {
        alert('Add field');
        return false
    }

}
