<?php include_once "template/koka.php" ;?>


<?php if(isset($_GET['lexo']))
{
    $kërkim=$_GET['lexo'];
    
    $sql="SELECT DISTINCT
    lib_pershkrim.Nr_Seri,
    lib_pershkrim.Titulli,
    lib_pershkrim.Pershkrimi,
    lib_pershkrim.Cmimi,
    lib_pershkrim.Botuesi,
    lib_pershkrim.Nr_faqeve
   
    
    FROM 
    
    `lib_pershkrim` WHERE  lib_pershkrim.Nr_Seri=$kërkim";
    $stm2=$mysqli->prepare($sql);
    $stm2->execute();
    $rezultati2=$stm2->get_result();
    $stm2->close();  

    if($rezultati2->num_rows!=0)
    {

    }
    else{
        echo "<h2>Ju nuk keni asnjë rezultat</h2>";
    }


    $sql="  SELECT 

    lib_kat.Kategoria
    FROM 

    `lib_pershkrim`
    JOIN lib_klas ON lib_klas.Nr_Seri=lib_pershkrim.Nr_Seri
    JOIN lib_kat ON  lib_kat.ID_Kat=lib_klas.ID_Kat WHERE lib_pershkrim.Nr_Seri=$kërkim";

    

    $stm2=$mysqli->prepare($sql);
    $stm2->execute();
    $kategori=$stm2->get_result();
    $stm2->close(); 

    $sql="SELECT 

    lib_autor.Emri,
    lib_autor.Mbiemri
    
    FROM 

    `lib_pershkrim`
    JOIN lib_aut_klas ON lib_aut_klas.Nr_Seri=lib_pershkrim.Nr_Seri
    JOIN lib_autor ON  lib_aut_klas.ID_Autori=lib_autor.ID WHERE lib_pershkrim.Nr_Seri=$kërkim";

    

    $stm2=$mysqli->prepare($sql);
    $stm2->execute();
    $autor=$stm2->get_result();
    $stm2->close(); 



}else{
   die();

}
 ?>

<div class="mbështjell">
  
    <?php while($rreshti=$rezultati2->fetch_assoc()){ ?>
        <form action="produkt.php" method="get">
        <div style="justify-content: center"><h1 style="justify-content: center">Titulli:<?php  echo $rreshti['Titulli']." "." Autori: ";
        while ($rresht_a=$autor->fetch_assoc()) {
            echo $rresht_a['Emri']." ".$rresht_a['Mbiemri']. " ";
        }
       
        ?></h1>
        </div>
    <div class="brenda">
    
        <a href=""><img src="imazhe/<?php echo $rreshti['Titulli'];?>.jpg" ></a>
        <div class="pjesa">
        
        <?php 
        echo "Kategoria: ";
        while ($rresht_k=$kategori->fetch_assoc()) {
            foreach ($rresht_k as $key => $value) {
                echo $value. " ";
                
            }
        }
        echo "<br> <br>";
        ?>
            <?php echo $rreshti['Pershkrimi']; ?>
            <br>
            <br>
            
          
            <a class="re" style="position:relative;text-decoration:none;" href="shporta.php?pro=<?php echo $rreshti['Nr_Seri'];?>">Shto produktin në kartë<i class="material-icons">add_shopping_cart</i></a>
            <br>
        </div>
       
       
    </div>
    </form>
    <?php } 
    $rezultati2->free_result();
    ?>
    
</div>


<?php include_once "template/kemba.php" ;?>