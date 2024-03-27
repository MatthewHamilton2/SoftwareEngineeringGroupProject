<?php
	include("connect.php");
?>
<!DOCTYPE html>

<html lang="en">

<head>


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styling.css" />
    <title></title>

</head>

<body class="unset">



<div id="sidenavbar" class="sidenav" style="display:none">


    <a href="index.php">Home</a>
    <a href="profilePage.html" class="split">My Profile</a>
    <a href="settings_page/settings.html" class="split">Settings</a>
    <a href="logout.php" class="split">Logout</a>
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

</div>

<header>
    <span class="navSpan" onclick = "openNav()">&#9776;</span>
    <div class="logo">
        <img src="placeHolder.PNG" alt="Collab Nexus Logo">
            <h1>Collab Nexus: Profile Page</h1>
                </div>

                <div class="profile">
                    <img src="profile.png" alt="Profile Picture" class="profile-picture">
                </div>
        </header>
<div id="main">
    <!--homepage header -->
    <!--h3 style="text-align:center; margin-top:-30px; padding: 20px; font-size:40px; padding "></h3> -->

    <h3 style= "margin-top:-25px; font-size:25px; background-color: #0090ff; color: white; padding: 15px">Profile Page</h3>
    <div class="row">
        <div class='profileContainer'>
            <button class="ProfileButton" onclick="appearModal('modalStudentGroups')">
                <img src="profile.png" alt=""></button>
            <?php
                $username = $_SESSION["username"];
                $sql = "SELECT groupid from groups2users WHERE user = '$username'";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['groupid'];
                    $sql = "SELECT groupname from chatgroup WHERE groupid = '$id'";
                    $secondResult = mysqli_query($conn, $sql);
                    $name = mysqli_fetch_assoc($secondResult)['groupname'];
                    echo "
                        <div class = 'groupContainerInner'>
            <div class = groupImageText>
                <a href='studentGroups.php?groupid=" . $id . "'>" . $name . "</a>
            </div>
        </div>
    </div>
</div>
    </body>
</html>