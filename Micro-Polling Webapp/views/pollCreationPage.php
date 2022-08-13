<?php
session_start();

if (isset($_POST["submitPoll"]) && $_POST["submitPoll"]) {

    // Access Inputs
    $question = trim($_POST["pollCreationQuestion"]);
    $answer1 = trim($_POST["answer1"]);
    if(isset($_POST["answer2"])) $answer2 = trim($_POST["answer2"]);
    if(isset($_POST["answer3"])) $answer3 = trim($_POST["answer3"]);
    if(isset($_POST["answer4"])) $answer4 = trim($_POST["answer4"]);
    if(isset($_POST["answer5"])) $answer5 = trim($_POST["answer5"]);
    $open_dt = trim($_POST["openDate"]);
    $close_dt = trim($_POST["closeDate"]);
    $uid = $_SESSION["uid"];
    $currentDt = date("Y-m-d");

    try {
        //connect to database
        $db = new PDO("mysql:host=localhost; dbname=aqd157", "aqd157", "X4vi3r!");

        $q1 = "INSERT INTO Polls (user_id, question, created_dt, open_dt, close_dt, last_vote_dt) VALUES ('$uid', '$question', '$currentDt', '$open_dt','$close_dt', '$currentDt')";
        $r1 = $db->exec($q1);
        $poll_id = $db->lastInsertId();

        $q2 = "INSERT INTO Answers (poll_id, answer) VALUES ('$poll_id', '$answer1')";
        $r2 = $db->exec($q2);

        if(isset($_POST["answer2"])) {
            $q3 = "INSERT INTO Answers (poll_id, answer) VALUES ('$poll_id', '$answer2')";
            $r3 = $db->exec($q3);
        }

        if(isset($_POST["answer3"])) {
            $q4 = "INSERT INTO Answers (poll_id, answer) VALUES ('$poll_id', '$answer3')";
            $r4 = $db->exec($q4);
        }
        
        if(isset($_POST["answer4"])) {
            $q5 = "INSERT INTO Answers (poll_id, answer) VALUES ('$poll_id', '$answer4')";
            $r5 = $db->exec($q5);
        }

        if(isset($_POST["answer5"])) {
            $q6 = "INSERT INTO Answers (poll_id, answer) VALUES ('$poll_id', '$answer5')";
            $r6 = $db->exec($q6);
        }

        if ($r1!= false) {
            header("Location: ../index.php");
            $r1 = null;
            $db = null;
            exit();
        } 
        if ($r2!= false) {
            header("Location: ../index.php");
            $r2 = null;
            $db = null;
            exit();
        }  
        if ($r3!= false) {
            header("Location: ../index.php");
            $r3 = null;
            $db = null;
            exit();
        }
        if ($r4!= false) {
            header("Location: ../index.php");
            $r4 = null;
            $db = null;
            exit();
        }
        if ($r5!= false) {
            header("Location: ../index.php");
            $r5 = null;
            $db = null;
            exit();
        }
        if ($r6!= false) {
            header("Location: ../index.php");
            $r6 = null;
            $db = null;
            exit();
        }
        else {
            $r1 = null;
            $r2 = null;
            $r3 = null;
            $r4 = null;
            $r5 = null;
            $r6 = null;
            $error .= "Trouble adding new poll to database!\n<br />";
        }         

    } catch(PDOException $e) {
        echo "PDO Error >> " . $e->getMessage() . "\n<br />";
    }
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml" lang="en">
<head>
<title>BiggerPicture - Poll Creation Page</title>

<meta name="viewport" content="width=device-width, initial-scale=1" />

<link rel="stylesheet" type="text/css" media="screen and (min-width: 581px)" href="../assets/css/pageDesign.css" />


</head>

<body>
    <!-- div class="header" part -->
    <div class="header">
        <table>
            <tr>
            <td>
            <img src="../assets/images/polling.jpeg" alt="logo" height="80px" width="100px"/></td>
            <td>
            <h2>&nbsp;BiggerPicture - A Micro-Polling Website</h2></td>
            </tr>
        </table>
    </div> 

    <!-- Avatar Picture -->
    <img src="<?php echo $_SESSION["avatar"]; ?>" alt="Avatar" class="avatarPic" style="height:70px;width:80px;" />
        <?php
        //If somebody is logged in, display a welcome message
        if(isset($_SESSION["emailAdd"])) {
        ?>

            <h3>Welcome, logged in as: <?=$_SESSION["screenName"]?></h3>	

        <?php 
        //If nobody is logged in, display login and signup page.
        } else {	
        header("Location: views/pollManagementPage.php");
        
        }
        ?>
        <br />
    </div>

    <!-- div class="nav"igation bar -->
    <div class="nav">
        <ul class="horizontal">
            <li>
                <a class="active" href="../index.php">Home</a>
            </li>
            <li>
                <a href="pollVotePage.php">Poll Vote Page</a>
            </li>
            <li>
                <a href="pollResultsPage.php">Poll Results Page</a>
            </li>
            
        </ul>
    </div>


    <div class="section">
        <h2>Welcome to the Poll Creation Page!</h2>
        <div class="article">
            <p>Form that will be used to allow logged-in user to create a new poll.</p>
            <p>Form fields for open and close date/times, questions to be asked, possible answers (up to five).</p>
        </div>
    </div> 
    <!-- Most Recent Active Polls Part -->
    <div class="section" id="me">
        <h2>Create Poll</h2>

        <div class="article">

            <div id="pollCreate">
                <form id="pollCreation" method="post" action="pollCreationPage.php">
                    <!-- Form to create a poll -->

                    <table id="pollTable">
                        <tr>
                            <td>&nbsp;</td>
                            <td><label id="msg_question" class="err_msg"></label></td>
                        </tr>

                        <tr>
                            <td>Question</td>
                            <td><textarea id="pollCreationQuestion" name="pollCreationQuestion" placeholder="Type Your Question Here: " cols="50" rows="10" maxlength="101"></textarea><br/>Character Count: <b id="charCount">0/100</b></td>
                            
                        </tr>
                    </table>
                    <table id="pollAnswerTable1">
                        <tr>
                            <td>&nbsp;</td>
                            <td><label id="msg_answer1" class="err_msg"></label></td>
                        </tr>

                        <tr>
                            <td>Answer: </td>
                            <td><textarea type="text" id="answer1" name="answer1" cols="50" rows="5" maxlength="51"></textarea><br/>Character Count: <b id="ansCharCount1">0/50</b></td>
                        </tr>

                    </table>
                    <table id="pollAnswerTable2"> </table>
                    <table id="pollAnswerTable3"> </table>
                    <table id="pollAnswerTable4"> </table>
                    <table id="pollAnswerTable5"> </table>


                    <input id="addNewButton" type="button" value="Add New Answer" onclick="createNewField();">
                    
                    <!-- Open and Close date code -->
                    <br />
                    <br />
                    <label for="openDate">Open Date:</label>
                    <input type="date" name="openDate" />
                    <br />
                    <br />
                    <label for="closeDate">Close Date:</label>
                    <input type="date" name="closeDate" />
                    <br />
                    <br />
                    <input type="submit" name="submitPoll" />
                </form>
                <!-- onclick="window.location.href='pollManagementPage.php';" -->
                <script type="text/javascript" src="../assets/js/pollCreate.js"> </script> 
                <!-- Poll Creation Event Registration  -->
                <script type="text/javascript" src="../assets/js/pollCreateReg.js"> </script> 

            </div>
        </div> 
    </div> 

    
    <!-- Sign in Part -->
    <div class="aside" id="like">
        
        <div class="article">
            <h4>Information here</h4>
            <p>MORE INFO HERE SOON...... </p>
        </div> 

        <div class="article">
            <h4>News</h4>
            <p>MORE INFO HERE SOON...... </p>

        </div>
        </div> 

        <div class="footer">
            <p>&copy; 2022 Amiel De Los Reyes' CS215 Assignment.</p>
        </div>

</body>
</html>


