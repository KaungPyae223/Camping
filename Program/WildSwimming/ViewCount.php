
<?php
include('Connect.php');

function getUserIp(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}




$ip = getUserIp();
//  echo "<br>$ip<br>";

$query = "SELECT * FROM ipaddress WHERE IP = '$ip'";
$result = mysqli_query($connect,$query);
$num = mysqli_num_rows($result);

if ($num == 0) {
    $InsertIP = "INSERT INTO ipaddress (IP) VALUES ('$ip')";
    mysqli_query($connect, $InsertIP);

    $SelectCounter = "SELECT * FROM counter WHERE ID = 0";
    $result = mysqli_query($connect, $SelectCounter);


}

$select = " Select * from ipaddress";
$query = mysqli_query($connect, $select);
$count = mysqli_num_rows($query);
echo $count;

?>

