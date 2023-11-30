<?php
session_start();
include('Connect.php');
if(!isset($_SESSION["AdminID"])){
    echo "<script>window.alert('Please Log In first')</script>";
    echo "<script>window.location='LogIn.php'</script>";
}
if (isset($_POST["btnAdd"])) {

    $Folder = 'Images/';
    $ImagesDir = '';

    foreach ($_FILES['LocalAttractionImages']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['LocalAttractionImages']['name'][$key];
        $tmp_name = $_FILES['LocalAttractionImages']['tmp_name'][$key];

        $ImagesDir .= $Folder . "_" . $file_name . "+";

        $upload_destination = $Folder . $file_name;
        $upload = move_uploaded_file($tmp_name, $upload_destination);
        if (!$upload) {
            echo "<script>window.alert('Error in picture Local Attraction Image')</script>";
            exit();
        }
    }

    $LocalAttractionProfileImage = $_FILES['LocalAttractionProfile']['name'];
    $LocalAttractionProfileImage = $Folder . "_" . $LocalAttractionProfileImage;
    $copy = copy($_FILES['LocalAttractionProfile']['tmp_name'], $LocalAttractionProfileImage);
    if (!$copy) {
        echo "<script>window.alert('Error in picture Local Attraction Profile Image')</script>";
        exit();
    }

    $Name = $_POST["txtName"];
    $Description = $_POST["Description"];
    $Description = str_replace("'","",$Description);
    $Features = $_POST["txtFeatures"];

    $checkName = "Select * from localattraction where LocalAttractionName = '$Name'";
    $check = mysqli_query($connect, $checkName);
    $row = mysqli_num_rows($check);

    if ($row > 0) {
        echo "<script>window.alert('Local Attraction is Already exit')</script>";
        echo "<script>window.location = 'LocalAttractionControl.php'</script>";

    } else {
        $query = "Insert Into localattraction(LocalAttractionName,LocalAttractionIntroImage,LocalAttractionDescription,LocalAttractionFeatures,LocalAttractionImages) values ('$Name','$LocalAttractionProfileImage','$Description','$Features','$ImagesDir')";
        $Insert = mysqli_query($connect, $query);
        if ($Insert) {
            echo "<script>window.alert('Successfully Insert Local Attraction')</script>";
            header("Location: LocalAttractionControl.php");

        } else {
            echo $Insert;
        }
    }

}
if (isset($_POST["BtnEdit"])) {

    $Folder = 'Images/';
    $ID = $_POST['txtID'];
    $ImagesDir = '';

    foreach ($_FILES['LocalAttractionImages']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['LocalAttractionImages']['name'][$key];
        $tmp_name = $_FILES['LocalAttractionImages']['tmp_name'][$key];

        $ImagesDir .= $Folder . $file_name . "+";

        $upload_destination = $Folder . $file_name;
        $upload = move_uploaded_file($tmp_name, $upload_destination);
        if (!$upload) {
            echo "<script>window.alert('Error in picture Local Attraction Image')</script>";
            exit();
        }
    }

    $LocalAttractionProfileImage = $_FILES['LocalAttractionProfile']['name'];
    $LocalAttractionProfileImage = $Folder . "_" . $LocalAttractionProfileImage;
    $copy = copy($_FILES['LocalAttractionProfile']['tmp_name'], $LocalAttractionProfileImage);
    if (!$copy) {
        echo "<script>window.alert('Error in picture Local Attraction Profile Image')</script>";
        exit();
    }

    $Name = $_POST["txtName"];
    $Description = $_POST["Description"];
    $Description = str_replace("'","",$Description);
    $Features = $_POST["txtFeatures"];

    $query = "Update localattraction set
    LocalAttractionName = '$Name',
    LocalAttractionIntroImage = '$LocalAttractionProfileImage',
    LocalAttractionDescription = '$Description',
    LocalAttractionFeatures = '$Features',
    LocalAttractionImages = '$ImagesDir'
    where LocalAttractionID = '$ID'
    ";
    $Insert = mysqli_query($connect, $query);
    if ($Insert) {
        echo "<script>window.alert('Successfully Update')</script>";
        header("Location: LocalAttractionControl.php");

    } else {
        echo $Insert;
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
    <title>Document</title>
    <link rel="stylesheet" href="gwsc.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

</head>
<body class="List">
<form class="PitchSearchContainer" method="post" action="LocalAttractionControl.php">
    <input type="text" value="" name="txtSearch" list="LocalAttractionList" placeholder="Search Local Attraction"
           class="PitchSearchInput">
    <datalist id="LocalAttractionList">
        <?php
        $select = "Select * from localattraction";
        $query = mysqli_query($connect, $select);
        $count = mysqli_num_rows($query);
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($query);
            $Name = $row["LocalAttractionName"];

            echo " <option value='$Name'>$Name</option>";
        }
        ?>

    </datalist>
    <div class="SearchButtonContainer">
        <button class="MoodleCall SearchButton">Search</button>
        <button class="MoodleCall LocationCall" id="PitchAdd">New Local Attraction</button>

    </div>
</form>
<?php
if (isset($_POST['txtSearch'])) {
    $SearchName = $_POST['txtSearch'];
} else {
    $SearchName = "";
}
$select = "Select * from localattraction where LocalAttractionName like '%$SearchName%'";
$query = mysqli_query($connect, $select);
$count = mysqli_num_rows($query);
if ($count == 0) {
    echo "<h2>No records</h2>";
} else {
    for ($i = 0; $i < $count; $i++) {
        $row = mysqli_fetch_array($query);
        $ID = $row["LocalAttractionID"];
        $Name = $row["LocalAttractionName"];
        $IntroImage = $row["LocalAttractionIntroImage"];
        $Description = $row["LocalAttractionDescription"];
        $Features = $row["LocalAttractionFeatures"];
        $AttractionImages = $row["LocalAttractionImages"];

        echo "<div class='PitchContent'>
        <img src='$IntroImage' class='PitchDisplayImage'>
        <div class='PitchData'>
            <h2>$Name</h2>
            <p class='PitchDescription text-justify'>$Description</p>
            <div class='FacilitiesContainer'>";

        $Feature = explode('+', $Features);
        $Feature = array_filter($Feature, function ($Feature) {
            return trim($Feature) !== '';
        });
        foreach ($Feature as $FeatureItem) {
            echo "<p class='FacilitiesName' > $FeatureItem </p >";
        }

        echo "</div>
            <div class='PitchFooter'>
                <button class='MoodleCall' Feature='$Features' ID = '$ID'>Edit Local Attraction</button>
            </div>
        </div>
    </div>";
    }
}
?>

<script>

    const AddMoodle = (name = '', ID = 0, Description = '', LocationFeatures = '', method = 'btnAdd', value = 'Add') => {
        const AddFeatures = (LocationFeatures) => {
            let FeatureShow = '';
            const LocationFeature = LocationFeatures.split("+");
            LocationFeature.forEach(el => {
                el = el.trim();
                if (el !== '') {
                    FeatureShow += `<p class="FacilitiesName">${el}</p>`
                }
            })
            return FeatureShow;
        }

        const Moodle = document.createElement("div");
        Moodle.classList.add("Moodle");
        Moodle.innerHTML = `<div class="LocalAttractionPanel">
        <div class="LocalAttractionBody">
            <img class="LocalAttractionImage" src="Images/photo.png">
            <form class="LocalAttractionContent" enctype="multipart/form-data" action="LocalAttractionControl.php"
                  method="post" >
                <input type="file" name="LocalAttractionProfile" id="LocalAttractionProfile" class="Display_None"
                       accept=".png, .jpg, .jpeg" required>
                <h1>Local Attraction Of <span class="Name">${name}</span></h1>
                <h2>Local Attraction Name</h2>
                <input type="hidden" name="txtID" value="${ID}">
                <input type="text" name="txtName" placeholder="Local Attraction Name" value="${name}" id="Name" required>
                <h2>Description</h2>
                <textarea name="Description" placeholder="Description" maxlength="1000"
                          class="LocalDescription" required rows="5">${Description}</textarea>
                <input type="hidden" name="txtFeatures" id="Features" value="${LocationFeatures}" required>
                <h2>Features</h2>
                <div class="FeaturesShow">
                    <div class="FacilitiesContainer" id="FacilitiesContainer">
                        ${AddFeatures(LocationFeatures)}
                    </div>
                    <input type="text" placeholder="Add Features" id="LocalFeatures">
                    <button class='FeatureAddButton'>Add</button>
                </div>
                <input type="file" name="LocalAttractionImages[]" id="LocalAttractionImages" class="Display_None"
                       accept=".png, .jpg, .jpeg" multiple required>
                <div class="LocalImageContainer">
                    <img src="Images/photo.png" class="FeatureImageAdd">
                </div>

                <input type="submit" name="${method}" value="${value}" class="LogInbth">
                <button type="reset" value="Clear" class="LogInbth" id="CloseForm">Cancel</button>


            </form>
        </div>

    </div>`;


        const MoodleClose = Moodle.querySelector("#CloseForm");
        MoodleClose.addEventListener("click", () => {
            Moodle.remove();
        });

        const Features = Moodle.querySelector("#Features");
        const LocalFeatures = Moodle.querySelector("#LocalFeatures");
        const FeatureAddButton = Moodle.querySelector(".FeatureAddButton")
        const FeatureContainer = Moodle.querySelector("#FacilitiesContainer");

        FeatureAddButton.addEventListener("click", (event) => {
            event.preventDefault();
            if (LocalFeatures.value !== '') {
                const p = document.createElement("p");
                p.classList.add("FacilitiesName");
                p.innerText = LocalFeatures.value;
                FeatureContainer.appendChild(p);
                Features.value += `${LocalFeatures.value} + `;
                LocalFeatures.value = '';
            }

        })

        FeatureContainer.addEventListener("dblclick", (event) => {
            if (event.target.classList.contains("FacilitiesName")) {
                Features.value = Features.value.replace(event.target.innerText + "+", "");
                event.target.remove();
            }
        })

        const Name = Moodle.querySelector("#Name");
        const TitleName = Moodle.querySelector(".Name");

        Name.addEventListener("keyup", (event) => {
            TitleName.innerText = event.target.value;
        });

        const AddImage = Moodle.querySelector(".FeatureImageAdd");
        const Container = Moodle.querySelector(".LocalImageContainer");
        const ImageFile = Moodle.querySelector("#LocalAttractionImages");

        AddImage.addEventListener("click", () => {
            ImageFile.click();
        })

        ImageFile.addEventListener("change", (event) => {
            const FeatureImage = Moodle.querySelectorAll('.LocationFeatures');
            FeatureImage.forEach((el) => {
                el.remove();
            })
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.addEventListener("load", (event) => {
                    const img = document.createElement("img");
                    img.src = event.target.result;
                    img.classList.add("LocationFeatures");
                    Container.insertBefore(img, Container.firstChild)
                });
                reader.readAsDataURL(files[i]);
            }
        });

        const LocalAttractionImage = Moodle.querySelector(".LocalAttractionImage");
        const LocalProfile = Moodle.querySelector("#LocalAttractionProfile");

        LocalAttractionImage.addEventListener("click", () => {
            LocalProfile.click();
        })

        LocalProfile.addEventListener("change", (event) => {
            const reader = new FileReader();
            reader.addEventListener("load", (event) => {
                LocalAttractionImage.src = event.target.result;
            })
            reader.readAsDataURL(event.target.files[0]);
        })

        return Moodle;
    }

    const MoodleBtn = document.querySelector("#PitchAdd");
    const Body = document.querySelector(".List");

    MoodleBtn.addEventListener("click", (event) => {
        event.preventDefault();
        Body.append(AddMoodle());
    })

    Body.addEventListener("click", (event) => {
        if (event.target.classList.contains("MoodleCall")) {
            const PitchData = event.target.closest(".PitchData")
            const Name = PitchData.querySelector("h2").innerText;
            const Description = PitchData.querySelector(".PitchDescription").innerText;
            const Feature = event.target.getAttribute("Feature");
            const ID = event.target.getAttribute("ID");
            Body.append(AddMoodle(Name, ID, Description, Feature, 'BtnEdit', 'Edit'));
        }
    })

</script>
</body>
</html>
