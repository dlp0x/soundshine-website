<section>
  <?php

  use App\Classes\ApiClient;
  use App\Helpers\Texter;

  $id = (int) $match['params']['id'];

  $data = ApiClient::get('/team/' . $id);
  $user = $data['member'] ?? null;
  $posts = $data['posts'] ?? [];

  if ($user !== null):
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
                    <?php if (count($posts) > 0): ?>
                      <?php foreach ($posts as $post): ?>
                        <small>
                          <a style="text-decoration:underline;" href="
                          <?php
                          global $router;
                          echo $router->generate('single_post', ['slug' => $post['slug']]);
                          ?>">
                            <?= $post['title']; ?></a>
                        </small>
                        <div>
                          <div class="mb-4"></div>
                        </div>
                        <hr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <?= _('Nothing found.'); ?>
                    <?php endif; ?>
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
  <?php else: ?>
    <div class="container">
      <p><?= _('Nothing found.'); ?></p>
    </div>
  <?php endif; ?>
</section>
