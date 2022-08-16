<?php
session_start();

if (isset($_POST["submit"]) && $_POST["submit"]) {
    // Establish Database Connection
    $db = new PDO("mysql:host=localhost; dbname=aqd157", "aqd157", "X4vi3r!");
    $answerId = $_POST['answer'];
    $voteDt = date("Y-m-d");

    
    if(isset($_SESSION["uid"])) {
        $query = "INSERT INTO Votes (answer_id, vote_dt) VALUES ('$answerId', '$voteDt')";
        $result = $db->exec($query);
    } else {
        $query = "INSERT INTO Votes (answer_id, vote_dt) VALUES ('$answerId', '$voteDt')";
        $result = $db->exec($query);
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml" lang="en">
<head>
<title>BiggerPicture - Poll Vote Page</title>

<meta name="viewport" content="width=device-width, initial-scale=1" />

<link rel="stylesheet" type="text/css" href="../assets/css/pageDesign.css" />

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

    <!-- div class="nav"igation bar -->
    <div class="nav">
        <ul class="horizontal">
            <li>
                <a href="../index.php">Main Page</a>
            </li>
            <li>
                <a class="active" href="pollVotePage.php">Poll Vote Page</a>
            </li>
            <li>
                <a href="pollResultsPage.php">Poll Results Page</a>
            </li>
          
        </ul>
    </div>

    <!-- Most Recent Active Polls Part -->
    <div class="section" id="me">
        <h2>Welcome to the Poll Vote Page!</h2>

        <div class="article">
            <p>Public page (no login required) that shows a specific polling question and allows the user to select one answer from the list provided.</p>
            <p>Should include the screen name and avatar of the user that created the poll.</p>
            <p>This page may be accessed from the Main Page, or from logged-in user’s Poll Management Page</p>
        </div>
    </div>

    <div class="section" id="votesPage">
        <?php
            // Establish Database Connection
            $db = new PDO("mysql:host=localhost; dbname=aqd157", "aqd157", "X4vi3r!");
            $query = "SELECT u.user_id, p.created_dt, u.screen_name, u.avatar, p.poll_id, p.question, a.answer_id, a.answer
            FROM Polls p, Answers a, Users u
            WHERE p.poll_id = a.poll_id AND u.user_id = p.user_id
            ORDER BY p.created_dt DESC";                 
            $result = $db->query($query);

            $tempPollId = "";
            $counter = 0;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $question = $row["question"];
                $pollId = $row["poll_id"];
                $answer = $row["answer"];
                $answerId = $row["answer_id"];
                $screenName = $row["screen_name"];
                $userAvatar = $row["avatar"];
                $createdDt = $row['created_dt'];
                
                // Display only the question once
                if ($tempPollId != $pollId) {
                    if ($tempPollId != $pollId && $tempPollId != "") {

                        echo '<button id="submitVote' . $counter . '" onclick="testFunction(' .  $counter . ');">Submit</button>';
                        echo '<p id="result' . $counter . '"></p> <br /></div>';
                        $counter++;
                    }
                    //echo '<form method="post" action="pollVotePage.php">';
                    echo '<h3>Poll Created by: <img src="../assets/' . $userAvatar . '" alt="logo" height="30px" width="50px"/>&nbsp;&nbsp;' . $screenName . ' on ' . $createdDt . '</h3>';
                    echo '<div class="article"><h4>' . $question . '</h4> ';

                    echo '<input type="radio" name="vote' . $counter . '" id="vote' . $counter . '" value="' . $answerId . '" />
                    <label for="answer1">' . $answer . '</label><br />';
                }
                // Display the answers
                else {
                    echo '<input type="radio" name="vote' . $counter . '" id="vote' . $counter . '" value="' . $answerId . '" />
                    <label for="answer1">' . $answer . '</label><br />';
                }

                $tempPollId = $pollId;
            }
        ?>
        
        <button id="submitVote<?= $counter; ?>" onclick="testFunction();">Submit</button>
        <br />
        </div>

        <!-- <script src="updateVotes.js"></script> -->
        
        <!-- JS AJAX code -->
        <script>
        function testFunction(counter) {
            // Get form input values
            var name = "vote" + counter;
            var answerId = document.querySelector('input[name="' + name + '"]:checked').value;
            var parms = "answerId=" + answerId;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "updateVotes.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    // Do something after
                    var obj = JSON.parse(xmlhttp.responseText);
                    // alert(xmlhttp.responseText);
                    var voteCount = obj.vote_count;

                    document.getElementById('result' + counter).innerHTML = 'Total Votes for your answer is now: ' + voteCount;

                    // Disable Radio Button and Submit Button
                    document.getElementById('submitVote' + counter).disabled = true;

                    document.querySelector('input[name="' + name + '"]').disabled = true;

                    // Uncheck the redio button
                    document.querySelector('input[name="' + name + '"]').checked = false;

                }
            }

            xmlhttp.send(parms);
        }
        </script>
        </div>

    </div>

    <!-- Sign in Part -->
    <div class="aside" id="like">
        <h2>Current User: <img src="<?php if(isset($_SESSION['uid'])){
            echo $_SESSION['avatar'];
        }?>" alt="logo" height="30px" width="50px"/> <?php if(isset($_SESSION['uid'])) echo $_SESSION['screenName']; ?></h2>

        <div class="article">
          The current user can vote from this public page.
            
        </div>
        </div>

        <div class="footer">
            <p>&copy; 2022 Amiel De Los Reyes' CS215 Assignment.</p>
        </div>

</body>
</html>


