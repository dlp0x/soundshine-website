<?php

use App\Classes\ApiClient;
use App\Helpers\DateFormater;
use App\Helpers\Texter;

?>
<section>
  <?php
  $id = (int) $match['params']['id'];
  $data = ApiClient::get('/shows/' . $id);
  $show = $data['show'] ?? null;
  $episodes = $data['episodes'] ?? [];
  ?>
  <?php if ($show === null): ?>
    <div class="container">
      <p><?= _('Nothing found.'); ?></p>
    </div>
  <?php else: ?>
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
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <h3 class="widgetTitle"><?= _("Last episodes"); ?></h3>
          <?php if (count($episodes) > 0): ?>
            <?php foreach ($episodes as $episode):
              $accents = ["&", "è"];
              $lettre = ["&amp", "e"];
              $showArtist = str_replace($accents, $lettre, (string) $episode['artist']);
              $showTrack = str_replace($accents, $lettre, (string) $episode['title']);
            ?>
              <div class="card mb-3" style="max-width: 100%">
                <div class="row g-0">
                  <div class="col-md-3">
                    <img src="../uploads/shows/<?php echo $episode['image']; ?>" class="img-fluid rounded-start" alt="..." width="200" height="200">
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h5 class="card-title"><?php echo Texter::cutText($showTrack, 30); ?></h5>
                      <p class="card-text"><?php DateFormater::giveMetheHour($episode['date_played']); ?></p>
                      <?php
                      // NOTE: the previous version streamed the podcast file directly
                      // (via songs.path + REMOTE_PODCASTS_FOLDER). GET /shows/:id
                      // does not currently expose an audio path or "associated_artists",
                      // so inline playback is temporarily unavailable here pending a
                      // radiodj-api enhancement to include that data. Documented as a
                      // known follow-up in the PR notes.
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <?= _("No episodes for this show."); ?>
          <?php endif; ?>
        </div>
        <div class="col-lg-4">
          <h4 class="widgetTitle"><?= _('Show Informations'); ?></h4>
          <?php
          // NOTE: "curator" / "scheduleDay" / "scheduleTime" are not part of
          // GET /shows/:id yet, so the "Next episode" / "Hosted by" block is
          // temporarily unavailable — see PR notes for the same follow-up.
          echo _("No longer online.");
          ?>
          <hr>
        </div>
      </div>
    </div>
  <?php endif; ?>
</section>
