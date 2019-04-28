<?php

namespace App\Service;

class RandomString 
{
    public static function Generate($nom,$prenom, $length=20)
    {
        $characters = "azertyuiopqsdfghjklmwxcvbn1234567890AZERTYUIOPQSDFGHJKLMWXCVBN";
        $characterLength = strlen($characters);
        $randomString = "";
        for($i = 0; $i<$length;$i++)
        {
            $randomString .= $characters[mt_rand(0,$characterLength-1)];
        }
        //probleme pour personne ayant le meme nom et prenom
        $randomString .= strval($nom);
        $randomString .= strval($prenom);
        return $randomString;
    }
}