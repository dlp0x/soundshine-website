<?php

use App\Classes\Posts as Posts;
use App\Classes\Songs as Songs;

?>

<main style="margin: 120px 0 0 0;">
  <div class="container widget">
    <div class="row">
      <div class="col-lg gx-5">
        <div class="row mt-2">
          <h3 class="p-3"><?= _('news/blogs'); ?></h3>
        </div>
        <?= Posts::displayNews(5) ?>
        <div class="row mt-2">
          <h3 class="p-3"><?= _('Last played songs'); ?></h3>
        </div>
        <?= Songs::displaySongs('lastplayed', 'date_played', 5) ?>
        <div class="row mt-2">
          <h3 class="p-3"><?= _('Top Charts'); ?></h3>
        </div>
        <?= Songs::displaySongs('countdown', 'count_played', 5) ?>
      </div>
      <div class="col-lg-6">
        <div class="row mt-2">
          <h3 class="p-3"><?= _('Requests'); ?></h3>
        </div>
        <?= Songs::displayRequests() ?>
        <div class="row mt-2">
          <h3 class="p-3"><?= _('Shows Live'); ?></h3>
        </div>
        <?= Songs::displayShows(10) ?>
        <div class="row mt-2">
          <h3 class="p-3"><?= _('Events'); ?></h3>
        </div>
        <?= Songs::displayEvents(99); ?>
      </div>
    </div>
  </div>
</main>