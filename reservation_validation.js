function validateReservation() {
    var startDate = document.getElementById('field1').value;
    var endDate = document.getElementById('field2').value;
    var current = new Date().toJSON();

    if(startDate>endDate || startDate<current){
        alert('Pick Valid Date');
        return false;
    }

    for (var i = 0; i < queryResult.length; i++) {
        var reservationStartDate = queryResult[i].start_date;
        var reservationEndDate = queryResult[i].return_date;
        
        if (startDate <= reservationEndDate && endDate >= reservationStartDate) {
            alert("Selected dates overlap with an existing reservation.");
            return false;
        }
    } 
    return true;
}
