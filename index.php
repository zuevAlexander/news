<?php

/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 26.06.2016
 * Time: 12:59
 */

//include_once ("vendors/Twig/Autoloader.php");

require_once ("vendor/autoload.php");
include_once ("model/menu.php");

class Main
{
    private function getMenu()
    {
        $menu = new Menu();
        return $menu->getAll();
    }

    public function render()
    {
        try {
            $menu = $this->getMenu();
            $loader = new Twig_Loader_Filesystem('view');
            $twig = new Twig_Environment($loader, array(
                'cache' => 'cache',
            ));

            echo $twig->render('main.html', array(
                'menu' => $menu,
                'title' => 'Home Page'
            ));
        }
        catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}

$main = new Main();
$main->render();