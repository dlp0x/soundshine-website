<?php

use App\Classes\ApiClient;
use App\Helpers\Shortcodes;

// Get the post slug from the URL (radiodj-api only exposes posts by slug)
$slug = $match['params']['slug'];
$parsedown = new Parsedown;

$data = ApiClient::get('/blog/' . rawurlencode($slug));
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
    <div class="posts-img" style="background-image: url('../uploads/posts/<?= $post['featured_image']; ?>'); padding-top:15%;">

        <h3 class="text-center post-title"><b><?= $post['title']; ?></b></h3>
    </div>
    <div class="post-meta text-center" style="line-height:5rem;">
        <span style="margin-right:10px;"><i class="bi bi-calendar3"></i><i class="fa-solid fa-calendar-days" style="margin-right: 10px;"></i> <?= $post['date_posted']; ?> </span>
        <span style=""> <i class="bi bi-person-circle"></i></i> <?php if (!empty($post['nice_nickname'])) {
                                                                    echo $post['nice_nickname'];
                                                                } ?>,
            <?= $post['job_title'] ?? ''; ?> </span>
    </div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-10 mx-auto post-content" style="padding:20px;">
                    <?php
                    $content = $post['content'];
                    echo $parsedown->text(Shortcodes::makeShortcode($content));
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
</main>
