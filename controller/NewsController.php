<?php

require_once('Controller.php');
require_once('./model/post.php');
require_once('./model/menu.php');

class NewsController extends Controller
{
    public function __construct()
    {
        
    }

    public function index($id)
    {
        $data = array(
            'menu' => $this->getMenu($id),
            'news' => $this->getNews($id)
        );
        $this->render('news.html', $data);
    }

    private function getMenu($menuId = null)
    {
        $menu = new Menu();
        return $menuId = null ? $menu->getAll() : $menu->getById($menuId);
    }

    private function getNews($newsId)
    {
        if(!$newsId) {
            throw new Exception('Error news');
        }
        else {
        $post = new Post();
        return $post->getById($newsId);
        }
    }
}