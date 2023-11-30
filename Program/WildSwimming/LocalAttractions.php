<?php
session_start();
include ("Connect.php");
$PitchID = $_SESSION["PitchID"];
$ID = $_REQUEST["ID"];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Local Attraction</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="gwsc.css">

</head>
<body class="Information">
<?php
$select = "SELECT * FROM localattraction WHERE LocalAttractionID = $ID";
$query = mysqli_query($connect, $select);
$row = mysqli_fetch_array($query);
$Name = $row["LocalAttractionName"];
$IntroImage = $row["LocalAttractionIntroImage"];
$Description = $row["LocalAttractionDescription"];
$Features = $row["LocalAttractionFeatures"];
$Images = $row["LocalAttractionImages"];
echo "
<img class='PitchImage' src='$IntroImage'>
<a href='PitchesInformation.php?ID=$PitchID' class='ExitButton'><i class='fa-solid fa-arrow-right-from-bracket'></i> Exit</a>
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
<br>
<section class='InformationSection'>
    <p><b>Name:</b> $Name </p>
    <h2>Local Attraction Features</h2>
    <div class='FacilitiesContainer'>
";
$Feature = explode('+', $Features);
$Feature = array_filter($Feature, function ($Feature) {
    return trim($Feature) !== '';
});
foreach ($Feature as $FeatureItem) {
    echo "<p class='FacilitiesName' > $FeatureItem </p >";
}
echo "</div>
    <div class='LocalImageContainer'>";
$NewImages = str_replace(" ","%20",$Images);
$Images = explode('+', $NewImages);
$Images = array_filter($Images, function ($Images) {
    return trim($Images) !== '';
});
foreach ($Images as $SingleImage) {
    echo "<img src='$SingleImage' class='FeatureImageAdd'>";

}
echo "</div>

    <br>
    <p><b>Description</b></p>
    <p class='text-justify'>
    $Description
    </p>
</section>";
?>


<footer>
    <p class="text-center">Local Attraction Page</p>
    <p class="text-center">&copy;GWSC Copyright 2023</p>
</footer>
</body>
</html>
