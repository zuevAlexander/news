<?php

/**
 * Created by PhpStorm.
 * User: Александр
 * Date: 26.06.2016
 * Time: 22:42
 */
require_once ("vendor/autoload.php");
include_once("model/menu.php");
include_once ("model/post.php");

class NewsPage
{
    const BUSINESS = 1;
    const IT = 2;
    const SPORT = 3;
    
    private function getMenu($idMenu)
    {
        $menu = new Menu();
        return $menu->getById($idMenu);
    }

    public function groupByTheme()
    {
        $post = new Post();
        $rows = $post->getByTheme();
        $list = array();
        foreach ($rows as $item) {
            switch ($item->getTheme()) {
                case self::BUSINESS:
                    $list[self::BUSINESS][] = $item;
                    break;
                case self::SPORT:
                    $list[self::SPORT][] = $item;
                    break;
                case self::IT:
                    $list[self::IT][] = $item;
                    break;
                default:
                    echo 'error';
            }
        }
        return $list;
    }

    public function render()
    {
        try {
            $loader = new Twig_Loader_Filesystem('view');
            $twig = new Twig_Environment($loader, array(
                'cache' => 'cache',
            ));

            $page = $this->groupByTheme();
            $menu = array();
            foreach ($page as $key => $item) {
                $menu[$key] = $this->getMenu($key);
            }

            echo $twig->render('page.html', array(
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