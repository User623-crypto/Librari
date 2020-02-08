<?php
        define('DB_SERVER','localhost:3307');
        define('DB_USERNAME','root');
        define('DB_PASSWORD','');
        define('DB_NAME','librari');
        
        
        $mysqli=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);
        
        if($mysqli===false)
          die("ERROR:Could not connect. ". $mysqli->connect_error());
        


?>