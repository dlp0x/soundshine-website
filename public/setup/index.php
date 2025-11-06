<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=utf-8');

use App\Classes\StaticContent as StaticContent;

require('../../app/classes/StaticContent.php');
?>
<html>

<head>
    <meta charset="UTF-8">
    <!-- Plugins CSS Styles Sheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title><?= _('rewindRadio Installation'); ?></title>
</head>

<body class="bg-dark">
    <div class="m-3">
        <div class="alert alert-info text-center" role="alert">
            <?= _("This is the alpha version version fo the script. Go to <a href='https://github.com/noordotda/rewindRadio' target='_blank'>Github page</a> to stay up-to-date."); ?>
        </div>
    </div>
    <div class="text-center mt-5">
        <img src="logo.png" width="150px" height="150px" alt="rewindRadio logo">
    </div>
    <div class="card mx-auto mt-3 card-dark" style="width: 50rem;">
        <div class="card-header">
            <h4><?= _("RewindRadio script Installation process, Part 1"); ?> </h4>
        </div>
        <div class="card-body">
            <form method="POST" action="setup.php">
                <div class="container">
                    <p><?= _("Please add your database information below."); ?></p>
                    <input type="hidden" name="language" value="<?= $language; ?>">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%"><label for="hostname" class="form-label"><?= _("Hostname:"); ?></label></td>
                            <td><input type="text" id="hostname" name="hostname" class="form-control">
                                <div class="form-text"><?= _('Please enter your MySQL hostname.') ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td width="30%"><label for="username" class="form-label"><?= _("Username:"); ?></label></td>
                            <td> <input type="text" id="username" name="username" class="form-control">
                                <div class="form-text"><?= _("Please enter your MySQL username. Do not use the root user. Create a new user for the script."); ?></div>
                </div>
                </td>
                </tr>
                <tr>
                    <td width="30%"><label for="password" class="form-label"><?= _("Password"); ?></label></td>
                    <td> <input type="password" id="password" name="password" class="form-control">
                        <div class="form-text"><?= _("Please enter your MySQL password."); ?></div>
        </div>
        </td>
        </tr>
        <tr>
            <td width="30%"><label for="database" class="form-label"><?= _("Database name"); ?></label></td>
            <td> <input type="text" id="database" name="database" class="form-control">
                <div class="form-text"><?= _("Please enter your MySQL database name."); ?></div>
            </td>
        </tr>
        <tr>
            <td width="30%"><label for="prefix" class="form-label"><?= _("Choosen Prefix"); ?></label></td>
            <td> <input type="text" id="prefix" name="prefix" class="form-control">
                <div class="form-text"><?= _("An underscore '_' will be added to the end of your prefix, for example, prefix_tablename, to make it easier to find tables in case of bugs."); ?> </div>
            </td>
        </tr>
        </table>

        <div class="mb-4 mt-4" style="background-color:#eaeaea; padding:15px;">
            <input type="checkbox" class="form-check-input" id="addFakeData" name="addFakeData" value="true">
            <label for="addFakeData" class="form-check-label"><?= _("Add Fake Data?"); ?></label>
            <div class="form-text"><?= _("Please check this box if you want to add fake data."); ?></div>
        </div>

    </div>
    </div>
    </div>
    <div class="card mx-auto mt-3 card-dark" style="width: 50rem;">
        <div class="card-header">
            <h4><?= _("RewindRadio script Installation process, Part 2"); ?></h4>
        </div>
        <div class="card-body">
            <div class="container">
                <input type="hidden" name="language" value="<?= $language ?>">
                <table class="table table-borderless">
                    <tr>
                        <td width="30%"><label for="site_name" class="form-label"><?= _("Website Name"); ?></label></td>
                        <td><input type="text" id="site_name" name="site_name" class="form-control">
                            <div class="form-text"><?= _("Please enter the name of your website."); ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="30%"><label for="siteUsername" class="form-label"><?= _("Username"); ?></label></td>
                        <td> <input type="text" id="siteUsername" name="siteUsername" class="form-control">
                            <div class="form-text"><?= _("Please enter a username. It will be used to log in to the private section of the website."); ?></div>
            </div>
            </td>
            </tr>
            <tr>
                <td width="30%"><label for="sitePassword" class="form-label"><?= _("Password"); ?></label></td>
                <td> <input type="password" id="sitePassword" name="sitePassword" class="form-control">
                    <div class="form-text"><?= _("Please enter your password. It will be used to log in to the private section of the website."); ?></div>
        </div>
        </td>
        </tr>
        <tr>
            <td width="30%"><label for="userEmail" class="form-label"><?= _("Email adress"); ?></label></td>
            <td> <input type="text" id="userEmail" name="userEmail" class="form-control">
                <div class="form-text"><?= _("Please enter your email address here. It will be used to change your password and activate your account."); ?></div>
            </td>
        </tr>
        </table>
        <input type="submit" class="btn btn-dark" value="<?= _("Install plugin"); ?>">
        </form>
    </div>
    </div>
    </div>
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 mt-5 border-top">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                <svg class="bi" width="30" height="24">
                    <use xlink:href="#bootstrap"></use>
                </svg>
            </a>
            <span class="mb-3 mb-md-0 text-light">Coded with love by noordaStudios</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex mx-5">
            <li class="ms-3"><a class="text-light" href="#"><i class="bi bi-twitter">
                        <use xlink:href="#twitter"></use>
                    </i></a></li>
            <li class="ms-3"><a class="text-light" href="#"><i class="bi bi-instagram">
                        <use xlink:href="#instagram"></use>
                    </i></a></li>
            <li class="ms-3"><a class="text-light" href="#"><i class="bi bi-github">
                        <use xlink:href="#github"></use>
                    </i></a></li>
        </ul>
    </footer>

    <?= StaticContent::getScriptFiles(); ?>
</body>

</html>