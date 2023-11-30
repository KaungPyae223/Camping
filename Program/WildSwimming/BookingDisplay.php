<?php
session_start();
include("Connect.php");

if(!isset($_SESSION["AdminID"])){
    echo "<script>window.alert('Please Log In first')</script>";
    echo "<script>window.location='LogIn.php'</script>";
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

<h1 class="text-center">Booking Lists</h1>
<br>
<div class="TableContainer">
    <table class="MainTable">
        <tr>
            <th class="ID">ID</th>
            <th>Pitch Name</th>
            <th>Customer Name</th>
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


                echo "<tr class='BookingTr' Status = '$Status' Email='$Email' UnitPrice='$UnitPrice' SubTotal = '$SubTotal' Tax='$Tax'>";
                echo "<td class='ID'>$BookingNo</td>";
                echo "<td class='PitchName'>$PitchName </td>";
                echo "<td class='Name'>$Name </td>";
                echo "<td class='Qty'>$Qty </td>";
                echo "<td class='Price'>$Price </td>";
                echo "<td class='Date'>$BookingDate </td>";


                echo "</tr>";

            }
        }

        ?>
    </table>
</div>
<script>

    const Body = document.querySelector('.List');

    const AddMoodle = (BookID,Date,Customer,Email,Pitch,UnitPrice,Visitors,Sub,Tax,Total,Description) => {
        const Moodle = document.createElement("div");
        Moodle.classList.add("Moodle");
        Moodle.innerHTML = `
        <div class="MoodleBody">
        <div class="BookingDisplay">
            <h2>Details of Booking No ${BookID}</h2>
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
    MoodleOpen.addEventListener("dblclick", (event) => {
        if (event.target.parentElement.classList.contains("BookingTr")) {
            const Tr = event.target.parentElement;
            const CustomerName = Tr.querySelector(".Name").innerText;
            const PitchName = Tr.querySelector(".PitchName").innerText;
            const ID = Tr.querySelector(".ID").innerText;
            const Qty = Tr.querySelector(".Qty").innerText;
            const Price = Tr.querySelector(".Price").innerText;
            const Date = Tr.querySelector(".Date").innerText;
            const Status = Tr.getAttribute("Status");
            const Email = Tr.getAttribute("Email");
            const UintPrice = Tr.getAttribute("UnitPrice");
            const SubTotal = Tr.getAttribute("SubTotal");
            const Tax = Tr.getAttribute("Tax");
            Body.append(AddMoodle(ID,Date,CustomerName,Email,PitchName,UintPrice,Qty,SubTotal,Tax,Price,Status));
        }
    })

</script>
</body>
</html>
