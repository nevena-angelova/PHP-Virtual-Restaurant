<?php
include 'models/image.php';
include 'models/paging.php';
include 'models/recipe/recipe.php';
include 'models/recipe/recipes.php';

class RecipeController
{
    public function add()
    {
        if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true) {
            $recipe = new Recipe();
            $recipe->setAction('add');
            if ($_POST) {
                $recipe_id = $recipe->insertRecipe();
                if ($recipe_id != NULL) {
                    header('Location: ?c=recipe&a=view&id=' . $recipe_id);
                }
            }
            ViewRenderer::render('views/pages/recipe/form.php', $recipe);
        } else {
            trigger_error('Not authorized!', E_USER_ERROR);
        }
    }

    public function edit()
    {
        if (isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true) {
            $recipe = new Recipe();
            $recipe->setAction('edit');

            if (isset($_GET['id'])) {
                $recipe->getRecipeData();
            }

            if ($_POST) {
                $recipe_id = $recipe->editRecipe();
                if ($recipe_id != NULL) {
                    header('Location: ?c=recipe&a=view&id=' . $recipe_id);
                }
            }

            ViewRenderer::render('views/pages/recipe/form.php', $recipe);
        } else {
            trigger_error('Not authorized!', E_USER_ERROR);
        }
    }

    public function view()
    {
        if (isset($_GET['id'])) {
            $recipe = new Recipe();
            $recipe->getRecipeData();
            ViewRenderer::render('views/pages/recipe/view.php', $recipe);
        } else {
            trigger_error('Wrong request!', E_USER_ERROR);
        }
    }

    public function all()
    {
        $recipes = new Recipes();
        $recipes->setRecipes();
        ViewRenderer::render('views/pages/recipe/list.php', $recipes);
    }

}