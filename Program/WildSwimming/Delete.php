<?php

session_start();
include("Connect.php");

$ID = $_REQUEST["ID"];
$Type = $_SESSION["Type"];
$Link = $_SESSION["Link"];

switch ($Type){
    case "Campsite" :
        $query = "delete from campsite where campsiteID = '$ID'";
        break;
    case "PitchType":
        $query = "delete from pitchtype where PitchTypeID = '$ID'";
        break;
    case "Admin":
        $query = "delete from admin where AdminID = '$ID'";
        break;

}

$query = mysqli_query($connect,$query);
if($query){
    echo "<script>window.alert('Successfully Delete')</script>";
    echo "<script>window.location = '$Link'</script>";

}
else{
    echo $query;
}
