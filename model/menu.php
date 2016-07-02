<?php
/**
 * Created by PhpStorm.
 * User: zuev
 * Date: 7/2/16
 * Time: 5:04 PM
 */

include_once("./lib/DataBase.php");



class Menu
{

    private $id;
    private $name;
    private $uri;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    public function get ($id)
    {
        $id = mysql_real_escape_string($id);
        $query = mysql_query("select * from menu where id = $id");
        $result = mysql_fetch_assoc($query);
        $id = $result['id'];
        $name  = $result['name'];
        $uri  = $result['uri'];
        $menu = new Menu();

        $menu->setId($id);
        $menu->setName($name);
        $menu->setUri($uri);

        return $menu;
    }

    public function  save ()
    {

        if($this->id) {
            $request  = "update menu set 'name' = $this->name, 'uri' = $this->uri where id  = $this->id";
        }
        
        else{
            $request = "insert into menu (name,uri) values ($this->name, $this->uri)";
        }

        return mysql_query($request);

    }

    public function delete ()
    {
        $query = "delete from menu where id = $this->id";
        return mysql_query($query);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }



}