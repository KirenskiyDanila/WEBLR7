<?php

namespace App\Controller;

class TemplateController
{
    static public function loadSession() : string
    {
        ob_start();
        if (!isset($_SESSION['name'])) :
            ?>
            <ul class="nav col-10 col-md-auto mb-2 justify-content-between mb-md-0">

                <li><a href="//localhost/WEBLR7/public/archive/1" class="nav-link px-2 link-secondary h4">Архив новостей</a></li>
                <li><a href="//localhost/WEBLR7/public/#" class="nav-link px-2 link-secondary h4 mx-4">Главная страница</a></li>

            </ul>

            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-outline-primary me-2">Login</button>
                <button type="button" class="btn btn-primary">Sign-up</button>
            </div>
            <?php
        else:
            ?>
            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="//localhost/WEBLR7/public/archive/1" class="nav-link px-2 link-secondary h4">Архив новостей</a></li>
                <li><a href="#" class="nav-link px-2 link-secondary h4">Новостной сайт</a></li>
                <li><a href="#" class="nav-link px-2 link-secondary h4">Приветствуем, <?=$_SESSION['name']?></a></li>
            </ul>
            <?php
        endif;
        return ob_get_clean();
    }

}