<?php

/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 26.06.2016
 * Time: 19:00
 */
include_once("vendors/Twig/Autoloader.php");
include_once ("model/post.php");
include_once ("model/menu.php");

class News
{
    private $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance(); //composition
    }

    private function getMenu($idMenu)
    {
        $menu = new Menu();
        return $menu->getById($idMenu);
    }

    private function getNewsForNews()
    {
        $post = new Post();
        $id = (int)$_GET["id"];
        return $post->getById($id);
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
            $theme = $this->getMenu($news->getTheme());
            echo $template->render(array(
/*                '$news' => $news['theme'],
                'title' => $news['title'],
                'body' => $news['body'],
                'author' => $news['author'],
                'date' => $news['date']*/
                'news' => $news,
                'theme' => $theme
            ));

        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}

$news = new News();
$news->render();

