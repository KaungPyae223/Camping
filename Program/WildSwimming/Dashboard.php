<?php
session_start();

include("Connect.php");

if(!isset($_SESSION["AdminID"])){
    echo "<script>window.alert('Please Log In first')</script>";
    echo "<script>window.location='LogIn.php'</script>";
}

$Name = $_SESSION["AdminName"];
$Email = $_SESSION["AdminEmail"];


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Global Wild Swimming Camping</title>
    <link rel="stylesheet" href="gwsc.css">
</head>
<body class="DashBoardBody">


<div class="DashBoardNav">
    <div class="Intro">
        <p class="logo">GWSC</p>
        <p class="DashboardName"><?php echo $Name;?></p>
        <p class=""><?php echo $Email;?></p>
    </div>
    <div class="DashBoardLink">
        <button src="PitchControl.php" class="DashBard-active DashBoardButton">Add Pitch</button>
        <button src="LocalAttractionControl.php" class="DashBoardButton">Local Attractions</button>
        <button src="Admin.php" class="DashBoardButton">Add Admin</button>
        <button src="Site.php" class="DashBoardButton">Add Camp Site</button>
        <button src="PitchType.php" class="DashBoardButton">Add Pitch type</button>
        <button src="ShowReview.php" class="DashBoardButton">Reviews</button>
        <button src="ContactShow.php" class="DashBoardButton">Contact Messages</button>
        <button src="BookingDisplay.php" class="DashBoardButton">Booking Lists</button>


    </div>
    <div class="DashboardCopyRight">
        <p class="text-small text-center">copyright &copy 2023</p>
    </div>

</div>
<iframe src="PitchControl.php" class="DashBoardItem">

</iframe>
<script>
    const DashboardButton = document.querySelectorAll(".DashBoardButton");
    const DashboardLink = document.querySelector(".DashBoardLink");
    DashboardLink.addEventListener("click", (event) => {
        if (event.target.classList.contains("DashBoardButton")) {
            RemoveActive();
            event.target.classList.add("DashBard-active");
            const src = event.target.getAttribute("src");
            changeSrc(src);
        }
    });
    const RemoveActive = () =>{
        DashboardButton.forEach((el) =>{
            el.classList.remove("DashBard-active");
        })
    }
    const DashBoardItem = document.querySelector(".DashBoardItem");
    const changeSrc = (src) => {
        DashBoardItem.src = src;

    }

</script>

</body>
</html>

