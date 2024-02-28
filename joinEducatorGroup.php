<?php
    session_start();

    try{
    include("connect.php");
    $code = filter_input(INPUT_POST, "groupCode", FILTER_SANITIZE_SPECIAL_CHARS);
    $sql = "SELECT groupid FROM educatorgroup WHERE joincode = '$code'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $groupid = mysqli_fetch_assoc($result)["groupid"];
        $username = $_SESSION["username"];
        $sql = "INSERT INTO educatorgroups2users (groupid, user) VALUES ('$groupid', '$username')";
        mysqli_query($conn, $sql);
        echo "<script> location.href='EducatorGroups.php"."?groupid=".$groupid."'; </script>";
    }
    else{
        echo"invalid code";
    }
    }
    catch(mysqli_sql_exception){
        echo"invalid code";
    }

?>