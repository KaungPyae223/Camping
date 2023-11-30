<?php
session_start();
include ("Connect.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pitches</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="gwsc.css">
</head>
<body>
<header>
    <nav class="d-flex">
        <h2 class="brand">GWSC</h2>
        <div class="d-flex Desktop-Mode">
            <div class="nav-items">
                <a href="Home.php">Home</a>
                <a href="" class="active">Pitches</a>
                <a href="Reviews.php">Reviews</a>
                <a href="Contact.php">Contact</a>
            </div>
            <?php
            if(!isset($_SESSION["CustomerID"])){
                echo "<a href='LogIn.php' class='log-in'>Log In</a>";
            }
            else{
                $CustomerName = $_SESSION["CustomerName"];
                $_SESSION['CallBack'] = 'PitchesTypesAndAvailabilities.php';

                echo "<a href='Profile.php' class='log-in ProfileBtn'>$CustomerName</a>";

            }
            ?>

        </div>
        <button class="Mobile-Mode" id="NavCall">
            <i class="fa-solid fa-bars"></i>
        </button>
    </nav>
    <div class="Mobile-Nav">
        <div>
            <button class="Mobile-Mode" id="NavClose"><i class="fa-solid fa-xmark"></i></button>
            <h2 class="Mobile-Nav-Title text-center">GWSC</h2>
            <p class="text-center">Global Wild Swimming and Camping</p>
        </div>
        <div class="d-flex Mobile-Nav-Item">
            <a href="Home.php">Home</a>
            <a href="" class="active">Pitches</a>
            <a href="Reviews.php">Reviews</a>
            <a href="Contact.php">Contact</a>
            <?php
            if(!isset($_SESSION["CustomerID"])){
                echo "<a href='LogIn.php'>Log In</a>";
            }
            else{
                $CustomerName = $_SESSION["CustomerName"];
                $_SESSION['CallBack'] = 'PitchesTypesAndAvailabilities.php';

                echo "<a href='Profile.php'>$CustomerName</a>";

            }
            ?>

        </div>

        <div class="Mobile-Nav-footer">
            <p class="text-center">&copy;GWSC Copyright 2023</p>
        </div>
    </div>
</header>
<article>
    <h1 class="text-center">Available Pitches</h1>
</article>
<section class="PitchTypeAvl">
    <form class="PitchSearchContainer" method="post" action="PitchesTypesAndAvailabilities.php">
        <select name="cboPitch" class="Combo">
            <option value="">All</option>
            <?php
            $select = "Select * from pitchtype";
            $run = mysqli_query($connect, $select);
            $count = mysqli_num_rows($run);
            for ($i = 0; $i < $count; $i++) {
                $data = mysqli_fetch_array($run);
                $ID = $data["PitchTypeID"];
                $PName = $data["TypeName"];
                echo "<option value=$ID>$PName</option>";
            }

            ?>
        <input type="text" value="" name="txtSearch" list="PitchList" placeholder="Search Pitch Name" class="PitchSearchInput">
        <datalist id="PitchList">
            <?php
            $select = "Select * from pitches";
            $query = mysqli_query($connect, $select);
            $count = mysqli_num_rows($query);
            for ($i = 0; $i < $count; $i++) {
                $row = mysqli_fetch_array($query);
                $Name = $row["PitchName"];

                echo " <option value='$Name'>$Name</option>";
            }
            ?>

        </datalist>
        <div class="d-flex justify-content-center">
            <button class="PitchAvlSearch">Search</button>
        </div>
    </form>
</section>
<div class="d-flex PitchShow">
    <?php
    if (isset($_POST['txtSearch'])) {
        $SearchName = $_POST['txtSearch'];
        $PitchID = $_POST['cboPitch'];
    } else {
        $SearchName = "";
        $PitchID = "";
    }
    $select = "SELECT * FROM pitches WHERE PitchName LIKE '%$SearchName%' and PitchTypeID like '%$PitchID%'";
    $query = mysqli_query($connect, $select);
    $count = mysqli_num_rows($query);
    if ($count == 0) {
        echo "<h2>No records</h2>";
    } else {
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($query);
            $IntroImage = $row["PitchIntroImage"];
            $Name = $row["PitchName"];
            $Location = $row["Location"];
            $Price = $row["Price"];
            $Description = $row["Description"];
            $FacilitiesName = $row["FacilitiesName"];
            $Duration = $row["Duration"];
            $Display = substr($Description,0,100) . "...";
            $ID = $row["PitchID"];
            echo "<div class='PitchCard'>
            <div class='PitchCardHeader'>
                <img src='$IntroImage' class='PitchCardImage'>
            </div>
            <div class='PitchCardBody'>
                <h2>$Name</h2>
                <p class='PitchCardLocation'>$Location</p>
                <p>$Duration</p>
                <div class='FacilitiesContainer'>";
            $Feature = explode('+', $FacilitiesName);
            $Feature = array_filter($Feature, function ($Feature) {
                return trim($Feature) !== '';
            });
            foreach ($Feature as $FeatureItem) {
                echo "<p class='FacilitiesName' > $FeatureItem </p >";
            }
            echo "
                </div>
                <p class='text-justify'>$Display</p>

            </div>
            <div class='d-flex PitchCardFooter'>
                <h2>$Price $</h2>
                <a href='PitchesInformation.php?ID=$ID' class='PitchCardReadMore'>Read More</a>
            </div>
        </div>";
        }
    }
    ?>
</div>
<footer>
    <div class="d-flex Footer">
        <div class="d-flex FooterContent">
            <p class="FooterTitle">Company</p>
            <a href="#">Booking</a>
            <a href="#">Application</a>
            <a href="#">Document</a>

        </div>
        <div class="d-flex FooterContent">
            <p class="FooterTitle">Get Support</p>
            <a href="#">FAQ</a>
            <a href="#">Account</a>
            <a href="#">Payment Methods</a>
            <a href="#">Refunds</a>
        </div>
        <div class="d-flex FooterContent">
            <p class="FooterTitle">Contact Us</p>
            <a href="#">Contact Us</a>
            <a href="#">Live Chat</a>
        </div>
        <div class="d-flex FooterContent">
            <p class="FooterTitle">Follow Us</p>
            <div class="d-flex">
                <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-facebook"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>

    </div>
    <br>
    <br>
    <div>
        <p class="text-center">Pitch Types and Availabilities Page</p>
        <p class="text-center">&copy;GWSC Copyright 2023</p>
    </div>
</footer>
<script>
    const NavCall = document.querySelector("#NavCall");
    const NavClose = document.querySelector("#NavClose");
    const MobileNav = document.querySelector(".Mobile-Nav")
    NavCall.addEventListener("click", () => {
        MobileNav.style.transform = "translateX(0%)"
    })
    NavClose.addEventListener("click", () => {
        MobileNav.style.transform = "translateX(-100%)"
    })
</script>
</body>
</html>
