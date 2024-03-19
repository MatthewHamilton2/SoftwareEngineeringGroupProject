<?php
    session_start();
    include("connect.php");
    $username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" type = "text/css" href="styling.css">
    <title>Collab Nexus: Statistics</title>
</head>
<body class="unset">
<div id="sidenavbar" class="sidenav">
		<!--  <a href="index.php">Home</a> -->
		<a href="profilePage.html" class="split">My Profile</a>
		<!--  <a href="settings_page/settings.php" class="split">Settings</a>  -->
        <a href="statistics.php">Statistics</a>
		<a href="logout.php" class="split">Logout</a>
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

	</div>

	<header id = "statheader">
		<!--  <span class="navSpan" onclick = "openNav()">&#9776;</span>  -->
		<a href="index.php">
			<div class="logo">
				<img src="logo.png" alt="Collab Nexus Logo">
				<h1>Collab Nexus: Home</h1>
			</div>
		</a>
		<div class="profile">
			<img src="profile.png" alt="Profile Picture" class="profile-picture" onclick = "openNav()">
		</div>
	</header>

    <div id = "statisticsPage" >
        <div id = "statistics-left-column" style="margin-right: 50px;">
            <h1 class="statistics-left-header">Student Groups</h1>
            <?php
                    $result = mysqli_query($conn, "SELECT groupid, groupname FROM chatgroup WHERE creatorname = '$username'");
                    while($row = mysqli_fetch_assoc($result)){
                        $groupid = $row['groupid'];
                        $name = $row['groupname'];
                        echo"
                        <div class = 'unfocusedGroup'>
                        <a href=\"#stu$groupid\"onclick= 'highlight(this, \"stu$groupid\")'>$name</a><br>
                        </div>
                        ";
                    }
            ?>
            <h1 class="statistics-left-header">Educator Groups</h1>
            <?php
                    $result = mysqli_query($conn, "SELECT groupid, groupname FROM educatorgroup WHERE creatorname = '$username'");
                    while($row = mysqli_fetch_assoc($result)){
                        $groupid = $row['groupid'];
                        $name = $row['groupname'];
                        echo"
                        <div class = 'unfocusedGroup'>
                        <a href=\"#edu$groupid\"onclick= 'highlight(this, \"edu$groupid\")'>$name</a><br>
                        </div>
                        ";
                    }
            ?>
         
        </div>
        
        <div>
        <h1 class="statistics-middle-header">Student Groups</h1>
        <?php
            $sql = "SELECT * FROM chatgroup WHERE creatorname = '$username'";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
                $name = $row['groupname'];
                $id = $row['groupid'];
                $sql = "SELECT COUNT(*) AS messageCount FROM message WHERE groupid = '$id' AND DATE(timeSent) = CURDATE()";
                $innerresult = mysqli_query($conn, $sql);
                $innerrow = mysqli_fetch_assoc($innerresult);
                $messageCountDay = $innerrow['messageCount'];

                $sql = "SELECT COUNT(*) AS messageCount FROM message WHERE groupid = '$id' AND timeSent >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
                $innerresult = mysqli_query($conn, $sql);
                $innerrow = mysqli_fetch_assoc($innerresult);
                $messageCountWeek = $innerrow['messageCount'];

                $sql = "SELECT COUNT(*) AS messageCount FROM message WHERE groupid = '$id' AND timeSent >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
                $innerresult = mysqli_query($conn, $sql);
                $innerrow = mysqli_fetch_assoc($innerresult);
                $messageCountMonth = $innerrow['messageCount'];

                $sql = "SELECT COUNT(*) AS messageCount FROM message WHERE groupid = '$id' AND timeSent >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
                $innerresult = mysqli_query($conn, $sql);
                $innerrow = mysqli_fetch_assoc($innerresult);
                $messageCountYear = $innerrow['messageCount'];

                $sql = "SELECT COUNT(*) AS messageCount FROM message WHERE groupid = '$id'";
                $innerresult = mysqli_query($conn, $sql);
                $innerrow = mysqli_fetch_assoc($innerresult);
                $messageCountAll = $innerrow['messageCount'];
                
                $sql = "SELECT COUNT(*) AS userCount FROM groups2users WHERE groupid = '$id'";
                $innerresult = mysqli_query($conn, $sql);
                $innerrow = mysqli_fetch_assoc($innerresult);
                $numberOfUsers = $innerrow['userCount'];

                $averageMessages = $messageCountAll / $numberOfUsers;

                $sql = "SELECT COUNT(DISTINCT user) AS users FROM message WHERE groupid = '$id'";
                $innerresult = mysqli_query($conn, $sql);
                $innerrow = mysqli_fetch_assoc($innerresult);
                $activeUsers = $innerrow['users'];

                $sql = "SELECT COUNT(DISTINCT user) AS users FROM message WHERE groupid = '$id' AND timeSent >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK);";
                $innerresult = mysqli_query($conn, $sql);
                $innerrow = mysqli_fetch_assoc($innerresult);
                $recentActiveUsers = $innerrow['users'];

                $sql = "SELECT user, COUNT(*) AS messageCount FROM message WHERE groupid = '$id' GROUP BY user ORDER BY messageCount DESC LIMIT 1";
                $innerresult = mysqli_query($conn, $sql);
                if(mysqli_num_rows($innerresult) > 0){
                    $innerrow = mysqli_fetch_assoc($innerresult);
                    $mostActiveUser = $innerrow['user'];
                    $mostActiveUserMessages = $innerrow['messageCount'];  
                }
                else{
                    $mostActiveUser = "N/A";
                    $mostActiveUserMessages = "N/A";
                }

                echo"
                    <div class='statisticsBoxes' id = 'stu$id'>
                        <h1 style='text-align:center' class ='statisticsHeader'>$name</h1>
                        <p>Number of messages over past 24 hours: <strong>$messageCountDay</strong></p>
                        <p>Number of messages over past 7 days: <strong>$messageCountWeek</strong><p>
                        <p>Number of messages over past month: <strong>$messageCountMonth</strong><p>
                        <p>Number of messages over past year: <strong>$messageCountYear</strong><p>
                        <p>Number of messages over all time: <strong>$messageCountAll</strong></p>

                        <p>Total number of users in group: <strong>$numberOfUsers</strong><p>
                        <p>Average number of messages sent per user: <strong>$averageMessages</strong><p>
                        <p>Number of active users: <strong>$activeUsers</strong><p>
                        <p>Number of recently active users: <strong>$recentActiveUsers</strong><p>
                        <p>Most active user in group: <strong>$mostActiveUser</strong>, Messages sent: <strong>$mostActiveUserMessages</strong><p>
                    </div>
                ";
            }
        ?>
        <h1 class="statistics-middle-header">Educator Groups</h1>
        <?php
                $sql = "SELECT * FROM educatorgroup WHERE creatorname = '$username'";
                $resultouter = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($resultouter)){
                    $id = $row['groupid'];
                    $name = $row['groupname'];
                    $sql = "SELECT discussionName FROM discussions WHERE groupid = '$id'";
                    $resultouter2 = mysqli_query($conn, $sql);

                    echo "
                    <div class='statisticsBoxes' id = 'edu$id'>
                    <h1 class ='statisticsHeaderEdu' onclick = 'toggleDropdowns(\"$id\")'>$name ▼</h1>";
                    
                    echo"<div id = '$id' class = 'hidden'>";
                    while($row = mysqli_fetch_assoc($resultouter2)){
                        $discussionName = $row['discussionName'];

                        $sql = "SELECT COUNT(*) AS messageCount FROM discussionmessage WHERE groupid = '$id' AND discussionName = '$discussionName' AND DATE(timeSent) = CURDATE()";
                        $innerresult = mysqli_query($conn, $sql);
                        $innerrow = mysqli_fetch_assoc($innerresult);
                        $messageCountDay = $innerrow['messageCount'];

                        $sql = "SELECT COUNT(*) AS messageCount FROM discussionmessage WHERE groupid = '$id' AND discussionName = '$discussionName' AND timeSent >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)";
                        $innerresult = mysqli_query($conn, $sql);
                        $innerrow = mysqli_fetch_assoc($innerresult);
                        $messageCountWeek = $innerrow['messageCount'];

                        $sql = "SELECT COUNT(*) AS messageCount FROM discussionmessage WHERE groupid = '$id' AND discussionName = '$discussionName' AND timeSent >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
                        $innerresult = mysqli_query($conn, $sql);
                        $innerrow = mysqli_fetch_assoc($innerresult);
                        $messageCountMonth = $innerrow['messageCount'];

                        $sql = "SELECT COUNT(*) AS messageCount FROM discussionmessage WHERE groupid = '$id' AND discussionName = '$discussionName' AND timeSent >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)";
                        $innerresult = mysqli_query($conn, $sql);
                        $innerrow = mysqli_fetch_assoc($innerresult);
                        $messageCountYear = $innerrow['messageCount'];

                        $sql = "SELECT COUNT(*) AS messageCount FROM discussionmessage WHERE groupid = '$id' AND discussionName = '$discussionName'";
                        $innerresult = mysqli_query($conn, $sql);
                        $innerrow = mysqli_fetch_assoc($innerresult);
                        $messageCountAll = $innerrow['messageCount'];

                        $sql = "SELECT COUNT(DISTINCT user) AS users FROM discussionmessage WHERE groupid = '$id' AND discussionName = '$discussionName'";
                        $innerresult = mysqli_query($conn, $sql);
                        $innerrow = mysqli_fetch_assoc($innerresult);
                        $activeUsers = $innerrow['users'];

                        $sql = "SELECT COUNT(DISTINCT user) AS users FROM discussionmessage WHERE groupid = '$id' AND discussionName = '$discussionName' AND timeSent >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK);";
                        $innerresult = mysqli_query($conn, $sql);
                        $innerrow = mysqli_fetch_assoc($innerresult);
                        $recentActiveUsers = $innerrow['users'];

                        $sql = "SELECT user, COUNT(*) AS messageCount FROM discussionmessage WHERE groupid = '$id' AND discussionName = '$discussionName' GROUP BY user ORDER BY messageCount DESC LIMIT 1";
                        $innerresult = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($innerresult) > 0){
                            $innerrow = mysqli_fetch_assoc($innerresult);
                            $mostActiveUser = $innerrow['user'];
                            $mostActiveUserMessages = $innerrow['messageCount'];  
                        }
                        else{
                            $mostActiveUser = "N/A";
                            $mostActiveUserMessages = "N/A";
                        }

                        echo"
                            <div>
                                <h3 style='text-align:center' class ='statisticsHeader'>$discussionName</h3>
                                <p>Number of messages over past 24 hours: <strong>$messageCountDay</strong></p>
                                <p>Number of messages over past 7 days: <strong>$messageCountWeek</strong><p>
                                <p>Number of messages over past month: <strong>$messageCountMonth</strong><p>
                                <p>Number of messages over past year: <strong>$messageCountYear</strong><p>
                                <p>Number of messages over all time: <strong>$messageCountAll</strong></p>

                                <p>Total number of users in group: <strong>$numberOfUsers</strong><p>
                                <p>Number of active users: <strong>$activeUsers</strong><p>
                                <p>Number of recently active users: <strong>$recentActiveUsers</strong><p>
                                <p>Most active user in group: <strong>$mostActiveUser</strong>, Messages sent: <strong>$mostActiveUserMessages</strong><p>
                            </div>
                        ";
                    }
                    echo"</div>
                    </div>";

                }
        ?>
        </div>
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

        function toggleDropdowns(groupid){
            var drop = document.getElementById(groupid);
            if(drop.style.display === "block"){
                drop.style.display = "none";
            }
            else {
                drop.style.display = "block";
            }
        }

        function highlight(element, id){
            var focusedelement = document.getElementById(id);
            var previousFocused = document.querySelector(".focusedGroup");

            if(previousFocused){
                previousFocused.classList.remove('focusedGroup');
                previousFocused.classList.add('unfocusedGroup');
            }
            focusedelement.classList.remove('unfocusedGroup');
            focusedelement.classList.add('focusedGroup');
        }
	</script>
</body>
</html>