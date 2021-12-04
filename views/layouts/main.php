<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <link href="/template/less/components/plugins/forms/checkboxes/switchery.less">
        <script src="/template/js/plugins/forms/styling/switchery.min.js"></script>
      <?= Html::csrfMetaTags() ?>
        <!-- <link rel="shortcut icon" type="image/png" href="/template/imgs/favicon.png" /> -->
        <title><?= Html::encode(Yii::$app->name), ' :: ', Html::encode($this->title) ?></title>


      <?php $this->head() ?>
    </head>

    <body class="navbar-top">
    <?php $this->beginBody() ?>

    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header">
            <a class="navbar-brand" href="/"><img src="/template/images/logo.png" alt=""></a>
            <ul class="nav navbar-nav pull-right visible-xs-block">
                <li><a data-toggle="collapse" data-target="#navbar-mobile" class="collapsed" aria-expanded="false">
                        <i class="icon-tree5"></i>
                    </a></li>
                <li><a class="sidebar-mobile-main-toggle">
                        <i class="icon-paragraph-justify3"></i>
                    </a></li>
            </ul>
        </div>

        <div class="navbar-collapse collapse" id="navbar-mobile" aria-expanded="false" style="height: 1px;">
            <ul class="nav navbar-nav">
                <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">


                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="<?= Yii::$app->user->getIdentity()->getAvatar() ?>" alt="<?= Yii::$app->user->getIdentity()->username ?>">
                        <span><?= Yii::$app->user->getIdentity()->userProfile->fullname ?></span>
                        <i class="caret"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="/user"><i class="icon-user-plus"></i><?php echo Yii::t('layout', 'Профиль') ?></a></li>
                        <li class="divider"></li>
                        <li><a href="/user/sign-in/logout"><i class="icon-switch2"></i><?php echo Yii::t('layout', 'Выйти') ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>


    <div class="page-container" style="height: 100vh">


        <!-- Page content -->
        <div class="page-content">

            <!-- Main sidebar -->
            <div class="sidebar sidebar-main sidebar-fixed">
                <div class="sidebar-content" style="overflow-y: hidden;" tabindex="4">
                    <!-- Main navigation -->
                    <div class="sidebar-category sidebar-category-visible">
                        <div class="category-content no-padding">
                          <?php
                          echo \app\components\MenuNav::widget([
                            'route'        => ltrim(str_replace(["/{$this->context->module->defaultRoute}/{$this->context->defaultAction}", "/{$this->context->defaultAction}"], '', Yii::$app->controller->getRoute()), '/'),
                            'encodeLabels' => false,
                            'linkTemplate' => '<a href="{url}"><i class="{iconClass}"></i>{label}</a>',
                            'options'      => [
                              'class' => 'navigation navigation-main navigation-accordion',
                            ],
                            'items'        => [
                              [
                                'iconClass' => 'icon-list',
                                'visible'   => Yii::$app->user->can(\app\models\User::ROLE_USER),
                                'label'     => Yii::t('layout', 'Очередь задач'),
                                'url'       => ['/task'],
                              ],
                              [
                                'iconClass' => 'icon-atom',
                                'visible'   => Yii::$app->user->can(\app\models\User::ROLE_USER),
                                'label'     => Yii::t('layout', 'Бренды'),
                                'url'       => ['/brand'],
                              ],
                              [
                                'iconClass' => 'icon-chess-king',
                                'url'       => '#',
                                'label'     => Yii::t('layout', 'Администрирование'),
                                'visible'   => Yii::$app->user->can(\app\models\User::ROLE_ADMINISTRATOR),
                                'items'     => [
                                  [
                                    'label' => Yii::t('layout', 'Пользователи'),
                                    'url'   => ['/administration/user'],
                                  ],
                                  [
                                    'label' => Yii::t('layout', 'RBAC'),
                                    'url'   => ['/rbac'],
                                  ],
                                ],
                              ],
                              [
                                'iconClass' => 'icon-cabinet',
                                'url'       => '#',
                                'label'     => Yii::t('layout', 'Instagram'),
                                'visible'   => Yii::$app->user->can(\app\models\User::ROLE_USER),
                                'items'     => [
                                  [
                                    'label' => Yii::t('layout', 'Посты'),
                                    'url'   => ['/post'],
                                  ],
                                  [
                                    'label' => Yii::t('layout', 'Хэштеги'),
                                    'url'   => ['/tag'],
                                  ],
                                  [
                                    'label' => Yii::t('layout', 'Профиль'),
                                    'url'   => ['/profile'],
                                  ],
                                ],
                              ],
                              [
                                'iconClass' => 'icon-gear',
                                'url'       => '#',
                                'label'     => Yii::t('layout', 'Общие настройки'),
                                'visible'   => Yii::$app->user->can(\app\models\User::ROLE_USER),
                                'items'     => [
                                  [
                                    'label' => Yii::t('layout', 'Выключение бота'),
                                    'url'   => ['/settings/toggle'],
                                  ],
                                  [
                                    'label' => Yii::t('layout', 'Белый список'),
                                    'url'   => ['/settings/whitelisted'],
                                  ],
                                  [
                                    'label' => Yii::t('layout', 'Слова триггеры'),
                                    'url'   => ['/settings/triggers'],
                                  ],
                                  [
                                    'label' => Yii::t('layout', 'Стоп слова'),
                                    'url'   => ['/settings/stops'],
                                  ],
                                  [
                                    'label' => Yii::t('layout', 'Запрос'),
                                    'url'   => ['/settings/request'],
                                  ],
                                  [
                                    'label' => Yii::t('layout', 'Компы'),
                                    'url'   => ['/computer'],
                                  ],
                                ],
                              ],
                            ],
                          ]);
                          ?>
                        </div>
                    </div>
                    <!-- /main navigation -->

                </div>
            </div>
            <!-- /main sidebar -->


            <!-- Main content -->
            <div class="content-wrapper ">
                <!-- Content area -->
                <div class="content">
                  <?= $content ?>

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->
    <div class="navbar navbar-default navbar-fixed-bottom">
        <ul class="nav navbar-nav no-border visible-xs-block">
            <li><a class="text-center collapsed" data-toggle="collapse" data-target="#navbar-second"><i class="icon-circle-up2"></i></a></li>
        </ul>

        <div class="navbar-collapse collapse" id="navbar-second">
            <div class="navbar-text">
              <?= date('Y') ?> &copy; <?= Yii::$app->name ?>
            </div>
        </div>
    </div>


    <div id="ascrail2004" class="nicescroll-rails nicescroll-rails-vr"
         style="padding-right: 0.5px; padding-top: 1.5px; padding-bottom: 1.5px; width: 3px; z-index: 99; cursor: default; position: fixed; top: 48px; left: 256.5px; height: 719px; display: block; opacity: 0;">
        <div style="position: relative; top: 0px; float: right; width: 3px; height: 690px; background-color: rgb(204, 204, 204); background-clip: padding-box; border-radius: 5px;"
             class="nicescroll-cursors"></div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>