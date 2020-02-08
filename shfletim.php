<?php 
include_once "template/koka.php";



if(isset($_GET['kateg']))
{
    $kërkim=$_GET['kateg'];

    $sql="SELECT DISTINCT
    
    lib_pershkrim.Nr_Seri,
    lib_pershkrim.Titulli,
    lib_pershkrim.Pershkrimi,
    lib_pershkrim.Cmimi,
    lib_pershkrim.Botuesi,
    lib_pershkrim.Nr_faqeve,
    lib_kat.Kategoria
    FROM 
    
    `lib_pershkrim`
    JOIN lib_klas ON lib_klas.Nr_Seri=lib_pershkrim.Nr_Seri
    JOIN lib_kat ON  lib_kat.ID_Kat=lib_klas.ID_Kat WHERE lib_kat.Kategoria='$kërkim'";

    $stm2=$mysqli->prepare($sql);
    $stm2->execute();
    $rezultati2=$stm2->get_result();
    $stm2->close();  
}else{
    $sql="SELECT * FROM lib_pershkrim";
    $stm2=$mysqli->prepare($sql);
    $stm2->execute();
    $rezultati2=$stm2->get_result();
    $stm2->close();  

}




?>
<h2>Kategoritë</h2>
 <form action="shfletim.php" method="get">
<?php 
    $sql="SELECT DISTINCT

    lib_kat.Kategoria
    FROM 
    
    lib_pershkrim
    JOIN lib_klas ON lib_klas.Nr_Seri=lib_pershkrim.Nr_Seri
    JOIN lib_kat ON  lib_kat.ID_Kat=lib_klas.ID_Kat";

    
        
        $stm=$mysqli->prepare($sql);
        

        if(!$stm->execute())
        {
           echo "Nuk ekzekutohet anketimi";
        }
        $rezultati=$stm->get_result();
        ?> <div class="kategori"> <?php  
        while ($rreshti=$rezultati->fetch_row()) {
            ?>
           
                <button class="kat" type="subimt" name="kateg" value="<?php foreach ($rreshti as $key => $value) {
                    echo $value;?>"><?php echo $value;
                } ?></button>
       
        <?php } 
        $rezultati->free_result();

        $stm->close();
?>
</div>
</form>




<div class="mbështjell">
  
    <?php 
    while($rreshti=$rezultati2->fetch_assoc()){ ?>
    <form action="produkt.php" method="get">
        <div style="justify-content: center"><h1 style="justify-content: center"><?php echo $rreshti['Titulli'];?></h1></div>
    <div class="brenda">
    
        <a href=""><img src="imazhe/<?php echo $rreshti['Titulli'];?>.jpg" ></a>
        <div class="pjesa">
            <?php echo Shkurtues::shkurto($rreshti['Pershkrimi']) ; ?>
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