<?php 
include_once "template/koka.php";
?>

<?php if(isset($_GET['buton']))
{
    $kërkim=$_GET['Kerko'];
    
    $sql="SELECT DISTINCT
    lib_pershkrim.Nr_Seri,
    lib_pershkrim.Titulli,
    lib_pershkrim.Pershkrimi,
    lib_pershkrim.Cmimi,
    lib_pershkrim.Botuesi,
    lib_pershkrim.Nr_faqeve,
    lib_autor.Emri,
    lib_autor.Mbiemri
    
    FROM 
    
    `lib_pershkrim`
    JOIN lib_aut_klas ON lib_aut_klas.Nr_Seri=lib_pershkrim.Nr_Seri
    JOIN lib_autor ON  lib_aut_klas.ID_Autori=lib_autor.ID WHERE lib_pershkrim.Titulli Like '%$kërkim%' OR  lib_pershkrim.Pershkrimi Like '%$kërkim%' OR
    lib_autor.Emri LIKE '%$kërkim%' OR lib_autor.Mbiemri LIKE '%$kërkim%'";

    $stm2=$mysqli->prepare($sql);
    $stm2->execute();
    $rezultati2=$stm2->get_result();
    $stm2->close();  

    if($rezultati2->num_rows!=0)
    {
        echo "<h2>Ju keni ".$rezultati2->num_rows." rezultate</h2>";

    }
    else{
        echo "<h2>Ju nuk keni asnjë rezultat</h2>";
    }
}else{
   die();

}
 ?>

<div class="mbështjell">
  
    <?php while($rreshti=$rezultati2->fetch_assoc()){ ?>
        <form action="produkt.php" method="get">
        <div style="justify-content: center"><h1 style="justify-content: center">Titulli:<?php echo $rreshti['Titulli']." "." Autori: ".$rreshti['Emri']." ".$rreshti['Mbiemri'];?></h1></div>
    <div class="brenda">
    
        <a href=""><img src="imazhe/<?php echo $rreshti['Titulli'];?>.jpg" ></a>
        <div class="pjesa">
            <?php echo Shkurtues::shkurto($rreshti['Pershkrimi']); ?>
            <br>
            <br>
            
           
            <button style="background:transparent;border:none;font-size:18px;color:dodgerblue;cursor:pointer" type="submit" name="lexo" value="<?php echo $rreshti['Nr_Seri'];?>">Lexo më Shumë</button>
        </div>
       
    </div>
    </form>
    <?php } 
    $rezultati2->free_result();
    ?>
    
</div>


<?php 
include_once "template/kemba.php";
?>