<?php
session_start();
include("Connect.php");
$SetTimeOut = 600;
if(!isset($_SESSION["LogInFail"])){
    $_SESSION["LogInFail"] = 0;
}
if(isset($_POST['g-recaptcha-response'])){
    $captcha=$_POST['g-recaptcha-response'];
    if(!$captcha){
        echo '<h2>Please check the the captcha form.</h2>';
        exit;
    }
    $secretKey = "6Lc0n40mAAAAAMAoPr9sAsv_hL15Mg5IEtdazucZ";

    $ip = $_SERVER['REMOTE_ADDR'];

    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);

    $response = file_get_contents($url);
    $responseKeys = json_decode($response,true);

    if(!$responseKeys["success"]) {
        echo '<h2>reCaptcha verification failed.</h2>';
    }

}


if (isset($_POST['BtnLogIn'])) {

    if (isset($_SESSION['lockoutTime']) && $_SESSION['lockoutTime'] > time()) {
        $remainingTime = $_SESSION['lockoutTime'] - time();
        $RemainingMinutes = intval($remainingTime/60);
        $ReminSecnds = $remainingTime%60;
        echo "<script>window.alert('Account locked. Please try again in $RemainingMinutes minutes $ReminSecnds seconds')</script>";

    } else {
        $Email = $_POST['TxtEmail'];
        $Password = $_POST['TxtPassword'];

        $check = "Select * from admin where AdminEmail = '$Email' and Password = '$Password'";
        $Query = mysqli_query($connect, $check);
        $AdminCount = mysqli_num_rows($Query);

        if ($AdminCount > 0) {
            echo "<script>window.alert('Successfully log in')</script>";

            $array = mysqli_fetch_array($Query);
            $aID = $array['AdminID'];
            $aEmail = $array['AdminEmail'];
            $aName = $array['AdminName'];

            $_SESSION["AdminEmail"] = $aEmail;
            $_SESSION["AdminID"] = $aID;
            $_SESSION["AdminName"] = $aName;

            header("Location: Dashboard.php");

        } else {

            $check = "Select * from customers where  Email = '$Email' and Password = '$Password'";
            $Query = mysqli_query($connect, $check);
            $CustomerCount = mysqli_num_rows($Query);
            if ($CustomerCount > 0) {
                echo "<script>window.alert('Successfully log in')</script>";

                $array = mysqli_fetch_array($Query);
                $ID = $array['CustomerID'];
                $Email = $array['Email'];
                $Name = $array['FirstName'] . " " . $array['SurName'];

                $_SESSION["CustomerEmail"] = $Email;
                $_SESSION["CustomerID"] = $ID;
                $_SESSION["CustomerName"] = $Name;

                header("Location: Home.php");
            } else {
                if ($_SESSION["LogInFail"] >= 3) {
                    $_SESSION['lockoutTime'] = time() + $SetTimeOut;
                    $Minute = $SetTimeOut/60;
                    echo "<script>window.alert('Account locked. Please try again in $Minute minutes')</script>";
                    $SetTimeOut = $SetTimeOut * 2;
                    $_SESSION["LogInFail"] = 0;
                } else {
                    $_SESSION["LogInFail"] += 1;
                    echo "<script>window.alert('Login fail ".$_SESSION["LogInFail"]." times. Please try again')</script>";

                }
            }
        }
    }
}
if (isset($_POST["btnRegister"])) {

    $FirstName = $_POST["txtFirstName"];
    $SurName = $_POST["txtSurName"];
    $Email = $_POST["txtEmail"];
    $Address = $_POST["txtAddress"];
    $PhoneNo = $_POST["txtPhoneNo"];
    $Password = $_POST["Password"];
    $ConfirmPassword = $_POST["ConfirmPassword"];

    $check = "Select * from customers where Email = '$Email'";
    $checkRow = mysqli_query($connect, $check);
    $count = mysqli_num_rows($checkRow);
    if ($count > 0) {
        echo "<script>window.alert('This customer already exit')</script>";
        header("Location: LogIn.php");
    } else {
        if ($ConfirmPassword === $Password) {
            $insert = "Insert into customers (FirstName,SurName,Email,Addresses,PhoneNo,Password) values ('$FirstName','$SurName','$Email','$Address','$PhoneNo','$Password')";
            $query = mysqli_query($connect, $insert);
            if ($query) {
                echo "<script>window.alert('Successfully Register a Customer')</script>";
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
    <title>Global Wild Swimming Camping</title>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <link rel="stylesheet" href="gwsc.css">
</head>
<body>
<div class="RegisterBody">
    <form action="LogIn.php" method="post">

        <h1>GWSC Log In</h1>
        <input type="text" name="TxtEmail" placeholder="Email" required>

        <input type="password" name="TxtPassword" placeholder="Password" required>

        <div class="g-recaptcha" data-type="image"  data-sitekey="6Lc0n40mAAAAAECs8_IY2TpqCPNNa57PBcC4A1qV"></div>


        <input type="submit" name="BtnLogIn" value="Log In" class="LogInbth">
        <button type="reset" value="Clear" class="LogInbth">Cancel</button>
        <br>
        <hr>
        <button class="LogInbth Register">Register a customer</button>

    </form>

</div>
<script>
    const body = document.querySelector("body");
    const Register = document.querySelector(".Register");
    Register.addEventListener("click", (event) => {
        event.preventDefault();
        body.append(callMoodle());
    })
    const callMoodle = () => {
        const Moodle = document.createElement("div");
        Moodle.classList.add("Moodle");

        Moodle.innerHTML = `
        <div class="MoodleBody">
            <form action="LogIn.php" method="POST">
                <h1>Customer Registeriation Form</h1>
                <label>First Name</label>
                <input type="text" name="txtFirstName" placeholder="First Name" required>

                <label>Sur Name</label>
                <input type="text" name="txtSurName" placeholder="Sur Name" required>

                <label>Email</label>
                <input type="email" name="txtEmail" placeholder="Email" required>

                <label>Address</label>
                <input type="text" name="txtAddress" placeholder="Address" required>

                <label>Phone Number</label>
                <input type="text" name="txtPhoneNo" placeholder="Phone Number" required>

                <label>Password</label>
                <input type="text" name="Password" placeholder="Password" required>

                <label>Confirm Password</label>
                <input type="text" name="ConfirmPassword" placeholder="Confirm Password" required>

<input type="submit" name="btnRegister" value="Register" class="LogInbth">
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
