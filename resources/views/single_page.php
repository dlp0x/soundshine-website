<?php

use App\Classes\ApiClient;
use App\Helpers\Shortcodes;

// Get the page slug from the URL.
// NOTE: this previously read $match['params']['id'], but the route
// (`pages/[*:slug]`) only ever provided a 'slug' param — a pre-existing bug.
// Fixed as part of this migration since it's the same code path.
$slug = $match['params']['slug'];

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
    <div class="posts-img" style="background-image: url('uploads/posts/<?= $post['featured_image']; ?>'); padding-top:15%;">

        <h3 class="text-center post-title"><b><?= $post['title']; ?></b></h3>
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
