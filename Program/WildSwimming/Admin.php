<?php
session_start();
include('Connect.php');
if(!isset($_SESSION["AdminID"])){
    echo "<script>window.alert('Please Log In first')</script>";
    echo "<script>window.location='LogIn.php'</script>";
}

if (isset($_POST['btnAdd'])) {
    $name = $_POST['txtName'];
    $email = $_POST['txtEmail'];
    $phone = $_POST['txtPhone'];
    $password = $_POST['txtPassword'];
    $address = $_POST['txtAddress'];
    $checkEmail = "Select * from admin where AdminEmail = '$email'";
    $result = mysqli_query($connect, $checkEmail);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        echo "<script>window.alert(`There is already exit`)</script>";
        header("Location: Admin.php");
    } else {
        $insert = "insert into admin (AdminName,AdminEmail,AdminPhoneNumber,AdminAddress,Password) values ('$name','$email','$phone','$address',$password)";
        $finalResult = mysqli_query($connect, $insert);
        if ($finalResult) {
            echo "<script>window.alert(`Successfully`)</script>";
            header("Location: Admin.php");

        } else {
            echo $finalResult;
        }
    }
}

if (isset($_POST['btnEdit'])) {

    $ID = $_POST["txtID"];
    $name = $_POST['txtName'];
    $email = $_POST['txtEmail'];
    $phone = $_POST['txtPhone'];
    $password = $_POST['txtPassword'];
    $address = $_POST['txtAddress'];
    $Update = "Update admin set AdminName = '$name',AdminEmail = '$email', AdminPhoneNumber = '$phone' , AdminAddress = '$address', Password = '$password' where AdminID = '$ID'";
    $query = mysqli_query($connect, $Update);

    if ($query) {
        echo "<script>window.alert('Successfully Update')</script>";
        header("Location: Admin.php");
    } else {
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
    <title>Global Wild Swimming Camping</title>
    <link rel="stylesheet" href="gwsc.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

</head>
<body class="List">

<?php
$select = "Select * from admin";
$query = mysqli_query($connect, $select);
$count = mysqli_num_rows($query);
if ($count == 0) {
    echo "<p>No records</p>";
}

?>

<div class="Header">
    <h2>Admin List</h2>
    <button class="MoodleCall">Add new Admin</button>
</div>
<div class="TableContainer">
    <table class="MainTable">
        <tr>
            <th class="ID">ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
        <?php
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($query);

            $ID = $row["AdminID"];
            $Name = $row["AdminName"];
            $Email = $row["AdminEmail"];
            $Phone = $row["AdminPhoneNumber"];
            $Address = $row["AdminAddress"];


            echo "<tr>";
            echo "<td class='ID'>$ID</td>";
            echo "<td class='Name'>$Name</td>";
            echo "<td class='Phone'>$Phone</td>";
            echo "<td class='Email'>$Email</td>";

            echo "<td class='Address'>$Address 
            
            </td>";
            echo "<td class='Action'><div class='ButtomForm'>
          <button class='EditButton' ID='$ID' ><i class='fa-solid fa-pencil'></i></button>
                <button class='DeleteButton'  ID='$ID'><i class='fa-solid fa-trash'></i></button>   
  
           </div></td>";
            echo "</tr>";

        }
        ?>
    </table>
</div>
<script>

    const Body = document.querySelector('.List');

    const AddMoodle = (title = 'Admin Registration Form', value = 'Add', method = 'btnAdd', ID = 0, name = '', email = '', phone = '', address = '') => {
        const Moodle = document.createElement("div");
        Moodle.classList.add("Moodle");

        Moodle.innerHTML = `
        <div class="MoodleBody">
            <form action="Admin.php" method="POST">
                <h1>${title}</h1>
                <input type="hidden" name="txtID" value="${ID}">
        <input type="text" name="txtName" placeholder="Enter Admin Full Name" value="${name}" required>
        <input type="email" name="txtEmail" placeholder="Enter Admin Email" value="${email}" required>
        <input type="text" name="txtPhone" placeholder="Enter Admin Phone" value="${phone}" required>
        <textarea name="txtAddress" placeholder="Enter Admin Address" required>${address}</textarea>
        <input type="password" name="txtPassword" placeholder="Enter Staff Password" required>
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
        if (event.target.classList.contains("EditButton")) {
            const td = event.target.closest("td");
            const Name = td.parentElement.querySelector(".Name").textContent;
            const Email = td.parentElement.querySelector(".Email").textContent;
            const Phone = td.parentElement.querySelector(".Phone").textContent;
            const Address = td.parentElement.querySelector(".Address").textContent;
            const ID = event.target.getAttribute("ID");
            Body.append(AddMoodle(`Edit Form of ${Name}`, 'Edit', 'btnEdit', ID, Name, Email, Phone, Address));

        } else if (event.target.classList.contains("DeleteButton")) {
            if (window.confirm("Are you sure to Delete")) {
                const ID = event.target.getAttribute("ID");
                <?php
                $_SESSION["Type"] = 'Admin';
                $_SESSION["Link"] = 'Admin.php';
                ?>
                window.location = `Delete.php?ID=${ID}`;
            }
        }
    })
</script>
</body>
</html>
