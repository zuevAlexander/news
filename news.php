<?php

/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 26.06.2016
 * Time: 19:00
 */
require_once ("vendor/autoload.php");
include_once ("model/post.php");
include_once ("model/menu.php");

class News
{
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
        try {
            $loader = new Twig_Loader_Filesystem('view');
            $twig = new Twig_Environment($loader, array(
                'cache' => 'cache',
            ));

            $news = $this->getNewsForNews();
            $theme = $this->getMenu($news->getTheme());

            echo $twig->render('news.html', array(
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

