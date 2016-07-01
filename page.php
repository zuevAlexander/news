<?php

/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 26.06.2016
 * Time: 22:42
 */
include_once("config.php");
include_once("DataBase.php");
include_once("vendors/Twig/Autoloader.php");

class NewsPage
{
    private $db;
    const BUSINESS = 1;
    const IT = 2;
    const SPORT = 3;

    public function __construct()
    {
        $this->db = new DataBase(HOST, USER, PASS, DB_NAME);
    }

    private function getMenu($idMenu)
    {
        $query = "SELECT * FROM `menu` where id='$idMenu'";
        return $this->db->getResult($query);
    }

    private function getNewsForPage()
    {
        if ($id = (int)$_GET['id']) {
            $query = "SELECT * FROM `news` where theme=$id";
        } else {
            $query = "SELECT * FROM `news` where 1 limit 10";
        }
        $perform = $this->db->executeQuery($query);
        $result = array();
        while ($row = mysql_fetch_assoc($perform)) {

            switch ($row['theme']) {
                case self::BUSINESS:
                    $result[self::BUSINESS][] = $row;
                    break;
                case self::SPORT:
                    $result[self::SPORT][] = $row;
                    break;
                case self::IT:
                    $result[self::IT][] = $row;
                    break;
                default:
                    echo 'error';
            }
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
            $template = $twig->loadTemplate('page.html');

            // передаём в шаблон переменные и значения
            // выводим сформированное содержание
            $page = $this->getNewsForPage();
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