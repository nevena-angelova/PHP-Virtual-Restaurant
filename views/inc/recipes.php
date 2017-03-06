<?php

$delay = 0;
if(count($model->getRecipes())>0){
    foreach ($model->getRecipes() as $recipe) {
        $delay += 0.3;
        echo '<div class="recipe col-md-3 col-sm-3 wow fadeInUp text-center" data-wow-delay="' . $delay . 's">
                        <a class="img-link" href="?c=recipe&a=view&id=' . $recipe['id'] . '">';

        $src = isset($recipe['image']) ? $recipe['image']->resize(300, 300, true) :'user_img/recipes/default.png';

        echo '<img alt="снимка" src="' . $src . '" class="img-responsive">';
        echo '</a>
                 <div class="text-left">
                     <div class="recipe-title">
                         <h3><a href="?c=recipe&a=view&id=' . $recipe['id'] . '">' . $recipe['title'] . '</a></h3>
                     </div>
                      <h5>Категория: ' . $recipe['category_name'] . '</h5>
                      <a href="?c=user&a=profile&id=' . $recipe['user_id'] . '">' . $recipe['user_name'] . '</a>
                      <span>' . $recipe['create_date'] . '</span>
                 </div>
         </div>';
    }
}else{
    echo '<div class="col-md-12 col-sm-12 wow fadeInUp text-center" data-wow-delay="0.3">Няма намерени рецепти.</div>';
}

?>