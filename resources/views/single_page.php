<?php

use App\Classes\Database;
use App\Helpers\shortcodes;

// Get the post ID from the URL
$post_id = $match['params']['id'];
$db = new Database();
$db_conx_rdj = $db->connect();
// Prepare and execute the SELECT query
$stmt = $db_conx_rdj->prepare("SELECT * FROM " . PREFIX . "_posts LEFT JOIN " . PREFIX . "_users ON " . PREFIX . "_posts.posted_by = " . PREFIX . "_users.id LEFT JOIN " . PREFIX . "_categories ON " . PREFIX . "_posts.category_id = " . PREFIX . "_categories.id LEFT JOIN " . PREFIX . "_tags ON " . PREFIX . "_posts.tag_id = " . PREFIX . "_tags.id WHERE " . PREFIX . "_posts.id = :post_id AND " . PREFIX . "_posts.post_type = 2");
$stmt->execute([':post_id' => $post_id]);

// Fetch the result
$post = $stmt->fetch();
?>
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
    </div>
</section>
<?php
// Close the statement
$stmt->closeCursor();

?>