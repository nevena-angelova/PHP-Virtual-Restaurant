<!-- login section -->
<section id="login">
    <div class="container">
        <?php
        ViewRenderer::render('views/inc/validation_errors.php', $model)
        ?>
        <div class="row">
            <div class="col-md-offset-1 col-md-10 col-sm-12 text-center">
                <h1 class="heading">Вход</h1>
                <hr>
            </div>
            <div class="col-md-offset-1 col-md-10 col-sm-12 wow fadeIn" data-wow-delay="0.9s">
                <form class="form" action="?c=user&a=login" method="post">
                    <div class="col-md-6 col-sm-6">
                        <input name="username" type="text" class="form-control" value="<?= $model->getUsername() ?>"
                               placeholder="Потребителско име"
                               data-rule-required="true"
                               data-rule-minlength="<?= $model->getValidationRules()['username_len']['min'] ?>"
                               data-rule-maxlength="<?= $model->getValidationRules()['username_len']['max'] ?>"
                        />
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <input name="pass" type="password" class="form-control" value="<?= $model->getPass() ?>"
                               placeholder="Парола"
                               data-rule-required="true"
                               data-rule-minlength="<?= $model->getValidationRules()['pass_len']['min'] ?>"
                               data-rule-maxlength="<?= $model->getValidationRules()['pass_len']['max'] ?>"
                        />
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