<?php
session_start();
include("Connect.php");
if(!isset($_SESSION["AdminID"])){
    echo "<script>window.alert('Please Log In first')</script>";
    echo "<script>window.location='LogIn.php'</script>";
}
if (isset($_POST["btnAdd"])) {

    $TypeName = $_POST["txtTypeName"];

    $check = "Select * from pitchtype where TypeName = '$TypeName'";
    $checkRow = mysqli_query($connect, $check);
    $count = mysqli_num_rows($checkRow);
    if ($count > 0) {
        echo "<script>window.alert('Type Name already exit')</script>";
        header("Location: PitchType.php");
    } else {
        $insert = "Insert into pitchtype (TypeName) values ('$TypeName')";
        $query = mysqli_query($connect, $insert);
        if ($query) {
            echo "<script>window.alert('Successfully insert the pitchType')</script>";
            header("Location: PitchType.php");
        } else {
            echo $query;
        }
    }
}

if(isset($_POST['btnEdit'])){

    $TypeName = $_POST["txtTypeName"];
    $ID = $_POST["txtID"];
    $Update = "Update pitchtype set TypeName = '$TypeName' where PitchTypeID = '$ID'";
    $query = mysqli_query($connect,$Update);

    if($query){
        echo "<script>window.alert('Successfully Update')</script>";

        header("Location: PitchType.php");

    }
    else{
        echo $query;
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


<div class="Header">
    <h2>Pitch Type Table</h2>
    <button class="MoodleCall">Add new Pitch Type</button>
</div>
<div class="TableContainer">
    <table class="MainTable">
        <tr>
            <th class="ID">ID</th>
            <th>Pitch Type Name</th>
            <th>Action</th>

        </tr>
        <?php
        $select = "Select * from pitchType";
        $query = mysqli_query($connect, $select);
        $count = mysqli_num_rows($query);
        if ($count == 0) {
            echo "<tr>";
            echo "<td colspan='3'><h2>No records</h2></td>";
        }
        else{
            for ($i = 0; $i < $count; $i++) {
                $row = mysqli_fetch_array($query);

                $ID = $row["PitchTypeID"];
                $Name = $row["TypeName"];

                echo "<tr>";
                echo "<td class='ID'>$ID</td>";
                echo "<td>$Name </td>";
                echo "<td class='Action'><div class='ButtomForm'>
          <button class='EditButton' ID='$ID' Name='$Name'><i class='fa-solid fa-pencil'></i></button>
                <button class='DeleteButton'  ID='$ID'><i class='fa-solid fa-trash'></i></button>   
  
           </div></td>";

                echo "</tr>";

            }
        }

        ?>
    </table>
</div>

<script>

    const Body = document.querySelector('.List');

    const AddMoodle = (title = 'Pitch Type Entry Form', value = 'Add', method = 'btnAdd', ID = 0,OldName="") => {
        const Moodle = document.createElement("div");
        Moodle.classList.add("Moodle");

        Moodle.innerHTML = `
        <div class="MoodleBody">
            <form action="PitchType.php" method="POST">
                <h1>${title}</h1>
                <input type="hidden" name="txtID" value="${ID}">
                <input type="text" name="txtTypeName" placeholder="Enter Pitch Type Name" required value="${OldName}">
                <input type="submit" name=${method} value="${value}" class="LogInbth">
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

    const MoodleOpen = document.querySelector(".MoodleCall");
    MoodleOpen.addEventListener("click", () => {
        Body.append(AddMoodle());
    })


    const MainTable = document.querySelector(".TableContainer");
    MainTable.addEventListener("click", (event) => {
        if(event.target.classList.contains("EditButton")){
            const Name = event.target.getAttribute("Name");
            const ID = event.target.getAttribute("ID");
            Body.append(AddMoodle(`Edit Form of ${Name}`,'Edit','btnEdit',ID,Name));

        }
        else if (event.target.classList.contains("DeleteButton")){
            if(window.confirm("Are you sure to Delete")){
                const ID = event.target.getAttribute("ID");
                <?php
                $_SESSION["Type"] = 'PitchType';
                $_SESSION["Link"] = 'PitchType.php';
                $Type = $_SESSION["Type"];
                ?>

                window.location = `Delete.php?ID=${ID}`;
            }
        }
    })
</script>
</body>
</html>