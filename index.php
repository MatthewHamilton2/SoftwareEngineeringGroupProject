<?php
session_start();
include("connect.php");
if(!isset($_SESSION['username'])){
    echo "<script> location.href='login.php'; </script>";
}
?>

<!DOCTYPE html>

<html>

<head>


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css" />

</head>

<body class="unset">



<div id="sidenavbar" class="sidenav" style="display:none">


			<a href="index.php">Home</a>
			<a href="Profile.html" class="split">My Profile</a>
			<a href="settings_page/settings.html" class="split">Settings</a>
            <a href="logout.php" class="split">Logout</a>
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

		</div>

        <header>
			<span class="navSpan" onclick = "openNav()">&#9776;</span>
			<div class="logo">
			  <img src="placeHolder.PNG" alt="Collab Nexus Logo">
			  <h1>Task Troopers: Home</h1>
			</div>
			<div class="profile">
			  <img src="placeHolder.PNG" alt="Profile Picture" class="profile-picture">
			</div>
		</header>

    <div id="main">

        <h3 style="text-align:center; font-size:20px">Homepage</h3>

        <h3>Student Groups</h3>
        <div class="row">
            <div class='groupContainer'>
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
                            <div>
                            <img src='./placeHolder.PNG' class='groupImage'></img>
                            </div>
                            <div class = groupImageText>
                                <a href='studentGroups.php?groupid=" . $id . "'>" . $name . "</a>
                            </div>
                        </div>
                    ";
                }
                ?>
            </div>

            <button class="createButton" onclick="appearModal('modalStudentGroups')">+</button>

        </div>

        <dialog id="modalStudentGroups">
            <button onclick="disappearModal('modalStudentGroups')">X</button><br>
            <button id="createStudentGroup" onclick="appearModal('modalCreateStudentGroups'); disappearModal('modalStudentGroups')">Create Group</button><br>
            <button id="joinStudentGroup" onclick="appearModal('modalJoinStudentGroups'); disappearModal('modalStudentGroups')">Join Group</button>
        </dialog>
        <dialog id="modalCreateStudentGroups">
            <button onclick="disappearModal('modalCreateStudentGroups'); appearModal('modalStudentGroups')">&laquo;</button><br>
            <form action="createGroup.php" method="post">
                <input type="text" name="groupName" placeholder="Group Name">
            </form>
        </dialog>
        <dialog id="modalJoinStudentGroups">
            <button onclick="disappearModal('modalJoinStudentGroups'); appearModal('modalStudentGroups')">&laquo;</button><br>
            <form action="joinGroup.php" method="post">
                <input type="text" name="groupCode" placeholder="Group Code">
            </form>
        </dialog>
        
        <h3>Educator Groups</h3>
        <div class="row">
            <div class='groupContainer'>
                <?php
                $username = $_SESSION["username"];
                $sql = "SELECT groupid from educatorgroups2users WHERE user = '$username'";
                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['groupid'];
                    $sql = "SELECT groupname from educatorgroup WHERE groupid = '$id'";
                    $secondResult = mysqli_query($conn, $sql);
                    $name = mysqli_fetch_assoc($secondResult)['groupname'];
                    echo "
        <div class = 'groupContainerInner'>
            <div>
            <img src='./placeHolder.PNG' class='groupImage'></img>
            </div>
            <div class = groupImageText>
                <a href='EducatorGroups.php?groupid=" . $id . "'>" . $name . "</a>
            </div>
        </div>
        ";
                }
                ?>
            </div>

            <button class="createButton" onclick="appearModal('modaleducatorGroups')">+</button>
        </div>

        <dialog id="modaleducatorGroups">
            <button onclick="disappearModal('modaleducatorGroups')">X</button><br>
            <button id="createStudentGroup" onclick="appearModal('modalCreateEducatorGroups'); disappearModal('modaleducatorGroups')">Create Group</button><br>
            <button id="joinStudentGroup" onclick="appearModal('modalJoinEducatorGroups'); disappearModal('modaleducatorGroups')">Join Group</button>
        </dialog>
        <dialog id="modalCreateEducatorGroups">
            <button onclick="disappearModal('modalCreateEducatorGroups'); appearModal('modaleducatorGroups')">&laquo;</button><br>
            <form action="createEducatorGroup.php" method="post">
                <input type="text" name="groupName" placeholder="Group Name">
            </form>
        </dialog>
        <dialog id="modalJoinEducatorGroups">
            <button onclick="disappearModal('modalJoinEducatorGroups'); appearModal('modaleducatorGroups')">&laquo;</button><br>
            <form action="joinEducatorGroup.php" method="post">
                <input type="text" name="groupCode" placeholder="Group Code">
            </form>
        </dialog>

        </div>
        <script>
            window.onload = closeNav();

            function openNav() {
                document.getElementById("sidenavbar").style.width = "250px";
                document.getElementById("sidenavbar").style.display = "block";
                document.getElementById("main").style.marginLeft = "250px";

            }

            function closeNav() {
                document.getElementById("sidenavbar").style.width = "0";
                document.getElementById("sidenavbar").style.display = "none";
                document.getElementById("main").style.marginLeft = "0";
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