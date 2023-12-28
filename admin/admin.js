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
    if (document.getElementById("field8").value == "") {
        alert('Add field');
        return false
    }
}
function validateCarRes() {
    if (document.getElementById("field9").value == "") {
        alert('Add field');
        return false
    }
    if (document.getElementById("field10").value == "") {
        alert('Add field');
        return false
    }
    if (document.getElementById("field11").value == "") {
        alert('Add field');
        return false
    }

}
function validateStatus() {
    if (document.getElementById("field12").value == "") {
        alert('Add field');
        return false
    }

}
function validateCustomerRes() {
    if (document.getElementById("field13").value == "") {
        alert('Add field');
        return false
    }
}
function validateFinance() {
    if (document.getElementById("field14").value == "") {
        alert('Add field');
        return false
    }
    if (document.getElementById("field15").value == "") {
        alert('Add field');
        return false
    }
}
function validateStaff() {
    if (document.getElementById("reg1").value == "") {
        alert('Write First Name !')
        return false
    }
    else if (document.getElementById("reg2").value == "") {
        alert('Write Last Name !')
        return false
    }
    else if (document.getElementById("reg3").value == "") {
        alert('Write Email !');
        return false;
    }
    else if (document.getElementById("reg4").value == "") {
        alert('Write Password !');
        return false;
    }
    else if (document.getElementById("reg5").value == "") {
        alert('Write Confirmation Password !');
        return false;
    }
    else if (document.getElementById("reg6").value == "" || document.getElementById("reg6").value > 4 || document.getElementById("reg6").value < 1) {
        alert('Choose Office!');
        return false;
    }
    else {
        if (document.getElementById("reg5").value == document.getElementById("reg4").value)
            return true;
        else {
            alert('Passwords Miss-Match!');
            return false;
        }
    }
}