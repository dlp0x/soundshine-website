<?php

namespace App\Classes;

use App\Helpers\Shortcodes;
use App\Helpers\Texter;

class Posts
{
  /**
   * Fetches published news posts (post_type = 1, not featured) from the
   * radiodj-api /blog endpoint.
   *
   * NOTE: /blog does not accept post_type/is_featured filters, so we
   * over-fetch (bounded by the API's own 50-row cap) and filter client-side
   * to preserve the site's previous "post_type = 1 AND is_featured = 0"
   * behavior. See PR notes for details.
   *
   * @return array|null Null on API failure, filtered+limited array otherwise.
   */
  private static function fetchNews(int $limitNews): ?array
  {
    $apiLimit = min(max($limitNews * 3, $limitNews), 50);
    $data = ApiClient::get('/blog', ['limit' => $apiLimit]);
    $posts = $data['posts'] ?? null;

    if ($posts === null) {
      return null;
    }

    $filtered = array_values(array_filter($posts, function ($post) {
      return (int) ($post['post_type'] ?? 0) === 1 && (int) ($post['is_featured'] ?? 0) === 0;
    }));

    return array_slice($filtered, 0, $limitNews);
  }

  public static function displayNews($limitNews)
  {
    global $router;

    $posts = self::fetchNews((int) $limitNews);

    if ($posts === null || count($posts) === 0) {
      echo '<div id="widget" style="padding: 20px;">
<div class="bd-callout bd-callout-info">
 <p>Pas d\'articles.</p>
</div>
</div>';
      return;
    }

    foreach ($posts as $row) {
      $slug = $row['slug'];
      $cleanDate = !empty($row['date_posted']) ? date('d/m/Y', strtotime((string) $row['date_posted'])) : '';
?>

      <!-- Display the articles -->
      <div class="row border-bottom border-3 bg-light p-2">
        <div class="col-2 mx-3">
          <a href="<?= $router->generate('single_post', ['slug' => $slug]); ?>">
            <img src="/uploads/posts/<?= $row['featured_image']; ?>" alt="<?= $row['title']; ?>" class="rounded-4 img-cover" width="105" height="105"></a>
        </div>
        <div class="col-9">

          <a href="<?= $router->generate('single_post', ['slug' => $slug]); ?>" class="title text-uppercase fw-bold">
            <?= $cleanDate; ?> -
            <?= Texter::cutText($row['title'], 80);
            $pattern = '/\*{1,2}|#{1,6}|[_`~]{1,2}/';
            ?> </a>

          <div class='artist'><?= preg_replace($pattern, '', Texter::cutText(Shortcodes::removeShortcodes($row['content']), 100)); ?></div>
          <div class="meta">
            <?= _('Posted by'); ?>
            <?php if (!empty($row['nice_nickname'])) {
              echo $row['nice_nickname'];
            } else {
              echo $row['nice_nickname'] ?? '';
            } ?>
          </div>
        </div>
      </div>
    <?php }
  }
  public static function displayMegaNews($limitNews)
  {
    global $router;

    $posts = self::fetchNews((int) $limitNews);

    if ($posts === null || count($posts) === 0) {
      echo '<div id="widget" style="padding: 20px;">
      <div class="bd-callout bd-callout-info">
      <p>Pas d\'articles.</p>
      </div>
      </div>';
      return;
    }

    foreach ($posts as $row) {
      $slug = $row['slug']; ?>
      <!-- Display the articles -->
      <div class="card" style="width: 25rem;">
        <a href="<?= $router->generate('single_post', ['slug' => $slug]); ?>">
          <img src="/uploads/posts/<?= $row['featured_image']; ?>" alt="<?= $row['title']; ?>" class="card-img-top" height="200"></a>
        <div class="card-body">
          <h5 class="card-title"><a href="<?= $router->generate('single_post', ['slug' => $slug]); ?>"><?= Texter::cutText($row['title'], 80) ?></a></span></h5>
          <p class="card-text"><?= Texter::cutText(Shortcodes::removeShortcodes($row['content']), 80); ?></p>
        </div>
        <div class="card-footer">
          <?= _('Posted by'); ?>
          <?php if (!empty($row['nice_nickname'])) {
            echo $row['nice_nickname'];
          } ?>
        </div>
      </div>

<?php }
  }
}
