<?php

namespace App\Controller;

use App\Entity\News;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Persistence\ManagerRegistry;

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

    static public function formData(array $news) : array
    {
        $data = array();
        for ($i = 0; $i < count($news); $i++) {
            $comments = $news[$i]->getComments();
            $data[$i]['name'] = $news[$i]->getName();
            $data[$i]['annotation'] = $news[$i]->getAnnotation();
            $data[$i]['date'] = $news[$i]->getDate();
            $data[$i]['commentCount'] = count($comments);
            $data[$i]['id'] = $news[$i]->getId();
        }

        return LogicController::sortDate($data);
    }

    static public function formPagination(int $page, ManagerRegistry $doctrine) : array
    {
        $count = $doctrine->getRepository(News::class)->getCount();

        $k = $page;
        $j = $page;
        while (($j - $k) < 10) {
            $end_while = true;
            if ($k > 1) {
                $k --;
                $end_while = false;
            }
            if (($j * 10) <= $count) {
                $j++;
                $end_while = false;
            }
            if ($end_while) {
                break;
            }
        }

        $pages = array();
        for ($i = $k; $i <= $j; $i++) {
            $pages[] = $i;
        }

        return $pages;

    }

}