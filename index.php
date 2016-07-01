<?php

/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 26.06.2016
 * Time: 12:59
 */

include_once("config.php");
include_once("DataBase.php");
include_once("vendors/Twig/Autoloader.php");

class Main
{
    private $db;

    public function __construct()
    {
        $this->db = new DataBase(HOST, USER, PASS, DB_NAME);
    }

    private function getMenu()
    {
        $query = "SELECT * FROM `menu` where 1";
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
            // указывае где хранятся шаблоны
            $loader = new Twig_Loader_Filesystem('view');

            // инициализируем Twig
            $twig = new Twig_Environment($loader);

            // подгружаем шаблон
            $template = $twig->loadTemplate('main.html');

            // передаём в шаблон переменные и значения
            // выводим сформированное содержание
            $menu = $this->getMenu();
            echo $template->render(array(
                'menu' => $menu,
                'title' => 'Home Page'
            ));

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

}

$main = new Main();
$main->render();
