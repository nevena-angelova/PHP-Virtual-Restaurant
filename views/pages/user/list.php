<!-- list recipes section -->
<section id="all-users">
    <div class="container">
        <div class="col-md-offset-2 col-md-8 col-sm-12 text-center">
            <h1 class="heading">Потребители</h1>
            <hr>
        </div>
        <div class="row">
            <?php
            $delay = 0;
            foreach ($model as $user) {
                $delay += 0.3;
                echo '<div class="user wow fadeInUp text-center" data-wow-delay="' . $delay . 's">
                        <a class="img-link" title="' . $user['user_name'] . '" href="?c=user&a=profile&id=' . $user['id'] . '">';

                $src = isset($user['image']) ? $user['image']->resize(150, 150, true)
                    : 'user_img/users/default150.png';

                echo '<img alt="снимка" src="' . $src . '" class="img-responsive">';
                echo '</a>
                </div>';
            }
            ?>
        </div>
    </div>
</section>