<?php

use App\Classes\Songs;
?>
<section>
  <div class="posts-img" style="background-image: url('uploads/posts/pexels-pixabay-164425.jpg'); padding-top:15%;">
    <h3 class="text-center post-title"><b><?= _('Schedule'); ?></b></h3>
  </div>
  <div>
    <div class="container content">
      <div class="row">
        <div class="col-10 mx-auto" style="padding:20px;">
          <div class="post-content" style="padding: 20px; min-height:500px;">
            <div class="container">
              <div class="row">
                <div class="idance">
                  <div class="schedule content-block">
                    <div class="container">
                      <div class="timetable">
                        <nav>
                          <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-link" id="nav-monday-tab" data-bs-toggle="tab" data-bs-target="#nav-monday" type="button" role="tab" aria-controls="nav-monday" aria-selected="true"><?= _('Monday'); ?></a>
                            <a class="nav-link" id="nav-tuesday-tab" data-bs-toggle="tab" data-bs-target="#nav-tuesday" type="button" role="tab" aria-controls="nav-tuesday" aria-selected="true"><?= _('Tuesday'); ?></a>
                            <a class="nav-link" id="nav-wednesday-tab" data-bs-toggle="tab" data-bs-target="#nav-wednesday" type="button" role="tab" aria-controls="nav-wednesday" aria-selected="true"><?= _('Wednesday'); ?></a>
                            <a class="nav-link" id="nav-thursday-tab" data-bs-toggle="tab" data-bs-target="#nav-thursday" type="button" role="tab" aria-controls="nav-thursday" aria-selected="true"><?= _('Tuesday'); ?></a>
                            <a class="nav-link" id="nav-friday-tab" data-bs-toggle="tab" data-bs-target="#nav-friday" type="button" role="tab" aria-controls="nav-friday-" aria-selected="true"><?= _('Friday'); ?></a>
                            <a class="nav-link" id="nav-saturday-tab" data-bs-toggle="tab" data-bs-target="#nav-<?= _('Samedi'); ?>" type="button" role="tab" aria-controls="nav-<?= _('Samedi'); ?>-" aria-selected="true"><?= _('Saturday'); ?></a>
                            <a class="nav-link" id="nav-sunday-tab" data-bs-toggle="tab" data-bs-target="#nav-<?= _('Dimanche'); ?>" type="button" role="tab" aria-controls="nav-<?= _('Dimanche'); ?>-" aria-selected="true"><?= _('Sunday'); ?></a>
                          </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                          <div class="tab-pane fade" id="nav-monday" role="tabpanel" aria-labelledby="nav-monday-tab" tabindex="0">
                            <?= Songs::getSchedule('&1', 98); ?>
                          </div>
                          <div class="tab-pane fade" id="nav-tuesday" role="tabpanel" aria-labelledby="nav-tuesday-tab" tabindex="0">
                            <?= Songs::getSchedule('&2', 98); ?>
                          </div>
                          <div class="tab-pane fade" id="nav-wednesday" role="tabpanel" aria-labelledby="nav-wednesday-tab" tabindex="0">
                            <?= Songs::getSchedule('&3', 98); ?>
                          </div>
                          <div class="tab-pane fade" id="nav-thursday" role="tabpanel" aria-labelledby="nav-thursday-tab" tabindex="0">
                            <?= Songs::getSchedule('&4', 98); ?>
                          </div>
                          <div class="tab-pane fade" id="nav-friday" role="tabpanel" aria-labelledby="nav-friday-tab" tabindex="0">
                            <?= Songs::getSchedule('&5', 98); ?>
                          </div>
                          <div class="tab-pane fade" id="nav-saturday" role="tabpanel" aria-labelledby="nav-saturday-tab" tabindex="0">
                            <?= Songs::getSchedule('&6', 98); ?>
                          </div>
                          <div class="tab-pane fade" id="nav-sunday" role="tabpanel" aria-labelledby="nav-sunday-tab" tabindex="0">
                            <?= Songs::getSchedule('&0', 98); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>