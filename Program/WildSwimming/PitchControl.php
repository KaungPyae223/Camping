<?php

session_start();
include("Connect.php");
if(!isset($_SESSION["AdminID"])){
    echo "<script>window.alert('Please Log In first')</script>";
    echo "<script>window.location='LogIn.php'</script>";
}

if (isset($_POST["btnAdd"])) {
    $PitchName = $_POST['txtName'];
    $Location = $_POST['txtLocation'];
    $LocationAddress = $_POST['txtLocationAddress'];
    $FacilitiesName = $_POST['txtFeatures'];
    $Price = $_POST['txtPrice'];
    $Description = $_POST['Description'];
    $Description = str_replace("'","",$Description);
    $Status = 'Active';
    $CampsiteID = $_POST['cboCampsite'];
    $PitchTypeID = $_POST['cboPitchType'];
    $LocalAttractionID = $_POST['cboLocalAttraction'];
    $Duration = $_POST['txtDuration'];
    $FacilitiesDescription = $_POST['FacilitiesDescription'];
    $FacilitiesDescription = str_replace("'","",$FacilitiesDescription);
    $Folder = 'Images/';
    $PitchImagesDir = '';

    foreach ($_FILES['FacilitiesImages']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['FacilitiesImages']['name'][$key];
        $tmp_name = $_FILES['FacilitiesImages']['tmp_name'][$key];

        $PitchImagesDir .= $Folder . $file_name . "+";

        $upload_destination = $Folder . $file_name;
        $upload = move_uploaded_file($tmp_name, $upload_destination);
        if (!$upload) {
            echo "<script>window.alert('Error in picture Pitch Features Image')</script>";
            exit();
        }
    }

    $PitchProfileImage = $_FILES['PitchImage']['name'];
    $PitchProfileImage = $Folder . "_" . $PitchProfileImage;
    $copy = copy($_FILES['PitchImage']['tmp_name'], $PitchProfileImage);
    if (!$copy) {
        echo "<script>window.alert('Error in picture Pitch Profile Image')</script>";
        exit();
    }


    $checkName = "Select * from pitches where PitchName = '$PitchName'";
    $check = mysqli_query($connect, $checkName);
    $count = mysqli_num_rows($check);

    if ($count > 0) {
        echo "<script>window.alert('Pitch Already exit')</script>";
        header("Location: PitchControl.php");


    } else {
        $LocationAddress = $_POST['txtLocationAddress'];
        $query = "Insert into pitches (PitchName,PitchIntroImage,Location,FacilitiesName,FacilitiesImage,Price,Description,Status,CampsiteID,PitchTypeID,LocalAttractionID,Duration,FacilitiesDescription,LocationAddress) values ('$PitchName','$PitchProfileImage','$Location','$FacilitiesName','$PitchImagesDir','$Price','$Description','$Status','$CampsiteID','$PitchTypeID','$LocalAttractionID','$Duration','$FacilitiesDescription','$LocationAddress')";
        $Insert = mysqli_query($connect, $query);
        if ($Insert) {
            header("Location: PitchControl.php");


        } else {
            echo $Insert;
        }
    }
}
if (isset($_POST['btnEdit'])) {
    $PitchName = $_POST['txtName'];
    $ID = $_POST['txtID'];
    $Location = $_POST['txtLocation'];
    $FacilitiesName = $_POST['txtFeatures'];
    $Price = $_POST['txtPrice'];
    $Description = $_POST['Description'];
    $Description = str_replace("'","",$Description);
    $Description = str_replace("'","",$Description);
    $Status = 'Active';
    $LocationAddress = $_POST['txtLocationAddress'];
    $CampsiteID = $_POST['cboCampsite'];
    $PitchTypeID = $_POST['cboPitchType'];
    $LocalAttractionID = $_POST['cboLocalAttraction'];
    $Duration = $_POST['txtDuration'];
    $FacilitiesDescription = $_POST['FacilitiesDescription'];
    $FacilitiesDescription = str_replace("'","",$FacilitiesDescription);

    $Folder = 'Images/';
    $PitchImagesDir = '';

    foreach ($_FILES['FacilitiesImages']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['FacilitiesImages']['name'][$key];
        $tmp_name = $_FILES['FacilitiesImages']['tmp_name'][$key];

        $PitchImagesDir .= $Folder . $file_name . "+";

        $upload_destination = $Folder . $file_name;
        $upload = move_uploaded_file($tmp_name, $upload_destination);
        if (!$upload) {
            echo "<script>window.alert('Error in picture Pitch Features Image')</script>";
            exit();
        }
    }

    $PitchProfileImage = $_FILES['PitchImage']['name'];
    $PitchProfileImage = $Folder . "_" . $PitchProfileImage;
    $copy = copy($_FILES['PitchImage']['tmp_name'], $PitchProfileImage);
    if (!$copy) {
        echo "<script>window.alert('Error in picture Pitch Profile Image')</script>";
        exit();
    }

    $query = "UPDATE pitches
SET
  PitchName = '$PitchName',
  PitchIntroImage = '$PitchProfileImage',
  Location = '$Location',
  FacilitiesName = '$FacilitiesName',
  FacilitiesImage = '$PitchImagesDir',
  Price = '$Price',
  Description = '$Description',
  Status = '$Status',
  CampsiteID = '$CampsiteID',
  PitchTypeID = '$PitchTypeID',
  LocalAttractionID = '$LocalAttractionID',
  Duration = '$Duration',
  FacilitiesDescription = '$FacilitiesDescription',
  LocationAddress = '$LocationAddress'
WHERE
  PitchID = '$ID'
";
    $Update = mysqli_query($connect, $query);
    if ($Update) {
        echo "<script>window.alert('Successfully Update')</script>";
        header("Location: PitchControl.php");


    } else {
        echo $Update;
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

<form class="PitchSearchContainer" method="post" action="PitchControl.php">
    <input type="text" value="" name="txtSearch" list="PitchList" placeholder="Search Pitch" class="PitchSearchInput">
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
    <div class="SearchButtonContainer">
        <button class="MoodleCall SearchButton">Search</button>
        <button class="MoodleCall PitchCall" id="PitchAdd">New Pitch</button>

    </div>
</form>
<?php
if (isset($_POST['txtSearch'])) {
    $SearchName = $_POST['txtSearch'];
} else {
    $SearchName = "";

}
$select = "Select P.*,C.CampsiteName,L.LocalAttractionName,Pt.TypeName from pitches P,pitchtype Pt,localattraction L,campsite C where P.CampsiteID = C.CampsiteID and P.PitchTypeID = Pt.PitchTypeID and P.LocalAttractionID = L.LocalAttractionID and P.PitchName like '%$SearchName%'";
$query = mysqli_query($connect, $select);
$count = mysqli_num_rows($query);
if ($count == 0) {
    echo "<h2>No records</h2>";
} else {
    for ($i = 0; $i < $count; $i++) {
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
        $CampsiteName = $row["CampsiteName"];
        $PitchTypeID = $row["PitchTypeID"];
        $PitchType= $row["TypeName"];
        $LocalAttractionID = $row["LocalAttractionID"];
        $LocalName = $row["LocalAttractionName"];
        $Duration = $row["Duration"];
        $FacilitiesDescription = $row['FacilitiesDescription'];
        $AddressLocation = $row['LocationAddress'];
        echo "<div class='PitchContent'>
        <img src='$IntroImage' class='PitchDisplayImage'>
        <div class='PitchData'>
            <h2>$Name Pitch</h2>
            <p class='Location'>$Location</p>
            <p class='Location'>$Duration</p>
            <p class='PitchDescription text-justify'>$Description</p>
            <div class='FacilitiesContainer'>";

        $Feature = explode('+', $FacilitiesName);
        $Feature = array_filter($Feature, function ($Feature) {
            return trim($Feature) !== '';
        });
        foreach ($Feature as $FeatureItem) {
            echo "<p class='FacilitiesName' > $FeatureItem </p >";
        }

        echo "</div>
        <p><b>Local Attraction Name:</b> $LocalName</p>
        <p><b>Campsite Name:</b> $CampsiteName</p>
        <p><b>Pitch Type Name:</b> $PitchType</p>
            <div class='PitchFooter'>
            <h2>$Price $</h2>
                <button class='MoodleCall' Duration='$Duration' Title='$Name' ID = '$ID' Location='$Location' FacilitiesName='$FacilitiesName' Price='$Price' campsiteID ='$CampsiteID' pitchTypeID = '$PitchTypeID' LocalAttractionID = '$LocalAttractionID' FacilitiesDescription = '$FacilitiesDescription' AddressLocation = '$AddressLocation'>Edit Pitch</button>
            </div>
        </div>
    </div>";
    }
}
?>


<script>


    const Body = document.querySelector('.List');
    const PitchAdd = document.querySelector('#PitchAdd');

    PitchAdd.addEventListener("click", (event) => {
        event.preventDefault();
        Body.append(AddMoodle());
    })
    const AddMoodle = (title = '', value = 'Add', method = 'btnAdd', ID = 0, PitchLocation = '', FacilitiesName = '', Price = '', EditDescription = '', CampsiteID = "0", PitchTypeID = "0", LocalAttractionID = "0", FacilitiesDescription = "", LocationAddress = "", EditDuration = "") => {

        const AddFeatures = (PitchFeatures) => {
            let FeatureShow = '';
            const LocationFeature = PitchFeatures.split("+");
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

        Moodle.innerHTML = `
    <div class="PitchPanel">
        <div class="PitchBody">
            <img class="PitchImage" src="Images/photo.png">
            <form class="PitchForm" enctype="multipart/form-data" action="PitchControl.php"
                  method="post" >
                <input type="file" name="PitchImage" id="PitchProfile" class="Display_None"
                       accept=".png, .jpg, .jpeg" required>
                <h1><span class="Name">${title}</span> Pitch</h1>
                <h2>Pitch Name</h2>
                <input type="hidden" name="txtID" value="${ID}">
                <input type="text" name="txtName" placeholder="Pitch Name" value="${title}" id="Name" required>
                <h2>Pitch Location</h2>
                <input type="text" name="txtLocation" placeholder="Pitch Location" value="${PitchLocation}"  required>
                <h2>Location Address</h2>
                <input type="text" name="txtLocationAddress" placeholder="Location Address" value="${LocationAddress}"  required>
                <h2>Description</h2>
                <textarea name="Description" placeholder="Description" maxlength="5000"
                          class="PitchDescription" required rows="8">${EditDescription}</textarea>
                <input type="hidden" name="txtFeatures" id="Features" value="${FacilitiesName}" required>
                <h2>Features</h2>
                <div class="FeaturesShow">
                    <div class="FacilitiesContainer" id="FacilitiesContainer">
                        ${AddFeatures(FacilitiesName)}
                    </div>
                    <input type="text" placeholder="Add Features" id="PitchFeatures">
                    <button class='FeatureAddButton'>Add</button>
                </div>
                <input type="file" name="FacilitiesImages[]" id="PitchFeaturesImages" class="Display_None"
                       accept=".png, .jpg, .jpeg" multiple required>
                <div class="FacilitiesImageContainer">
                    <img src="Images/photo.png" class="FeatureImageAdd">
                </div>
                <h2>FacilitiesDescription</h2>
                <textarea name="FacilitiesDescription" placeholder="Facilities Description" maxlength="5000"
                          class="PitchDescription" required rows="8">${FacilitiesDescription}</textarea>

                <h2>Duration</h2>
                <input type="text" placeholder="Duration" name="txtDuration" value="${EditDuration}" required>

                <h2>Price</h2>
                <input type="number" name="txtPrice" placeholder="Price" value='${Price}' required>
                <h2>Choose Site</h2>
                <select name="cboCampsite" id='Campsite'>
                    <?php
        $select = "Select * from campsite";
        $run = mysqli_query($connect, $select);
        $count = mysqli_num_rows($run);
        for ($i = 0; $i < $count; $i++) {
            $data = mysqli_fetch_array($run);
            $CID = $data["CampsiteID"];
            $CName = $data["CampsiteName"];
            echo "<option value='$CID'>$CName</option>";
        }

        ?>
                </select>

                <h2>Choose Pitch Type</h2>
                <select name="cboPitchType" id='PitchType'>
                    <?php
        $select = "Select * from pitchtype";
        $run = mysqli_query($connect, $select);
        $count = mysqli_num_rows($run);
        for ($i = 0; $i < $count; $i++) {
            $data = mysqli_fetch_array($run);
            $PID = $data["PitchTypeID"];
            $PName = $data["TypeName"];
            echo "<option value='$PID'>$PName</option>";
        }

        ?>
                </select>
                <h2>Local Attraction</h2>
                <select name="cboLocalAttraction" id='LocalAttraction'>
                    <?php
        $select = "Select * from localattraction";
        $run = mysqli_query($connect, $select);
        $count = mysqli_num_rows($run);
        for ($i = 0; $i < $count; $i++) {
            $data = mysqli_fetch_array($run);
            $LID = $data["LocalAttractionID"];
            $LName = $data["LocalAttractionName"];
            echo "<option value='$LID'>$LName</option>";
        }

        ?>
                </select>
                <input type="submit" name="${method}" value="${value}" class="LogInbth">
                <button type="reset" value="Clear" class="LogInbth" id="CloseForm">Cancel</button>
            </form>
        </div>
    </div>
    `;
        const MoodleClose = Moodle.querySelector("#CloseForm");
        MoodleClose.addEventListener("click", () => {
            Moodle.remove();
        });

        const Campsite = Moodle.querySelector("#Campsite");
        for (let i = 0; i < Campsite.children.length; i++) {
            if (Campsite.children[i].value === CampsiteID)
                Campsite.children[i].selected = true;
        }

        const PitchType = Moodle.querySelector("#PitchType");
        for (let i = 0; i < PitchType.children.length; i++) {
            if (PitchType.children[i].value === PitchTypeID)
                PitchType.children[i].selected = true;
        }

        const LocalAttraction = Moodle.querySelector("#LocalAttraction");
        for (let i = 0; i < LocalAttraction.children.length; i++) {
            if (LocalAttraction.children[i].value === LocalAttractionID)
                LocalAttraction.children[i].selected = true;
        }

        const Features = Moodle.querySelector("#Features");
        const FeatureAddButton = Moodle.querySelector(".FeatureAddButton")
        const FeatureContainer = Moodle.querySelector("#FacilitiesContainer");
        const PitchFeature = Moodle.querySelector("#PitchFeatures");
        FeatureAddButton.addEventListener("click", (event) => {
            event.preventDefault();
            if (PitchFeature.value !== '') {
                const p = document.createElement("p");
                p.classList.add("FacilitiesName");
                p.innerText = PitchFeature.value;
                FeatureContainer.appendChild(p);
                Features.value += `${PitchFeature.value} + `;
                PitchFeature.value = '';
            }

        })

        FeatureContainer.addEventListener("dblclick", (event) => {
            if (event.target.classList.contains("FacilitiesName")) {
                Features.value = Features.value.replace(event.target.innerText + " + ", "");
                event.target.remove();
            }
        })

        const Name = Moodle.querySelector("#Name");
        const TitleName = Moodle.querySelector(".Name");

        Name.addEventListener("keyup", (event) => {
            TitleName.innerText = event.target.value;
        });

        const AddImage = Moodle.querySelector(".FeatureImageAdd");
        const Container = Moodle.querySelector(".FacilitiesImageContainer");
        const ImageFile = Moodle.querySelector("#PitchFeaturesImages");

        AddImage.addEventListener("click", () => {
            ImageFile.click();
        })

        ImageFile.addEventListener("change", (event) => {
            const FeatureImage = Moodle.querySelectorAll('.PitchFeatures');
            const files = event.target.files;
            FeatureImage.forEach((el) => {
                el.remove();
            })
            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.addEventListener("load", (event) => {
                    const img = document.createElement("img");
                    img.src = event.target.result;
                    img.classList.add("PitchFeatures");
                    Container.insertBefore(img, Container.firstChild)
                });
                reader.readAsDataURL(files[i]);
            }
        });

        const LocalAttractionImage = Moodle.querySelector(".PitchImage");
        const LocalProfile = Moodle.querySelector("#PitchProfile");

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
    };
    Body.addEventListener("click", (event) => {
        if (event.target.classList.contains("MoodleCall")) {
            const ID = event.target.getAttribute("ID");
            const Name = event.target.getAttribute("Title");
            const Location = event.target.getAttribute("Location");
            const Price = event.target.getAttribute("Price");
            const Facilities = event.target.getAttribute("FacilitiesName");
            const Description = event.target.closest(".PitchData").querySelector(".PitchDescription").innerText;
            const CampsiteID = event.target.getAttribute("CampsiteID");
            const pitchTypeID = event.target.getAttribute("pitchTypeID");
            const LocalAttractionID = event.target.getAttribute("LocalAttractionID");
            const FacilitiesDescription = event.target.getAttribute("FacilitiesDescription");
            const AddressLocation = event.target.getAttribute("AddressLocation");
            const Duration = event.target.getAttribute("Duration");
            Body.append(AddMoodle(Name, 'Edit', 'btnEdit', ID, Location, Facilities, Price, Description, CampsiteID, pitchTypeID, LocalAttractionID, FacilitiesDescription, AddressLocation,Duration));
        }
    })


</script>
</body>
</html>
