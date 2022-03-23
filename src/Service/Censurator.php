<?php

namespace App\Service;

class Censurator
{
    public function purify(string $description)
    {
        $grosmot = array("Hitler","Zemmour","lepen","poutine","russie","ukraine","noirs","arabes");
        $censure = str_ireplace($grosmot,"******",$description);


        return $censure;
    }
}
?>
