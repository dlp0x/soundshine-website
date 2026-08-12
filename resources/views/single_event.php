<?php

use App\Classes\ApiClient;
use App\Helpers\Shortcodes;

// NOTE: this view is not currently wired into routes/web.php (no
// 'single_event' route is registered) — it was already unreachable before
// this migration. It also queried the _posts table rather than an events
// table, which looks like a pre-existing bug/leftover. Left functionally
// equivalent (now via the API, by slug) rather than redesigned, since
// re-routing/rebuilding it is outside the scope of issue #1.
$slug = $_GET['slug'] ?? ($_GET['id'] ?? '');

$data = ApiClient::get('/blog/' . rawurlencode((string) $slug));
$post = $data['post'] ?? null;
?>
<?php if ($post === null): ?>
    <div class="container">
        <div class="row">
            <div class="col-10 mx-auto post-content" style="padding:20px;">
                <p><?= _('Nothing found.'); ?></p>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="posts-img" style="background-image: url('/public/uploads/<?= $post['featured_image']; ?>'); padding-top:15%;">
        <h3 class="text-center post-title"><b><?= $post['title']; ?></b></h3>
    </div>
    <div class="post-meta text-center" style="line-height:5rem;">
        <span style="margin-right:10px;"><i class="bi bi-calendar3"></i><i class="fa-solid fa-calendar-days" style="margin-right: 10px;"></i> <?= $post['date_posted']; ?> </span>
        <span style=""> <i class="bi bi-person-circle"></i></i> <?= $post['nice_nickname'] ?? ''; ?>, <?= $post['job_title'] ?? ''; ?> </span>
    </div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-10 mx-auto post-content" style="padding:20px;">
                    <?php
                    $content = $post['content'];
                    echo Shortcodes::makeShortcode($content);
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
