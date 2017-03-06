<?php
include 'models/image.php';
include 'models/recipe/recipes.php';

class HomeController
{
    public function index()
    {
        $recipes = new Recipes();
        $recipes->setNRecipes(8);
        ViewRenderer::render('views/pages/home.php', $recipes );
    }

    public function error()
    {
        ViewRenderer::render('views/pages/error.php');
    }

}
