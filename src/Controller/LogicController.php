<?php

namespace App\Controller;

use Doctrine\ORM\PersistentCollection;

class LogicController
{

    static public function sortDate(array $array) : array
    {
        for ($i = 0; $i < count($array) - 1; $i++) {
            for ($j = 0; $j < count($array) - $i - 1; $j++) {
                if ($array[$j + 1]['date'] > $array[$j]['date']) {
                    $tmp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array[$j + 1] = $tmp;
                }
            }
        }
        return $array;
    }

}