<?php

namespace App\Classes;

use App\Helpers\DateFormater;
use App\Helpers\Texter;
use \PDO;

class Songs
{
    /**
     * 
     * This function displays the songs on Rewind Radio.
     *
     */
    public static function displaySongs(string $type, string $orderby, int $limit)
    {
        // Connect to the database
        $db = new Database();
        $db_conx_rdj = $db->connect();
        // Select the last played song with song type 0 from the history table
        $query = "SELECT * FROM songs WHERE song_type = ? AND count_played > 0 ORDER BY $orderby DESC LIMIT ?, ?";
        $stmt = $db_conx_rdj->prepare($query);
        $stmt->bindValue(1, 0, PDO::PARAM_INT);
        $stmt->bindValue(2, 1, PDO::PARAM_INT);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->execute();
        // Check if a song was found
        if ($stmt->rowCount() > 0) {
            // Fetch the song
            while ($song = $stmt->fetch()) {
                // Replace some characters in the artist and title
                $accents = ["&", "è"];
                $letters = ["&amp", "e"];
                $show_artist = str_replace($accents, $letters, (string) $song['artist']);
                $show_track = str_replace($accents, $letters, (string) $song['title']);
                $fileName = $song['image'];
                $fileName2 = $song['artist'];
                $fileName2 .= " - ";
                $fileName2 .= $song['title'];
                // Display the song
?>

                <!-- Display the content-->
                <div class="row border-bottom border-3 bg-light p-2">
                    <div class="col-1 d-flex align-items-center mx-4">
                        <?php if ($type = "countdown") {
                            echo DateFormater::giveMetheHour($song['date_played']);
                        } elseif ($type = "lastplay") {
                            echo DateFormater::giveMetheHour($song['date_played']);
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
        } else {
            // No song was found
            echo '<div id="widget" style="padding: 20px;">';
            echo '<div class="bd-callout bd-callout-info">';
            echo '<p>' . _('Nothing found.') . '</p>';
            echo '</div>';
            echo '</div>';
        }
    }
    /**
     * 
     * This function displays the songs on Rewind Radio.
     *
     */
    public static function displaySongsText(string $type, string $orderby, int $limit)
    {
        // Connect to the database
        $db = new Database();
        $db_conx_rdj = $db->connect();
        // Select the last played song with song type 0 from the history table
        $query = "SELECT * FROM songs WHERE song_type = ? AND count_played > 0 ORDER BY $orderby DESC LIMIT ?, ?";
        $stmt = $db_conx_rdj->prepare($query);
        $stmt->bindValue(1, 0, PDO::PARAM_INT);
        $stmt->bindValue(2, 1, PDO::PARAM_INT);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->execute();
        // Check if a song was found
        if ($stmt->rowCount() > 0) {
            // Fetch the song
            while ($song = $stmt->fetch()) {
                // Replace some characters in the artist and title
                $accents = ["&", "è"];
                $letters = ["&amp", "e"];
                $show_artist = str_replace($accents, $letters, (string) $song['artist']);
                $show_track = str_replace($accents, $letters, (string) $song['title']);
                $fileName = $song['image'];
                $fileName2 = $song['artist'];
                $fileName2 .= " - ";
                $fileName2 .= $song['title'];
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
        } else {
            // No song was found
            echo '<div id="widget" style="padding: 20px;">';
            echo '<div class="bd-callout bd-callout-info">';
            echo '<p>' . _('Nothing found.') . '</p>';
            echo '</div>';
            echo '</div>';
        }
    }

    /**
     *
     * Display not already played requests.
     *
     */
    public static function displayRequests()
    {
        $query = "SELECT songs.ID, songs.artist, songs.title, songs.image, requests.username, requests.requested, 
COUNT(*) AS requests FROM songs LEFT JOIN requests ON songs.ID = requests.songID WHERE TIMESTAMPDIFF( DAY, requests.requested, NOW() ) <= 365 AND PLAYED = 0 GROUP BY songs.ID ORDER BY requests DESC LIMIT 0,4";

        $db = new Database();
        $db_conx_rdj = $db->connect();
        $stmt = $db_conx_rdj->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while ($song = $stmt->fetch()) {
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
            $stmt->closeCursor(); // End the query processing
        } else {
            echo '<div id="widget" style="padding: 20px;">
<div class="bd-callout bd-callout-info">
<p>' . _('Nothing found.') . '</p></div>
</div>';
        }
    }

    public static function displayEvents(int $catID)
    {
        $db = new Database();
        $db_conx_rdj = $db->connect();
        $reponse = $db_conx_rdj->query("SELECT * FROM events
LEFT JOIN " . PREFIX . "_events_info ON events.id = " . PREFIX . "_events_info.event_id
WHERE catID=$catID ORDER BY events.time ASC");
        $events = $reponse->fetchAll();
        if ($reponse->rowCount() > 0) {
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
        } else {
            echo '<div id="widget" style="padding: 20px;">
<div class="bd-callout bd-callout-info">
<p>' . _('Nothing found.') . '</p></div>
</div>';
        }
        $reponse->closeCursor();
    }
    public static function displayShows(int $parentID)
    {
        global $router;
        $query = "SELECT * FROM subcategory
JOIN " . PREFIX . "_subcategory_info
ON subcategory.id = " . PREFIX . "_subcategory_info.subcategory_id WHERE subcategory.parentid=$parentID";
        $db = new Database();
        $db_conx_rdj = $db->connect();
        $stmt = $db_conx_rdj->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($show = $stmt->fetch()) {
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
<?php }
            $stmt->closeCursor();
        } else { {
                echo '<div id="widget" style="padding: 20px;">
<div class="bd-callout bd-callout-info">
<p>' . _('Nothing found.') . '</p>
 </div>
</div>';
            }
        }
    }

    /**
     * This function retrieves and displays the schedule for a specified day.
     *
     * @param string $day The day for which to retrieve the schedule.
     */

    public static function getSchedule(string $day, int $catID)
    {
        // Connect to the database
        $db = new Database();
        $db_conx_rdj = $db->connect();

        // Select all events with the specified category and the specified day
        $stmt = $db_conx_rdj->prepare("SELECT * FROM events 
        LEFT JOIN z_events_info ON events.ID = z_events_info.event_id WHERE day = :day AND catID = :catID AND enabled = 1");
        $stmt->bindValue(':catID', $catID);
        $stmt->bindValue(':day', $day);
        $stmt->execute();

        // Check if any events were found
        if ($stmt->rowCount() > 0) {
            $events = $stmt->fetchAll();
            // return $events; // you can return the array of events to see if it's working 
            // Fetch each event
            foreach ($events as $event) {
                // Extract the event hours
                // Display the event
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
        } else {
            echo '<div class="alert alert-info mt-3">' . _('Nothing found.') . '</div>';
        }
    }
}
