<!-- list recipes section -->
<section id="all-recipes">
    <div class="container">
        <div class="col-md-offset-2 col-md-8 col-sm-12 text-center">
            <div class="filter">
                <form action="?c=recipe&a=all" method="post">
                    <input type="text" value="<?= $model->getFilter()['word'] ?>" name="word"
                           placeholder="Ключова дума"/>
                    <select name="category">
                        <option value="">Всички</option>
                        <?php
                        $categories = $model->getCategories();
                        $cat_id = isset($model->getFilter()['category']) ? $model->getFilter()['category'] :'';
                        foreach ($categories as $key => $category) {
                            echo '<option ';
                            echo $cat_id == $key ? "selected" :"";
                            echo ' value="' . $key . '">' . $category . '</option>';
                        }
                        ?>
                    </select>
                    <button type="submit">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </form>
            </div>
            <hr>
        </div>
        <?php
        if ($model->getPaging() != null && $model->getPaging()->getPages() > 1) {
            echo '<div class="row paging"><ul>';
            for ($i = 1; $i <= $model->getPaging()->getPages(); $i++) {
                echo '<li><a ';
                echo $model->getPaging()->getP() == $i ? 'class="active"' : '';
                echo ' href = "?c=recipe&a=all&p=' . $i . '&pages=' . $model->getPaging()->getPages() .
                    '&word=' . $model->getFilter()['word'] .
                    '&category=' . $model->getFilter()['category'] . '">' . $i . '</a ></li >';
            }
            echo '</ul></div>';
        }
        ?>
        <div class="row">
            <?php
            ViewRenderer::render('views/inc/recipes.php', $model);
            ?>
        </div>
    </div>
</section>