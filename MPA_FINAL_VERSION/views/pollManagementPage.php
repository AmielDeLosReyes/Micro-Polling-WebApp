<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml" lang="en">
<head>
<title>BiggerPicture - Poll Management Page</title>

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

    <div>
        <!-- Avatar Picture -->
        <img src="<?php if(isset($_SESSION["emailAdd"])) {echo $_SESSION["avatar"];} ?>" alt="Avatar" class="avatarPic" style="height:70px;width:80px;" />
        <?php
        //If somebody is logged in, display a welcome message
        if(isset($_SESSION["emailAdd"])) {
        ?>
            <h3>Welcome, logged in as: <?=$_SESSION["screenName"]?></h3>	

        <?php }
        ?> <a href="logout.php">Logout</a> <br/>
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
        <h2>Welcome to the Poll Management Page!</h2>

        <div class="article">
            <p>Screen Name: <?php echo $_SESSION['screenName']; ?></p>
            <p>Email: <?php echo $_SESSION['emailAdd']; ?></p>
            <p>User ID: <?php echo $_SESSION['uid']; ?></p>
            
        </div>
    </div>

    <!-- Most Recent Active Polls Part -->
    <div class="section" id="me">
        <h2>Polls You've Posted</h2>

        <div class="article">

            <ol>
                <?php 
                    
                    $db = new PDO("mysql:host=localhost; dbname=aqd157", "aqd157", "X4vi3r!");
                    $uid = $_SESSION["uid"];
                    $query = "SELECT * FROM Polls WHERE user_id = '$uid' ORDER BY created_dt DESC";
                    $result = $db->query($query);

                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $userPollQuestion = $row['question'];
                        $userPollDateCreated = $row['created_dt'];
                        
                        echo '<li>' . $userPollQuestion . ' (Date Created: '. $userPollDateCreated .  ')</li>';
                    }
                ?>  
            </ol>
            <p>
                &nbsp;&nbsp;&nbsp;&nbsp;<button onclick="window.location.href='pollCreationPage.php';">Post a New Poll</button>
            </p>
        </div>
    </div>

    </div>

        <div class="footer">
            <p>&copy; 2022 Amiel De Los Reyes' CS215 Assignment.</p>
        </div>

</body>
</html>


