<?php 
    require_once "dbconnection.php";
    require_once "model/model.php";
   if(session_status()==PHP_SESSION_NONE)
   session_start();

    
   if(!isset($_SESSION['URI']))
   {
        $_SESSION['URI']="";
        $_SESSION['rifreskim']=0;
       
   }
   

   if($_SESSION['URI']!=$_SERVER['REQUEST_URI'])
   {
    $_SESSION['rifreskim']=0;
  
   }
   else{
    $_SESSION['rifreskim']++;
   
   }
   $_SESSION['URI']=$_SERVER['REQUEST_URI'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style/mystyle.css">
    <link rel="stylesheet" href="style/regjistrim.css">
    <link rel="stylesheet" href="style/shfletim.css">
    <link rel="stylesheet" href="style/kinema.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!--Ikonat thjesht merr ikona nga interneti-->
    <title>Document</title>
</head>
<body>
    <div class="navigim" id="navigimID">
        <div class="djathtas">
            <a href="index.php">Librari Rei</a>
            <a href="rreth.php">Rreth platformës</a>
            <a href="shfletim.php">Shfletimi</a>
        </div>
        
        
        <div class="majtas">
        <a href="shporta.php"><i class="material-icons">shopping_cart</i></a>
           
            <?php if(!isset($_SESSION['hyrja'])){ ?> 
            <a href="#hyr" onclick="forma()">Hyr</a>
            <?php }else{
                echo "<a href='historia.php'>Historia</a>";
                echo "<a href='#hyr'>".$_SESSION['Emri']."</a>";
                echo "<a href='dalja.php'>"."Dil"."</a>";
            } ?>
            <form action="kerko.php" method="get">
            <div class="test" style="display: flex; flex-direction:row;margin-top:8px; margin-right:5px;">
            
            <input type="text" placeholder="Kërko" name="Kerko" style="background: transparent;color:white;border-right:none;">
            <button type="submit" name="buton" style="background: transparent;border-left:none;"><i class="material-icons">search</i></button>
            
            </div>
            </form>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="material-icons">menu</i>
                
            </a>
            
        </div>
        
    </div>
        <div class="forma" id="forma">
            <div class="forma_p">
                <div class="mblidh">
                    <div class="rr_h">
                        <div class="hyr"  onclick="Hyr()">Hyr
                           </div>
                        <div class="rreg"  onclick="Rreg()">Rregjistrohu</div>
                    
                    </div>

                    <div class="r_info" id="rregID">
                        <div class="info">
                            <form action="Rregjistrim.php" method="post"> 

                                <span><i class="material-icons" style="padding: 5px;">person</i><label for=""> Emri</label></span><input type="text" placeholder="Shembull:Arben" required name="përdoruesi">
                                <span><i class="material-icons" style="padding: 5px;">person</i> <label for="">Mbiemri</label></span><input type="text" placeholder="Shembull:Cakaj" required name="mbiemri">
                                <span><i class="material-icons" style="padding: 5px;">email</i><label for=""> Email</label></span><input type="email" placeholder="Shembull:arben.cakaj@outlook.com" required name="email">
                                <span><i class="material-icons" style="padding: 5px;">label</i><label for=""> Adresa</label></span><input type="text" placeholder="Shembull:Lagja 18" required name="adresa">
                                <span><i class="material-icons" style="padding: 5px;">location_city</i><label for=""> Qyteti</label></span><input type="text" placeholder="Shembull:Durrës" required name="qyteti">
                                <span><i class="material-icons" style="padding: 5px;">place</i><label for=""> Shteti</label></span><input type="text" placeholder="Shembull:Shqipëri(AL)" required name="shteti">
                                <span><i class="material-icons" style="padding: 5px;">post_add</i><label for=""> Kodi Postar</label></span><input type="text" placeholder="Shembull:2000" required name="kodi_postar" >
                                <span><i class="material-icons" style="padding: 5px;">vpn_key</i><label for=""> Fjalëkalimi</label></span><input type="password" placeholder="Fjalëkalimi" required name="fjalëkalimi">
                                <span><i class="material-icons" style="padding: 5px;">vpn_key</i><label for=""> Përserit Fjalëkalimi</label></span><input type="password" placeholder="Fjalëkalimi" required name="fjalëkalimi2">
                                <input class="btn" name="regjistrohu" type="submit" value="Rregjistrohu" style="padding: 10px;margin: 8px;font-weight: bold;font-size: 1.112em;">


                            </form>
                          
                        </div>
                    </div>

                    <div class="h_info" id="hyrID">
                        <div class="info">
                            <form action="hyrja.php" method="post">
                            <span><i class="material-icons" style="padding: 5px;">email</i><label for=""> Email</label></span><input type="email" placeholder="Shembull:arben.cakaj@outlook.com" required name="email">
                            <span><i class="material-icons" style="padding: 5px;">vpn_key</i><label for=""> Fjalëkalimi</label></span><input type="password" placeholder="Fjalëkalimi" required name="fjalëkalimi">
                            <input class="btn" type="submit" value="Hyr" style="padding: 10px;margin: 8px;font-weight: bold; font-size: 1.112em;">
                            </form>
                            
                        </div>
                    </div>
                    </div>

                    </div>
                   
            </div>
        </div>
   
        
    <div class="kinema">
    <?php for($i=0;$i<3;$i++){ ?>
    <?php 
        $sql="
        SELECT lib_pershkrim.Titulli FROM lib_pershkrim
        ORDER BY RAND()
            LIMIT 12";

            $stm=$mysqli->prepare($sql);
    $rezultatiK=$stm->execute();
    $rezultatiK=$stm->get_result();
    $stm->close();

    ?>
        <div class="frama" >
        <a class="para" onclick="nderro(-1)"> &lt</a>
            <?php while($rreshti=$rezultatiK->fetch_assoc()){ ?>
               
               <a class="im" href="shfletim.php" ><img style="width:100%;height:100%" src="imazhe/<?php echo $rreshti['Titulli'];?>.jpg"> </a>
            <?php } ?>
            
           
            <a class="pas" onclick="nderro(1)">&gt</a>
        </div>
            <?php } ?>
        

    </div>


    <script src="javascript/script.js"></script>
    <script src="javascript/forma.js"></script>
    <script src="javascript/kinema.js"></script>