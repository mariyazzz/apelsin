<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php

/**
 * @var $this yii\web\View
 * @var $form_model \app\models\LoginForm
 */

$this->title = 'Апельсин';
?>
<section class="section">
    <div class="swiper-form-wrap">
        <!-- Swiper-->
        <div class="swiper-container swiper-slider swiper-slider_height-1 swiper-align-left swiper-align-left-custom context-dark bg-gray-darker" data-loop="false"
             data-autoplay="5500" data-simulate-touch="false" data-slide-effect="fade">
            <div class="swiper-wrapper">
                <div class="swiper-slide" data-slide-bg="images/index_background.jpg">
                    <div class="swiper-slide-caption">
                        <div class="container container-bigger swiper-main-section">
                            <div class="row row-fix justify-content-sm-center justify-content-md-start">
                                <div class="col-md-6 col-lg-5 col-xl-4 col-xxl-5">
                                    <h3>5 мифов о здоровом питании</h3>
                                    <p class="text-spacing-sm">Заблуждения о еде, с которыми многие из нас никак не могут расстаться</p><a
                                            class="button button-default-outline button-nina button-sm" href="#">Читать далее</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide" data-slide-bg="images/index_background.jpg">
                    <div class="swiper-slide-caption">
                        <div class="container container-bigger swiper-main-section">
                            <div class="row row-fix justify-content-sm-center justify-content-md-start">
                                <div class="col-md-6 col-lg-5 col-xl-4 col-xxl-5">
                                    <h3>Как еда влияет на нашу жизнь</h3>
                                    <p class="text-spacing-sm">Еда больше чем на 50% определяет наше долгосрочное здоровье, заболеваемость самыми страшными болезнями века и очень
                                        сильно влияет на бодрость и эффективность каждый день.</p><a class="button button-default-outline button-nina button-sm" href="#">Читать
                                        далее</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide" data-slide-bg="images/index_background.jpg">
                    <div class="swiper-slide-caption">
                        <div class="container container-bigger swiper-main-section">
                            <div class="row row-fix justify-content-sm-center justify-content-md-start">
                                <div class="col-md-6 col-lg-5 col-xl-4 col-xxl-5">
                                    <h3>Здоровая еда - это здорово!</h3>
                                    <p class="text-spacing-sm">Полезная пища может быть вкусно приготовленной! Расскажем, как этого добиться.</p><a
                                            class="button button-default-outline button-nina button-sm" href="#">Читать далее</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Swiper controls-->
            <div class="swiper-pagination-wrap">
                <div class="container container-bigger">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container container-bigger form-request-wrap form-request-wrap-modern">
            <div class="row row-fix justify-content-sm-center justify-content-lg-end">
                <div class="col-lg-6 col-xxl-5">
                    <div class="form-request form-request-modern bg-gray-lighter novi-background">
                      <?php
                      if (!Yii::$app->getUser()->isGuest) {
                          $name = Yii::$app->user->getIdentity()->userProfile->fullname;
                          echo "<h4>Здравствуйте, {$name}!</h4>";
                          echo '<a href="/?r=/user/sign-in/logout"><i class="icon-switch2"></i>Выйти</a>';

                        } else {
                      ?>
                        <h4>Войдите в Ваш аккаунт</h4>
                        <div class="row row-20 row-fix">
                            <div class="col-sm-12">
                              <?php $form = ActiveForm::begin([
                                'id'          => 'login-form',
                                'fieldConfig' => [
                                  'template'     => "{input}{error}",
                                  'inputOptions' => ['class' => 'form-control'],
                                ],
                                'options'     => [
                                  'class' => 'sign-in-form',
                                ],
                              ]); ?>

                              <?= $form->field($form_model, 'identity')->textInput(['placeholder' => Yii::t('login', 'Логин')]); ?>
                              <?= $form->field($form_model, 'password')->passwordInput(['placeholder' => Yii::t('login', 'Пароль')]); ?>
                              <?= $form->field($form_model, 'rememberMe')->checkbox(); ?>
                              <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
                              <?php ActiveForm::end() ?>
                              <?= Html::a('Регистрация', \yii\helpers\Url::to(['user/sign-in/signup'])) ?>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-variant-1 bg-default novi-background bg-cover">
    <div class="container container-wide">
        <div class="row row-fix justify-content-xl-end row-30 text-center text-xl-left">
            <div class="col-xl-8">
                <div class="parallax-text-wrap">
                    <h3>Полезные рецепты</h3>
                </div>
            </div>
            <div class="col-xl-3 text-xl-right"><a class="button button-secondary button-nina" href="#">посмотреть все</a></div>
        </div>
        <div class="row row-50">
            <div class="col-md-6 col-xl-4">
                <article class="event-default-wrap">
                    <div class="event-default">
                        <figure class="event-default-image"><img src="images/broccoli.jpg" alt="" width="570" height="370"/>
                        </figure>
                        <div class="event-default-caption"><a class="button button-xs button-secondary button-nina" href="#">подробнее</a></div>
                    </div>
                    <div class="event-default-inner">
                        <h5><a class="event-default-title" href="#">Салат с брокколи</a></h5>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-xl-4">
                <article class="event-default-wrap">
                    <div class="event-default">
                        <figure class="event-default-image"><img src="images/porridge.jpg" alt="" width="570" height="370"/>
                        </figure>
                        <div class="event-default-caption"><a class="button button-xs button-secondary button-nina" href="#">подробнее</a></div>
                    </div>
                    <div class="event-default-inner">
                        <h5><a class="event-default-title" href="#">Рисовая каша на воде</a></h5>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-xl-4">
                <article class="event-default-wrap">
                    <div class="event-default">
                        <figure class="event-default-image"><img src="images/miso.jpg" alt="" width="570" height="370"/>
                        </figure>
                        <div class="event-default-caption"><a class="button button-xs button-secondary button-nina" href="#">подробнее</a></div>
                    </div>
                    <div class="event-default-inner">
                        <h5><a class="event-default-title" href="#">Мисо-суп с овощами</a></h5>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-xl-4">
                <article class="event-default-wrap">
                    <div class="event-default">
                        <figure class="event-default-image"><img src="images/rice.jpg" alt="" width="570" height="370"/>
                        </figure>
                        <div class="event-default-caption"><a class="button button-xs button-secondary button-nina" href="#">подробнее</a></div>
                    </div>
                    <div class="event-default-inner">
                        <h5><a class="event-default-title" href="#">Бурый рис с морковкой</a></h5>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-xl-4">
                <article class="event-default-wrap">
                    <div class="event-default">
                        <figure class="event-default-image"><img src="images/laz.jpg" alt="" width="570" height="370"/>
                        </figure>
                        <div class="event-default-caption"><a class="button button-xs button-secondary button-nina" href="#">подробнее</a></div>
                    </div>
                    <div class="event-default-inner">
                        <h5><a class="event-default-title" href="#">Лазанья</a></h5>
                    </div>
                </article>
            </div>
            <div class="col-md-6 col-xl-4">
                <article class="event-default-wrap">
                    <div class="event-default">
                        <figure class="event-default-image"><img src="images/chi_soup.jpg" alt="" width="570" height="370"/>
                        </figure>
                        <div class="event-default-caption"><a class="button button-xs button-secondary button-nina" href="#">подробнее</a></div>
                    </div>
                    <div class="event-default-inner">
                        <h5><a class="event-default-title" href="#">Постные щи</a></h5>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- our advantages-->
<section class="section section-lg bg-gray-lighter novi-background bg-cover text-center">
    <div class="container container-wide">
        <h3>Калькулятор здорового питания</h3>
        <a class="button button-secondary button-nina" href="<?= \yii\helpers\Url::to(['site/calculate']) ?>">попробовать</a>
        <div class="row row-50 justify-content-sm-center text-left">
            <div class="col-sm-10 col-md-6 col-xl-3">
                <article class="box-minimal box-minimal-border">

                    <p class="big box-minimal-title">Вес</p>
                    <hr>
                    <div class="box-minimal-text text-spacing-sm">С помощью калькулятора вы сможете с легкостью рассчитать верное количество калорий, которое нужно употреблять
                        ежедневно. Через несколько недель вы станете намного ближе к желаемому результату на весах.
                    </div>
                </article>
            </div>
            <div class="col-sm-10 col-md-6 col-xl-3">
                <article class="box-minimal box-minimal-border">

                    <p class="big box-minimal-title">Питание</p>
                    <hr>
                    <div class="box-minimal-text text-spacing-sm">Как же здорово - питаться правильно!
                        Благодаря полезной и вкусной пищи можно поднять себе настроение на весь день. Также из-за легких рецептов приготовления не нужно тратить много времени,
                        чтобы ппросто покушать.
                    </div>
                </article>
            </div>
            <div class="col-sm-10 col-md-6 col-xl-3">
                <article class="box-minimal box-minimal-border">

                    <p class="big box-minimal-title">Здоровье</p>
                    <hr>
                    <div class="box-minimal-text text-spacing-sm">Очень важно следить за своим здоровьем, наш калькулятор поможет вам в этом. Правильное количество углеводов, жиров
                        и белков позволит забыть о растройствах пищеварения. Также пропадет изжога, усталось и сонливость.
                    </div>
                </article>
            </div>
            <div class="col-sm-10 col-md-6 col-xl-3">
                <article class="box-minimal box-minimal-border">

                    <p class="big box-minimal-title">Настроение</p>
                    <hr>
                    <div class="box-minimal-text text-spacing-sm">Хороший настрой на весь день - это главный фактор успеха во всем! Вы каждый день будете просыпаться с улыбкой на
                        лице, радовать своих родных вашем настроем и просто наслаждаться жизнью. Осталось лишь попробовать!.
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- Tips & tricks-->
<section class="section section-lg novi-background bg-cover bg-default text-center">
    <div class="container-wide">
        <div class="row row-50">
            <div class="col-sm-12">
                <h3>Всё о правильном питании</h3>

                <!-- Owl Carousel-->
                <div class="owl-carousel owl-carousel-team owl-carousel-inset" data-items="1" data-md-items="2" data-xl-items="3" data-stage-padding="15" data-loop="true"
                     data-margin="30" data-mouse-drag="false" data-dots="true" data-autoplay="true">
                    <article class="post-blog"><a class="post-blog-image" href="#"><img src="images/run.jpg" alt="" width="570" height="415"/></a>
                        <div class="post-blog-caption">
                            <div class="post-blog-caption-header">
                                <ul class="post-blog-tags">
                                    <li><a class="button-tags" href="#">Спорт</a></li>
                                </ul>
                                <ul class="post-blog-meta">
                                    <li><span>от</span>&nbsp;<a href="#">Елена Попова</a></li>
                                </ul>
                            </div>
                            <div class="post-blog-caption-body">
                                <h5><a class="post-blog-title" href="#">Лучшие упражнения перед бегом</a></h5>
                            </div>
                            <div class="post-blog-caption-footer">
                                <time datetime="2019">Фев 27, 2022</time>
                                <a class="post-comment" href="#"></a>
                            </div>
                        </div>
                    </article>
                    <article class="post-blog"><a class="post-blog-image" href="#"><img src="images/berries.jpg" alt="" width="570" height="415"/></a>
                        <div class="post-blog-caption">
                            <div class="post-blog-caption-header">
                                <ul class="post-blog-tags">
                                    <li><a class="button-tags" href="#">Еда</a></li>
                                </ul>
                                <ul class="post-blog-meta">
                                    <li><span>от</span>&nbsp;<a href="#">Алексей Иванов</a></li>
                                </ul>
                            </div>
                            <div class="post-blog-caption-body">
                                <h5><a class="post-blog-title" href="#">Полезные свойства фруктов</a></h5>
                            </div>
                            <div class="post-blog-caption-footer">
                                <time datetime="2019">Яны 27, 2019</time>
                                <a class="post-comment" href="#"></a>
                            </div>
                        </div>
                    </article>
                    <article class="post-blog"><a class="post-blog-image" href="#"><img src="images/gym.jpg" alt="" width="570" height="415"/></a>
                        <div class="post-blog-caption">
                            <div class="post-blog-caption-header">
                                <ul class="post-blog-tags">
                                    <li><a class="button-tags" href="#">Спорт</a></li>
                                </ul>
                                <ul class="post-blog-meta">
                                    <li><span>от</span>&nbsp;<a href="#">Ирина Новикова</a></li>
                                </ul>
                            </div>
                            <div class="post-blog-caption-body">
                                <h5><a class="post-blog-title" href="#">Как в зале размять все мышцы?</a></h5>
                            </div>
                            <div class="post-blog-caption-footer">
                                <time datetime="2019">Июн 29, 2019</time>
                                <a class="post-comment" href="#"></a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            <div class="col-12"><a class="button button-secondary button-nina button-offset-lg" href="#">Посмотреть все статьи</a></div>
        </div>
    </div>
</section>

<section class="section section-lg text-center bg-gray-lighter novi-background bg-cover">
    <div class="container container-bigger">
        <h3>Отзывы</h3>
        <div class="divider divider-decorate"></div>
        <!-- Owl Carousel-->
        <div class="owl-carousel owl-layout-1" data-items="1" data-dots="true" data-nav="true" data-stage-padding="0" data-loop="true" data-margin="30" data-mouse-drag="false"
             data-autoplay="true">
            <article class="quote-boxed">
                <div class="quote-boxed-aside"><img class="quote-boxed-image" src="images/person3.jpg" alt="" width="210" height="250"/>
                </div>
                <div class="quote-boxed-main">
                    <div class="quote-boxed-text">
                        <p>Благодаря калькулятору проекта Апельсин я уже в юном возрасте смоглас наладить свое питание и подтянуть фигуру. Очень понятный интерфейс и полезный
                            функционал. </p>
                    </div>
                    <div class="quote-boxed-meta">
                        <p class="quote-boxed-cite">Джулия Рэйн</p>
                        <p class="quote-boxed-small">17 лет</p>
                    </div>
                </div>
            </article>
            <article class="quote-boxed">
                <div class="quote-boxed-aside"><img class="quote-boxed-image" src="images/person2.jpg" alt="" width="210" height="210"/>
                </div>
                <div class="quote-boxed-main">
                    <div class="quote-boxed-text">
                        <p>Я уже полгода питаюсь рецептами на этом сайте. Сначала получаю ежедневную норму калорий, потом сразу появляются интересные рецепты, которые можно
                            готовить каждый день.</p>
                    </div>
                    <div class="quote-boxed-meta">
                        <p class="quote-boxed-cite">Михаил Иванов</p>
                        <p class="quote-boxed-small">35 лет</p>
                    </div>
                </div>
            </article>
            <article class="quote-boxed">
                <div class="quote-boxed-aside"><img class="quote-boxed-image" src="images/person1.jpg" alt="" width="210" height="210"/>
                </div>
                <div class="quote-boxed-main">
                    <div class="quote-boxed-text">
                        <p>Кроме полезного калькулятора я пользуюсь советами по здоровому питанию. Интересная информация доступа каждый день и в удобном формате.</p>
                    </div>
                    <div class="quote-boxed-meta">
                        <p class="quote-boxed-cite">Сэм Боул</p>
                        <p class="quote-boxed-small">40 лет</p>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>