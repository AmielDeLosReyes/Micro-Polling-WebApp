

function SignupForm(event) {
    var valid = true;
    var warnings = "";

    // Get field values
    var elements = event.currentTarget;
    var screenName = elements[0].value;
    var email = elements[1].value;
    var password = elements[2].value;
    var confirmPassword = elements[3].value;
    var emailFormat =  /^[a-zA-Z0-9.!#$%&'*+\=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    

    //-- validate email --
    if (email == null || email == ""){
        warnings += "Email is empty.\n";
        valid = false;
     }else if(email.length > 60){
        warnings += "Max length for email is 60 characters.\n";
        valid = false;
     }else if(!(email.match(emailFormat))) {
         warnings += "Invalid email address!\n";
         valid = false;
     }


     // Validate Screen Name 
     if (screenName == null || screenName == "") {
        warnings += "Email is empty.\n";
        valid = false;
     } else if (!(/^\S{3,}$/.test(screenName) || !(/^[A-Za-z]+$/.test(screenName)))) {
        warnings += "Password cannot have whitespaces or any non-word characters!\n";
        valid = false;
     }

     // Validate Password
      if(password == null || password == "") {
         warnings += "Password is empty.\n";
         valid = false;
      }else if(password.length != 8) {
         warnings += "Password length must be 8 characters!\n";
         valid = false;
      }

      // Validate Confirm Password
      if(confirmPassword == null || confirmPassword == "") {
         warnings += "Confirm Password is empty.\n";
         valid = false;
      } else if(password != confirmPassword) {
      warnings += "Password does not match!\n";
      valid = false;
      }

      if(valid == false) {    
         alert(warnings);

         //prevent form to be submitted if one of above fields is invalid
         event.preventDefault();
      }else {
         alert("Account created successfully!");
      }

}