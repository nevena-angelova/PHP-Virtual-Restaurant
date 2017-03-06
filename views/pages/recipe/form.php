<!-- add recipe section -->
<section id="add-recipe">
    <div class="container">
        <?php
        ViewRenderer::render('views/inc/validation_errors.php', $model)
        ?>
        <div class="row">
            <div class="col-md-offset-1 col-md-10 col-sm-12 text-center">
                <h1 class="heading"><?= $model->getAction() == 'edit' ? 'Редакция' : 'Добавяне на рецепта' ?></h1>
                <hr>
            </div>
            <div class="col-md-offset-1 col-md-10 col-sm-12 wow fadeIn" data-wow-delay="0.9s">
                <form class="form" action="?c=recipe&a=<?= $model->getAction() ?>&id=<?= $model->getId() ?>" method="post"
                      enctype="multipart/form-data">
                    <div class="col-md-6 col-sm-6">
                        <select name="category" class="form-control"
                                data-rule-required="true"
                        ><option value="">Категория *</option>
                            <?php
                            foreach ($model->getCategories() as $key => $category) {
                                echo '<option ';
                                echo $category == $model->getCategory() ? "selected" : "";
                                echo ' value="' . $key . '">' . $category . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input name="title" type="text" class="form-control" value="<?= $model->getTitle() ?>"
                               placeholder="Заглавие *"
                               data-rule-required="true"
                               data-rule-minlength="<?= $model->getValidationRules()['title_len']['min'] ?>"
                               data-rule-maxlength="<?= $model->getValidationRules()['title_len']['max'] ?>"/>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <textarea name="ingredients" class="form-control"
                                  placeholder="Необходими съставки (всяка на отделен ред) *"
                                  data-rule-required="true"
                                  data-rule-minlength="<?= $model->getValidationRules()['ingredients_len']['min'] ?>"
                                  data-rule-maxlength="<?= $model->getValidationRules()['ingredients_len']['max'] ?>"><?php
                            if ($model->getIngredients() != NULL) {
                                $ingredients_arr = explode(PHP_EOL, $model->getIngredients());
                                foreach ($ingredients_arr as $ingredient) {
                                    echo $ingredient . '&#13;&#10';
                                }
                            } ?></textarea>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <textarea name="description" rows="8" class="form-control"
                                  placeholder="Начин на приготвяне *"
                                  data-rule-required="true"
                                  data-rule-minlength="<?= $model->getValidationRules()['description_len']['min'] ?>"
                                  data-rule-maxlength="<?= $model->getValidationRules()['description_len']['max'] ?>"
                        ><?= $model->getDescription() ?></textarea>
                    </div>
                    <?php
                    if ($model->getImage() != NULL) {
                        echo '<div class="col-md-9 col-lg-9">
                                 <img alt="снимка"src="' . $model->getImage()->getFullFileName() . '" class="img-responsive">
                            </div> ';
                    }
                    ?>
                    <div class="col-md-12 col-sm-12">
                        <div class="choose-image">
                            <div class="file-input-mask">Изберете снимка</div>
                            <input name="image" type="file"
                                   filename="<?= $model->getImage() != NULL ? $model->getImage()->getFileName() : '' ?>"
                                   class="file-input" placeholder="Снимка"/>
                            <div id="input-file-name"></div>
                        </div>
                    </div>
                    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                        <input name="submit" type="submit" class="form-control" value="Изпрати">
                    </div>
                </form>
            </div>
            <div class="col-md-2 col-sm-1"></div>
        </div>
    </div>
</section>