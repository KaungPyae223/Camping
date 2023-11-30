<?php
session_start();
include("Connect.php");
$ID = $_REQUEST["ID"];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Features Details</title>
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
$Name = $row["PitchName"];
$FacilitiesImage = $row["FacilitiesImage"];
$FacilitiesDescription = $row['FacilitiesDescription'];
$FacilitiesName = $row["FacilitiesName"];
echo "
<a href='PitchesInformation.php?ID=$ID' class='ExitButton'><i class='fa-solid fa-arrow-right-from-bracket'></i> Exit</a>
<br>
<br>
<br>
<h1 class='text-center'>Features Details of $Name Pitch</h1>
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
<br>
<section class='InformationSection'>
    <p><b>Name:</b> $Name</p>

    <h2>Features</h2>
    <div class='FacilitiesContainer'>
";
$Feature = explode('+', $FacilitiesName);
$Feature = array_filter($Feature, function ($Feature) {
    return trim($Feature) !== '';
});
foreach ($Feature as $FeatureItem) {
    echo "<p class='FacilitiesName' > $FeatureItem </p >";
}

echo "</div>
<div class='LocalImageContainer'>";
$NewImages = str_replace(" ","%20",$FacilitiesImage);
$Images = explode('+', $NewImages);
$Images = array_filter($Images, function ($Images) {
    return trim($Images) !== '';
});
foreach ($Images as $SingleImage) {
    echo "<img src='$SingleImage' class='FeatureImageAdd'>";

}
echo "</div>
<p><b>Features Description</b></p>
    <p class='text-justify'> $FacilitiesDescription</p>
</section>
";
?>

<h2 class="text-center">Wearable technologies</h2>
<div class="d-flex PitchShow">
    <div class="PitchCard">
        <div class="PitchCardHeader">
            <img src="Images/Waist%20Fan.PNG" class="PitchCardImage">
        </div>
        <div class="PitchCardBody">
            <h2>Waist Fan</h2>
            <p class="text-justify">This fan is for giving the cooling when you are tired or too hot when you are hiking or camping</p>
        </div>
    </div>
    <div class="PitchCard">
        <div class="PitchCardHeader">
            <img src="Images/Watch.jpg" class="PitchCardImage">
        </div>
        <div class="PitchCardBody">
            <h2>Smart Watch</h2>
            <p class="text-justify">This watch contains gps and can measure ecg and oxygen concentration. It can also calculate how high above the sea level etc.</p>
        </div>
    </div>
    <div class="PitchCard">
        <div class="PitchCardHeader">
            <img src="Images/Solar.jpg" class="PitchCardImage">
        </div>
        <div class="PitchCardBody">
            <h2>Solar charger</h2>
            <p>With this device you can charge your smart devices with the solar panel</p>
        </div>
    </div>
</div>






<footer>
    <p class="text-center">Features Page</p>
    <p class="text-center">&copy;GWSC Copyright 2023</p>
</footer>
</body>
</html>
