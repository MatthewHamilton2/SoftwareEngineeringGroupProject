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
    <link rel="stylesheet" type="text/css" href="styling.css" />
    <title>Home</title>
</head>

<body class="unset">
	<div id="sidenavbar" class="sidenav">
		<!--  <a href="index.php">Home</a> -->
		<a href="profilePage.php" class="split">My Profile</a>
		<!--  <a href="settings_page/settings.php" class="split">Settings</a>  -->
        <a href="statistics.php">Statistics</a>
		<a href="logout.php" class="split">Logout</a>
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

	</div>

	<header>
		<!--  <span class="navSpan" onclick = "openNav()">&#9776;</span>  -->
		<a href="index.php">
			<div class="logo">
				<img src="logo.png" alt="Collab Nexus Logo">
				<h1>Collab Nexus: Home</h1>
			</div>
		</a>
		<div class="profile">
        <?php
                    $user = $_SESSION['username'];
                    $sql = "SELECT * FROM userimage WHERE username = '$user'";
                    $result = mysqli_query($conn, $sql);
                
                    if(mysqli_num_rows($result) > 0){
                        $row = mysqli_fetch_assoc($result);
                        $imagedata = $row['groupimage'];
                        echo"<img src='data:image/png;base64," . base64_encode($imagedata) . "' alt='Image' class='profile-picture' style='border-radius:50%; cursor:pointer;' onclick=\"openNav()\">";
                    }
                    else{
                        echo"<img src=\"profile.png\" alt=\"\" class='profile-picture' onclick=\"openNav()\" style=\"cursor:pointer;\">";
                    }
                ?>
		</div>
	</header>

    <div id="main">
        <!--  hompage header  -->
        <!--  h3 style="text-align:center; margin-top:-30px; padding: 20px; font-size:40px; padding "></h3>  -->

        <h3 class="groupHeader">Student Groups</h3>
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
						<a href='studentGroups.php?groupid=" . $id . "' class='groupBtnName'>
								<div>
								<img src='./studentGroupIcon.png' class='groupImage'></img>
								</div>
								<div class = groupImageText>
									 ". $name ."
								</div>
							</a>
                        </div>
                    ";
                }
                ?>
				<div class = 'groupContainerInner'>
					<button class="createButton" onclick="appearModal('modalStudentGroups')">+</button>
				</div>
            </div>
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
        
        <h3 class="groupHeader">Educator Groups</h3>
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
							<a href='EducatorGroups.php?groupid=" . $id . "&channel=general' class='groupBtnName'>
								<div>
								<img src='./educatorGroupIcon.png' class='groupImage'></img>
								</div>
								<div class = groupImageText>
									" . $name . "
								</div>
							</a>
						</div>
						";
                }
                ?>
				<div class = 'groupContainerInner'>
					<button class="createButton" onclick="appearModal('modaleducatorGroups')">+</button>
				</div>
            </div>
        </div>

        <dialog id="modaleducatorGroups">
            <button onclick="disappearModal('modaleducatorGroups')">X</button><br>
            <?php
                $sql = "SELECT * FROM users WHERE username = '$username'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                  if($row['type'] == "educator"){
                        echo"
                        <button id=\"createStudentGroup\" onclick=\"appearModal('modalCreateEducatorGroups'); disappearModal('modaleducatorGroups')\">Create Group</button><br>
                        ";
                  }
            ?>
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
			document.getElementById("main").style.marginRight = "250px";

		}

		function closeNav() {
			document.getElementById("sidenavbar").style.width = "0";
			document.getElementById("main").style.marginRight = "0";
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