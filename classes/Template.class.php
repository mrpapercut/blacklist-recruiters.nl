<?php

class Template {

    public function getTemplate($template, $content = null) {
        if (!file_exists('templates/'.$template.'.php')) {
            echo 'templates/'.$template.'.php not found';
        } else {
            include_once('templates/'.$template.'.php');
        }
    }

    public function get404() {
        include_once('templates/404.php');
    }
}
