<?php

namespace Core\View;

// Use this View as starting point, if you dont like to use Twig or any other template framework
class View
{

    public function render($template, Array $options = [] ){

        foreach($options as $key => $value){
            ${$key} = $value;
        }
        include (project_root ."/templates/" . $template);
    }
}