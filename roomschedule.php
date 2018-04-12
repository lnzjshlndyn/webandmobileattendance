<?php

include("db_connect.php");
session_start();

if(isset($_POST['submit'])){
  $select = "SELECT *,time_format(startTime, '%h:%i%p') as newStart, time_format(endTime, '%h:%i%p') as newEnd from room_mastertable
  where day='".$_POST['day']."' and room='".$_POST['room']."'";
  $result = mysqli_query($conn, $select) or die(mysqli_error());
}else{
  $select = "SELECT *,time_format(startTime, '%h:%i%p') as newStart, time_format(endTime, '%h:%i%p') as newEnd from room_mastertable
  where day='Monday' and room='53'";
  $result = mysqli_query($conn, $select) or die(mysqli_error());
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Room Schedule</title>
  <meta charset="ultf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="mystyle.css">
  <link rel="shortcut icon" href="images/favicon.ico" />
  <link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style type="text/css">
  @media (max-width: 991px) {
    .navbar-header {
      float: none;
    }
    .navbar-left,.navbar-right {
      float: none !important;
    }
    .navbar-toggle {
      display: block;
    }
    .navbar-collapse {
      border-top: 1px solid transparent;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
    }
    .navbar-fixed-top {
      top: 0;
      border-width: 0 0 1px;
    }
    .navbar-collapse.collapse {
      display: none!important;
    }
    .navbar-nav {
      float: none!important;
      margin-top: 7.5px;
    }
    .navbar-nav>li {
      float: none;
    }
    .navbar-nav>li>a {
      padding-top: 10px;
      padding-bottom: 10px;
    }
    .collapse.in{
      display:block !important;
    }

  }
  @media (max-width: 450px){
    .datestyle{
      background-color: #ffffff;
      color: #000000;
      cursor: pointer;
      margin: 0 auto;
      width: 70%;
      padding: 5px;
      display: inline-block;
      border: 1px solid;
      border-radius: 3px;
      font-size: 15px;
      font-family: 'Quicksand', sans-serif;
    }

  }
</style>
</head>
<body>
  <!-- NAV -->
  <div id="navbar" class="navbar navbar-default navbar-fixed-top">
    <div class="navbar-header">
      <p id="navbrand"><img src="images/iicslogomini.png" width="53" height="60"  alt="">&nbsp;IICS</p>
      <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
    </div>

    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a  id="navlink" class="nav-link hvr-underline-reveal hvr-float" href="attendance.php">Attendance</a>
        </li>
        <li>
          <a id="navlink" class="nav-link hvr-underline-reveal hvr-float hvr-text hvr-selected" href="schedule.php">Schedules</a>
        </li>
        <li>
          <a id="navlink" class="nav-link hvr-underline-reveal hvr-float" href="documents.php">Documents</a>
        </li>
        <li>
          <a id="navlink" class="nav-link hvr-underline-reveal hvr-float" href="reports.php">Reports</a>
        </li>
        <li>
          <a id="navlink" class="nav-link hvr-underline-reveal hvr-float" href="manageUser.php">Manage User</a>
        </li>
        <li>
          <a href="logLogout.php" id="power" class="glyphicon glyphicon-off hvr-grow"></a>
        </li>
      </ul>
    </div>
  </div>
  <!--END NAV-->
  <br/><br/><br/><br/>  
  <div class="container">
    <div class="row">
      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
        <button type="button" class="BackButton" onclick="window.location.href='schedule.php'"><i class="glyphicon glyphicon-arrow-left"></i> Back</button>
      </div><!--End left div-->
      <div class="col-lg-4 col-md-4 col-sm-5 col-xs-8">
        <p class="documents"> Room Schedule</p>
      </div><!--End Middle div-->
      <form action="roomschedule.php" method="post">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
          <select name="day" id="classSchedule" class="schedstyle">
            <option value="">Select day:</option>
            <option value="Monday" selected>Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
            <option value="Saturday">Saturday</option>
          </select>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
          <select name="room" id="classSchedule" class="schedstyle">
            <?php 

            $distinct = "SELECT distinct room from room_mastertable order by room";
            $rDistinct = mysqli_query($conn, $distinct);

            while($row = mysqli_fetch_assoc($rDistinct)){
              echo "<option value='".$row['room']."'>".$row['room']."</option>";
            }
            ?>
          </select>
        </div>
      </div><!--End row div-->   
      <div class="row">
        <?php 
        if(isset($_POST['submit'])){
          echo "<div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>";
          echo "<p class='roomCaption'>Day: ".$_POST['day']."</p>";
          echo "</div>";
          echo "<div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>";
          echo "<p class='roomCaption'>Room: ".$_POST['room']."</p>";
          echo "</div>";
        }else{
          echo "<div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>";
          echo "<p class='roomCaption'>Day: Monday</p>";
          echo "</div>";
          echo "<div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>";
          echo "<p class='roomCaption'>Room: 53</p>";
          echo "</div>";

        }

        ?>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
        </div>    
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
          <button type="submit" name="submit" class="GoButton">Go</button>
        </div>  
      </div><!--End 2nd row -->
    </form>
    <div class="row">
      <div class="tableDesign">
        <center>      
          <table class='table table-bordered table-striped table-hover table-responsive'>
            <tr>
              <th>TIME</th>
              <th>SECTION</th>
              <th>SUBJECT</th>
              <th>PROFESSOR</th>
              <th></th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)){

             echo "<tr>";
         //echo "<td>". $row['day'] ."</td>";
             echo "<td>". $row['newStart'] ." - ". $row['newEnd'] ."</td>";
             echo "<td>". $row['section'] ."</td>";
             echo "<td>". $row['subject'] ."</td>";
             echo "<td>". $row['fullname'] ."</td>";
             echo "<td><a href=\"updateRoomSchedule.php?id=" . $row["id"] . "\"><span class='glyphicon glyphicon-pencil'></span></a></td>";
             echo "</tr>";

           } ?>
         </table>
       </center>
     </div><!--End table design div-->
   </div><!--End 3rd row-->
 </div>
</body>
</html>
