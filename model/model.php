<?php 

class Errors
{

    /**
     * Kthen nëse një vektor i ka të gjithë elementët bosh ose jo
     * Kthen e "true" nëse është bosh dhe "false" nëse jo
     * @param  $vektori që do knotrolloni
     * 
     */
  public static  function kontrollo($vektor)
  {
      $kuti='';
        foreach ($vektor as $key => $element) {
            $kuti=$kuti.$element;
        }

        if($kuti==='')
        return true;
        else
        return false;
  }  


    public static function kot()
    {
    echo "kot";
    }

}

class Kontroll 
{
    /**
     * Funksion që supozohet të vendosi vlerat e Sesionit kur
     * klienti rregjistrohet ose hyn në sistem
     * KUJDES:FUNKSIONON PER TABELEN KLIENTI
     * @param $array \ kjo duhet të jetë vektori i $sessionit
     * @param $mysqli \  lidhja e databazes në OO
     * @param $email \ email-i pasi është unik
     */
   public static function k_session(& $array,$mysqli,$email) 
   {
        $sql="SELECT * FROM klienti WHERE Email=?";

        $stm=$mysqli->prepare($sql);
        $stm->bind_param("s",$email);


        if(!$stm->execute())
        {
            return false;
        }
        $rezultati=$stm->get_result();

        if($rezultati->num_rows!=1)
        return false;

        $rreshti=$rezultati->fetch_assoc();

        foreach ($rreshti as $çelsi => $vlera) {
            $array[$çelsi]=$vlera;
            # code...
        }
        $stm->close();
        return true;

   }
}


class Shkurtues 
{
    /**
     * Shkurton përshkrimin e librit në një gjatësi të caktuar
     * dhe në fund të fjalisë nëse nuk e ka kaluar minimumin e 
     * fjalëve
     * @param $pershkrim / Duhet të marri përshkrimin e librit
     */
    public static function shkurto(&$përshkrim)
    {
            if(strlen($përshkrim)>=300)
            {
                $përshkrim=substr($përshkrim,0,300);
            }
            while (strlen($përshkrim)>=20 && substr($përshkrim,-1)!=".") {
                $përshkrim=substr($përshkrim,0,strlen($përshkrim)-1);
                # code...
            }
            $përshkrim=$përshkrim . "..";
            return $përshkrim;
    }
}



?>