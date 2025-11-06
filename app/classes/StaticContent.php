<?php

namespace App\Classes;

class StaticContent
{
  public static function getHeader()
  {
    StaticContent::getMeta();
    StaticContent::getIcons();
    StaticContent::getStylesheet();
  }

  public static function getMeta()
  {
    echo '
        <!-- Metas SEO -->
        <meta name="description" content="' . SITE_DESCRIPTION . '">
        <meta name="author" content="' . SITE_NAME . '">
        <meta name="apple-mobile-web-app-title" content="' . SITE_NAME . '">
        <meta name="application-name" content="' . SITE_NAME . '">
        <meta name="robots" content="index, follow">
        <meta name="description" content="' . SITE_DESCRIPTION . '">';
  }

  public static function getIcons()
  {
    echo '
        <!-- icons -->
        <link rel="apple-touch-icon"         href="/lib/icons/icon_iphone.png" sizes="180x180">
        <link rel="icon" type="image/png"    href="/lib/icons/icon_48.png" sizes="48x48">
        <link rel="icon" type="image/png"    href="/lib/icons/icon_32.png" sizes="32x32">
        <link rel="icon" type="image/png"    href="/lib/icons/icon_16.png" sizes="16x16">
        <link rel="shortcut icon"            href="/lib/icons/favicon.ico" />
        <link rel="icon" type="image/x-icon" href="/lib/icons/favicon.ico" />
        <link rel="icon" type="image/png"    href="/lib/icons/icon_16.png" />';
  }
  public static function getStyleSheet()
  {
    echo '
      <!-- CSS Styles Sheets -->
      <link href="/lib/css/bootstrap/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="/lib/fonts/bootstrap-icons.css">
      <link rel="stylesheet" href="/lib/css/plyr/plyr.css" />
      <link href="/lib/css/style.css" rel="stylesheet"/> 
      ';
  }
  public static function getScriptFiles()
  {
    echo '
      <script src="/lib/js/bootstrap/popper.min.js"></script>
      <script src="/lib/js/bootstrap/bootstrap.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/vidstack@^1.0.0/cdn/vidstack.js" type="module"></script>
      <script src="/lib/js/scripts.js"></script>
      <script src="/lib/js/plyr/plyr.js"></script>
      <script>
      document.addEventListener("DOMContentLoaded", () => {
          const controls = ["play", "mute", "volume", "airplay", "settings"];
          const players = Array.from(document.querySelectorAll(".js-player")).map(
            (p) => new Plyr(p)
          );
        });
        
        // Get all the plyr players on the page
        const players = Array.from(document.querySelectorAll(".js-player")).map(p => new Plyr(p));
        
        // Loop through the players and add an event listener for the `playing` event
        players.forEach(player => {
          player.on("playing", event => {
            // When the player starts playing, loop through all the other players and pause them
            players.forEach(otherPlayer => {
              if (otherPlayer !== player) {
                otherPlayer.stop();
              }
            });
          });
        });
      </script>';
  }

  public static function noScriptInstalled()
  {
    echo '
  <body class="bg-dark">
  <div class="text-center mt-5">
  <img src="images/logo.png" width="150px" height="150px" alt="your awesome logo">
  </div>
  <div class="card mx-auto mt-3 text-dark" style="width: 30rem;">
  <div class="card-header"><h4>' . _('Installation de rewindRadio') . '</h4></div>
  <div class="card-body">
  <h5>' . _('Installation non-terminée.') . '</h5>
  <p>' . _("Désolé, il semble que vous n'ayez pas completé le processus d'installation du script. Pour continuer, veuillez suivre les instructions d'installation disponibles en cliquant sur le bouton ci-bas. Si vous rencontrez des problèmes lors de l'installation ou l'utilisation du script, n'hésitez pas à visiter <a href='https://github.com/noordotda/rewindRadio'>la section issues</a> pour obtenir de l'aide.") . ' </p>

  <a class="btn btn-dark" href="/setup/index.php?language=fr" class="card-link">' . _("Démarrer l'installation") . '</a>
  <hr>
  <h5>' . _('Installation not completed') . '</h5>
  <p>' . _("Sorry, it seems that you have not complete the installation process. To proceed, please follow the installation instructions available by cliking on the button below. If you experience any issues while installing or using the script, please don't hesitate to visit <a href='https://github.com/noordotda/rewindRadio'>the Github page</a>.") . '</p>
  <a class="btn btn-dark" href="/setup/index.php?language=en" class="card-link">' . _('Start Installation') . '</a>
  
  </div>
</div></div></body>';
  }
}

/*
    public static function get_facebook_og() {
        echo '
        <!-- Facebook Open Graph SEO -->
        <meta property="og:locale" content="fr-CA" />
        <meta property="og:type" content="'.FB_OG_TYPE.'" />
        <meta property="og:title" content="'. SITE_URL . SPACER . SITE_SLOG . '" />
        <meta property="og:description" content="'.SITE_DESCRIPTION.'" />
        <meta property="og:url" content="'.\SITE_URL.'" />
        <meta property="og:site_name" content="'.SITE_NAME.'" />
        <meta property="fb:app_id" content="'.FB_APPID.'" />
        <meta property="og:image" content="public/social/fb-link-default.jpg" />
        <meta property="fb:profile_id" content="'.FACEBOOK_ID.'">
        <meta property="og:image:secure_url" content="public/social/fb-link-default.jpg" />';
}

    public static function get_twitter_og() {
        echo '
        <!-- Twitter SEO -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="'.SITE_NAME . SPACER . SITE_SLOG.'" />
        <meta name="twitter:description" content="'.SITE_DESCRIPTION.'">
        <meta property="twitter:image" content="public/social/fb-link-default.jpg">
        <meta name="twitter:site" content="'. SITE_URL.'">';
}

} 
*/
