<?php

class Recipes
{
    private $categories;
    private $recipes;
    private $filter;
    private $paging;

    public function getCategories()
    {
        if (!isset($this->categories)) {
            $this->categories = array();
            $db = DB::getInstance()->getConnection();
            $get_categories_query = mysqli_query($db, 'SELECT * FROM categories');

            if (mysqli_error($db)) {
                trigger_error(mysqli_error($db), E_USER_ERROR);
            }

            while ($row = mysqli_fetch_assoc($get_categories_query)) {
                $this->categories[$row['id']] = $row['name'];
            }
        }

        return $this->categories;
    }

    public function getRecipes()
    {
        return $this->recipes;
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function getPaging()
    {
        return $this->paging;
    }

    private function setRecipeItems($db, $sql)
    {
        $get_recipes_query = mysqli_query($db, $sql);
        if (mysqli_error($db)) {
            trigger_error(mysqli_error($db), E_USER_ERROR);
        }

        $this->recipes = array();
        while ($row = mysqli_fetch_assoc($get_recipes_query)) {
            $recipe = array();
            $recipe['id'] = $row['recipe_id'];
            $recipe['title'] = $row['title'];
            if (!empty($row['image'])) {
                $recipe['image'] = new Image('recipes', $row['image'], $row['user_name']);
            }
            $recipe['create_date'] = $row['create_date'];
            $recipe['user_name'] = $row['user_name'];
            $recipe['user_id'] = $row['user_id'];
            $recipe['category_name'] = $row['category_name'];
            $this->recipes[] = $recipe;
        }
    }

    public function setRecipes()
    {
        $db = DB::getInstance()->getConnection();

        $this->filter = array();
        $this->filter['word'] = isset($_POST['word']) ? trim($_POST['word']) :
            (isset($_GET['word']) ? $_GET['word'] :'');

        $word_esc = mysqli_real_escape_string($db, $this->filter['word']);

        $this->filter['category'] = !empty($_POST['category']) ? trim($_POST['category']) :
            (!empty($_GET['category']) ? $_GET['category'] :'');

        $category_esc = '%%';
        if (!empty($this->filter['category'])) {
            $category_esc = mysqli_real_escape_string($db, $this->filter['category']);
        }

        $this->paging = new Paging(8);

        if (!isset($_GET['pages'])) {
            $count_sql = 'SELECT COUNT(*) as count
                FROM recipes
                LEFT JOIN categories
                ON recipes.category_id = categories.id
                WHERE(
                (recipes.title LIKE "%' . $word_esc . '%"
                OR recipes.description LIKE "%' . $word_esc . '%"
                OR recipes.ingredients LIKE "%' . $word_esc . '%")
                AND categories.id LIKE "' . $category_esc . '")';

            $get_count_query = mysqli_query($db, $count_sql);
            if (mysqli_error($db)) {
                trigger_error(mysqli_error($db), E_USER_ERROR);
            }

            $result = mysqli_fetch_assoc($get_count_query);

            $this->paging->calcPages($result['count']);
        } else {
            $this->paging->setPages($_GET['pages']);
        }

        $sql = 'SELECT recipes.id as recipe_id, recipes.title, recipes.image,
                recipes.create_date, users.user_name, users.id as user_id, categories.name as category_name
                FROM recipes
                LEFT JOIN users
                ON recipes.user_id = users.id
                LEFT JOIN categories
                ON recipes.category_id = categories.id
                WHERE(
                (recipes.title LIKE "%' . $word_esc . '%"
                OR recipes.description LIKE "%' . $word_esc . '%"
                OR recipes.ingredients LIKE "%' . $word_esc . '%")
                AND categories.id LIKE "' . $category_esc . '")
                ORDER BY recipes.create_date DESC
                LIMIT ' . $this->paging->getN() . ' OFFSET ' . $this->paging->getOffset();

        $this->setRecipeItems($db, $sql);
    }

    public function setUserRecipes()
    {
        $db = DB::getInstance()->getConnection();
        $id_esc = mysqli_real_escape_string($db, $_GET['id']);
        $sql = 'SELECT recipes . id as recipe_id, recipes . title, recipes . image,
                recipes . create_date, users . user_name, users . id as user_id, categories . name as category_name
                FROM recipes
                LEFT JOIN users
                ON recipes . user_id = users . id
                LEFT JOIN categories
                ON recipes . category_id = categories . id
                WHERE users . id = ' . $id_esc . '
                ORDER BY recipes . create_date DESC';

        $this->setRecipeItems($db, $sql);
    }

    public function setNRecipes($n)
    {
        $db = DB::getInstance()->getConnection();
        $sql = 'SELECT recipes . id as recipe_id, recipes . title, recipes . image,
                recipes . create_date, users . user_name, users . id as user_id, categories . name as category_name
                FROM recipes
                LEFT JOIN users
                ON recipes . user_id = users . id
                LEFT JOIN categories
                ON recipes . category_id = categories . id
                ORDER BY recipes . create_date DESC
                LIMIT ' . $n;

        $this->setRecipeItems($db, $sql);
    }
}