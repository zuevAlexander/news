<?php
/**
 * Created by PhpStorm.
 * User: zuev
 * Date: 7/2/16
 * Time: 5:04 PM
 */

include_once ("./lib/DataBase.php");


class Menu
{

    private $db;
    
    private $id;
    private $name;
    private $uri;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    public function getById($id)
    {
        $id = mysql_real_escape_string($id);
        $query = mysql_query("select * from menu where id = $id");
        $row = mysql_fetch_assoc($query);
        $menu = $this->fillMenu($row);

        return $menu;
    }

    private function fillMenu($row) {
        $menu = new Menu();
        $menu->id = $row['id'];
        $menu->name = $row['name'];
        $menu->uri = $row['uri'];

        return $menu;
    }

    public function getAll()
    {
        $query = mysql_query("SELECT * FROM `menu` where 1");
        $menu = array();
        while ($row = mysql_fetch_assoc($query)) {
            $menu[] = $this->fillMenu($row);
        }

        return $menu;
    }

    public function save()
    {
        if ($this->id) {
            $request = "update menu set 'name' = $this->name, 'uri' = $this->uri where id  = $this->id";
        } else {
            $request = "insert into menu (name,uri) values ($this->name, $this->uri)";
        }

        return mysql_query($request);

    }

    public function delete()
    {
        $query = "delete from menu where id = $this->id";
        return mysql_query($query);
    }
    
    public function __set($fieldName, $value) {
        $this->$fieldName = $value;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUri()
    {
        return $this->uri;
    }

}