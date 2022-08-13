<?php
$validate = true;
$error = "";
$reg_Email = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
$reg_Pswd = "/^(\S*)?\d+(\S*)?$/";
$reg_Bday = "/^\d{1,2}\/\d{1,2}\/\d{4}$/";
$email = "";
// $date = "mm/dd/yyyy";


// Check if a form was sent:
//   submitSignup is the name of the submit button on the form, 
//   it needs to be set and any non-zero value is true
if (isset($_POST["submitSignup"]) && $_POST["submitSignup"]) {

    // Access inputs
    $screenName = $_POST["screenName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    // $birthdate = $_POST["birthday"];
    

    // Avatar upload
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $avatar = $target_file;
    // Check if image file is a actual image or fake image
    if(isset($_POST["submitSignup"])) {
      $check = getimagesize($_FILES["avatar"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }

    // Check file size
    if ($_FILES["avatar"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["avatar"]["name"]) . " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
    // End of avatar upload

    try {
        //connect to database
        $db = new PDO("mysql:host=localhost; dbname=aqd157", "aqd157", "X4vi3r!");

        //Validate all fields before attempting a query

        // Validate email format
        $emailMatch = preg_match($reg_Email, $email);
        if($email == null || $email == "" || $emailMatch == false) {
            $validate = false;
            $error .= "Invalid email address.\n<br />";
        }

        // Check if the email address is already taken.
        $q1 = "SELECT COUNT(*) FROM User WHERE email = '$email'";
        $count = $db->query($q1)->fetchColumn(); 
        if($count > 0) {
            $validate = false;
            $error .= "Email address already exists.\n";
        } 
              
        // Validate password
        $pswdLen = strlen($password);
        $pswdMatch = preg_match($reg_Pswd, $password);
        if($password == null || $password == "" || $pswdLen < 8 || $pswdMatch == false) {
            $validate = false;
            $error .= "Invalid password.\n<br />";
        }


        // Only attempt to insert new user if all fields valid
        if($validate == true) {
            
            $q2 = "INSERT INTO Users (email, screen_name, password, avatar) VALUES ('$email','$screenName','$password', '$avatar')";

            $r2 = $db->exec($q2);
            
            if ($r2 != false) {
                header("Location: ../index.php");
                $r2 = null;
                $db = null;
                exit();

            } else {
                $r2 = null;
                $validate = false;
                $error .= "Trouble adding new user to database!\n<br />";
            }         
        }
        
        if ($validate == false) {
            $error .= "Signup failed.";
        }
        $db = null;
    } catch (PDOException $e) {
        echo "PDO Error >> " . $e->getMessage() . "\n<br />";
    }
}

// Error printing should be done in a better part of the HTML document.
echo $error;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml" lang="en">
<head>

<title>BiggerPicture - Sign Up Page</title>
<link rel="stylesheet" href="../assets/css/normalize.min.css" />
<link rel="stylesheet" href="../assets/css/style.css" />
<script type="text/javascript" src="../assets/js/signupForm.js"> </script>
</head>
<body>


<div id="login-form-wrap">
  <a href="../index.php"><img src="../assets/images/polling.jpeg" alt="logo" height="80px" width="100px"/></a>BiggerPicture
  <h2>Sign up as a User</h2>

  <!-- Start of forms -->
  <form id="login-form" method="post" action="signup.php" enctype="multipart/form-data">
  <div id="screenNameMsg" class="err_msg"></div>
  <p>
    <input type="text" id="screenName" name="screenName" placeholder="Screen Name" required><i class="validation"><span></span><span></span></i>
  </p>
  <p>
    <input type="text" id="email" name="email" placeholder="Email Address" required><i class="validation"><span></span><span></span></i>
  </p>

  <!-- added fields -->
  <p>
    <input type="password" id="password" name="password" placeholder="Password" required><i class="validation"><span></span><span></span></i>
  </p>

  <p>
    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required><i class="validation"><span></span><span></span></i>
  </p>

  <p>
      <input type="file" id="avatar" name="avatar" style="height:100px;font-size:18px;">
  </p>
  <!-- <p>Birthdate:
      <input type="date" id="avatar" name="birthday" style="font-size: 1rem" >
  </p> -->

  <p>
    <input type="submit" id="login" value="Sign Up" name="submitSignup">
  </p>

  
  </form>
  <!-- End of file -->

  <!-- Sign Up Form DOM Event Registration -->
  <script type="text/javascript"  src="../assets/js/signupFormEventReg.js"></script>

  <div id="create-account-wrap">
    <p>&copy; 2022 Amiel De Los Reyes' CS215 Assignment.</p>
  </div> <!-- create-account-wrap -->
</div> <!-- login-form-wrap -->


<script async src="../assets/js/UA-80520768-2.js" type="647f3f0d7be5400e9d13c353-text/javascript"></script>
<script type="647f3f0d7be5400e9d13c353-text/javascript">
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-80520768-2');
</script>
<script src="../assets/js/rocket-loader.min.js" data-cf-settings="647f3f0d7be5400e9d13c353-|49" defer=""></script></body>
</html>

