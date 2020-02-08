<?php include_once "template/koka.php";?>


<?php 
     $id_porosi=$_SESSION['raport'];
     
     $sql="
     SELECT 
     
     SUM(rreshtporosi.Cmimi) AS 'Cmimi',
     SUM(rreshtporosi.Sasia) AS 'Shuma'
     
     FROM 
     
     porosi
     JOIN rreshtporosi ON porosi.ID_porosi=rreshtporosi.ID_porosi  WHERE porosi.ID_porosi=$id_porosi
     ";

     $stm=$mysqli->prepare($sql);
    $rezultati=$stm->execute();
    $rezultati=$stm->get_result();
    $rreshti=$rezultati->fetch_assoc();
    $stm->close();



?>
<div>
    <h1>Blerja u krye me sukses</h1>
</div>
<div>

    <h3>Ju keni blerë <?php echo $rreshti['Shuma'] ?> produkte dhe Totali që keni paguar është <?php echo $_SESSION['totalK'] ?> lekë</h3>

</div>
<div>
    <h3>Produktet do të dërgohen në <?php echo $_SESSION['adresa'] ?></h3>
</div>

 <a href="historia.php">Shikoni historine e blerjes</a>



</body>
</html>