<?php

class Recipe
{
    protected $id;
    protected $title;
    protected $image;
    protected $create_date;
    protected $user;
    protected $user_id;
    protected $user_img;
    protected $category;
    private $categories;
    protected $ingredients;
    protected $description;
    protected $action;
    protected $validation_errors = array();
    protected $validation_rules = array(
        'title_len' => array('min' => 3, 'max' => 100, 'msg' => 'Невалидно заглавие (задължитено поле, от 3 до 100 символа).'),
        'ingredients_len' => array('min' => 10, 'max' => 1000, 'msg' => 'Грешка в "Необходими съставки" (задължитено поле, от 3 до 3000 символа).'),
        'description_len' => array('min' => 10, 'max' => 3000, 'msg' => 'Грешка в "Начин на приготвяне" (задължитено поле, от 3 до 3000 символа).'),
        'category' => array('msg' => 'Невалидна категория.'),
    );

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $title_trimmed = trim($title);
        if (mb_strlen($title_trimmed) >= $this->validation_rules['title_len']['min']
            && mb_strlen($title_trimmed) <= $this->validation_rules['title_len']['max']
        ) {
            $this->title = $title_trimmed;
        } else {
            $this->validation_errors['title'] = $this->validation_rules['title_len']['msg'];
        }
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getCreateDate()
    {
        return $this->create_date;
    }

    public function setCreateDate()
    {
        $format = 'Y-m-d H:i:s';
        date_default_timezone_set("Europe/Helsinki");
        $ts = time();
        $this->create_date = date($format, $ts);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUserImg()
    {
        return $this->user_img;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        if ($category != NULL && is_numeric($category)) {
            $this->category = $category;
        } else {
            $this->validation_errors['category'] = $this->validation_rules['category']['msg'];
        }
        $this->category = $category;
    }

    public function getCategories()
    {
        if (!isset($this->categories)) {
            $this->categories = array();
            $db = DB::getInstance()->getConnection();
            $get_categories_query = mysqli_query($db, 'SELECT * FROM recipes.categories');

            if (mysqli_error($db)) {
                trigger_error(mysqli_error($db), E_USER_ERROR);
            }

            while ($row = mysqli_fetch_assoc($get_categories_query)) {
                $this->categories[$row['id']] = $row['name'];
            }
        }

        return $this->categories;
    }

    public function getIngredients()
    {
        return $this->ingredients;
    }

    public function setIngredients($ingredients)
    {
        $ingredients_trimmed = trim($ingredients);
        if (mb_strlen($ingredients_trimmed) >= $this->validation_rules['ingredients_len']['min']
            && mb_strlen($ingredients_trimmed) <= $this->validation_rules['ingredients_len']['max']
        ) {
            $this->ingredients = $ingredients_trimmed;
        } else {
            $this->validation_errors['ingredients'] = $this->validation_rules['ingredients_len']['msg'];
        }
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $description_trimmed = trim($description);
        if (mb_strlen($description_trimmed) >= $this->validation_rules['description_len']['min']
            && mb_strlen($description_trimmed) <= $this->validation_rules['description_len']['max']
        ) {
            $this->description = $description_trimmed;
        } else {
            $this->validation_errors['description'] = $this->validation_rules['description_len']['msg'];
        }
    }

    public function getValidationErrors()
    {
        return $this->validation_errors;
    }

    public function getValidationRules()
    {
        return $this->validation_rules;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;
    }

    public function insertRecipe()
    {
        $this->setTitle($_POST['title']);
        $this->setIngredients($_POST['ingredients']);
        $this->setDescription($_POST['description']);
        $this->setCategory($_POST['category']);
        $this->setCreateDate();

        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $image = new Image('recipes', $_FILES['image']['name'], $_SESSION['username']);
            $image->uploadToServer();
            if (count($image->getValidationErrors() === 0)) {
                $this->image = $image;
            } else {
                $this->validation_errors = array_merge($this->validation_errors, $image->getValidationErrors());
            }
        }

        if (count($this->validation_errors) === 0) {
            $db = DB::getInstance()->getConnection();

            $title_esc = mysqli_real_escape_string($db, $this->title);
            $ingredients_esc = mysqli_real_escape_string($db, $this->ingredients);
            $description_esc = mysqli_real_escape_string($db, $this->description);
            $img_esc = null;
            if ($this->image != null) {
                $file_name = $this->image->getFileName();
                $img_esc = mysqli_real_escape_string($db, $file_name);
            }
            $category_id_esc = mysqli_real_escape_string($db, $this->category);

            $sql = 'INSERT INTO recipes.recipes(title, ingredients, description, image, create_date, user_id, category_id )'
                . ' VALUES ("' . $title_esc . '","' . $ingredients_esc . '","' . $description_esc . '","' . $img_esc . '","' . $this->create_date . '","' . $_SESSION['user_id'] . '","' . $category_id_esc . '" )';

            mysqli_query($db, $sql);
            if (mysqli_error($db)) {
                trigger_error(mysqli_error($db), E_USER_ERROR);
            }

            return mysqli_insert_id($db);
        }
    }

