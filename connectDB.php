<?php
/* Database connection settings */
	$servername = "localhost";
    $username = "root";		//put phpmyadmin username.(default is "root")
    $password = "";			//if phpmyadmin has a password put it here.(default is "root")
    $dbname = "rfidattendance";
    
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
?>