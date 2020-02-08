<?php 
//require_once "dbconnection.php";


$stm="CREATE TABLE IF NOT EXISTS klienti (
    ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    Emri VARCHAR(20) NOT NULL,
    Mbiemri VARCHAR(20) NOT NULL,
    Email VARCHAR(50) NOT NULL,
    Adresa VARCHAR(25) NOT NULL,
    Qyteti VARCHAR(30) NOT NULL,
    Shteti VARCHAR(2) NOT NULL,
    Kodi_Postar VARCHAR(5) NOT NULL,
    PRIMARY KEY (ID)
)";

if(!$mysqli->query($stm))
   echo "Error";


?>