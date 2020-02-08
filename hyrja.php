<?php 
require_once "dbconnection.php";
include_once "model/model.php";

if(session_status()==PHP_SESSION_NONE)
    session_start();

if(isset($_SESSION['hyrja'])&& $_SESSION['hyrja']===true)//Shohin nëse 
{
    //header("location:index.php");
    echo 'Ju keni hyrë';
    echo "<a href='dalja.php'>Dilni</a>";
    exit;//mbyll skriptin
}

$email=$fjalëkalim='';
$error=array('e_error'=>'','f_error'=>'');//Deklarojm një vektor  ku do të ruajm gabimet

if($_SERVER['REQUEST_METHOD']=="POST")
{
    if(empty(trim($_POST['email'])))
    {
        $error['e_error']="Ju lutemi shkruani email-in";
    }
    else{
        $email=htmlspecialchars(trim($_POST['email']));
    }

    if(empty(trim($_POST['fjalëkalimi'])))
    {
        $error['f_error']="Ju lutemi shkruani fjalëkalimin";
    }
    else{
        $fjalëkalim=htmlspecialchars(trim($_POST['fjalëkalimi']));
    }


    if(Errors::kontrollo($error))
    {
        $sql="SELECT * FROM klienti WHERE Email=?";

        if($stm=$mysqli->prepare($sql))
        {
            $stm->bind_param("s",$email);
            if($stm->execute())
            {
                   $rezultati=$stm->get_result();//Kthen rezultatin e anketimit
                   
                   if($rezultati->num_rows==1)//Nëse email-i ekziston në databazë
                   {
                        $rreshti=$rezultati->fetch_assoc();//e ruajm rreshtin e parë të rezultatit

                        if(password_verify($fjalëkalim,$rreshti['Fjalekalimi']))
                        {
                            
                            if(!Kontroll::k_session($_SESSION,$mysqli,$email)) die();
                            $_SESSION['hyrja']=true;
                           

                           header("location:index.php");
                           
                        }else{
                            $error['f_error']="Fjalëkalimi i përdorur nuk është i saktë";
                            echo "<h1>Ju nuk mundeni të logoheni emaili ose fjalëkalimi jane gabim</h1> <br>
                            <a href='index.php'>Faqja Kryesore</a> ";
                        }

                        

                   }else{
                       $error['e_error']="Nuk ekzistion ky email";
                       echo "<h1>Ju nuk mundeni të logoheni emaili ose fjalëkalimi jane gabim</h1> <br>
                       <a href='index.php'>Faqja Kryesore</a> ";
                   }
            }else
            {echo "Nuk mundet të ekzekutoj anketimin";}


        }else{
            echo "Nuk mundet të përgatisi kodin sql";
        }
        
    }
    else {
        foreach ($error as $key => $value) {
            echo $value."<br>";
        }
        echo "<h1>Ju nuk mundeni të logoheni emaili ose fjalëkalimi jane gabim</h1> <br>
        <a href='index.php'>Faqja Kryesore</a> ";
    }
}



?>

