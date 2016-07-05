<?php

/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 26.06.2016
 * Time: 22:42
 */
include_once("config.php");
include_once("lib/DataBase.php");
include_once("vendors/Twig/Autoloader.php");
include_once("model/menu.php");
include_once ("model/post.php");

class NewsPage
{
    private $db;
    const BUSINESS = 1;
    const IT = 2;
    const SPORT = 3;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    private function getMenu($idMenu)
    {
        $menu = new Menu();
        return $menu->getById($idMenu);
    }
    
    private function getNewsByTheme()
    {
        $post = new Post();
        return $post->getByTheme();
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
            $template = $twig->loadTemplate('page.html');

            // передаём в шаблон переменные и значения
            // выводим сформированное содержание
            $page = $this->getNewsByTheme();
            $menu = array();
            foreach ($page as $key => $item) {
//                array_push($item, $this->getMenu($key));
//
//                $page[$key] = $item;
                $menu[$key] = $this->getMenu($key);
            }
            echo $template->render(array(
                'page' => $page,
                'menu' => $menu
            ));

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

// {
//        foreach ($page as $key => $item) {
//            $theme = $this->getMenu($key);
//            echo "<h1><a href=\"/MyNewProject/page.php?id=$key\" style=\"color: black\">" . $theme['name'] . "</a></h1>";
//            foreach ($item as $v1) {
//                echo "<h3><a href=\"news.php?id=" . $v1['id'] . "\">" . $v1['title'] . "</a></h3>";
//                echo "<small><i>Published by " . $v1['author'] . " on " . $v1['date'] . "</i></small>";
//                echo "<p style=\"align:middle\">" . substr($v1['body'], 0, 350) . "...</p>";
//            }
//        }
//        if ($id = $_GET["id"]) {
//            echo "<h2><a href=\"page.php\" style=\"color: black\">&#8592 Go back to all news list</a></h2>";
//        }
//
//
//    }

}


$NewsPage = new NewsPage();
$NewsPage->render();