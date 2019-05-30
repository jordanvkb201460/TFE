<?php

namespace App\Service;

class RandomString 
{
    public static function Generate($length=20)
    {
        $characters = "azertyuiopqsdfghjklmwxcvbn1234567890AZERTYUIOPQSDFGHJKLMWXCVBN";
        $characterLength = strlen($characters);
        $randomString = "";
        for($i = 0; $i<$length;$i++)
        {
            $randomString .= $characters[mt_rand(0,$characterLength-1)];
        }
        return $randomString;
    }
}