<section>
  <?php

  use App\Classes\Database;
  use App\Helpers\Texter;

  $id = $match['params']['id'];
  $query = "SELECT * from " . PREFIX . "_users where id = $id";

  $db = new Database;
  $db_conx_rdj = $db->connect();
  $stmt = $db_conx_rdj->prepare($query);
  $stmt->execute();


  if ($stmt->rowCount() > 0) {
    while ($user = $stmt->fetch()) {
  ?>

      <div class="container">
        <div class="main-body">
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="../uploads/profile/<?= $user['avatar']; ?>" alt="<?= $user['username']; ?>" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4><?= $user['nice_nickname']; ?></h4>
                      <p class="text-secondary mb-1"><?= $user['job_title']; ?></p>
                      <p class="text-secondary mb-3"><?= $user['bio']; ?></p>
                      <button class="btn btn-outline-dark"><?= _("Message me on discord"); ?></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="bi bi-box-arrow-up-right me-2"></i><?= _('Website:'); ?></h6>
                    <span class="text-secondary">https://yoursite.com</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="bi bi-github me-2"></i><?= _('Github:'); ?></h6>
                    <span class="text-secondary"><?= $user['facebook']; ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="bi bi-twitter me-2"></i><?= _('Twitter:'); ?></h6>
                    <span class="text-secondary">@<?= $user['twitter']; ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="bi bi-instagram me-2"></i><?= _('Instagram:'); ?></h6>
                    <span class="text-secondary"><?= $user['instagram']; ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="bi bi-linkedin me-2"></i><?= _('Linkedin:'); ?></h6>
                    <span class="text-secondary"><?= $user['linkedin']; ?></span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-header"><?= _('About the DJ'); ?></div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0"><?= _('Name'); ?></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?= $user['nice_nickname']; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0"><?= _('Email address'); ?></h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?= $user['email']; ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row gutters-sm">
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-header">
                      <i class="bi bi-kanban me-2"></i><?= _('Published Articles'); ?>
                    </div>
                    <div class="card-body">
                      <?php $id = $match['params']['id'];
                      $query = "SELECT " . PREFIX . "_posts.id, " . PREFIX . "_posts.featured_image," . PREFIX . "_posts.date_posted, " . PREFIX . "_posts.title, " . PREFIX . "_posts.content," . PREFIX . "_categories.name as category_name, " . PREFIX . "_tags.name as tag_name, DATE_FORMAT(DATE(date_posted), '%d/%m/%Y') AS clean_date FROM " . PREFIX . "_posts LEFT JOIN " . PREFIX . "_categories ON " . PREFIX . "_posts.category_id = " . PREFIX . "_categories.id LEFT JOIN " . PREFIX . "_tags ON " . PREFIX . "_posts.tag_id = " . PREFIX . "_tags.id WHERE " . PREFIX . "_posts.posted_by = $id AND post_type = 1 ORDER BY " . PREFIX . "_posts.date_posted ASC";

                      $db = new Database;
                      $db_conx_rdj = $db->connect();
                      $stmt = $db_conx_rdj->prepare($query);
                      $stmt->execute();
                      if ($stmt->rowCount() > 0) {
                        while ($user = $stmt->fetch()) {
                      ?>
                          <small>
                            <a style="text-decoration:underline;" href="
                          <?php $id = $user['id'];
                          global $router;
                          echo $router->generate('single_post', ['id' => $id]); ?>">
                              <?= $user['title']; ?></a>
                          </small>
                          <div>
                            <div class="mb-4">
                              <small><?php
                                      Texter::cutText(preg_replace('/\[(.*?)\]/', '', (string) $user['content']), 100) ?></small>
                            </div>
                          </div>
                          <hr>
                      <?php }
                      } else {
                        echo _('Nothing found.');
                      } ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-header">
                      <i class="bi bi-kanban me-2"></i>Project Status
                    </div>
                    <div class="card-body">
                      <small>Web Design</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-dark" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Website Markup</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-dark" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>One Page</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-dark" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Mobile Template</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-dark" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <small>Backend API</small>
                      <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar bg-dark" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php }
    ?>
</section>
<?php /* if (isset($_POST['submit'])) {
// Check if a file was uploaded
if (isset($_FILES['file'])) {
uploadFile($_FILES['file'], ['jpg', 'jpeg', 'png', 'gif'], 'public/uploads/users/');
} else {
echo "No file was selected.";
}
}*/
  } ?>