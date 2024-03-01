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
    <button class="backButton" onclick="goto('index.php')" style ="font-size: 40px; padding-bottom: 11.5px;";>&larr;</button> <button id="settings-button">Settings</button>
   
    <div id="nav-bar-header">
    <?php
        $groupid = $_GET['groupid'];
        $sql = "SELECT groupname FROM chatgroup WHERE groupid = '$groupid'";
        $result = mysqli_query($conn, $sql);
        $groupname = mysqli_fetch_assoc($result)['groupname'];
        echo "<h3 style='text-align:center; font-size: 20px;'>".$groupname."</h3>";
      ?>
    
    </div>
    <div id="channels">
      <h4>Channels</h4>
      <button class="channelButton">#general</button>
      <button class="channelButton">#random</button>
      <?php
          $sql = "SELECT joincode FROM chatgroup WHERE groupid = '$groupid'";
          $result = mysqli_query($conn, $sql);
          $code = mysqli_fetch_assoc($result)['joincode'];
          echo"
          <h4> Join Code: </h4>
          <h3 style= 'margin-left:15px'>
          ".$code."
          </h3>";
      ?>
    </div>
  </div>
  <div id="chat">
    <div id ="chatdiv">
      <?php
      $groupid = $_GET['groupid'];
        $sql = "SELECT * FROM (SELECT * FROM message WHERE groupid = ".$groupid." ORDER BY timeSent DESC LIMIT 10) AS subquery ORDER BY subquery.timeSent ASC";
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
      <form id='chatform' method='post' action='sendMessage.php?groupid=".$groupid."'>
        <input type='text' id='messageInput' placeholder='Type your message...' name = 'message'>
      </form>
      ";
      ?>
    </div>
  </div>
  <div>
    <button id="create-event-button">Create Event</button>
  </div>
  
  <div id="members-bar">
    <div id="members">
      <h4 style="margin-left: 15px;">Members</h4>
    </div>
    <div id="members-list">
      <ul>
        <?php
          $sql = "SELECT user FROM groups2users WHERE groupid='$groupid'";
          $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_assoc($result)){
            $username = $row['user'];
            echo"
              <li class='users'>".$username."</li>
            ";
          }
        ?>
      </ul>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <?php
  $groupid = $_GET['groupid'];
  echo"
  <script>
    $(document).ready(function(){
      setInterval(function(){
        $('#chatdiv').load('studentGroups.php?groupid=".$groupid." #chatdiv');
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

<form method="post" id="createevent">
  <input type="text" name = "eventname" placeholder="Event Name"><br>
  <input type="text" name = "maxparticipants" placeholder="Participants"><br>
  <input type="date" name = "starttime" placeholder="Date"><br>
  <input type="text" name = "duration" placeholder="Duration"><br>
  <input type="text" name = "description" placeholder="Description"><br>
  <input type="submit" value="Create Event">
</form>
<div>
  <?php
    $sql = "SELECT * FROM events WHERE groupid='$groupid'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $name = $row["eventname"];
        $eventid = $row["eventid"];
        echo "
        $name <br>
        <form method = 'post'>
        <button class = 'eventjoin' value='".$eventid."'>Join Event</button>
        <br>
        ";
    }
  ?>
</div>

<script>
  $(document).ready(function(){
		$("#createevent").submit(function(){
			var eventname = $("input[name='eventname']").val();
			var maxparticipants = $("input[name='maxparticipants']").val();
			var starttime = $("input[name='starttime']").val();
      var duration = $("input[name='duration']").val();
      var username = "<?php $username = $_SESSION["username"]; echo $username;?>";
      var description = $("input[name='description']").val();
      var groupid = <?php echo $groupid?>;
			$.ajax({
				type: "POST",
				url: "createEvent.php",
				data: 
				{	
					eventname: eventname,
					maxparticipants: maxparticipants,
					starttime: starttime,
          duration: duration,
          username: username,
          description: description,
          groupid: groupid
				},
				success: function(response) {
					console.log(response);
				}
			})
		})
	})

  $(document).ready(function() {
    $('.eventjoin').click(function(){
      var eventid = ($(this).attr("value"));
      var username = "<?php $username = $_SESSION["username"]; echo $username;?>";
      $.ajax({
        type: "POST",
        url: "joinEvent.php",
        data: 
        {
          eventid: eventid,
          username: username
        }
      })
    })
  })
</script>
