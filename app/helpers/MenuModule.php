<?php
use Phalcon\Tag;

class MenuModule extends Tag {
    static public function initialize($param) {
        $menu = '<ul>';
        foreach($param as $p) {
            $menu .= '<li>' . $p . '</li>';
        }
        $menu .= '</ul>';

        return $menu;
    }
}