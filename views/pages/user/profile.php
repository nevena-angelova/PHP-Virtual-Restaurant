<!-- user profile section -->
<section id="profile">
    <div class="container">
        <div class="panel wow fadeIn" data-wow-delay="0.9s">
            <div class="panel-heading text-center">
                <h3><?= $model->getUsername() ?></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-10 col-sm-10 hidden-md hidden-lg"><br>
                        <dl>
                            <?php
                            if ($model->getFirstName() != NULL) {
                                echo '<dt>
                                    <dd>Име</dd>
                                    <dd>' . $model->getFirstName() . '</dd>
                                </dt>';
                            }
                            if ($model->getLastName() != NULL) {
                                echo '<dt>
                                    <dd>Фамилия</dd>
                                    <dd>' . $model->getLastName() . '</dd>
                                </dt>';
                            }
                            ?>
                            <dt>Email</dt>
                            <dd><?= $model->getEmail(); ?></dd>
                            <dt>Дата на регистрация</dt>
                            <dd><?= $model->getRegisterDate(); ?></dd>
                            <?php
                            if ($model->getAbout() != NULL) {
                                echo '<dt>За мен</dt><dd>' . $model->getAbout() . '</dd>';
                            }
                            ?>
                        </dl>
                    </div>
                    <div class="col-md-3 col-lg-3 " align="center">
                        <img alt="снимка"
                             src="<?= $model->getImage() != NULL ? $model->getImage()->getFullFileName() : 'user_img/users/default.png' ?>"
                             class="img-responsive">
                    </div>
                    <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                        <table class="table">
                            <tbody>
                            <?php
                            if ($model->getFirstName() != NULL) {
                                echo '<tr>
                                    <td>Име</td>
                                    <td>' . $model->getFirstName() . '</td>
                                </tr>';
                            }
                            if ($model->getLastName() != NULL) {
                                echo '<tr>
                                    <td>Фамилия</td>
                                    <td>' . $model->getLastName() . '</td>
                                </tr>';
                            }
                            ?>
                            <tr>
                                <td>Email</td>
                                <td><a href="mailto:info@support.com"><?= $model->getEmail() ?></a></td>
                            </tr>
                            <tr>
                                <td>Дата на регистрация</td>
                                <td><?= $model->getRegisterDate(); ?></td>
                            </tr>
                            <?php
                            if ($model->getAbout() != NULL) {
                                echo '<tr>
                                    <td>За мен</td>
                                    <td>' . $model->getAbout() . '</td>
                                </tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                        <a id="show-recipes-btn" data-id="<?= $model->getId() ?>" href="#" class="btn">Рецепти</a>
                        <?= isset($_SESSION['user_id']) && $model->getId() == $_SESSION['user_id'] ?
                            '<a href="?c=user&a=edit&id=' . $model->getId() . '" class="btn">Редакция на
                            профил</a>' : '' ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="user-recipes-wrap" class="row">
        </div>
    </div>
</section>