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
    private $id;
    private $date;
    private $title;
    private $body;
    private $uri;
    private $theme;
    private $author;
    private $db;
    const BUSINESS = 1;
    const IT = 2;
    const SPORT = 3;
    
    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    private function fillPost($row)
    {
        $post = new Post();
        $post->setId($row['id']);
        $post->setDate($row['date']);
        $post->setTitle($row['title']);
        $post->setBody($row['body']);
        $post->setUri($row['uri']);
        $post->setTheme($row['theme']);
        $post->setAuthor($row['author']);
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
        if ($id = (int)$_GET['id']) {
            $query = "SELECT * FROM `news` where theme=$id";
        } 
        else {
            $query = "SELECT * FROM `news` where 1 limit 10";
        }
        
        $perform = mysql_query($query);
        $post = array();
        
        while ($row = mysql_fetch_assoc($perform)) {
            switch ($row['theme']) {
                case self::BUSINESS:
                    $post[self::BUSINESS][] = $row;
                    break;
                case self::SPORT:
                    $post[self::SPORT][] = $row;
                    break;
                case self::IT:
                    $post[self::IT][] = $row;
                    break;
                default:
                    echo 'error';
            }
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
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

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param mixed $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }


}