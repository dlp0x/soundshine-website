<?php

use App\Classes\Database;
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
                                        $db = new Database();
                                        $db_conx_rdj = $db->connect();
                                        $reponse = $db_conx_rdj->query('SELECT * FROM songs WHERE song_type = 0 AND id_subcat != 18 AND id_subcat != 19 AND id_subcat != 5 AND enabled = 1 ORDER BY count_played DESC LIMIT 40');
                                        if ($reponse->rowCount() > 0) {
                                            $i = 1;
                                            while ($donnees = $reponse->fetch()) {
                                        ?>
                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $donnees['title']; ?></td>
                                                    <td><?= $donnees['artist']; ?></td>
                                                    </td>
                                                </tr>

                                        <?php
                                            }
                                            $reponse->closeCursor(); // Termine le traitement de la requête
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