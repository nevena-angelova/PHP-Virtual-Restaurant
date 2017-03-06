<!-- home section -->
<section id="home" class="parallax-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h1>Виртуален ресторант</h1>

                <div id="home-navigation">
                    <ul>
                        <li><a href="#home-recipes" class="smoothScroll">Нови рецепти</a></li>
                        <li><a href="#menu" class="smoothScroll">Специални предложения</a></li>
                        <li><a href="#team" class="smoothScroll">Екип</a></li>
                        <li><a href="#contact" class="smoothScroll">Контакти</a></li>
                    </ul>
                </div>

                <?php
                $is_logged = isset($_SESSION['is_logged']) && $_SESSION['is_logged'] == true;
                if ($is_logged) {
                    echo '<a href="?c=user&a=logout" class="smoothScroll btn btn-default">ИЗХОД</a>';
                } else {
                    echo '<a href="?c=user&a=login" class="smoothScroll btn btn-default">ВХОД</a>
                          <div><a class="register-btn" href="?c=user&a=register">Регистрация</a></div>';
                }
                ?>
            </div>
        </div>
    </div>
</section>


<!-- gallery section -->
<div class="home-btn-wrapper">
    <a href="#home" class="home-btn gallery-home-btn smoothScroll">
        <span class="glyphicon glyphicon-home"></span>
    </a>
</div>
<section id="home-recipes">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8 col-sm-12 text-center">
                <h1 class="heading">Нови рецепти</h1>
                <hr>
            </div>
            <?= ViewRenderer::render('views/inc/recipes.php', $model) ?>
        </div>
</section>

<!-- menu section -->
<div class="home-btn-wrapper">
    <a href="#home" class="home-btn menu-home-btn smoothScroll">
        <span class="glyphicon glyphicon-home"></span>
    </a>
</div>
<section id="menu" class="parallax-section">
    <div class="container">
        <div class="row">
            <a href="#home" class="home-btn smoothScroll"><span class="glyphicon glyphicon-home"></span></a>

            <div class="col-md-offset-2 col-md-8 col-sm-12 text-center">
                <h1 class="heading">Специални предложения</h1>
                <hr>
            </div>
            <div class="col-md-6 col-sm-6">
                <h4>Доставка <span>3,50 лв.</span></h4>
                <h5>Време за доставка – 30 до 50 минути</h5>
            </div>
            <div class="col-md-6 col-sm-6">
                <h4>Организиране на кетъринг <span>200,00 лв.</span></h4>
                <h5>Предлагаме кетъринг с предварително одобрено от Вас меню</h5>
            </div>
            <div class="col-md-6 col-sm-6">
                <h4>Празнични торти <span>100 лв.</span></h4>
                <h5>Tорти, приготвени по идея на нашите клиенти</h5>
            </div>
            <div class="col-md-6 col-sm-6">
                <h4>Домашни сладка <span>6,90 лв.</span></h4>
                <h5>Домашно сладко от вишни (230 г) / бели череши / горски ягоди </h5>
            </div>
            <div class="col-md-6 col-sm-6">
                <h4>Закуски <span> 2,20 лв.</span></h4>
                <h5>баница / домашни мекици / сладка пита</h5>
            </div>
            <div class="col-md-6 col-sm-6">
                <h4>С вкус на ориент <span>2,20лв.</span></h4>
                <h5>Саралия / Джобчета / Баклава / Пръстчета </h5>
            </div>
            <div class="col-md-6 col-sm-6">
                <h4>Мъфини <span>1,80лв.</span></h4>
                <h5>ванилия / вишна / боровинки / маскарпоне /с парченца шоколад</h5>
            </div>
            <div class="col-md-6 col-sm-6">
                <h4>Напитки <span>3.10лв.</span></h4>
                <h5>Домашни лимонада / студен чай от Бъз / студен чай от Липа</h5>
            </div>
        </div>
    </div>
</section>


<!-- team section -->
<div class="home-btn-wrapper">
    <a href="#home" class="home-btn team-home-btn smoothScroll">
        <span class="glyphicon glyphicon-home"></span>
    </a>
</div>
<section id="team" class="parallax-section">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-2 col-md-8 col-sm-12 text-center">
                <h1 class="heading">Екип</h1>
                <hr>
            </div>
            <div class="col-md-4 col-sm-4 wow fadeInUp" data-wow-delay="0.3s">
                <img src="images/team1.jpg" class="img-responsive center-block" alt="team img">
                <h4>Таня</h4>

                <h3>Главен готвач</h3>
            </div>
            <div class="col-md-4 col-sm-4 wow fadeInUp" data-wow-delay="0.6s">
                <img src="images/team2.jpg" class="img-responsive center-block" alt="team img">
                <h4>Линда</h4>

                <h3>Пица специалист</h3>
            </div>
            <div class="col-md-4 col-sm-4 wow fadeInUp" data-wow-delay="0.9s">
                <img src="images/team3.jpg" class="img-responsive center-block" alt="team img">
                <h4>Джани Ко</h4>

                <h3>Пекар</h3>
            </div>
        </div>
    </div>
</section>


<!-- contact section -->
<div class="home-btn-wrapper">
    <a href="#home" class="home-btn contact-home-btn smoothScroll">
        <span class="glyphicon glyphicon-home"></span>
    </a>
</div>
<section id="contact" class="parallax-section">
    <div class="container">
        <div id="send-msg-result"></div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10 col-sm-12 text-center">
                <h1 class="heading">Контакти</h1>
                <hr>
            </div>
            <div class="col-md-offset-1 col-md-10 col-sm-12 wow fadeIn" data-wow-delay="0.9s">
                <form id="contact-form" action="#" method="post">
                    <div class="col-md-6 col-sm-6">
                        <input name="email" type="email" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <textarea name="message" rows="8" class="form-control" id="message"
                                  placeholder="Съобщение"></textarea>
                    </div>
                    <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6">
                        <input name="submit" type="submit" class="form-control" id="submit" value="Изпрати">
                    </div>
                </form>
            </div>
            <div class="col-md-2 col-sm-1"></div>
        </div>
    </div>
</section>