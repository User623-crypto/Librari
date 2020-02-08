<?php include_once "template/koka.php";?>


<?php 
     
     if(!isset($_SESSION['hyrja']))
     {
         echo "<h2> Ju duhet të logoheni përapa se të shikoni historikun";
         die();
     }
     $id_klienti=$_SESSION['ID'];
     $sql="
     SELECT 

     
     porosi.ID_porosi,
     porosi.DatePorosi,
     rreshtporosi.Seri,
     lib_pershkrim.Titulli,
     rreshtporosi.Sasia
     
     
     FROM 
     
     porosi
     JOIN rreshtporosi ON porosi.ID_porosi=rreshtporosi.ID_porosi
     JOIN lib_pershkrim ON rreshtporosi.Seri=lib_pershkrim.Nr_Seri
     JOIN klienti ON klienti.ID=porosi.ID_Klienti WHERE klienti.ID=$id_klienti
     ";

     $stm=$mysqli->prepare($sql);
    $rezultati=$stm->execute();
    $rezultati=$stm->get_result();
    $stm->close();

    if($rezultati->num_rows<1){
    echo "Ju nuk keni blerë asnjë produkt ende";
    die();
    }



?>
<div style="width: 100%;display:flex;justify-content:center"><h1>Historiku i Blerjeve</h1></div>

<div class="brenda">
        <div class="shporta" style="border-top: none;border-bottom:none;margin-bottom:0px;font-weight:bold;font-size:18px;">
                <div class="pro">NR i Porosisë</div>
                <div class="pro">Data e Porosisë</div>
                <div class="pro">Nr i Serisë</div>
                <div class="pro">Titulli</div>
                <div class="pro">Kopertina</div>
                <div class="pro">Sasia</div>
                
               
            </div>
    
            <?php 
           // for($i=0;$i<count($_SESSION['produktiK']);$i++){
                while($rreshti=$rezultati->fetch_assoc()){
                    # code...
               // }
            ?>
           
            <div class="shporta">
         
         
           <div class="pro" style="display: flex">
            
               <?php echo $rreshti['ID_porosi'] ?>

              
           </div>

           <div class="pro">
               <?php echo $rreshti['DatePorosi'] ?>
           </div>

           <div class="pro">
           <?php echo $rreshti['Seri']; ?>
           </div>

           <div class="pro" >
                    
                    <div ><?php echo $rreshti['Titulli'] ?></div> 
                     
            </div>

           <div class="pro" style="display: flex">
              
               <img style="max-width: 50px;max-height:75px" src="imazhe/<?php echo $rreshti['Titulli'];//echo $_SESSION['produktiK'][$i]['Titulli'];?>.jpg" >
           </div>
           
          
           
           <div class="pro">
           <?php echo $rreshti['Sasia']; ?>
           </div>

          
           
           
            
            </div>
           <?php  }
            ?>
         

            

          

            </div>

          

        </div>

</body>
</html>