<?php

namespace App\Classes;

use App\Classes\Database;
use App\Helpers\Shortcodes;
use App\Helpers\Texter;

class Posts
{
  public static function displayNews($limitNews)
  {
    global $router;
    $db = new Database;
    $db_conx_rdj = $db->connect();
    $query = "SELECT " . PREFIX . "_posts.id, " . PREFIX . "_posts.featured_image," . PREFIX . "_posts.posted_by, " . PREFIX . "_posts.date_posted, " . PREFIX . "_posts.title, " . PREFIX . "_posts.content, " . PREFIX . "_users.username, " . PREFIX . "_users.nice_nickname," . PREFIX . "_categories.name as category_name, " . PREFIX . "_tags.name as tag_name,
    DATE_FORMAT(DATE(date_posted), '%d/%m/%Y') AS clean_date FROM " . PREFIX . "_posts
    LEFT JOIN " . PREFIX . "_users ON " . PREFIX . "_posts.posted_by = " . PREFIX . "_users.id 
    LEFT JOIN " . PREFIX . "_categories ON " . PREFIX . "_posts.category_id = " . PREFIX . "_categories.id 
    LEFT JOIN " . PREFIX . "_tags ON " . PREFIX . "_posts.tag_id = " . PREFIX . "_tags.id WHERE post_type = 1 AND is_featured = 0 ORDER BY " . PREFIX . "_posts.date_posted DESC LIMIT $limitNews";
    $result = $db_conx_rdj->query($query);
    if ($result->rowCount() > 0) {
      while ($row = $result->fetch()) {
        $id = $row['id'];
        $posted_by = $row['posted_by'];
?>

        <!-- Display the articles -->
        <div class="row border-bottom border-3 bg-light p-2">
          <div class="col-2 mx-3">
            <a href="<?= $router->generate('single_post', ['id' => $id]); ?>">
              <img src="/uploads/posts/<?= $row['featured_image']; ?>" alt="<?= $row['title']; ?>" class="rounded-4 img-cover" width="105" height="105"></a>
          </div>
          <div class="col-9">

            <a href="<?= $router->generate('single_post', ['id' => $id]); ?>" class="title text-uppercase fw-bold">
              <?= $row['clean_date']; ?> -
              <?= Texter::cutText($row['title'], 80);
              $pattern = '/\*{1,2}|#{1,6}|[_`~]{1,2}/';
              ?> </a>

            <div class='artist'><?= preg_replace($pattern, '', Texter::cutText(Shortcodes::removeShortcodes($row['content']), 100)); ?></div>
            <div class="meta">
              <?= _('Posted by'); ?><a href="<?= $router->generate('profile', ['id' => $posted_by]); ?>">
                <?php if (isset($row['nice_nickname'])) {
                  echo $row['nice_nickname'];
                } else {
                  echo $row['username'];
                } ?></a>
            </div>
          </div>
        </div>
      <?php }
    } else {
      echo '<div id="widget" style="padding: 20px;">
<div class="bd-callout bd-callout-info">
 <p>Pas d\'articles.</p>
</div>
</div>';
    }
  }
  public static function displayMegaNews($limitNews)
  {

    global $router;
    $db = new Database();
    $db_conx_rdj = $db->connect();

    $query = "SELECT " . PREFIX . "_posts.id, " . PREFIX . "_posts.featured_image," . PREFIX . "_posts.posted_by, " . PREFIX . "_posts.date_posted, " . PREFIX . "_posts.title, " . PREFIX . "_posts.content, " . PREFIX . "_users.username, " . PREFIX . "_users.nice_nickname," . PREFIX . "_categories.name as category_name, " . PREFIX . "_tags.name as tag_name,
    DATE_FORMAT(DATE(date_posted), '%d/%m/%Y') AS clean_date FROM " . PREFIX . "_posts
    LEFT JOIN " . PREFIX . "_users ON " . PREFIX . "_posts.posted_by = " . PREFIX . "_users.id 
    LEFT JOIN " . PREFIX . "_categories ON " . PREFIX . "_posts.category_id = " . PREFIX . "_categories.id 
    LEFT JOIN " . PREFIX . "_tags ON " . PREFIX . "_posts.tag_id = " . PREFIX . "_tags.id WHERE post_type = 1 AND is_featured = 0 ORDER BY " . PREFIX . "_posts.date_posted DESC LIMIT $limitNews";
    $result = $db_conx_rdj->query($query);
    if ($result->rowCount() > 0) {
      while ($row = $result->fetch()) {
        $id = $row['id'];
        $posted_by = $row['posted_by']; ?>
        <!-- Display the articles -->
        <div class="card" style="width: 25rem;">
          <a href="<?= $router->generate('single_post', ['id' => $id]); ?>">
            <img src="/uploads/posts/<?= $row['featured_image']; ?>" alt="<?= $row['title']; ?>" class="card-img-top" height="200"></a>
          <div class="card-body">
            <h5 class="card-title"><a href="<?= $router->generate('single_post', ['id' => $id]); ?>"><?= Texter::cutText($row['title'], 80) ?></a></span></h5>
            <p class="card-text"><?= Texter::cutText(shortcodes::removeShortcodes($row['content']), 80); ?></p>
          </div>
          <div class="card-footer">
            <?= _('Posted by'); ?><a href="<?= $router->generate('profile', ['id' => $posted_by]); ?>">
              <?php if (isset($row['nice_nickname'])) {
                echo $row['nice_nickname'];
              } else {
                echo $row['username'];
              } ?></a>
          </div>
        </div>

<?php }
    } else {
      echo '<div id="widget" style="padding: 20px;">
      <div class="bd-callout bd-callout-info">
      <p>Pas d\'articles.</p>
      </div>
      </div>';
    }
  }
}
