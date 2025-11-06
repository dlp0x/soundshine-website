<?php

use App\Classes\Database;
use App\Helpers\DateFormater;
use App\Helpers\Texter;

?>
<section>
  <?php
  $id = $match['params']['id'];
  $db = new Database();
  $db_conx_rdj = $db->connect();
  $reponse = $db_conx_rdj->query("SELECT " . PREFIX . "_subcategory_info.*, subcategory.* 
FROM " . PREFIX . "_subcategory_info 
LEFT JOIN subcategory ON subcategory.ID = " . PREFIX . "_subcategory_info.subcategory_id 
WHERE subcategory_id = " . $id . " LIMIT 1");
  while ($show = $reponse->fetch()) {
  ?>
    <div class="px-4 py-5 mb-4 text-center" style="background-image: url('../uploads/shows/<?= $show['image']; ?>'); background-size:cover; background-repeat:no-repeat;">
      <h1 class="display-5 fw-bold text-white"><?php echo $show['name']; ?></h1>
      <div class="col-lg-6 mx-auto">
        <p class="lead mb-4 p-2" style="background-color: #fff;"><?php echo $show['description']; ?></p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
          <button type="button" class="btn btn-primary btn-lg px-4 gap-3"><?= _("Support this show"); ?></button>
          <button type="button" class="btn btn-outline-light btn-lg px-4"><?= _("Join the Discord chat"); ?></button>
        </div>
      </div>
    </div>
  <?php }
  $reponse->closeCursor(); ?>
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h3 class="widgetTitle"><?= _("Last episodes"); ?></h3>
        <?php
        $reponse = $db_conx_rdj->query("SELECT songs.title, songs.artist, songs.associated_artists, songs.path, " . PREFIX . "_subcategory_info.image
FROM songs
LEFT JOIN " . PREFIX . "_subcategory_info ON " . PREFIX . "_subcategory_info.subcategory_id = songs.id_subcat
WHERE id_subcat = " . $id . " ORDER BY title DESC LIMIT 20;");
        if ($reponse->rowCount() > 0) {
          while ($show = $reponse->fetch()) {
            $accents = ["&", "è"];
            $lettre = ["&amp", "e"];
            $showArtist = str_replace($accents, $lettre, (string) $show['artist']);
            $showTrack = str_replace($accents, $lettre, (string) $show['title']);

            // N'oubliez pas d'uploader vos fichiers mp3 sur votre serveur web!  
            $path = $show['path'];
            $getStreamURL = str_replace(LOCAL_PODCASTS_FOLDER, REMOTE_PODCASTS_FOLDER, (string) $path);
        ?>
            <div class="card mb-3" style="max-width: 100%">
              <div class="row g-0">
                <div class="col-md-3">
                  <img src="../uploads/shows/<?php echo $show['image']; ?>" class="img-fluid rounded-start" alt="..." width="200" height="200">
                </div>
                <div class="col-md-8">
                  <div class="card-body">
                    <h5 class="card-title"><?php Texter::cutText($showTrack, 30); ?></h5>
                    <p class="card-text">
                      <?php if (!empty($show['associated_artists'])) {
                        echo "Invité.e.s: " . $show['associated_artists'] . "";
                      } else {
                        echo _("No guest.s for this show.");
                      } ?></p>
                    <audio class="js-player">
                      <source src="<?= $getStreamURL; ?>" />
                    </audio>
                  </div>
                </div>
              </div>
            </div>
        <?php
          }
          $reponse->closeCursor(); // Termine le traitement de la requête
        } else {
          echo _("No episodes for this show.");
        }
        ?>
      </div>
      <div class="col-lg-4">
        <h4 class="widgetTitle"><?= _('Show Informations'); ?></h4>
        <?php
        $reponse = $db_conx_rdj->query("SELECT " . PREFIX . "_subcategory_info.*, subcategory.* 
FROM " . PREFIX . "_subcategory_info 
LEFT JOIN subcategory ON subcategory.ID = " . PREFIX . "_subcategory_info.subcategory_id 
WHERE subcategory_id = " . $id . " LIMIT 1");
        while ($show = $reponse->fetch()) { ?>
          <?php
          // Get the day from the database
          $day = $show['scheduleDay'];
          $timestamp = strtotime("next $day");
          $timestamp = strtotime('+1 week', $timestamp);
          $next_day = date('Y-m-d', $timestamp);
          if (!empty($show['scheduleDay'])) {
            echo _('Next episode:') . " " . $next_day . "<br>"
              . _("Hosted by:") . " " . $show['curator'] . "<br>"
              . _("All") . " " . DateFormater::convertDate($show['scheduleDay'], 'l', 'french', false, false) . "s, " . $show['scheduleTime'] .
              " " . $lang["timezone"];
          } else {
            echo _("No longer online.");
          } ?>
          <hr>
        <?php }
        $reponse->closeCursor(); ?>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div>
</section>