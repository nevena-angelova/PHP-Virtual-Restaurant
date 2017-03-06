<?php
include 'models/image.php';
include 'models/recipe/recipes.php';

class RecipeController
{
    public function usersAll()
    {
        $recipes = new Recipes();
        $recipes->setUserRecipes();

        if (count($recipes) > 0) {
            ViewRenderer::render('views/inc/recipes.php', $recipes);
            //echo json_encode($recipes);
        } else {
            echo 'Няма добавени рецепти.';
        }
    }
}