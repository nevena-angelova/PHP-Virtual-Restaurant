<!-- register section -->
<section id="register">
    <div class="container">
        <?php
        ViewRenderer::render('views/inc/validation_errors.php', $model)
        ?>
        <div class="row">
            <div class="col-md-offset-1 col-md-10 col-sm-12 text-center">
                <h1 class="heading"><?= $model->getAction() == 'edit' ? $model->getUsername() : 'Регистрация' ?></h1>
                <hr>
            </div>
            <div class="col-md-offset-1 col-md-10 col-sm-12 wow fadeIn" data-wow-delay="0.9s">
                <form class="form" action="?c=user&a=<?= $model->getAction() ?>&id=<?= $model->getId() ?>"
                      method="post"
                      enctype="multipart/form-data">

                    <?php
                    if ($model->getAction() == 'register') {
                        echo '<div class="col-md-6 col-sm-6">
                                <input name="username" type="text" class="form-control" value="' . $model->getUsername() . '" placeholder="Потребителско име *"
                                data-rule-required="true"
				                data-rule-minlength="' . $model->getValidationRules()['username_len']['min'] . '"
				                data-rule-maxlength="' . $model->getValidationRules()['username_len']['max'] . '"
				                />
                              </div>';
                    } ?>

                    <div class="col-md-6 col-sm-6">
                        <input name="email" type="email" class="form-control" value="<?= $model->getEmail() ?>"
                               placeholder="Email *"
                               data-rule-required="true"
                               data-rule-email="true"
                               data-rule-maxlength="<?= $model->getValidationRules()['email_len']['max'] ?>"
                        />
                    </div>

                    <?php
                    if ($model->getAction() == 'register') {
                        echo '<div class="col-md-6 col-sm-6">
                                <input id="pass" name="pass" type="password" class="form-control" value="' . $model->getPass() . '"
                                    placeholder="Парола *"
                                    data-rule-required="true"
                                    data-rule-minlength="' . $model->getValidationRules()['pass_len']['min'] . '"
                                    data-rule-maxlength="' . $model->getValidationRules()['pass_len']['max'] . '"
                                />
                              </div>
                              <div class="col-md-6 col-sm-6">
                                <input name="pass_repeat" type="password" class="form-control" placeholder="Отново паролата *"
                                    data-rule-required="true"
                                    data-rule-equalTo="#pass"
                                    data-rule-minlength="' . $model->getValidationRules()['pass_len']['min'] . '"
                                    data-rule-maxlength="' . $model->getValidationRules()['pass_len']['max'] . '">
                              </div>';
                    } ?>
                    <div class="col-md-6 col-sm-6">
                        <input name="first_name" type="text" class="form-control" value="<?= $model->getFirstName() ?>"
                               placeholder="Име"
                               data-rule-minlength="<?= $model->getValidationRules()['first_name_len']['min'] ?>"
                               data-rule-maxlength="<?= $model->getValidationRules()['first_name_len']['max'] ?>"
                        />
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input name="last_name" type="text" class="form-control" value="<?= $model->getLastName() ?>"
                               placeholder="Фамилия"
                               data-rule-minlength="<?= $model->getValidationRules()['last_name_len']['min'] ?>"
                               data-rule-maxlength="<?= $model->getValidationRules()['last_name_len']['max'] ?>"
                        />
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <textarea name="about" rows="8" class="form-control"
                                  placeholder="За мен"
                                  data-rule-minlength="<?= $model->getValidationRules()['about_len']['min'] ?>"
                                  data-rule-maxlength="<?= $model->getValidationRules()['about_len']['max'] ?>"
                        ><?= $model->getAbout() ?></textarea>
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
                            <input name="image"
                                   filename="<?= $model->getImage() != NULL ? $model->getImage()->getFileName() : '' ?>"
                                   type="file" class="file-input" placeholder="Снимка"/>

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