<?php
session_start();
include("Connect.php");

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Home</title>
    <link rel="stylesheet" href="gwsc.css">
</head>
<body>
<header class="Home">
    <nav class="d-flex">
        <h2 class="brand">GWSC</h2>
        <div class="d-flex Desktop-Mode">
            <div class="nav-items">
                <a href="" class="active">Home</a>
                <a href="PitchesTypesAndAvailabilities.php">Pitches</a>
                <a href="Reviews.php">Reviews</a>
                <a href="Contact.php">Contact</a>
            </div>
            <?php
            if (!isset($_SESSION["CustomerID"])) {
                echo "<a href='LogIn.php' class='log-in'>Log In</a>";
            }
            else{
                $CustomerName = $_SESSION["CustomerName"];
                $_SESSION['CallBack'] = 'Home.php';

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
            <a href="" class="active">Home</a>
            <a href="PitchesTypesAndAvailabilities.php">Pitches</a>
            <a href="Reviews.php">Reviews</a>
            <a href="Contact.php">Contact</a>
            <?php
            if (!isset($_SESSION["CustomerID"])) {
                echo "<a href='LogIn.php'>Log In</a>";
            }
            else{
                $CustomerName = $_SESSION["CustomerName"];
                $_SESSION['CallBack'] = 'Home.php';

                echo "<a href='Profile.php'>$CustomerName</a>";

            }
            ?>
        </div>

        <div class="Mobile-Nav-footer">
            <p class="text-center">&copy;GWSC Copyright 2023</p>
        </div>
    </div>
</header>
<main>
    <div class="Carousel">
        <div class="Slide-content d-flex Carousel-Active">

            <div class="Slide-Info">
                <div>
                    <h2 class="Heading">About GWSC</h2>
                    <p class="Text">Global Wild Swimming and Camping (GWSC) is a new business to the market and are
                        expanding its business to beyond the local community. GWSC has large community and are you ready
                        to explore the nature with us.</p>

                </div>

            </div>
        </div>
        <div class="Slide-content d-flex">
            <div class="Slide-Info">
                <div>
                    <h2 class="Heading">Our Goals</h2>
                    <p class="Text">At GWSC, our mission is to inspire, connect, and empower outdoor enthusiasts around
                        the world to experience the beauty and serenity of nature through wild swimming and camping.</p>

                </div>

            </div>
        </div>
        <div class="Slide-content d-flex">
            <div class="Slide-Info">
                <div>
                    <h2 class="Heading">Our Services</h2>
                    <p class="Text"> GWSC supports Adventure Planning and Resources,Community Forums, Event
                        Organizing, Travel Partnerships,Equipment and Gear Recommendations, Online Store, News and
                        Updates, Membership Benefits, Health and Wellness Programs etc,</p>

                </div>

            </div>
        </div>
        <div class="Slide-content d-flex">

            <div class="Slide-Info">
                <div>
                    <h2 class="Heading">Benefits of Wild Swimming</h2>
                    <p class="Text">By Wild Swimming, can improve physical fitness, Mental Wellbeing, Immune System
                        Support, Social Interaction, Enhanced Circulation and Skin Health, Mindfulness and Relaxation
                        etc,</p>

                </div>

            </div>
        </div>

        <div class="Slide">
            <img src="Images/Camping1.jpg" class="active">
            <img src="Images/Camping2.jpg">
            <img src="Images/Camping3.jpg">
            <img src="Images/Camping4.jpg">

        </div>
        <div class="Slide-button-group d-flex">
            <button class="active"></button>
            <button></button>
            <button></button>
            <button></button>

        </div>
    </div>
    <div class="Hero d-flex">

        <h1>Global Wild Swimming Camping</h1>
        <p class="Text">Discover the world's hidden gems through wild swimming and camping. Join a global community of
            nature enthusiasts, embark on epic adventures, and create unforgettable memories. Explore our planet
            responsibly while nurturing your love for the outdoors. Let's make every adventure an opportunity to protect
            and preserve the wild.
        </p>
    </div>

</main>

<section class="Users d-flex flex-warp">
    <div class="Users-Card d-flex">
        <i class="fa-solid fa-user"></i>
        <p>Total Viewers</p>
        <p class="number" data-max="<?php include("ViewCount.php"); ?>">0</p>
    </div>
    <div class="Users-Card d-flex">
        <i class="fa-sharp fa-solid fa-user-tie"></i>
        <p>Total Customers</p>
        <p class="number" data-max="
            <?php
        $select = "Select * from customers";
        $query = mysqli_query($connect, $select);
        $count = mysqli_num_rows($query);
        echo $count;
        ?>">0</p>
    </div>
    <div class="Users-Card d-flex">
        <i class="fa-solid fa-map"></i>
        <p>Total Services</p>
        <p class="number" data-max="
            <?php
        $select = " Select * from pitches";
        $query = mysqli_query($connect, $select);
        $count = mysqli_num_rows($query);
        echo $count;
        ?>
            ">0</p>
    </div>
</section>
<article>
    <h1 class="text-center">Latest Available Pitches</h1>
    <div class="d-flex Search-Container">
        <form class="d-flex Search" method="post" action="Home.php">
            <button>Search</button>
            <input type="text" placeholder="What are you looking for?" name="txtSearch" value="">

        </form>
    </div>
    <div class="d-flex PitchShow">
        <?php
        if (isset($_POST['txtSearch'])) {
            $SearchName = $_POST['txtSearch'];
        } else {
            $SearchName = "";
        }
        $select = "SELECT * FROM pitches WHERE PitchName LIKE '%$SearchName%'";
        $query = mysqli_query($connect, $select);
        $count = mysqli_num_rows($query);
        if ($count == 0) {
            echo "<h2>No records</h2>";
        } else {
            if ($count > 4){
                $count = 4;
            }
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
    <div class="d-flex justify-content-center ReadMore">
        <a href="PitchesTypesAndAvailabilities.php" class="PitchCardReadMore">Read More</a>
    </div>
    <br>
    <br>

    <h1 class="text-center">Our Information</h1>
    <div class="d-flex article-card">
        <div class="article-left Map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4287.418401119388!2d103.68008700789123!3d1.3154382815252925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smm!4v1695791122763!5m2!1sen!2smm"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="article-right">
            <h2 class="Heading">Contact Global Wild Swimming and Camping</h2>
            <p class="Text">We're here to assist you with all your insurance needs. Feel free to reach out to us for any
                questions or assistance you may require</p>
            <p><b>Address:</b> 123 Benoi Rd, BENOI sectior, M1 2XY, Singapore</p>
            <p><b>Phone:</b> +65 (0) 123 456 789</p>
            <p><b>Email:</b> info@GWSC.com</p>
            <p><b>Office Hours:</b> Mon-Fri: 8a.m - 8p.m SGT</p>

        </div>
    </div>
    <div class="d-flex article-card">
        <div class="article-left">
            <h2 class="Heading">Our Goals</h2>
            <p class="Text">At GWSC, our mission is to inspire, connect, and empower outdoor enthusiasts around the
                world to experience the beauty and serenity of nature through wild swimming and camping. </p>
            <ul>
                <li><b>Fostering Adventure and Exploration</b></li>
                <li><b>Building a Global Community</b></li>
                <li><b>Conservation and Sustainability</b></li>
                <li><b>Cultural Exchange</b></li>

            </ul>
        </div>
        <div class="article-right Map">
            <iframe src="https://www.youtube.com/embed/vmBSq1uQXYw?si=RRS-A6xbF-a9MenF" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
        </div>
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
            <a href="RSS.php">RSS</a>

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
        <p class="text-center">Home Page</p>
        <p class="text-center">&copy;GWSC Copyright 2023</p>
    </div>
</footer>
<script type="text/javascript">

    const NavCall = document.querySelector("#NavCall");
    const NavClose = document.querySelector("#NavClose");
    const MobileNav = document.querySelector(".Mobile-Nav")
    NavCall.addEventListener("click", () => {
        MobileNav.style.transform = "translateX(0%)"
    })
    NavClose.addEventListener("click", () => {
        MobileNav.style.transform = "translateX(-100%)"
    })

    let IsTransition = false;
    const Slide = document.querySelector(".Slide");
    const Btn = document.querySelectorAll(".Slide-button-group button");
    const ContentSlider = document.querySelectorAll(".Slide-content");
    Btn.forEach((Button, i) => {
        Button.addEventListener("click", () => {
            if (IsTransition) return;
            IsTransition = true;
            changeImage(Slide.children[i]);
            Active(Button);
            Default(ContentSlider[i]);
            clearInterval(intervalID);
            counter = i + 1;
            if (counter > 3)
                counter = 0;
            startInterval();
            setTimeout(() => {
                IsTransition = false;
            }, 2300);

        })
    });
    const changeImage = (Image) => {
        [...Slide.children].forEach((el) => {
            el.classList.remove("active");
        })
        Image.classList.add("active");
    }

    const Active = (btn) => {
        Btn.forEach((Button) => {
            Button.classList.remove("active");
        })
        btn.classList.add(("active"));
    }

    const Default = (SlideOpen) => {
        document.querySelectorAll(".Slide-content").forEach((SlideContent) => {
            SlideContent.classList.remove("Carousel-Active");
        })

        SlideOpen.classList.add("Carousel-Active");

    }
    let counter = 1;
    let intervalID;
    const makeSlide = (i) => {
        Active(Btn[i]);
        Default(ContentSlider[i]);
        changeImage(Slide.children[counter]);
    }


    function startInterval() {
        intervalID = setInterval(() => {
            makeSlide(counter);
            counter++;
            if (counter > 3) {
                counter = 0;
            }
        }, 10000);
    }

    startInterval();


    //Search animative start

    const SearchBtn = document.querySelector(".Search button");
    const SearchContainer = document.querySelector(".Search");
    const OldSearchContainerWidth = SearchContainer.offsetWidth;
    SearchContainer.style.width = SearchBtn.offsetWidth + "px";

    const User = document.querySelector(".Users");
    const Number = document.querySelectorAll(".number");
    let start = false;

    const startCount = (el) => {
        let max = el.dataset.max;
        let count = setInterval(() => {
            el.textContent++;
            if (el.textContent === max.trim()) {
                clearInterval(count);
                console.log("Hello");
            }
        }, 2000 / Number);
    }

    const article = document.querySelectorAll(".article-card");


    const MakeToEndAction = (element) => {
        return element.offsetTop + element.offsetHeight
    }

    const MakeToStartAction = (element) => {
        return element.offsetTop - (window.innerHeight - element.offsetHeight);
    }

    window.onscroll = () => {
        if (window.scrollY > Slide.offsetTop && window.scrollY < MakeToEndAction(Slide)) {
            Slide.children[counter - 1].style.objectPosition = `center ${(window.scrollY / Slide.offsetHeight) * 50 + 50}%`;
        }
        if (window.scrollY > MakeToStartAction(SearchContainer) && window.scrollY < MakeToEndAction(SearchContainer)) {
            SearchContainer.style.width = OldSearchContainerWidth + "px";
        } else {
            SearchContainer.style.width = SearchBtn.offsetWidth + "px";

        }
        if (window.scrollY > MakeToStartAction(User) && window.scrollY < MakeToEndAction(User)) {
            if (!start) {
                Number.forEach((el) => startCount(el))
            }
            start = true
        }
        article.forEach((el) => {
            if (window.scrollY > MakeToStartAction(el) && window.scrollY < MakeToEndAction(el)) {
                [...el.children].forEach((child) => {
                    child.classList.add("active");
                })
            } else {
                [...el.children].forEach((child) => {
                    child.classList.remove("active");
                })
            }
        })
    }

</script>
</body>
</html>



