<?php 
    require_once "dbconnection.php";

    include_once "model/model.php";
    
    if(session_status()==PHP_SESSION_NONE)
        session_start();

    if(!isset($_SESSION['hyrja']))
    {
        echo "<a href='index.php'>Ju duhet të logoheni që të kryeni blerjen</a>";
        die();
    }

    if(isset($_POST['blerja'])&& isset($_POST['add']))
    {
        $_SESSION['adresa']=$_POST['add'];
        $data=date("y,m,d");
        $id_klienti=$_SESSION['ID'];
        $sql="INSERT INTO `porosi`( `ID_Klienti`, `DatePorosi`) VALUES ('$id_klienti','$data')";
        $stm=$mysqli->prepare($sql);
        $stm->execute();

        $id_porosi=$stm->insert_id;
        $stm->close();
        foreach ($_SESSION['produktiK'] as $çels => $produkt) {
            $seri=$produkt['Nr_Seri'];
            $sasi=$produkt['sasia'];
            $çmimi=$produkt['Cmimi'];
            $sql="INSERT INTO `rreshtporosi`(`ID_porosi`, `Seri`, `Sasia`, `Cmimi`) VALUES ('$id_porosi','$seri','$sasi','$çmimi')";
            # code...
            $stm=$mysqli->prepare($sql);
            $stm->execute();
            $stm->close();
        }
        unset($_SESSION['produktiK']);
        
        $_SESSION['raport']=$id_porosi;
        header("location:raport.php");

    }

?>
<?php include_once "template/koka.php";?>

       <div class="brenda">
        <div class="shporta" style="border-top: none;border-bottom:none;margin-bottom:0px;font-weight:bold;font-size:18px;">
                <div class="pro">NR i Serisë</div>
                <div class="pro">Kopertina</div>
                <div class="pro">Titulli</div>
                <div class="pro">Sasia</div>
                <div class="pro">Çmimi</div>
                <div class="pro">Vlera</div>
               
            </div>
    
            <?php 
           // for($i=0;$i<count($_SESSION['produktiK']);$i++){
                foreach ($_SESSION['produktiK'] as $produkt) {
                    # code...
               // }
            ?>
           
            <div class="shporta">
         
         
           <div class="pro" style="display: flex">
            
               <?php echo $produkt['Nr_Seri'] ?>

              
           </div>
           <div class="pro" style="display: flex">
              
               <img style="max-width: 50px;max-height:75px" src="imazhe/<?php echo $produkt['Titulli'];//echo $_SESSION['produktiK'][$i]['Titulli'];?>.jpg" >
           </div>
           <div class="pro">
               <?php echo $produkt['Titulli'] ?>
           </div>
           <div class="pro" >
                    
                   <div style="margin-top: 10px"><?php echo $produkt['sasia'] ?></div> 
                    
           </div>
           <div class="pro">
           <?php echo $produkt['Cmimi']." L"; ?>
           </div>
           <div class="pro">
           <?php //echo $_SESSION['produktiK'][$i]['Cmimi']*$_SESSION['produktiK'][$i]['sasia']." L" ?>
           <?php echo $produkt['Cmimi']*$produkt['sasia']." L"; ?>
           </div>
            
            </div>
           <?php  }
            ?>
            <div class="totali">
               
               <div style="justify-content:flex-end;margin-right:5px">Transporti: </div>
               <div>
                   <?php 
                   
                   if(isset($_SESSION['produktiK']))
                   {
                    $trans=50;
                    $sasia=0;

                    foreach ($_SESSION['produktiK'] as $çels => $produkt) {
                        $sasia+=$produkt['sasia'];
                    }

                    $trans+=($sasia-1)*30;
                    $_SESSION['trans']=$trans;
                    echo $trans. " L";
                   }
                   ?>
               </div>
           </div>
            <div class="totali">
               
                <div style="justify-content:flex-end;margin-right:5px">Totali: </div>
                <div>
                    <?php $value=0;
                   
                    foreach ($_SESSION['produktiK'] as $çels => $produkt) {
                        $value+=$produkt['Cmimi']*$produkt['sasia'];
                    }
                    $_SESSION['total']=$value+$trans;
                    echo $value+$trans." L ";
                    ?>
                </div>
            </div>

            <div class="pagesa" style="justify-content: flex-start">
            <form action="pagesa.php" method="post">
                <label for="">Adresa: </label> <input type="text" name="add" required>
        
            </div>

            <div class="pagesa">
               <div>
                   <button class="pag" type="submit" name="blerja">Konfirmo blerjen</button>
               </form></div>
            </div>


            </div>

          

        </div>

</body>
</html>
