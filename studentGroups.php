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
  <style>
    .popup {
      display: none;
      position: fixed;
      top: 50%;
      left:50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding : 20px;
      z-index: 9999;
    }
  </style>
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
    <button id="create-event-button" onclick="openForm()" style="font-size: 20px; margin-left: 15px; padding: 20px; font-weight: bold;">Create Event</button>

    <div class="popup" id="popupForm">
    <h13>Create Event</h13>
    <form method="post" id="createevent">
      <input type="text" name = "eventname" placeholder="Event Name" style="margin-top: 15px; margin-bottom: 10px; width: 97%;"><br>
      <input type="text" name = "description" placeholder="Description" style="margin-bottom: 10px; width: 97%;"><br>
      <input type="text" name = "maxparticipants" placeholder="Participants" style="margin-bottom: 10px; width: 97%;"><br>
      <input type="text" name = "duration" placeholder="Duration" style="margin-bottom: 10px; width: 97%;"><br>
      <input type="date" name = "starttime" placeholder="Date" style="width: 98%; margin-bottom: 10px; font-size: 15px;"><br>
      <input type="submit" value="Create Event" style="width: 98%; font-size: 15px;">
    </form>
    <button onclick="closeForm()" style="background: azure;color: black;color: black; font-size: 20px; position: absolute; right: 10px; top: 10px;">Close</button>
  </div>


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

    function openForm(){
      document.getElementById("popupForm").style.display = "block";
    }

    function closeForm(){
      document.getElementById("popupForm").style.display = "none";
    }
  </script>
</body>
</html>


<div>
  <?php
    $sql = "SELECT * FROM events WHERE groupid='$groupid'";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $name = $row["eventname"];
        $eventid = $row["eventid"];
        $duration = $row["duration"];
        $starttime = date('Y-m-d', strtotime($row["starttime"]));
        echo "
        <div class= 'event-info'>
          <p><stong>Name: </strong>$name</p>
          <p><stong>Duration: </strong>$duration</p>
          <p><stong>Start Time: </strong>$starttime</p>
        <form method = 'post'>
            <button class = 'eventjoin' value='".$eventid."' style ='width: 100%; background-color: azure; color: black; font-size: 20px; margin-right: 40px;'>Join Event</button>
          </form>
        </div>
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
