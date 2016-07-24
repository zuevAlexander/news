<?php


class NewsController
{
    public function __construct()
    {
        $this->index();
    }
 
    public function index()
    {
        echo __CLASS__;
    }
}