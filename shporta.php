<?php 
    require_once "dbconnection.php";

    include_once "model/model.php";
    
    if(session_status()==PHP_SESSION_NONE)
        session_start();

        if(isset($_GET['fshij']))
        {
            $fshij=$_GET['fshij'];
            
        
            foreach ($_SESSION['produktiK'] as $çelsi=>$produkt) {
               
                if($produkt['Nr_Seri']==$fshij)
                {
                    
                unset($_SESSION['produktiK'][$çelsi]);
                break;
                }
                
                # code...
            }
        
            unset($_GET['fshij']);
            header("location:shporta.php");
        }
        
        if(isset($_GET['shto']))
        {
            $fshij=$_GET['shto'];
            
        
            foreach ($_SESSION['produktiK'] as $çelsi=>$produkt) {
               
                if($produkt['Nr_Seri']==$fshij)
                {
                    
                $_SESSION['produktiK'][$çelsi]['sasia']++;
                break;
                
                }
             
            }
            unset($_GET['shto']);
            header("location:shporta.php");
        
        }
        
        if(isset($_GET['zbrit']))
        {
            $fshij=$_GET['zbrit'];
            
        
            foreach ($_SESSION['produktiK'] as $çelsi=>$produkt) {
               
                if($produkt['Nr_Seri']==$fshij)
                {  
                $_SESSION['produktiK'][$çelsi]['sasia']--;
                if( $_SESSION['produktiK'][$çelsi]['sasia']<=0)
                unset($_SESSION['produktiK'][$çelsi]);
        
                break;
                }
               
            }
            unset($_GET['zbrit']);
            header("location:shporta.php");
        
        }

    

?>

<?php include_once "template/koka.php" ;?>
<?php 
/*$pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) &&($_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' ||  $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache');*/

if(isset($_GET['pro'])&& $_SESSION['rifreskim']<1)
{
    
   
  


   $kërkim=$_GET['pro'];
    
    $sql="SELECT DISTINCT
    lib_pershkrim.Nr_Seri,
    lib_pershkrim.Titulli,
    lib_pershkrim.Cmimi
   
   
    
    FROM 
    
    `lib_pershkrim` WHERE  lib_pershkrim.Nr_Seri=$kërkim";
    $stm2=$mysqli->prepare($sql);
    $stm2->execute();
    $rezultati2=$stm2->get_result();
    $stm2->close();  
    unset($_GET['pro']);
    $store=$rezultati2->fetch_assoc();
    $store['sasia']=1;
    $kontroll=true;
    if(isset($_SESSION['produktiK'])){
        foreach($_SESSION['produktiK'] as $çelsi=>$produkt)
        {
        
         if($produkt['Titulli']===$store['Titulli'])
            {
                $_SESSION['produktiK'][$çelsi]['sasia']++;
                $kontroll=false;
            }
    
        }
    }else{
        $_SESSION['produktiK'][0]=$store;
        $kontroll=false;
    }
    if($kontroll)
    $_SESSION['produktiK'][]=$store;  
   
    
}



?>

       <?php if(empty($_SESSION['produktiK'])){
       echo "<h2> Ju nuk keni asnjë produkt në shportë </h2>";
       echo " <a href='shfletim.php'>Kërko produkte</a>";
       }else {

       ?>
      
        <div class="brenda">
        <div class="shporta" style="border-top: none;border-bottom:none;margin-bottom:0px;font-weight:bold;font-size:18px;">
                <div class="pro">NR i Serisë</div>
                <div class="pro">Kopertina</div>
                <div class="pro">Titulli</div>
                <div class="pro">Sasia</div>
                <div class="pro">Çmimi</div>
                <div class="pro">Vlera</div>
                <div class="pro">Fshij</div>
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
                    <form action="shporta.php" style="display: flex;flex-direction:row">
                   <div style="margin-top: 10px"><?php echo $produkt['sasia'] ?></div> 
                    <div style="display: flex;flex-direction:column">
                    <button style="margin-top: 0px" type="submit" name="shto" value="<?php echo $produkt['Nr_Seri'] ?>"><i  class="material-icons jeshil" >add</i></button>
                    <button type="submit" name="zbrit" value="<?php echo $produkt['Nr_Seri'] ?>"><i  class="material-icons" >remove</i></button>
                    </div>
              

               </form>
           </div>
           <div class="pro">
           <?php echo $produkt['Cmimi']." L"; ?>
           </div>
           <div class="pro">
           <?php //echo $_SESSION['produktiK'][$i]['Cmimi']*$_SESSION['produktiK'][$i]['sasia']." L" ?>
           <?php echo $produkt['Cmimi']*$produkt['sasia']." L"; ?>
           </div>
            
            <div class="pro">
                <form action="shporta.php" method="get">
                <button type="submit" name="fshij" value="<?php echo $produkt['Nr_Seri'] ?>"><i  class="material-icons " >remove</i></button>
                </form>
           
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
                    $_SESSION['totalK']=$value+$trans;
                    echo $value+$trans." L ";
                    ?>
                </div>
            </div>


            <div class="pagesa">
               <div><form action="pagesa.php" method="get">
                   <button class="pag" type="submit" name="paguaj">Realizo blerjen</button>
               </form></div>
            </div>

            </div>

          

        </div>
                <?php } ?>

</body>
</html>

<?php 



?>