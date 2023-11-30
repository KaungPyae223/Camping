<?php
include("connect.php");
session_start();
$CustomerID = $_SESSION["CustomerID"];

$Select = "Select * from customers where CustomerID = '$CustomerID'";
$query = mysqli_query($connect,$Select);
$row1 = mysqli_fetch_array($query);
$FirstName = $row1['FirstName'];
$SurName = $row1['SurName'];
$Email = $row1['Email'];
$Address = $row1['Addresses'];
$PhoneNo = $row1['PhoneNo'];
$callBack = $_SESSION['CallBack'];
$CheckPassword = $row1['Password'];

if (isset($_POST["btnEdit"])) {

    $FirstName = $_POST["txtFirstName"];
    $SurName = $_POST["txtSurName"];
    $Email = $_POST["txtEmail"];
    $Address = $_POST["txtAddress"];
    $PhoneNo = $_POST["txtPhoneNo"];
    $OldPassword = $_POST["OldPassword"];
    $NewPassword = $_POST["NewPassword"];
    $NewConfirmPassword = $_POST["NewConfirmPassword"];

    if ($OldPassword != $CheckPassword) {
        echo "<script>window.alert('Password Wrong')</script>";
        header("Location: Profile.php");
    } else {
        if ($ConfirmPassword === $Password) {
            $Update = "UPDATE customers
            SET
            FirstName = '$FirstName',
            SurName = '$SurName',
            Email = '$Email',
            Addresses = '$Address',
            PhoneNo = '$PhoneNo',
            Password = '$NewPassword'
            WHERE
            Password = '$OldPassword'; 
            ";
            $query = mysqli_query($connect, $Update);
            if ($query) {
                echo "<script>window.alert('Successfully Update a Customer information')</script>";
                echo "<script>window.location='LogIn.php';</script>";
            } else {
                echo $query;
            }
        } else {
            echo "<script>window.alert('The two password and confirm password do not match')</script>";

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
    <title>Profile</title>
    <link rel="stylesheet" href="gwsc.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

</head>
<body class="ProfileBody">
<a class="ExitButton" href="<?php echo "$callBack";?>"><i class="fa-solid fa-arrow-right-from-bracket"></i> Exit</a>
<br>
<br>
<br>
<br>
<h1 class="text-center"><?php echo "$FirstName $SurName";?> Profile</h1>
<div class="Profile-container">
    <p><b>Name: </b><span class="Name" ID="<?php echo "$CustomerID";?>" FirstName = '<?php echo "$FirstName";?>' SurName = '<?php echo "$SurName";?>'><?php echo "$FirstName $SurName";?></span></p>
    <p><b>Address: </b> <span class="Address"><?php echo "$Address";?></span></p>
    <p><b>Email Address: </b><span class="Email"><?php echo "$Email";?></span></p>
    <p><b>Phone No: </b><span class="PhoneNo"><?php echo "$PhoneNo";?></span></p>
    <br>
    <button class="PitchAvlSearch ProfileEditBtn">Edit</button>
</div>
<hr>
<br>
<h2 class="text-center">Booking List of <?php echo "$FirstName $SurName";?></h2>
<br>

<div class="TableContainer ProfileBookingTable">
    <table class="MainTable">
        <tr>
            <th class="ID">No</th>
            <th>Pitch Name</th>
            <th>Email</th>
            <th>Visitors</th>
            <th>Total Price</th>
            <th>Booking Date</th>

        </tr>
        <?php
        $select = "Select B.*,C.FirstName,C.SurName,P.PitchName,P.Price from booking B,customers C,pitches P where B.CustomerID = C.CustomerID and P.PitchID = B.PitchID";
        $query = mysqli_query($connect, $select);
        $count = mysqli_num_rows($query);
        if ($count == 0) {
            echo "<tr>";
            echo "<td colspan='6'><h2>No records</h2></td>";
        } else {
            for ($i = 0; $i < $count; $i++) {
                $row = mysqli_fetch_array($query);
                $UnitPrice = $row["Price"];
                $Name = $row["FirstName"] . " " . $row["SurName"];
                $PitchName = $row["PitchName"];
                $BookingNo = $row["BookingCodeNo"];
                $BookingDate = $row["BookingDate"];
                $Status = $row["Status"];
                $Price = $row["Price"];
                $SubTotal = $row["SubTotal"];
                $Tax = $row["Tax"];
                $Email = $row["CustomerEmail"];
                $Qty = $row["BookingQty"];
                $No = $i+1;

                echo "<tr class='BookingTr' Name='$Name' ID='$BookingNo' Status = '$Status' Email='$Email' UnitPrice='$UnitPrice' SubTotal = '$SubTotal' Tax='$Tax'>";
                echo "<td class='ID'>$No</td>";
                echo "<td class='PitchName'>$PitchName </td>";
                echo "<td>$Email</td>";
                echo "<td class='Qty'>$Qty </td>";
                echo "<td class='Price'>$Price </td>";
                echo "<td class='Date'>$BookingDate </td>";


                echo "</tr>";

            }
        }

        ?>
    </table>
</div>
<footer>
    <p class="text-center">Profile Page</p>
    <p class="text-center">&copy;GWSC Copyright 2023</p>
</footer>
<script>

    const Body = document.querySelector('.ProfileBody');

    const AddMoodle = (BookID, Date, Customer, Email, Pitch, UnitPrice, Visitors, Sub, Tax, Total, Description) => {
        const Moodle = document.createElement("div");
        Moodle.classList.add("Moodle");
        Moodle.innerHTML = `
        <div class="MoodleBody">
        <div class="BookingDisplay">
            <h2>Details of Booking ${Pitch}</h2>
            <br>
            <hr>
            <br>
            <p><b>Booking Date: ${Date}</b></p>
            <p><b>Customer Name: </b>${Customer}</p>
            <p><b>Email: </b>${Email}</p>
            <p><b>Pitch Name: </b>${Pitch}</p>
            <p><b>Unit Price: </b>${UnitPrice}</p>
            <p><b>Total Visitors: </b>${Visitors}</p>
            <p><b>Sub Total: </b>${Sub}</p>
            <p><b>Tax: </b>${Tax}</p>
            <p><b>Total Price: </b>${Total}</p>
            <p><b>Status: </b></p>
            <p>${Description}</p>
            <br>

            <button class="LogInbth" id="CloseForm">Cancel</button>
        </div>
    </div>
    `;

        const MoodleClose = Moodle.querySelector("#CloseForm");
        MoodleClose.addEventListener("click", () => {
            Moodle.remove();
        });
        return Moodle;
    };


    const MoodleOpen = document.querySelector(".TableContainer");
    MoodleOpen.addEventListener("click", (event) => {
        if (event.target.parentElement.classList.contains("BookingTr")) {
            const Tr = event.target.parentElement;
            const CustomerName = Tr.getAttribute("Name");
            const PitchName = Tr.querySelector(".PitchName").innerText;
            const ID = Tr.getAttribute("ID");
            const Qty = Tr.querySelector(".Qty").innerText;
            const Price = Tr.querySelector(".Price").innerText;
            const Date = Tr.querySelector(".Date").innerText;
            const Status = Tr.getAttribute("Status");
            const Email = Tr.getAttribute("Email");
            const UintPrice = Tr.getAttribute("UnitPrice");
            const SubTotal = Tr.getAttribute("SubTotal");
            const Tax = Tr.getAttribute("Tax");
            Body.append(AddMoodle(ID, Date, CustomerName, Email, PitchName, UintPrice, Qty, SubTotal, Tax, Price, Status));
        }
    })


    const EditButton = document.querySelector(".ProfileEditBtn");
    const body = document.querySelector(".ProfileBody");
    EditButton.addEventListener("click",(event) => {
        const Name = document.querySelector(".Name");
        const CustomerID = Name.getAttribute("ID");
        const FirstName = Name.getAttribute("FirstName");
        const SurName = Name.getAttribute("SurName");

        const Address = document.querySelector(".Address").innerText;
        const Email = document.querySelector(".Email").innerText;
        const Ph = document.querySelector(".PhoneNo").innerText;
        body.append(EditProfileForm(CustomerID,FirstName,SurName,Address,Email,Ph));
    })
    const EditProfileForm = (CustomerID,FirstName,LastName,Address,Email,PhoneNo) => {
        const Moodle = document.createElement("div");
        Moodle.classList.add("Moodle");

        Moodle.innerHTML = `
        <div class="MoodleBody">
            <form action="Profile.php" method="POST">
                <h1>Edit Customer Info Form</h1>

                <label>First Name</label>
                <input type="text" name="txtFirstName" placeholder="First Name" value="${FirstName}" required>

                <label>Sur Name</label>
                <input type="text" name="txtSurName" placeholder="Sur Name" value="${LastName}" required>

                <label>Email</label>
                <input type="email" name="txtEmail" placeholder="Email" value="${Email}" required>

                <label>Address</label>
                <input type="text" name="txtAddress" placeholder="Address" value="${Address}" required>

                <label>Phone Number</label>
                <input type="text" name="txtPhoneNo" placeholder="Phone Number" value="${PhoneNo}" required>

                <label>Old Password</label>
                <input type="text" name="OldPassword" placeholder="Old Password" required>


                <label>New Password</label>
                <input type="text" name="NewPassword" placeholder="New Password" required>

                <label>New Confirm Password</label>
                <input type="text" name="NewConfirmPassword" placeholder="New Confirm Password" required>

<input type="submit" name="btnEdit" value="Edit" class="LogInbth">
                <button type="reset" value="Clear" class="LogInbth" id="CloseForm">Cancel</button>
            </form>
        </div>
    `;

        const MoodleClose = Moodle.querySelector("#CloseForm");
        MoodleClose.addEventListener("click", () => {
            Moodle.remove();

        });

        return Moodle;
    }
</script>
</body>
</html>
