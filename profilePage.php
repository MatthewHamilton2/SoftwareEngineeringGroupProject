<?php
include("connect.php");
session_start();
$user = $_SESSION['username'];
if(isset($_POST['upload'])){

    $image = $_FILES['profileimage']['tmp_name'];
    $img = addslashes(file_get_contents($image));
    
    $sql = "SELECT * FROM userimage WHERE username = '$user'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $sql = "UPDATE userimage SET groupimage='$img' WHERE username='$user'";
        mysqli_query($conn, $sql);
    }
    else{
        $sql = "INSERT INTO userimage (username, groupimage) VALUES ('$user', '$img')";
        mysqli_query($conn, $sql);
    }
} elseif(isset($_POST['password'])){
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
    $sql = "SELECT password FROM users WHERE (username = '$user')";
    $result = mysqli_query($conn, $sql);
				if(mysqli_num_rows($result) > 0){
					if(password_verify($password, mysqli_fetch_assoc($result)["password"])){
                        $sql = "DELETE FROM users WHERE username = '$user'";
                        mysqli_query($conn, $sql);
                        session_destroy();
                        echo "<script> location.href='login.php';</script>";
					}
					else{
                        $message = "Incorrect Password; Account could not be deleted";
                        echo"<script>alert('$message')</script>";
					}
				}
}
?>

<!DOCTYPE html>

<html lang="en">

<head>


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styling.css" />
    <title>My Profile</title>

</head>

<body class="unset">



<div id="sidenavbar" class="sidenav" style="right:auto; left:0;">
<a href="index.php">Home</a>
			<a href="profilePage.php" class="split">My Profile</a>
			<a href="logout.php" class="split">Logout</a>
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            <a href="statistics.php">Statitics</a>
	</div>

<header id = "header">
    <span class="navSpan" onclick = "openNav()">&#9776;</span>
    <div class="logo">
        <img src="placeHolder.PNG" alt="Collab Nexus Logo">
            <h1>Collab Nexus: Profile Page</h1>
                </div>
        </header>
<div id="main">
    <!--homepage header -->
    <!--h3 style="text-align:center; margin-top:-30px; padding: 20px; font-size:40px; padding "></h3> -->

    <h3 style= "margin-top:-25px; font-size:25px; background-color: #0090ff; color: white; padding: 15px">Profile Page</h3>
    <div class="row">
        <div class='profileContainer'>
            <button class="ProfileButton" style="background-color:white;">
                <?php
                    $sql = "SELECT * FROM userimage WHERE username = '$user'";
                    $result = mysqli_query($conn, $sql);
                
                    if(mysqli_num_rows($result) > 0){
                        $row = mysqli_fetch_assoc($result);
                        $imagedata = $row['groupimage'];
                        echo"<img src='data:image/png;base64," . base64_encode($imagedata) . "' alt='Image' style=\"width:100%; height:100%; border-radius:50%;\">";
                    }
                    else{
                        echo"<img src=\"profile.png\" alt=\"\" style=\"width:100%; height:100%; border-radius:50%; background-color: #0090ff;\">";
                    }
                ?>
    </div>
        </div>
        
    </div>
</div>

<div class="row">
    <div class='profileContainer' style="top:55%;">
                <?php
                $username=$_SESSION['username'];
                echo "<div id = \"profilename\">$username</div>";
                ?>
                <div>
                <dialog id ="profilepicture">
                <form id="profilePicChange" action="" method="post" enctype="multipart/form-data">
                    <button onclick="disappearModal('profilepicture')">X</button>
                    <br>
                    <input type="file" id="profileimage" name="profileimage" accept=".png" required>
                    <br>
                    <button type="submit" name="upload">Upload</button>
                </form>

                </dialog>
                <button onclick="appearModal('profilepicture')">Change Profile Picture</button>
                <br>
                <button onclick="appearModal('deleteModal')" style="background-color: red;">Delete Account</button>

                <dialog id ="deleteModal">
                <form id="profilePicChange" action="" method="post" enctype="multipart/form-data">
                <button onclick="disappearModal('deleteModal')">X</button>
                    <p>Deleting your account will delete all messaeges you have sent, all groups you have created, all events you have made, all announcements you have made, ad
                        nd remove you from all groups.</p><br>
                    <p>This process cannot be reversed. To proceed, enter you password.</p>
                    <input type = "text" name="password" required>
                    <button type="submit">Delete Account</button>
                </form>

                </dialog>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>

		window.onload = closeNav();

		function openNav() {
	document.getElementById("sidenavbar").style.width = "250px";
	document.getElementById("sidenavbar").style.display = "block";
	document.getElementById("main").style.marginLeft = "250px";
    document.getElementById("header").style.marginLeft = "250px";
}

function closeNav() {
	document.getElementById("sidenavbar").style.width = "0";
	document.getElementById("sidenavbar").style.display = "none";
	document.getElementById("main").style.marginLeft = "0";
    document.getElementById("header").style.marginLeft = "0";
}

		function appearModal(modal) {
			document.getElementById(modal).showModal();
		}

		function disappearModal(modal) {
			document.getElementById(modal).close();
		}
	</script>
    </body>
</html>