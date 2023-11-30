<?php
session_start();
include ("Connect.php");

if(isset($_POST['btnContact'])){
    if(!isset($_SESSION["CustomerID"])){
        echo "<script>window.alert('Please Log in to Review')</script>";
        echo "<script>window.location = 'LogIn.php'</script>";

    }
    else{
        $Email = $_SESSION["CustomerEmail"];
        $Message = $_POST["txtContent"];
        $Message = str_replace("'","",$Message);

        $insert = "Insert into contact (ContactMessage,Email) values ('$Message','$Email')";
        $query = mysqli_query($connect, $insert);
        if ($query) {
            echo "<script>window.alert('Successfully Contact')</script>";
            echo "<script>window.location = 'Contact.php'</script>";
        } else {
            echo $query;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact</title>
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
                <a href="PitchesTypesAndAvailabilities.php">Pitches</a>
                <a href="Reviews.php" >Reviews</a>
                <a href="#" class="active">Contact</a>
            </div>
            <?php
            if(!isset($_SESSION["CustomerID"])){
                echo "<a href='LogIn.php' class='log-in'>Log In</a>";
            }
            else{
                $_SESSION['CallBack'] = 'Contact.php';
                $CustomerName = $_SESSION["CustomerName"];
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
            <a href="Home.php" >Home</a>
            <a href="PitchesTypesAndAvailabilities.php">Pitches</a>
            <a href="Reviews.php" >Reviews</a>
            <a href="#" class="active">Contact</a>
            <?php
            if(!isset($_SESSION["CustomerID"])){
                echo "<a href='LogIn.php'>Log In</a>";
            }
            else{
                $_SESSION['CallBack'] = 'Contact.php';
                $CustomerName = $_SESSION["CustomerName"];
                echo "<a href='Profile.php'>$CustomerName</a>";

            }
            ?>
            ?>

        </div>

        <div class="Mobile-Nav-footer">
            <p class="text-center">&copy;GWSC Copyright 2023</p>
        </div>
    </div>
</header>
<article>
    <h1 class="text-center">Content to GWSC</h1>
    <br>
    <div class="d-flex article-card align-item-center">

        <div>
            <h2 class="Heading">Contact Global Wild Swimming and Camping</h2>
            <p class="Text">We're here to assist you with all your insurance needs. Feel free to reach out to us for any
                questions or assistance you may require</p>
            <p><b>Address:</b> 123 Benoi Rd, BENOI sectior, M1 2XY, Singapore</p>
            <p><b>Phone:</b> +65 (0) 123 456 789</p>
            <p><b>Email:</b> info@GWSC.com</p>
            <p><b>Office Hours:</b> Mon-Fri: 8a.m - 8p.m SGT</p>

        </div>
        <form action="Contact.php" method="post" class="Map">
            <h3>Contact form</h3>
            <textarea name="txtContent" placeholder="Write Text here to Content" maxlength="1000" class="LocalDescription" required="" rows="6"></textarea>
            <div class="SendContainer d-flex align-item-center">
                <div>
                    <input type="checkbox" id="Check">
                    <label for="Check" class="text-small">I agree with <a href="PrivacyPolicies.php" class="Privacy text-small">Privacy Policies</a></label>
                </div>
                <button class="Send pe-none" name="btnContact">Contact</button>
            </div>

        </form>
    </div>
</article>
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
        <p class="text-center">Content Page</p>
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

    const Check = document.querySelector("#Check");
    const Send = document.querySelector(".Send");
    Check.addEventListener("change",()=>{
        if(Check.checked){
            Send.classList.remove("pe-none");
        }
        else {
            Send.classList.add("pe-none");
        }
    })
</script>
</body>
</html>
