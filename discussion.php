<?php
  include("connect.php");
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>student-group-page</title>
  <link rel="stylesheet" href="style.css">
</head>
<body id="studentGroupBody">
  <div id="nav-bar">
    <button class="backButton" onclick="goto('index.php')">&larr;</button>
    <div id="nav-bar-header">
    <?php
        $groupname = $_GET['name'];
        echo "<h3>".$groupname."</h3>";
      ?>
      <button id="settings-button">Settings</button>
    </div>
  </div>
  <div id="chat">
    <div id ="chatdiv">
      <?php
      $groupid = $_GET['groupid'];
      $name = $_GET['name'];
        $sql = "SELECT * FROM (SELECT * FROM discussionmessage WHERE (groupid = ".$groupid." AND discussionName = '".$name."') ORDER BY timeSent DESC LIMIT 10) AS subquery ORDER BY subquery.timeSent ASC";
        $result = mysqli_query($conn, $sql);
        echo"<div class = 'chatcontainer'>";
        while($row = mysqli_fetch_assoc($result)){
            $message = $row['messageText'];
            $sender = $row['user'];
            echo "
            <div class='chatmessage'>
            <p class='messagesender'>$sender"."<br>"."</p>
            <p>$message"."<br>"."</p>
            </div>
            ";
        }
        echo"</div>";
      ?>
    </div>
    <div id="inputContainer">
      <?php
      $groupid = $_GET['groupid'];
      echo"
      <form id='chatform' method='post' action='sendDiscussionMessage.php?groupid=" . $groupid . "&name=" . $name . "'>
        <input type='text' id='messageInput' placeholder='Type your message...' name = 'message'>
      </form>
      ";
      ?>
    </div>
  </div>
  <div id="members-bar">
    <div id="members">
      <h3>Educators</h3>
    </div>
    <div id="members-list">
      <ul>

      </ul>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <?php
  $groupid = $_GET['groupid'];
  $name = $_GET['name'];
  $webname = "'discussion.php?groupid=" . $groupid . "&name=" . $name . "'";
  echo"
  <script>
    $(document).ready(function(){
      setInterval(function(){
        $('#chatdiv').load('discussion.php?groupid=".$webname." #chatdiv');
      }, 3000);
    });
  </script>
  "
  ?>
  <script>
    function goto(destination){
        location.href = destination;
    }
  </script>
</body>
</html>