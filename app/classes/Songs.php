<?php

namespace App\Classes;

use App\Helpers\DateFormater;
use App\Helpers\Texter;

class Songs
{
    /**
     *
     * This function displays the songs on Rewind Radio.
     * $orderby maps to the radiodj-api endpoint that already sorts by that
     * column: 'date_played' -> /history, 'count_played' -> /top-tracks.
     *
     */
    public static function displaySongs(string $type, string $orderby, int $limit)
    {
        $songs = self::fetchSongs($orderby, $limit);

        if ($songs === null || count($songs) === 0) {
            ApiClient::emptyWidget();
            return;
        }

        foreach ($songs as $song) {
            // Replace some characters in the artist and title
            $accents = ["&", "è"];
            $letters = ["&amp", "e"];
            $show_artist = str_replace($accents, $letters, (string) $song['artist']);
            $show_track = str_replace($accents, $letters, (string) $song['title']);
            $fileName2 = $song['artist'];
            $fileName2 .= " - ";
            $fileName2 .= $song['title'];
            // Display the song
?>

            <!-- Display the content-->
            <div class="row border-bottom border-3 bg-light p-2">
                <div class="col-1 d-flex align-items-center mx-4">
                    <?php if ($type = "countdown") {
                        DateFormater::giveMetheHour($song['date_played'] ?? '');
                    } elseif ($type = "lastplay") {
                        DateFormater::giveMetheHour($song['date_played'] ?? '');
                    }
                    ?>
                </div>
                <div class="col-2 me-3"><?= Layout::getCoverImage($show_artist, $show_track, $fileName2) ?></div>
                <div class="col-6">
                    <div class='song_title'><?= Texter::cutText($show_artist, 30); ?></div>
                    <div class='song_artist'><?= Texter::cutText($show_track, 40); ?></div>
                </div>
            </div>
        <?php
        }
    }
    /**
     *
     * This function displays the songs on Rewind Radio.
     *
     */
    public static function displaySongsText(string $type, string $orderby, int $limit)
    {
        $songs = self::fetchSongs($orderby, $limit);

        if ($songs === null || count($songs) === 0) {
            ApiClient::emptyWidget();
            return;
        }

        foreach ($songs as $song) {
            // Replace some characters in the artist and title
            $accents = ["&", "è"];
            $letters = ["&amp", "e"];
            $show_artist = str_replace($accents, $letters, (string) $song['artist']);
            $show_track = str_replace($accents, $letters, (string) $song['title']);
            // Display the song
        ?>

            <!-- Display the content-->
            <div class="row border-bottom border-3 bg-light p-2">
                <div class="col-12">
                    <div class='song_title'><?= Texter::cutText($show_artist, 30); ?></div>
                    <div class='song_artist'><?= Texter::cutText($show_track, 40); ?></div>
                </div>
            </div>
        <?php
        }
    }

    /**
     * Fetches songs from the radiodj-api, routing to /history or
     * /top-tracks depending on the requested ordering.
     *
     * @return array|null Null on API failure, array (possibly empty) otherwise.
     */
    private static function fetchSongs(string $orderby, int $limit): ?array
    {
        // LIMIT was previously "OFFSET, COUNT" (LIMIT 1, $limit); the API
        // doesn't support an offset so we ask for one extra row and drop the
        // first one to keep the same "skip the very latest" behavior.
        $apiLimit = min($limit + 1, 50);

        if ($orderby === 'count_played') {
            $data = ApiClient::get('/top-tracks', ['limit' => $apiLimit]);
            $rows = $data['topTracks'] ?? null;
        } else {
            $data = ApiClient::get('/history', ['limit' => $apiLimit]);
            $rows = $data['history'] ?? null;
        }

        if ($rows === null) {
            return null;
        }

        return array_slice($rows, 1, $limit);
    }

