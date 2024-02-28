<?php
    include("connect.php");
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $groupid = filter_input(INPUT_POST, "groupid", FILTER_SANITIZE_SPECIAL_CHARS);

    $sql = "INSERT INTO educatorgroups2users (groupid, user) VALUES ('$groupid', '$username')";
		try{
    	mysqli_query($conn, $sql);
        echo"stuff";
		}
		catch(mysqli_sql_exception){
			echo"Invalid Username";
		}
?>