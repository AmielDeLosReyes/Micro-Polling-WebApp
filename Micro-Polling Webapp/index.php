<?php
session_start();

$validate = true;
$error = "";

$reg_Email = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
$reg_Pswd = "/^(\S*)?\d+(\S*)?$/";

$email = "";


if (isset($_SESSION["uid"])) {
    // Direct to phone management
    header("Location: views/pollManagementPage.php");
}

// Check if a form was sent:
//   submitLogin is the name of the submit button on the form, 
//   it needs to be set and any non-zero value is true
if (isset($_POST["submitLogin"]) && $_POST["submitLogin"]) {
    $email = trim($_POST["emailAdd"]);
    $password = trim($_POST["password"]);
    
    //Before using form data for anything, validate it!
    $emailMatch = preg_match($reg_Email, $email);
    if($email == null || $email == "" || $emailMatch == false) {
        $validate = false;
        $error .= "Invalid email address.\n<br />";
    }
        
    $pswdLen = strlen($password);
    $passwordMatch = preg_match($reg_Pswd, $password);
    if($password == null || $password == "" || $pswdLen < 8 || $passwordMatch == false) {
        $validate = false;
        $error .= "Invalid password.\n<br />";
    }
    
    // Only perform the query if all fields are valid
    if($validate == true) {
        try {
            $db = new PDO("mysql:host=localhost; dbname=aqd157", "aqd157", "X4vi3r!");

            //add code here to select * from table User where email = '$email' AND password = '$password'
            // start with $q = 
            $q = "SELECT * FROM Users WHERE email = '$email' AND password = '$password'";

            // Search for the requested email and password combo
            $r = $db->query($q, PDO::FETCH_ASSOC);

            
            // check result length: should be exactly 1 if there's a match.
            if ($r->rowCount() == 1)
            {
                // if there's a match, get the row
                $row = $r->fetch();

                // add identifying information from the row to the session and go to next page
                session_start();
                $_SESSION["emailAdd"] = $row["email"];
                $_SESSION["screenName"] = $row["screen_name"];
                $_SESSION["avatar"] = $row["avatar"];
                $_SESSION["uid"] = $row["user_id"];
                header("Location: views/pollManagementPage.php");
                $r = null;
                $db=null;
                exit();

            // result had wrong length
            } else {
                $validate = false;
                $error .= "The email/password combination was incorrect. Login failed.";
            }
            $r = null;
            $db=null;
        } catch (PDOException $e) {
            die("PDO Error >> " . $e->getMessage() . "\n<br />");
            
        }
    }

    // If validation or query failed, report errors
    // Maybe move this to HTML section of the page 
    if ($validate == false)
    {
        echo $error;
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml" lang="en">
<head>
<title>BiggerPicture's Homepage</title>

<meta name="viewport" content="width=device-width, initial-scale=1" />

<link rel="stylesheet" type="text/css" media="screen and (min-width: 581px)" href="assets/css/pageDesign.css" />
<script type="text/javascript" src="assets/js/loginForm.js"> </script> 
</head>

<body>
    <!-- header part -->
    <div class="header">
        <table>
            <tr>
            <td>
            <img src="assets/images/polling.jpeg" alt="logo" height="80px" width="100px"/></td>
            <td>
            <h2>&nbsp;BiggerPicture - A Micro-Polling Website</h2></td>
            </tr>
        </table>
    </div>

    <!-- navigation bar -->
    <div class="nav">
        <ul class="horizontal">
            <li>
                <a class="active" href="#home">Main Page</a>
            </li>
            <li>
                <a href="views/pollVotePage.php">Poll Vote Page</a>
            </li>
            <li>
                <a href="views/pollResultsPage.php">Poll Results Page</a>
            </li>
          
        </ul>
    </div>


    <div class="section">
        <h2>Welcome to the Main Page!</h2>

<!--         
        <div class="article">
            <p>Show branding.</p>
            

        </div> -->
    </div>

    <!-- Most Recent Active Polls Part -->
    <div class="section" id="me">
        <h2>Top 5 Most Recent Active Polls</h2>

        <div class="article">

        <ol>
            <?php
                $db = new PDO("mysql:host=localhost; dbname=aqd157", "aqd157", "X4vi3r!");
                $query = "SELECT * FROM Polls ORDER BY created_dt DESC LIMIT 5";
                $result = $db->query($query);

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $pollQuestion = $row['question'];
                    $createdDate = $row['created_dt'];

                    echo '<li>' . $pollQuestion . ' (Date Created: ' . $createdDate . ')</li>';
                }
            ?>
            
        </ol>
        </div>
    </div>
<!-- 
    <div class="section" id="classes">
        <h3>Info Here </h3>

        <div class="article">
        <h4>More Info</h4>

        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <br />
        
        </div>

        <div class="article">
        <h4>More Info</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <br />
        
        </div>

    </div> -->

    <!-- Sign in Part -->
    <div class="aside" id="like">
        <h2>Login as User</h2>

        <div class="article">
            <form id="logIn" method="post" action="index.php">
                <table>
                    <tr>
                        <td>&nbsp;</td>
                        <td><label id="msg_email" class="err_msg"></label></td>
                    </tr>

                    <tr>
                        <td>Email Address: </td>
                        <td><input type="text" id="emailAdd" name="emailAdd" /></div>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td><label id="msg_pswd" class="err_msg"></label></td>
			        </tr>

                    <tr>
                        <td>Password: </td>
                        <td><input type="password" id="password" name="password" /></div>
                    </tr>

                </table>
                <br />

                <input type="submit" name="submitLogin">

                <div>
                    Don't have an account? <a href="views/signup.php">Sign up</a>
                </div>

                <script type="text/javascript" src="assets/js/loginFormEventReg.js"> </script> 


        </div>

        <!-- <div class="article">
            <h4>information</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>

        <div class="article">
            <h4>Information</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        </div> -->
        </div>

        <div class="footer">
            <p>&copy; 2022 Amiel De Los Reyes' CS215 Assignment.</p>
        </div>

</body>
</html>


