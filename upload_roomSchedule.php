<?php

require 'cloudinary/Cloudinary.php';
require 'cloudinary/Uploader.php';
require 'cloudinary/Api.php';

\Cloudinary::config(array( 
	"cloud_name" => "ust", 
	"api_key" => "564874384895128", 
	"api_secret" => "_YsCf3z6Mu2yCuLk54Q0vn4UMMU" 
));

include("db_connect.php");
session_start();

if(isset($_POST['roomschedule'])){

	$truncate = "TRUNCATE table room_mastertable";
	/*$truncate2 = "TRUNCATE table room_icslab2";
	$truncate3 = "TRUNCATE table room_icslab3";
	$truncate4 = "TRUNCATE table room_icslab4";
	mysqli_query($conn, $truncate1) or die(mysqli_error());
	mysqli_query($conn, $truncate2) or die(mysqli_error());
	mysqli_query($conn, $truncate3) or die(mysqli_error());*/
	mysqli_query($conn, $truncate) or die(mysqli_error());

	$tmpfile = $_FILES["file"]["tmp_name"];

	foreach ($tmpfile as $key => $filename) {

		//$fname = $_FILES["file"]["name"][$key];

		/*if($fname == "ICSLAB1.csv"){
			$tableName = "room_icslab1";
		}elseif($fname == "ICSLAB2.csv"){
			$tableName = "room_icslab2";
		}elseif($fname == "ICSLAB3.csv"){
			$tableName = "room_icslab3";
		}elseif($fname == "ICSLAB4.csv"){
			$tableName = "room_icslab4";
		}
		*/
		if ($_FILES["file"]["size"] > 0) {	
			$file = fopen($filename, "r");
			$count = 0;


			while (($uploadData = fgetcsv($file, 100000, ",")) !== FALSE) {


				$count++;
				
				$day = $uploadData[0];
				$startTime = $uploadData[1];
				$endTime = $uploadData[2];

				if(empty($uploadData[3])){
					$room = 'NULL';
				}else{
					$room = "'".$uploadData[3]."'";
				}
				if(empty($uploadData[4])){
					$subject = 'NULL';
				}else{
					$subject = "'".$uploadData[4]."'";
				}
				if(empty($uploadData[5])){
					$section = 'NULL';
				}else{
					$section = "'".$uploadData[5]."'";
				}
				if(empty($uploadData[6])){
					$firstname = 'NULL';
				}else{
					$firstname = "'".$uploadData[6]."'";
				}
				if(empty($uploadData[7])){
					$lastname = 'NULL';
				}else{
					$lastname = "'".$uploadData[7]."'";
				}

				if ($count > 1) {

					$sql = "INSERT into room_mastertable(day, startTime, endTime, room, subject, section, firstname, lastname, fullname)
					values ('$day',time(str_to_date('".$startTime."', '%h:%i %p')),time(str_to_date('".$endTime."', '%h:%i %p')), $room, $subject, $section, $firstname, $lastname, concat($firstname,' ',$lastname))";

					//die($sql);

					mysqli_query($conn,$sql) or die(mysqli_error());
				}
			}

			fclose($file);
			echo "<script type='text/javascript'>alert('Upload successful.'); window.location.href='uploadSchedule.php';</script>";
		} else {
			echo "<script type='text/javascript'>alert('Please upload CSV File.'); window.history.back();</script>";
		}
	}
}

?>