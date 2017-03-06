<?php

class ViewRenderer
{
    //creates a scope for each view
    public static function render($name, $model = null)
    {
        include $name;
    }
}