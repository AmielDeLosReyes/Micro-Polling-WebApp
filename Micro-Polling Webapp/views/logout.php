<?php 
// Connect to any existing PHP Session
session_start();

// Destroy the PHP session
session_unset();
session_destroy();
	
// redirect the user back to the login page
header("Location: ../index.php");
exit();

?>
