<?php

namespace Core\View;

class View
{
    public function render($template, Array $options = [] ){

        foreach($options as $key => $value){
            ${$key} = $value;
        }

        include (project_root ."/templates/" . $template);
    }
}