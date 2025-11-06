<?php

use App\Classes\Layout;
use App\Classes\StaticContent;
?>

<footer>
    <div class="container">
        <div class="row pt-4">
            <div class="col-lg-4">
                <nav>
                    <div class="title"><?= _('Mobile Apps') ?></div>
                    <span><?= _("Download SimpleRadio app to listen to rewindRadio.") ?></span>
                    <div style="margin-top:10px;">
                        <a style="margin-right:10px;" href="https://itunes.apple.com/us/app/simple-radio-by-streema-tunein/id891132290?mt=8" target="_blank"><img src="../images/app_store.svg" width="143" height="45"></a>
                        <a href="https://play.google.com/store/apps/details?id=com.streema.simpleradio" target="_blank"> <img src="../images/google-play.png" width="143" height="45"></a>
                    </div>
                    <div style="margin-top: 10px;"><small><?= _('Require iOS 9.0 ou better or Android 4.1 or better.'); ?></small></div>
                </nav>
            </div>
            <div class="col-lg-3">
                <nav>
                    <ul>
                        <li class="title"><?= SITE_NAME ?></li>
                        <li class="nav-item"><a href="#" data-bs-toggle="modal" data-bs-target="#aboutModal"><?= _('About'); ?></a></li>
                        <li class='nav-item'><a href="https://www.bonfire.com" target="_blank"><?= _('Merch'); ?></a></li>
                        <li class='nav-item' id="teams"><a href="<?= $router->generate('team'); ?>"><?= _('Team'); ?></a></li>
                        <li class='nav-item' id="join_us"><a href="<?= $router->generate('benevolat'); ?>"><?= _('Volunteering'); ?></a></li>
                        <li class='nav-item' id="privacy_policy"><a href='<?= $router->generate('privacy-policy'); ?>'><?= _('Privacy Policy'); ?></a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <nav>
                    <ul>
                        <li class="title"><?= _('Inspirations') ?></li>
                        <li class='nav-item'><a href="<?= F3_LINK1_LINK ?>" target="_blank"><?= F3_LINK1_TXT ?></a></li>
                        <li class='nav-item'><a href="<?= F3_LINK2_LINK ?>" target="_blank"><?= F3_LINK2_TXT ?></a></li>
                        <li class='nav-item'><a href="<?= F3_LINK3_LINK ?>" target="_blank"><?= F3_LINK3_TXT ?></a></li>
                        <li class='nav-item'><a href="<?= F3_LINK4_LINK ?>" target="_blank"><?= F3_LINK4_TXT ?></a></li>
                        <li class='nav-item'><a href="<?= F3_LINK5_LINK ?>" target="_blank"><?= F3_LINK5_TXT ?></a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-2">
                <ul class="list-unstyled d-flex me-5 ms-5">

                    <?php
                    $socialLinks = [
                        ['twitter', TWITTER],
                        ['instagram', INSTAGRAM],
                        ['discord', DISCORD_INVITE],
                        ['github', GITHUB],
                    ];

                    foreach ($socialLinks as $link) {
                        echo "<h4>" . Layout::socialIcons($link[0], $link[1]) . "</h4>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</footer>
<div class="player">
    <div class="comingSoon"> <?php include('data/song_data.php'); ?></div>
    <audio class="js-player">
        <source src="<?= RADIO_URL ?>" />
    </audio>
</div>
<?php

include(VIEW_PATH . "layout/components.php");
StaticContent::getScriptFiles();
?>

<script>

</script>