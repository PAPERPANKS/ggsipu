<?php 
//connection with database
$host = 'localhost';
$user = 'root';
$password = '';
$db = 'database1';

try{
    $DBH = new pdo("mysql:host=$host;dbname=$db",$user,$password);    
}catch(PDOException $e){
    echo "Not Connected...".$e->getMessage();
}

//get IP_ADDR
$ip_address = $_SERVER['REMOTE_ADDR'];
//check if this ip_address exist in our DB
$sql = "SELECT ip_address from visitors WHERE ip_address='$ip_address'";
$Check = $DBH->prepare($sql);
$Check->execute();
$CheckIp = $Check->rowCount();
if ($CheckIp == 0) {
    $query="INSERT INTO visitors(id, ip_address) VALUES(NULL, '$ip_address')";
    $insertIp=$DBH->prepare($query);
    $insertIp->execute();
}
$number = $DBH->prepare("SELECT ip_address FROM visitors");
$number->execute();
$visitor = $number->rowCount();


$sql1 = "SELECT monthly from visitors_count WHERE 1";
$Check1 = $DBH->prepare($sql1);
$monthly_count = $Check1->execute();
// = $Check1;
$sql2 = "SELECT total from visitors_count WHERE 1";
$Check2 = $DBH->prepare($sql2);
$Check2->execute();
$total_count = 5;//$Check2;

?>
<span>
<?php
echo $visitor;
?>
<br>
<?php
echo $monthly_count, $total_count;
?>
</br>
</span>