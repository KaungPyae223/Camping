<?php
session_start();
include ("Connect.php");
if(isset($_POST['btnReview'])){
    if(!isset($_SESSION["CustomerID"])){
        echo "<script>window.alert('Please Log in to Review')</script>";
        echo "<script>window.location = 'LogIn.php'</script>";

    }
    else{
        $Review = $_POST['txtReview'];
        $Review = str_replace("'","",$Review);

        $ID = $_SESSION["CustomerID"];
        $date = $_POST['txtDate'];
        $rating = $_POST['cboRating'];
        $insert = "Insert into sitereview (CustomerID,Review,Rating,Date) values ('$ID','$Review','$rating','$date')";
        $query = mysqli_query($connect, $insert);
        if ($query) {
            echo "<script>window.alert('Successfully Review')</script>";
            echo "<script>window.location = 'Reviews.php'</script>";
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
    <title>Reviews</title>
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
                <a href="#" class="active">Reviews</a>
                <a href="Contact.php">Contact</a>

            </div>
            <?php
            if(!isset($_SESSION["CustomerID"])){
                echo "<a href='LogIn.php' class='log-in'>Log In</a>";
            }
            else{
                $CustomerName = $_SESSION["CustomerName"];
                $_SESSION['CallBack'] = 'Reviews.php';

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
            <a href="#" class="active">Reviews</a>
            <a href="Contact.php">Contact</a>
            <?php
            if(!isset($_SESSION["CustomerID"])){
                echo "<a href='LogIn.php'>Log In</a>";
            }
            else{
                $CustomerName = $_SESSION["CustomerName"];
                $_SESSION['CallBack'] = 'Reviews.php';

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
    <h1 class="text-center">Review of GWSC Website</h1>
    <div class="ReviewContainer d-flex">
        <button class="ReviewButton" id="MoodleCall">Give Review</button>
        <div id="google_translate_element" class="text-center"></div>

        <script type="text/javascript">
            function googleTranslateElementInit() {
                new google.translate.TranslateElement(
                    {pageLanguage: 'en'},
                    'google_translate_element'
                );
            }
        </script>

        <script type="text/javascript"
                src=
                "https://translate.google.com/translate_a/element.js?
cb=googleTranslateElementInit">
        </script>
        <?php
        $select = "SELECT S.*,C.FirstName,C.SurName FROM sitereview S,customers C where S.CustomerID = C.CustomerID";
        $query = mysqli_query($connect, $select);
        $count = mysqli_num_rows($query);
        if ($count == 0) {
            echo "<h2>No records</h2>";
        } else {
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($query);
            $FirstName = $row["FirstName"];
            $SurName = $row["SurName"];
            $Review = $row["Review"];
            $Rating = $row["Rating"];
            $Date = $row["Date"];
            echo "
                <div class='ReviewCard'>
                <h2>$FirstName $SurName</h2>
                <p class='text-small'>$Date</p>
                <p class='Text'>$Review</p>
                <div class='StarContainer d-flex'>
            ";
            for($s = 1;$s <= 5;$s++){
                if($s<=$Rating){
                    echo "<i class='fa-solid fa-star'></i>";
                }
                else{
                    echo "<i class='fa-regular fa-star'></i>";
                }
            }
            echo "
            </div>
        </div>
    </div>
            ";
        }
        }
        ?>




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
        <p class="text-center">Review Page</p>
        <p class="text-center">&copy;GWSC Copyright 2023</p>
    </div>
</footer>
<script>

    const Body = document.querySelector("body");
    const NavCall = document.querySelector("#NavCall");
    const NavClose = document.querySelector("#NavClose");
    const MobileNav = document.querySelector(".Mobile-Nav")
    NavCall.addEventListener("click", () => {
        MobileNav.style.transform = "translateX(0%)"
    })
    NavClose.addEventListener("click", () => {
        MobileNav.style.transform = "translateX(-100%)"
    })

    const AddMoodle = () => {
        const Moodle = document.createElement("div");
        Moodle.classList.add("Moodle");

        let currentDate = new Date();
        let year = currentDate.getFullYear();
        let month = currentDate.getMonth() + 1;
        let day = currentDate.getDate();
        let Today = day + "-" + month + "-" + year;

        Moodle.innerHTML = `
        <div class="MoodleBody">
            <form action="Reviews.php" method="POST">
                <h1>Review to GWSC</h1>
                <input type="hidden" name="txtDate" value="${Today}">
                <label>Rating</label>
                <select name="cboRating">
                    <option value=1>1</option>
                    <option value=2>2</option>
                    <option value=3>3</option>
                    <option value=4>4</option>
                    <option value=5>5</option>
                </select>
                <label>Review</label>
                <textarea name="txtReview" placeholder="Write review here" maxlength="250" class="LocalDescription" required="" rows="5"></textarea>
                <input type="submit" name="btnReview" value="Review" class="LogInbth">
                <button type="reset" value="Clear" class="LogInbth" id="CloseForm">Cancel</button>
            </form>
        </div>
    `;

        const MoodleClose = Moodle.querySelector("#CloseForm");
        MoodleClose.addEventListener("click", () => {
            Moodle.remove();
        });

        return Moodle;
    };

    const MoodleOpen = document.querySelector("#MoodleCall");
    MoodleOpen.addEventListener("click", () => {
        Body.append(AddMoodle());
    })

</script>
</body>
</html>
