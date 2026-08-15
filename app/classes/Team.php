<?php

namespace App\Classes;

class Team
{
  public static function displayTeam()
  {
    global $router;

    $data = ApiClient::get('/team');
    $team = $data['team'] ?? null;

    if ($team === null || count($team) === 0) {
      ApiClient::emptyWidget();
      return;
    }

    foreach ($team as $row) {
      $id = $row['id']; ?>
      <!-- Team item-->
      <div class="col-xl-3 col-sm-6 mb-5">
        <div class="bg-white rounded shadow-sm py-5 px-4">
          <a href="<?= $router->generate('profile', ['id' => $id]); ?>"><img src="/uploads/profile/<?= $row['avatar']; ?>" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm"></a>
          <h5 class="mb-0"><?= $row['nice_nickname']; ?></h5><span class="small text-uppercase text-muted"><?= $row['job_title']; ?></span>
          <ul class="social mb-0 list-inline mt-3">
            <li class="list-inline-item"><a href="https://www.facebook.com/<?= $row['facebook']; ?>" class="social-link"><i class="bi bi-facebook"></i></i></a></li>
            <li class="list-inline-item"><a href="https://www.twitter.com/<?= $row['twitter']; ?>" class="social-link"><i class="bi bi-twitter"></i></a></li>
            <li class="list-inline-item"><a href="https://instagram.com/<?= $row['instagram']; ?>" class="social-link"><i class="bi bi-instagram"></i></a></li>
            <li class="list-inline-item"><a href="https://linkedin.com/<?= $row['linkedin']; ?>" class="social-link"><i class="bi bi-linkedin"></i></a></li>
          </ul>
        </div>
      </div>

<?php
    }
  }
}
