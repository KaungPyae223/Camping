<?php
session_start();
include("Connect.php");
$ID = $_REQUEST["ID"];
$_SESSION["PitchID"] = $ID;
if(isset($_POST["btnBooking"]))
{
    if(!isset($_SESSION["CustomerID"])){
        echo "<script>window.alert('Please Log in to Review')</script>";
        echo "<script>window.location = 'LogIn.php'</script>";
    }
    else if($_POST["txtBookingQty"]<=0){
        echo "<script>window.alert('Booking quantity should be greater than 0')</script>";
        echo "<script>window.location = 'PitchesInformation.php?ID=$ID'</script>";

    }
    else{
        $BookingDate= $_POST["txtDate"];
        $PitchID = $ID;
        $Status = $_POST["Status"];
        $Status = str_replace("'","",$Status);

        $Price = $_POST["txtPrice"];
        $SubTotal= $_POST["txtSubTotal"];
        $Tax= $_POST["txtTax"];
        $CustomerEmail= $_POST["txtEmail"];
        $BookingQty= $_POST["txtBookingQty"];
        $CustomerID= $_SESSION["CustomerID"];

        $insert = "Insert into booking (BookingDate,PitchID,Status,Price,SubTotal,Tax,CustomerEmail,BookingQty,CustomerID) values ('$BookingDate','$PitchID','$Status','$Price','$SubTotal','$Tax','$CustomerEmail','$BookingQty','$CustomerID')";
        $query = mysqli_query($connect, $insert);
        if ($query) {
            echo "<script>window.alert('Successfully Booking')</script>";
            echo "<script>window.location = 'Home.php'</script>";

        } else {
            echo $query;
        }
    }
}
if(isset($_POST["Review"])){
    if(!isset($_SESSION["CustomerID"])){
        echo "<script>window.alert('Please Login to review')</script>";
        echo "<script>window.location = 'LogIn.php'</script>";

    }
    else{
        $Review = $_POST["txtReview"];
        $CustomerID = $_SESSION["CustomerID"];
        $ReviewDate = $_POST["txtReviewDate"];
        $insert = "Insert into pitchreview (PitchReview,PitchID,CustomerID,ReviewDate) values ('$Review','$ID','$CustomerID','$ReviewDate')";
        $query = mysqli_query($connect, $insert);
        if ($query) {
            echo "<script>window.alert('Successfully Review')</script>";
            echo "<script>window.location = 'PitchesInformation.php?ID=$ID'</script>";

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
    <title>Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="gwsc.css">

</head>
<body class="Information">
<?php

$select = "SELECT * FROM pitches WHERE PitchID = $ID";
$query = mysqli_query($connect, $select);
$row = mysqli_fetch_array($query);
$ID = $row["PitchID"];
$Name = $row["PitchName"];
$IntroImage = $row["PitchIntroImage"];
$Location = $row["Location"];
$FacilitiesName = $row["FacilitiesName"];
$FacilitiesImage = $row["FacilitiesImage"];
$Price = $row["Price"];
$Description = $row["Description"];
$Status = $row["Status"];
$CampsiteID = $row["CampsiteID"];
$PitchTypeID = $row["PitchTypeID"];
$LocalAttractionID = $row["LocalAttractionID"];
$Duration = $row["Duration"];
$FacilitiesDescription = $row['FacilitiesDescription'];
$AddressLocation = $row['LocationAddress'];
echo "<img class='PitchImage' src='$IntroImage'>
<a class='ExitButton' href='PitchesTypesAndAvailabilities.php'><i class='fa-solid fa-arrow-right-from-bracket'></i> Exit</a>
<br>
<h1 class='text-center'>$Name Information</h1>
<div id='google_translate_element' class='text-center'></div>

        <script type='text/javascript'>
            function googleTranslateElementInit() {
                new google.translate.TranslateElement(
                    {pageLanguage: 'en'},
                    'google_translate_element'
                );
            }
        </script>

        <script type='text/javascript'
                src=
                'https://translate.google.com/translate_a/element.js?
cb=googleTranslateElementInit'>
        </script>
<section class='InformationSection'>
    <p><b>Name:</b> $Name</p>
    <p><b>Location:</b> $Location</p>
    <p><b>Duration:</b> $Duration</p>
";

$campsite = "Select * from campsite where CampsiteID = $CampsiteID";
$query = mysqli_query($connect, $campsite);
$row = mysqli_fetch_array($query);
$campsiteName = $row["CampsiteName"];
echo "<p><b>Campsite:</b> $campsiteName</p>";

$PitchType = "Select * from pitchtype where PitchTypeID = $PitchTypeID";
$query = mysqli_query($connect, $PitchType);
$row = mysqli_fetch_array($query);
$PitchTypeName = $row["TypeName"];
echo "<p><b>Pitch Type:</b> $PitchTypeName</p>";

$LocalAttraction = "Select * from localattraction where LocalAttractionID = $LocalAttractionID";
$query = mysqli_query($connect, $LocalAttraction);
$row = mysqli_fetch_array($query);
$LocalAttractionName = $row["LocalAttractionName"];
echo "<p><b>Local Attraction:</b> $LocalAttractionName</p>";
echo "
    <a href='LocalAttractions.php?ID=$LocalAttractionID'>View Local Attraction More</a>
    <br><br>
    <h2>Map:</h2>
    <br>
    <iframe src='$AddressLocation'
            style='border:0;' allowfullscreen='' loading='lazy' referrerpolicy='no-referrer-when-downgrade'></iframe>
    <h2>Features</h2>
    <div class='FacilitiesContainer'>";

$Feature = explode('+', $FacilitiesName);
$Feature = array_filter($Feature, function ($Feature) {
    return trim($Feature) !== '';
});
foreach ($Feature as $FeatureItem) {
    echo "<p class='FacilitiesName' > $FeatureItem </p >";
}

echo "</div>
<div class='LocalImageContainer'>
";
$NewImages = str_replace(" ","%20",$FacilitiesImage);
$Images = explode('+', $NewImages);
$Images = array_filter($Images, function ($Images) {
    return trim($Images) !== '';
});
foreach ($Images as $SingleImage) {
    echo "<img src='$SingleImage' class='FeatureImageAdd'>";

}
echo "
    </div>
    <br>
    <a href='FeaturesDetails.php?ID=$ID'>View Features Details</a>
    <br>
    <br>
    <p><b>Description</b></p>
    <p class='text-justify'>$Description</p>
    <a class='Booking'>Booking</a>
    </section>
";

?>
<hr>
<div class="ReviewContainer">
    <br>
    <h1 class="text-center">Reviews of Pitch <?php echo "$Name"?></h1>
    <br>
    <form class="PitchSearchContainer" method="post" action="PitchesInformation.php?ID=<?php echo "$ID"; ?>">
        <input type="hidden" class="ReviewDate" name="txtReviewDate">
        <input type="text" class="ReviewInput" name="txtReview" placeholder="Review the Pitch">
        <div class="d-flex justify-content-center">
            <button class="PitchAvlSearch PitchReviewButton" name="Review">Review</button>
        </div>
    </form>
    <br>
    <?php
        $SelectReview = "Select PV.*,C.FirstName,C.SurName from pitchreview PV,customers C where PV.CustomerID = C.CustomerID and PitchID = '$ID'";
        $query1 = mysqli_query($connect, $SelectReview);
        $count = mysqli_num_rows($query1);
        if($count == 0)
        {
            echo "<h2 class='text-center'>No Reviews</h2>";
        }else{
            for($i = 0;$i < $count;$i++){
                $row1= mysqli_fetch_array($query1);
                $ReviewerName = $row1["FirstName"].' '.$row1["SurName"];
                $ReviewDate = $row1["ReviewDate"];
                $Review = $row1["PitchReview"];
                echo "
                <div>
        <h2>$ReviewerName</h2>
        <p class='text-small'><b>Review Date: </b>$ReviewDate</p>
        <p>$Review</p>
        <br>
        <hr>
    </div>
    <br>
                ";
            }
        }



    ?>
</div>
<footer>
    <p class="text-center">Information Page</p>
    <p class="text-center">&copy;GWSC Copyright 2023</p>
</footer>
<script>
    let currentDate = new Date();
    let year = currentDate.getFullYear();
    let month = currentDate.getMonth() + 1;
    let day = currentDate.getDate();
    let Today = day + "-" + month + "-" + year;

    const ReviewDate = document.querySelector(".ReviewDate");
    ReviewDate.value = Today;

    const Booking = document.querySelector(".Booking");
    const Body = document.querySelector(".Information");
    Booking.addEventListener("click", (event) => {
        event.preventDefault();
        Body.append(AddMoodle());
    })

    const AddMoodle = () => {


        const Moodle = document.createElement("div");
        Moodle.classList.add("Moodle");

        Moodle.innerHTML = `
    <div class="MoodleBody">
            <form action="PitchesInformation.php?ID=<?php echo "$ID";?>" method="POST">
                <h1>Booking Form of <?php echo "$Name Pitch"?></h1>
                <input type="hidden" name="txtDate" value=${Today}>
                <p><b>Date:</b> ${Today}</p>
                <p><b>Price:</b> <?php echo "$Price $";?></p>
                <input type="hidden" name="txtSinglePrice" id="SinglePrice" value=<?php echo"$Price";?>>
                <h4>Total Visitors</h4>
                <input type="number" name="txtBookingQty" id="BookingQty" value="0" required>

                <input type="hidden" name="txtSubTotal" id="SubTotal" >
                <input type="hidden" name="txtTax" id="Tax" >
                <input type="hidden" name="txtPrice" id="Price" >

                <p><b>Sub-Total:</b> <span id="SubDisplay">0</span> $</p>
                <p><b>Tax:</b> <span id="TaxDisplay">0</span> $</p>
                <p><b>Total Price:</b> <span id="TotalDisplay">0</span> $</p>

                <input type="email" name="txtEmail" placeholder="Email" required >

                <textarea name="Status" placeholder="Status" maxlength="5000"
                          class="PitchDescription" rows="6"></textarea>


                <input type="submit" name="btnBooking" value="Booking" class="LogInbth">
                <button type="reset" value="Clear" class="LogInbth" id="CloseForm">Cancel</button>
            </form>
        </div>
    `;
        const MoodleClose = Moodle.querySelector("#CloseForm");
        MoodleClose.addEventListener("click", () => {
            Moodle.remove();
        });

        const SingleValue = Moodle.querySelector("#SinglePrice");
        const TotalCustomer = Moodle.querySelector("#BookingQty");
        const SubTotal = Moodle.querySelector("#SubDisplay");
        const SubTotalForm = Moodle.querySelector('#SubTotal')
        const TaxForm = Moodle.querySelector("#Tax");
        const TaxDisplay = Moodle.querySelector('#TaxDisplay')
        const TotalDisplay= Moodle.querySelector("#TotalDisplay");
        const txtTotalDisplay= Moodle.querySelector('#Price');

        TotalCustomer.addEventListener("input", () => {
            if(parseInt(TotalCustomer.value) < 0){
                TotalCustomer.value = 0;
            }
            else {
                let SubTotalCalculate = parseInt(SingleValue.value) * parseInt(TotalCustomer.value);
                SubTotal.innerText = SubTotalCalculate.toString();
                SubTotalForm.value = SubTotalCalculate;
                let Tax = SubTotalCalculate/100 * 5;
                TaxDisplay.innerText = Tax.toString();
                TaxForm.value= Tax;
                let TotalPrice = SubTotalCalculate + Tax;
                TotalDisplay.innerText = TotalPrice.toString();
                txtTotalDisplay.value = TotalPrice;

            }

        });
        return Moodle;
    };

</script>
</body>
</html>
