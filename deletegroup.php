<?php
    include("connect.php");
    session_start();
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $groupid = filter_input(INPUT_POST, "groupid", FILTER_SANITIZE_SPECIAL_CHARS);
    $user = $_SESSION['username'];
    $response = array();

    $sql = "SELECT password FROM users WHERE (username = '$user')";
    $result = mysqli_query($conn, $sql);
				if(mysqli_num_rows($result) > 0){
					if(password_verify($password, mysqli_fetch_assoc($result)["password"])){
                        $sql = "DELETE FROM educatorgroup WHERE groupid = '$groupid'";
                        mysqli_query($conn, $sql);
                        $response['success'] = true;
                        echo json_encode($response);
					}
                    else{
                        $response['success'] = false;
                        echo json_encode($response);
                    }
				}

?>