<?php

/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 26.06.2016
 * Time: 12:59
 */

include_once ("config.php");
include_once ("lib/DataBase.php");
include_once ("vendors/Twig/Autoloader.php");

class Main
{
    private $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    private function getMenu()
    {
        $query = "select * from menu where 1";
        $perform = $this->db->executeQuery($query);
        $result = array();
        while ($row = mysql_fetch_assoc($perform)) {
            $result[] = $row;
        }
        return $result;
    }

    public function render()
    {
        Twig_Autoloader::register();
        try {
            $loader = new Twig_Loader_Filesystem('view');
            // инициализируем Twig
            $twig = new Twig_Environment($loader);
            $template = $twig->loadTemplate('main.html');
            $menu = $this->getMenu();
            echo $template->render(array(
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
