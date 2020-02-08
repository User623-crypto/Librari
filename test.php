<?php 

define('DB_SERVER','localhost:3307');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','student');
include_once "model/model.php";




$mysqli=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

if($mysqli===false)
  die("ERROR:Could not connect. ". $mysqli->connect_error());


  $sql="SELECT * FROM test";

  $stm=$mysqli->prepare($sql);

  if(!$stm->execute())
  {
      echo $stm->error;
  }
  $result=$stm->get_result();

  echo $result->num_rows;
  echo "<br>";
  $array[]=$result->fetch_assoc();
  $array[0]['sasia']=0;
  $array[0]['sasia']++;
  print_r($array);
  echo "<br>";
  print_r($array[0]['sasia']);
  echo "<br>";
  while ($row=$result->fetch_assoc()) {
    /*echo $row['Username']." ". $row['email'];*/
    foreach ($row as $key => $value) {
        echo $value." ".$key."////";
        # code...
    }
    echo "<br>";
      # code...
  }
  /*$var=['uno'=>"",'duo'=>"",'tre'=>""];
  $varw=[0,0,0];*/
  
 // echo Errors::kontrollo($var);
 echo  password_hash("Dyrrah",PASSWORD_DEFAULT);
 //$2y$10$p67cLTtVfiYqm88bdFfnV.yWJfUplReOANQZK./FBF9m31nyBFsT6
 echo "<br>";
  $x="uno para shume viteve. kishte shume kohe. sepese nuek duke. dhe pastaj ajo eshte. keshtu qe ishte.kot me kot.";
if(substr($x,-1)===".")
  echo $x;


echo "<br>";

Shkurtues::shkurto($x);
echo $x;



?>
<?php 
if(isset($_GET['lexo'])){
if($_GET['lexo']==1)
  echo "sukses";
}
?>
<a href="test.php?lexo=1">uno</a>
<br>
<?php 
echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
echo "<br>";
echo basename($_SERVER['REQUEST_URI']);
echo "<br>";
echo $_SERVER['REQUEST_URI'];

?>