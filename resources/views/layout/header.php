<?php

use App\Classes\Layout;
use App\Classes\StaticContent;

require '../vendor/autoload.php';
require('../config/constants.php');
require(CONFIG_PATH . 'config.php');
?>
<!DOCTYPE html>
<html lang="<?= LANG ?>">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php StaticContent::getStyleSheet(); ?>
  <title><?= SITE_NAME; ?> <?= TITLE_SPACER; ?> <?= SITE_SLOG; ?> </title>
</head>

<body>
  <header>
    <div class="bg-white">
      <nav class="navbar navbar-expand-lg mx-5">
        <div class="container-fluid">
          <?php Layout::getBrandLogo(); ?>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item" style="margin-left: 40px;"><a class="nav-link" aria-label="menuitem" href="<?= $router->generate('home'); ?>"><?= _('Home'); ?></a></li>
              <li class="nav-item"><a class="nav-link" href="<?= $router->generate('charts'); ?>"><?= _('Charts'); ?></a></li>
              <li class="nav-item"><a class="nav-link" href="<?= $router->generate('schedule'); ?>"><?= _('Schedule'); ?></a></li>
              <li class="nav-item"><a class="nav-link" href=""><?= _('shop'); ?></a></li>
            </ul>
            <ul>
              <button class="btn btn-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><?= _('Open the radio menu'); ?></button>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header>