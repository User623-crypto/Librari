<?php 
require_once "dbconnection.php";

include_once "model/model.php";

if(session_status()==PHP_SESSION_NONE)
    session_start();

$përdoruesi=$fjalëkalimi=$fjalëkalimi2=$mbiemri=$email=$adresa=$qyteti=$shteti=$kodi_postar='';
//$p_error=$f_error=$f2_error=$m_error=$e_error=$a_error=$q_error=$sh_error=$k_error='';//Erroret qe do të shfaqen nëse ka.
$error=array('p_error'=>'','f_error'=>'','f2_error'=>'','m_error'=>'','e_error'=>'','a_error'=>'','q_error'=>'','sh_error'=>'','k_error'=>'');

//Shohim nëse metoda e marrë është POST, pra nëse është bërë një kërkesë POST.
if($_SERVER["REQUEST_METHOD"]=="POST"){

    

    //Për Emrin
    if(empty(trim($_POST['përdoruesi'])))//Shohim nëse është futur një emer, funksioni trim heq hapsirat boshe të tepërta nga një String. 
    {
        $error['p_error']="Ju lutemi vendosni emrin.";
    }else{
        $përdoruesi=htmlspecialchars(trim($_POST['përdoruesi']));//htmlspecialchars përdoret për sigurinë
    }
    
     //Për Mbiemrin
     if(empty(trim($_POST['mbiemri'])))
     {
         $error['m_error']="Ju lutemi vendosni mbiemrin.";
     }else{
         $mbiemri=htmlspecialchars(trim($_POST['mbiemri']));
     }
     
       //Për Adresën
       if(empty(trim($_POST['adresa'])))
       {
           $error['a_error']="Ju lutemi vendosni adresën";
       }else{
           $adresa=htmlspecialchars(trim($_POST['adresa']));
       }

       //Për Shtetin
       if(empty(trim($_POST['shteti'])))
       {
           $error['sh_error']="Ju lutemi vendosni emrin e Shtetit";
       }else{
           $shteti=htmlspecialchars(trim($_POST['shteti']));
       }

       //Për Qytetin
       if(empty(trim($_POST['qyteti'])))
       {
           $error['q_error']="Ju lutemi vendosni emrin e qytetit";
       }else{
           $qyteti=htmlspecialchars(trim($_POST['qyteti']));
       }

       //Për Kodin Postar
       if(empty(trim($_POST['kodi_postar'])))
       {
           $error['k_error']="Ju lutemi vendosni kodin postar";
       }else{
           $kodi_postar=htmlspecialchars(trim($_POST['kodi_postar']));
       }

       //Për Fjalëkalimin
       if(empty(trim($_POST['fjalëkalimi'])))
       {
           $error['f_error']="Ju lutemi vendosni fjalëkalimin";
       }else{
           $fjalëkalimi=htmlspecialchars(trim($_POST['fjalëkalimi']));
       }

       //Për përseritjen e fjalëkalimit
       if(empty(trim($_POST['fjalëkalimi2'])))
       {
           $error['f2_error']="Ju lutemi shkruani përsëri fjalëkalimin";
       }else{
           if(htmlspecialchars(trim($_POST['fjalëkalimi2']))===htmlspecialchars(trim($_POST['fjalëkalimi'])))
            $fjalëkalimi2=htmlspecialchars(trim($_POST['fjalëkalimi2']));
            else
                $error['f2_error']="Fjalëkalimi nuk përputhet";
       }

        //Për Emailin
      if(empty(trim($_POST['mbiemri'])))
      {
          $error['e_error']="Ju lutemi vendosni email-in";
      }else{

            $sql="SELECT Email FROM klienti WHERE Email=?";

            if($stm=$mysqli->prepare($sql))
            {
                $stm->bind_param("s",$kontroll_email);
                $kontroll_email=htmlspecialchars(trim($_POST['email']));
                

                if($stm->execute())
                {
                    $stm->store_result();//Ruan rezultatin në vetvete

                    if($stm->num_rows()>=1)//Kthen numrin e rreshtave të rezultatit
                    {
                        $error['e_error']="Ky email-i është i zënë";
                    }else{
                        $email=htmlspecialchars(trim($_POST['email']));

                    }
                }

                $stm->close();
            }else{ echo "Error i përgatitjes";}

           
          
      }
     
      if(Errors::kontrollo($error))//kthen "true" nëse është bosh
      {
          
        $sql2="INSERT INTO klienti(Emri, Mbiemri, Email, Adresa, Qyteti, Shteti, Kodi_Postar, Fjalekalimi) VALUES (?,?,?,?,?,?,?,?)"; //vlera e ? merret me vonë për arsye sigurie;
          
        if($stm=$mysqli->prepare($sql2)) //$mysqli->prepare përgatit kodin sql nuk e kezekuton pret te marri vlerat e ?, për arsye sigurie.
        {
            if(!$stm->bind_param("ssssssss",$përdoruesi,$mbiemri,$email,$adresa,$qyteti,$shteti,$kodi_postar,$fjalëkalimihash))// bind zgjedh vleren që do zevendesoj  me ?  në rend orar.'s' tregon tipin e argumentit
            echo "cant bind param";
            /*$param_adresa=$adresa;$param_email=$email;$param_fjalëkalimi=$fjalëkalimi;
            $param_kodi_postar=$kodi_postar;$param_mbiemri=$mbiemri;$param_përdoruesi=$përdoruesi;
            $param_qyteti=$qyteti;*/
            $fjalëkalimihash=password_hash($fjalëkalimi,PASSWORD_DEFAULT);//Enkripton fjalëkalimin
           
            if(!$stm->execute())//ekzekuton kodin sql me vlerat e sakta
                echo "Nuk mund ta ekzekutonte kodin për arsye të panjohura me shumë mundësi 'email'-i ekziston";
               

               if(!Kontroll::k_session($_SESSION,$mysqli,$email)) die();
               $_SESSION['hyrja']=true;
               

                $stm->close();//Mbyll anketimin.
                header("location:index.php");
        }
        else{echo "Unknown erro";}
      }else{
          foreach ($error as $key => $value) {
              echo $value."<br>";
          }?>
          
          <!DOCTYPE html>
      <html lang="en">
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <meta http-equiv="X-UA-Compatible" content="ie=edge">
          <title>Document</title>
      </head>
      <body>
          <h1>NUK U RREGJISTRUAT KTHEHUNI TEK FAQJA KRYESORE</h1>
          <a href="index.php">Faqja Kryesore</a>
      </body>
      </html>
      <?php  }

    //Për Mbiemrin
    /*if(empty(trim($_POST['mbiemri'])))//Shohim nëse është futur një mbiemri, funksioni trim heq hapsirat boshe të tepërta nga një String. 
    {
        $p_error="Të lutemi vendosni mbiemrin.";
    }else{
        $sql="SELECT ID FROM klienti WHERE Mbiemri=? "; //vlera e ? merret me vonë për arsye sigurie;

        if($stm=$mysqli->prepare($sql)) //$mysqli->prepare përgatit kodin sql nuk e kezekuton pret te marri vlerat e ?, për arsye sigurie.
        {
            $stm->bind_param("s",$përdoruesi_p);// bind zgjedh vleren që do zevendesoj  me ?  në rend orar.'s' tregon tipin e argumentit
            $përdoruesi_p=trim($_POST['përdoruesi']); //funksioni trim masë sigurie se si dihet si ndryshon html

            if(!$stm->execute())//ekzekuton kodin sql me vlerat e sakta
                echo "Nuk mund ta ekzekutonte kodin për arsye të panjohura";
        
                $stm->close();//Mbyll anketimin.
        }

    }*/


 }

  ?>

<?php /*
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Document</title>
  </head>
  <body>
      <form action="Rregjistrim.php" method="post">
      <label for="">Emri</label><input type="text" name="përdoruesi">
      <label for="">Mbiemri</label><input type="text" name="mbiemri">
      <label for="">Email</label><input type="text" name="email">
      <label for="">Shteti</label><input type="text" name="shteti">
      <label for="">Qyteti</label><input type="text" name="qyteti">
      <label for="">Adresa</label><input type="text" name="adresa">
      <label for="">Kodi_Postar</label><input type="text" name="kodi_postar">
      <label for="">Passwordi</label><input type="text" name="fjalëkalimi">
      <label for="">Konfrimo paswordin</label><input type="text" name="fjalëkalimi2">

      <input type="submit" value="submit">
      </form>
  </body>
  </html>*/

  ?>