    public function editRecipe()
    {
        $db = DB::getInstance()->getConnection();

        $id_esc = mysqli_real_escape_string($db, $_GET['id']);
        $get_user_sql = 'SELECT user_id, image FROM `recipes` WHERE id = ' . $id_esc;
        $get_user_query = mysqli_query($db, $get_user_sql);

        if (mysqli_error($db)) {
            trigger_error(mysqli_error($db), E_USER_ERROR);
        }

        if (mysqli_num_rows($get_user_query) == 0) {
            trigger_error('No recipe found.', E_USER_ERROR);
        }

        $result = mysqli_fetch_assoc($get_user_query);

        if ($result['user_id'] != $_SESSION['user_id']) {
            trigger_error('The current user does not match the recipe creator.', E_USER_ERROR);
        }

        if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $image = new Image('recipes', $_FILES['image']['name'], $_SESSION['username']);
            $image->uploadToServer();
            if (count($image->getValidationErrors()) === 0) {
                $this->image = $image;
                if ($result['image'] != null && $this->image->getFileName() != $result['image']) {
                    $old_img = $image->getPath() . $result['image'];
                    unlink($old_img);
                }

            } else {
                $this->validation_errors = array_merge($this->validation_errors, $image->getValidationErrors());
            }
        }

        $this->setTitle($_POST['title']);
        $this->setIngredients($_POST['ingredients']);
        $this->setDescription($_POST['description']);

        if (count($this->validation_errors) === 0) {

            $title_esc = mysqli_real_escape_string($db, $this->title);
            $ingredients_esc = mysqli_real_escape_string($db, $this->ingredients);
            $description_esc = mysqli_real_escape_string($db, $this->description);
            $category_id_esc = mysqli_real_escape_string($db, $_POST['category']);

            $img_esc = null;
            if ($this->image != null) {
                $file_name = $this->image->getFileName();
                $img_esc = mysqli_real_escape_string($db, $file_name);
            }

            $update_sql = 'UPDATE recipes SET title = "' . $title_esc . '", ingredients = "' . $ingredients_esc . '",
             description = "' . $description_esc . '", image = "' . $img_esc . '",  category_id = ' . $category_id_esc .
                ' WHERE `recipes`.`id` = ' . $id_esc;


            mysqli_query($db, $update_sql);
            if (mysqli_error($db)) {
                trigger_error(mysqli_error($db), E_USER_ERROR);
            }

            return $id_esc;
        }
    }

    public function getRecipeData()
    {
        $db = DB::getInstance()->getConnection();
        $id_esc = mysqli_real_escape_string($db, $_GET['id']);
        $sql = 'SELECT recipes.id, recipes.title, recipes.ingredients, recipes.description, recipes.image,
                recipes.create_date,users.id as user_id, users.user_name, users.image as user_img, categories.name
                FROM recipes
                LEFT JOIN users
                ON recipes.user_id = users.id
                LEFT JOIN categories
                ON recipes.category_id = categories.id
                WHERE recipes.id = ' . $id_esc;

        $get_recipe_query = mysqli_query($db, $sql);
        if (mysqli_error($db)) {
            trigger_error(mysqli_error($db), E_USER_ERROR);
        }

        if (mysqli_num_rows($get_recipe_query) == 0) {
            trigger_error('No recipe found.', E_USER_ERROR);
        }

        $result = mysqli_fetch_assoc($get_recipe_query);
        $this->id = $result['id'];
        $this->title = $result['title'];
        $this->ingredients = $result['ingredients'];
        $this->description = $result['description'];
        if (!empty($result['image'])) {
            $this->image = new Image('recipes', $result['image'], $result['user_name']);
        }
        $this->create_date = $result['create_date'];
        $this->user = $result['user_name'];
        $this->user_id = $result['user_id'];
        if (!empty($result['user_img'])) {
            $this->user_img = new Image('users', $result['user_img'], $result['user_name']);
        }
        $this->category = $result['name'];
    }
}