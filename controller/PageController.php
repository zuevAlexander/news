<?php

require_once('Controller.php');
require_once('./model/post.php');
require_once('./model/menu.php');

class PageController extends Controller
{
    const BUSINESS = 1;
    const IT = 2;
    const SPORT = 3;

    public function __construct()
    {
 
    }

    public function index($id = null)
    {
        $data = array(
            'menu' => $this->getMenu($id),
            'page' => $this->getGroupedByTheme($id)
            );
        $this->render('page.html', $data);
    }

    public function indexRestStyle($id = null)
    {
        $data = array(
            'menu' => 'small menu',
            'page' => 'oloshen'
        );
        echo json_encode($data);
    }

    public function addComment($id)
    {
        echo " addComment() " . $id;
    }


    
    private function getMenu($menuId = null)
    {
        $menu = new Menu();
        return $menuId == null ? $menu->getAll() : $menu->getById($menuId);
    }


    private function getGroupedByTheme($themeId = null)
    {
        $post = new Post();
        if ($themeId != null) {
            $rows = $post->getByTheme($themeId);
        } else {
            $rows = $post->getAll();
        }
        $list = $this->groupByTheme($rows);
        return $list;
    }
    
    private function groupByTheme($rows)
    {
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


}