<?php
session_start();
include ("Connect.php");
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
<body>

<article>
    <h1 class="text-center">Review of GWSC Website</h1>
    <div class="ReviewContainer d-flex">

        <?php
        $select = "SELECT S.*,C.FirstName,C.SurName FROM sitereview S,customers C where S.CustomerID = C.CustomerID";
        $query = mysqli_query($connect, $select);
        $count = mysqli_num_rows($query);
        if ($count == 0) {
            echo "<h2>No records</h2>";
        } else {
            for ($i = 0; $i < $count; $i++) {
                $row = mysqli_fetch_array($query);
                $FirstName = $row["FirstName"];
                $SurName = $row["SurName"];
                $Review = $row["Review"];
                $Rating = $row["Rating"];
                $Date = $row["Date"];
                echo "
                <div class='ReviewCard'>
                <h2>$FirstName $SurName</h2>
                <p class='text-small'>$Date</p>
                <p class='Text'>$Review</p>
                <div class='StarContainer d-flex'>
            ";
                for($s = 1;$s <= 5;$s++){
                    if($s<=$Rating){
                        echo "<i class='fa-solid fa-star'></i>";
                    }
                    else{
                        echo "<i class='fa-regular fa-star'></i>";
                    }
                }
                echo "
            </div>
        </div>
    </div>
            ";
            }
        }
        ?>




</article>
</body>
</html>
