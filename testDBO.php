<?php
include_once ("model/menu.php");



for ($i=5; $i<29; $i++){
    $menu = new Menu();
    $menu = $menu->get($i);
    $menu->delete($i);
}