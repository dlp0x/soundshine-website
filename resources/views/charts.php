<?php

use App\Classes\ApiClient;
?>

<section>
    <div class="posts-img" style="background-image: url('uploads/posts/pexels-marlene-leppanen-12529340.jpg'); padding-top:15%;">

        <h3 class="text-center post-title"><b><?= _('Charts'); ?></b></h3>
    </div>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-10 mx-auto" style="padding:20px;">
                    <div class="post-content" style="padding: 20px;">
                        <div class="container">

                            <div class="row">
                                <table class='table table-light table-striped'>
                                    <thead>
                                        <tr>
                                            <th><?= _('Position'); ?></th>
                                            <th><?= _('Title'); ?></th>
                                            <th><?= _('Artists'); ?></th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        // Previously: "song_type = 0 AND id_subcat != 18/19/5", a site-specific
                                        // exclusion list. The API's /top-tracks endpoint instead uses the
                                        // canonical "requestable" subcategory allow-list (30, 35, 38, 39, 40)
                                        // shared with the Discord bot. Documented as an intentional behavior
                                        // change; verify chart coverage still matches expectations.
                                        $data = ApiClient::get('/top-tracks', ['limit' => 40]);
                                        $tracks = $data['topTracks'] ?? null;
                                        if ($tracks !== null && count($tracks) > 0) {
                                            $i = 1;
                                            foreach ($tracks as $donnees) {
                                        ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $donnees['title']; ?></td>
                                                    <td><?= $donnees['artist']; ?></td>
                                                    </td>
                                                </tr>

                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
