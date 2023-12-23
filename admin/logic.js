// Function to toggle form visibility
function toggleForm(formId) {
    // Get the clicked button and its form
    var clickedButton = document.querySelector('button[data-form="' + formId + '"]');
    var form = document.getElementById(formId);

    // Hide all forms and deactivate all buttons
    var allForms = document.querySelectorAll('.form');
    var allButtons = document.querySelectorAll('.button-container button');
    
    allForms.forEach(function (f) {
        f.classList.remove('show');
    });

    allButtons.forEach(function (btn) {
        btn.classList.remove('active');
    });

    // Show the clicked form and activate the clicked button
    form.classList.add('show');
    clickedButton.classList.add('active');

    // Get the height of the header
    var headerHeight = document.querySelector('header').offsetHeight;

    // Shift the form container down when showing the form
    if (form.classList.contains('show')) {
        document.querySelector('.form-container').style.marginTop = headerHeight + 'px';
    } else {
        document.querySelector('.form-container').style.marginTop = '0';
    }
}
function validateAdd() {
    // Get the file input element
    var fileInput = document.getElementById("imageUpload");
  

    // Check if a file is selected
    if (fileInput.files.length > 0) {
      
        var selectedFile = fileInput.files[0];

       
        var fileName = selectedFile.name;
       
    
        var newPath = "assets\\Car Images\\" + fileName;
        alert(newPath);

    }

    // Continue with your form validation logic...

    return false; // Prevent form submission for testing
}
