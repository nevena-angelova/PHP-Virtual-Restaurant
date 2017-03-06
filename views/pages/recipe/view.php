<!-- recipe view section -->
<section id="recipe-view">
    <div class="container">
        <div class="col-md-offset-2 col-md-8 col-sm-12 text-center">
            <h1 class="heading">
                <?php
                echo $model->getTitle();
                ?>
            </h1>
            <hr>
            <h5>
                Категория: <?= $model->getCategory() ?>
            </h5>
        </div>
        <div class="row">
            <div class="col-md-3 col-lg-3">
                <h4>Необходими съставки</h4>
                <ul class="ingredients">
                    <?php
                    $ingredients_arr = explode(PHP_EOL, $model->getIngredients());
                    foreach ($ingredients_arr as $ingredient) {
                        echo '<li>' . $ingredient . '</li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="col-md-9 col-lg-9">
                <img alt="снимка"
                     src="<?= $model->getImage() != NULL ? $model->getImage()->getFullFileName() : 'user_img/recipes/default.png' ?>"
                     class="img-responsive">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 ">
                <h4>Начин на приготвяне</h4>
                <?php
                echo $model->getDescription();
                ?>
            </div>
        </div>
        <?php

        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $model->getUserId()) {
            echo '<a class="btn" href="?c=recipe&a=edit&id=' . $model->getId() . '">Редактирай</a>';
        }

        ?>
    </div>
</section>
<section id="recipe-user-info">
    <div class="container">
        <div class="row user-info">
            <div class="col-md-12 col-lg-12 ">
                <h5>Добавена от</h5>
                <?php

                $src = $model->getUserImg() != NULL ? $model->getUserImg()->resize(70, 70, true) : 'user_img/users/default150.png';

                echo '<a class="user-img-link" href="?c=user&a=profile&id=' . $model->getUserId() . '">
                <img alt="снимка" src="' . $src . '" class="img-responsive"/></a>
                        <a href="?c=user&a=profile&id=' . $model->getUserId() . '">' . $model->getUser() . '</a><br/>
                        <span>' . $model->getCreateDate() . '</span>';
                ?>
            </div>
        </div>
    </div>
</section>