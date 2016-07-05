<?php

/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 26.06.2016
 * Time: 22:42
 */
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
            $loader = new Twig_Loader_Filesystem('view');
            $twig = new Twig_Environment($loader);
            $template = $twig->loadTemplate('page.html');
            $page = $this->getNewsByTheme();
            
            $menu = array();
            foreach ($page as $key => $item) {
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

}


$NewsPage = new NewsPage();
$NewsPage->render();