    /**
     *
     * Display not already played requests.
     *
     */
    public static function displayRequests()
    {
        $data = ApiClient::get('/requests');
        $songs = $data['requests'] ?? null;

        if ($songs === null || count($songs) === 0) {
            ApiClient::emptyWidget();
            return;
        }

        foreach ($songs as $song) {
            $username = $song['username'];
            $accents = ["&", "è"];
            $letters = ["&amp", "e"];
            $show_artist = str_replace($accents, $letters, (string) $song['artist']);
            $show_track = str_replace($accents, $letters, (string) $song['title']);
            $fileName = $song['image'];
        ?>
            <div class="row border-bottom border-3 bg-light p-2">
                <div class="col-2 mx-3"><?= Layout::getCoverImage($show_artist, $show_track, $fileName) ?></div>
                <div class="col-6">
                    <div class='song_title'><?= Texter::cutText($show_artist, 30); ?></div>
                    <div class='song_artist'><?= Texter::cutText($show_track, 40); ?></div>
                    <div class='song_artist'><?= _("Asked by"); ?><?= Texter::cutText($username, 40); ?></div>
                    <div class='song_artist'><?= _("Asked at"); ?> : <?= $song['requested']; ?></div>
                </div>
            </div>
        <?php
        }
    }

    public static function displayEvents(int $catID)
    {
        $data = ApiClient::get('/events', ['catID' => $catID]);
        $events = $data['events'] ?? null;

        if ($events === null || count($events) === 0) {
            ApiClient::emptyWidget();
            return;
        }

        foreach ($events as $event) {
        ?>
            <div class="row border-bottom border-3 bg-light p-2">
                <div class="col-2 mx-3">
                    <img src="/uploads/events/<?php echo $event['image']; ?>" alt='cover' class='rounded-4 img-cover' width="105" height="105">
                </div>
                <div class="col-5">
                    <div class='song_title'><?php echo $event['name']; ?></div>
                    <div class='song_artist'><?php echo $event['tags']; ?></div>
                    <div class='song_artist'>
                        <?php
                        echo Texter::test_replace($event['day']);
                        echo $event['time'];
                        ?>
                    </div>
                </div>
                <div class="col-lg-3 my-auto"><button class="btn btn-dark"><?= _('Add to my calendar'); ?></button></div>
            </div>
        <?php
        }
    }
    public static function displayShows(int $parentID)
    {
        global $router;

        $data = ApiClient::get('/shows', ['parentID' => $parentID]);
        $shows = $data['shows'] ?? null;

        if ($shows === null || count($shows) === 0) {
            ApiClient::emptyWidget();
            return;
        }

        foreach ($shows as $show) {
            $id = $show['id'];
        ?>

            <div class="row border-bottom-3 bg-light p-2 mb-2" style="background-image: url('/uploads/shows/<?= $show['image']; ?>'); background-position:center; background-size:cover;">
                <h4 class="text-light p-3 text-uppercase fw-bolder"><?= $show['name']; ?></h4>
                <div class="description mb-3 p-2 bg-light text-dark"><?= Texter::cutText($show['description'], 120); ?>
                    <div class="tags m-2 px-3 py-2" style="background-color: #eaeaea;">
                        <i class="bi bi-tags-fill" style="margin-right: 10px;"></i> <?= $show['tags']; ?>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-block">
                    <a class="btn btn-dark" href="<?= $router->generate('single_show', ['id' => $id]); ?>"><?= _("More informations"); ?></a>
                    <a class="btn btn-dark" href="audio/<?= strtolower(str_replace(' ', '_', (string) $show['name'])); ?>/podcasts_rss.php">
                        <?= _("Subscribe to this podcast"); ?></a>
                </div>
            </div>
<?php
        }
    }

    /**
     * This function retrieves and displays the schedule for a specified day.
     *
     * @param string $day The day for which to retrieve the schedule.
     */

    public static function getSchedule(string $day, int $catID)
    {
        $data = ApiClient::get('/events/schedule', ['day' => $day, 'catID' => $catID]);
        $events = $data['schedule'] ?? null;

        if ($events === null || count($events) === 0) {
            echo '<div class="alert alert-info mt-3">' . _('Nothing found.') . '</div>';
            return;
        }

        foreach ($events as $event) {
            echo '
<!-- Schedule Item -->
<div class="">
<div class="">
    <div class="">
        <img src="/uploads/' . $event['image'] . '" alt="' . $event['name'] . '" width="105" height="105">
    </div>
<div class="">
    <div class="timetable-item-time">' . $event['time'] . '</div>
    <div class="timetable-item-title">' . $event['name'] . '</div>
    <div class="timetable-item-desc">
        <p>' . $event['tags'] . '</p>
    </div>
</div>
</div>
 </div>';
        }
    }
}
