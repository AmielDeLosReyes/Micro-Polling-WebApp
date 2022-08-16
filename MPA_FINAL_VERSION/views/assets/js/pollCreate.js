


function pollCreate(event) {
    var valid = true;
    var warnings = "";

    // Get field values
    var elements = event.currentTarget;
    var pollQuestion = elements[0].value;
    var ans1 = elements[1].value;
    var ans2 = elements[2].value;
    var ans3 = elements[3].value;
    var ans4 = elements[4].value;
    var ans5 = elements[5].value;

    if (pollQuestion == null || pollQuestion == "") {
        warnings += "Poll question cannot be blank.\n";
        valid = false;
    }else if (pollQuestion.length > 100) {
        warnings += "Poll question can only have a maximum of 100 characters.\n"
        valid = false;
    }

    if (ans1.length > 50 || ans2.length > 50 || ans3.length > 50 || ans4.length > 50 || ans5.length > 50) {
        warnings += "Answers can only have less than 50 characters.\n";
        valid = false;
    }

    if(valid == false) {    
        alert(warnings);

        //prevent form to be submitted if one of above fields is invalid
        event.preventDefault();
     }else {
        alert("Poll created successfully!");
     }
}