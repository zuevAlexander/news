<?php
/**
 * Created by PhpStorm.
 * User: zuev
 * Date: 7/2/16
 * Time: 5:04 PM
 */

include_once ("./lib/DataBase.php");

class Post
{
    const BUSINESS = 1;
    const IT = 2;
    const SPORT = 3;
    private $db;

    private $id;
    private $date;
    private $title;
    private $body;
    private $uri;
    private $theme;
    private $author;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    private function fillPost($row)
    {
        $post = new Post();
        $post->id = $row['id'];
        $post->date = $row['date'];
        $post->title = $row['title'];
        $post->body = $row['body'];
        $post->uri = $row['uri'];
        $post->theme = $row['theme'];
        $post->author = $row['author'];
        return $post;
    }

    public function getById($id)
    {
        $id = mysql_real_escape_string($id);
        $query = mysql_query("select * from news where id = $id");
        $row = mysql_fetch_assoc($query);
        $post = $this->fillPost($row);
        return $post;
    }

    public function getByTheme()
    {
        $query = mysql_query("select * from news where 1");
        $post = array();
        while ($row = mysql_fetch_assoc($query)) {
            $post[] = $this->fillPost($row);
        }
        return $post;
    }

    public function getAll()
    {
        $query = mysql_query("select * from news where 1");
        $post = array();
        while ($row = mysql_fetch_assoc($query)) {
            $post[] = $this->fillPost($row);
        }
        return $post;
    }

    public function save()
    {
        if ($this->id) {
            $request = mysql_query("update news set 'date' = $this->date, 'title' = $this->title, 'body' = $this->body, 'uri' = $this->uri, 'theme' = $this->theme, 'author' = $this->author where id = $this->id");
        }
        else {
            $request = mysql_query("insert into news (date, title, body, uri, theme, author) value ($this->date, $this->title, $this->body, $this->uri, $this->theme, $this->author)");
        }
        return $request;
    }

    public function delete()
    {
        $request = mysql_query("delete from news where id = $this->id");
        return $request;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function getAuthor()
    {
        return $this->author;
    }

}