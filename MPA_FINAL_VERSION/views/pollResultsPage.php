<?php
session_start();

// TODO: post poll question, answers, and vote counts, this is just a display.
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml" lang="en">
<head>
<title>BiggerPicture - Poll Results Page</title>

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

    <!--  -->
    <div class="nav">
        <ul class="horizontal">
            <li>
                <a href="../index.php">Main Page</a>
            </li>
            <li>
                <a href="pollVotePage.php">Poll Vote Page</a>
            </li>
            <li>
                <a class="active" href="pollResultsPage.php">Poll Results Page</a>
            </li>
          
        </ul>
    </div>

    <!-- Most Recent Active Polls Part -->
    <div class="section" id="me">
        <h2>Welcome to the Poll Results Page!</h2>

        <div class="article">
            <p>Public page (no login required) that shows the results of a specific poll (the question and a graphical representation of the number of votes for each answer).</p>
            <p>Should include the screen name and avatar of the user that created the poll.</p>
            <p>This page may be accessed from the Main Page, or from logged-in user’s Poll Management Page</p>
        </div>
    </div>

    <div class="section" id="classes">
        <?php
            // Establish Database Connection
            $db = new PDO("mysql:host=localhost; dbname=aqd157", "aqd157", "X4vi3r!");
            $query = "SELECT u.user_id, p.created_dt, u.screen_name, u.avatar, p.poll_id, p.question, a.answer_id, a.answer, 
            (SELECT COUNT(*) from Votes v WHERE v.answer_id = a.answer_id) as vote_count
            FROM Polls p, Answers a, Users u 
            WHERE p.poll_id = a.poll_id AND u.user_id = p.user_id
            ORDER BY p.created_dt DESC";
            $result = $db->query($query);

            $tempPollId = "";

            
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                
                $question = $row["question"];
                $pollId = $row["poll_id"];
                $answer = $row["answer"];
                $answerId = $row["answer_id"];
                $screenName = $row["screen_name"];
                $userAvatar = $row["avatar"];
                $voteCount = $row['vote_count'];
                $createdDt = $row['created_dt'];

                // Display only the question once
                if ($tempPollId != $pollId) {
                    if ($tempPollId != $pollId && $tempPollId != "") {

                        echo '</div>';
                    }
                    // echo '<form method="post" action="pollVotePage.php">';
                    echo '<h3>Poll Created by: <img src="../assets/' . $userAvatar . '" alt="logo" height="30px" width="50px"/>&nbsp;&nbsp;' . $screenName . ' on ' . $createdDt . '</h3>';
                    echo '<div class="article"><h4>' . $question . '</h4> ';

                    echo '- ' . $answer . ' Votes: ' . $voteCount . "<br /><br />";
                    
                }
                // Display the answers
                else {
                    echo '- ' . $answer . ' Votes: ' . $voteCount . "<br /><br />";
                }

                $tempPollId = $pollId;
            }
        ?>

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


