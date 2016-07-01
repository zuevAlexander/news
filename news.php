<?php

/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 26.06.2016
 * Time: 19:00
 */
include_once("config.php");
include_once("DataBase.php");
include_once("vendors/Twig/Autoloader.php");

class News
{
    private $db;

    public function __construct()
    {
        $this->db = new DataBase(HOST, USER, PASS, DB_NAME); //composition
    }

    private function getMenu($idMenu)
    {
        $query = "SELECT * FROM `menu` where id='$idMenu'";
        $result = $this->db->getResult($query);
        return $result;
    }

    private function getNewsForNews()
    {
        $id = (int)$_GET["id"];
        $query = "SELECT * FROM `news` where id = $id";
        $result = $this->db->getResult($query);
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
            $template = $twig->loadTemplate('news.html');

            // передаём в шаблон переменные и значения
            // выводим сформированное содержание
            $news = $this->getNewsForNews();
            $theme = $this->getMenu($news['theme']);
            echo $template->render(array(
                'id' => $news['theme'],
                'title' => $news['title'],
                'body' => $news['body'],
                'author' => $news['author'],
                'date' => $news['date'],
                'theme' => $theme['name']
            ));

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}

$news = new News();
$news->render();
