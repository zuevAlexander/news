<?php

require_once ('./config.php');
require_once ("./vendor/autoload.php");
class Controller
{
    protected function render($template, $data)
    {
        try {
            $loader = new Twig_Loader_Filesystem(VIEW_FOLDER );
            $twig = new Twig_Environment($loader, array(
                'cache' => CACHE_FOLDER,
            ));

            echo $twig->render($template, $data);


        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}