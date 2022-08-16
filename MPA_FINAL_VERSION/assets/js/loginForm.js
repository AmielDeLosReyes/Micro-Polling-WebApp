// References:
// https://www.simplilearn.com/tutorials/javascript-tutorial/email-validation-in-javascript - email Format vlaidation

function loginForm(event) {
    var valid = true;
    


    // Get field values
    var elements = event.currentTarget;
    var email = elements[0].value;
    var password = elements[1].value;
    var emailFormat = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;

    // Get reference on message errors
    var msg_email = document.getElementById("msg_email");
    var msg_pswd = document.getElementById("msg_pswd");
    msg_email.innerHTML  = "";
    msg_pswd.innerHTML = "";

    //Variables for DOM Manipulation commands
    var textNode;

    //-- validate email --
    if (email == null || email == ""){
        textNode = document.createTextNode("Email address is empty.");
        msg_email.appendChild(textNode);
        valid = false;
     }else if(email.length > 60){
        textNode = document.createTextNode("Email address is too long. Maximum is 60 characters.");
        msg_email.appendChild(textNode);
        valid = false;
     }else if(!(email.match(emailFormat))) {
        textNode = document.createTextNode("Email address wrong format. example: username@example.com");
        msg_email.appendChild(textNode);
         valid = false;
     }

    //-- validate password --
    if(password == null || password == "") {
        textNode = document.createTextNode("Password is empty.");
        msg_pswd.appendChild(textNode);
        valid = false;
    }else if(password.length < 8) {
        textNode = document.createTextNode("Passwords must be 8 characters or longer.");
        msg_pswd.appendChild(textNode);
        valid = false;
    }else if (!(/^\S{3,}$/.test(password))) {
        textNode = document.createTextNode("Password is invalid. It must contain letters and at least one digit.");
        msg_pswd.appendChild(textNode);
        valid = false;
    }

    if(valid == false) {    
        
        //prevent form to be submitted if one of above fields is invalid
        event.preventDefault();
     }else {
        document.location.href = 'views/pollManagementPage.html';
     }
    

}