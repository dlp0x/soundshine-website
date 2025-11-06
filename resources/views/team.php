<?php

use App\Classes\Team; ?>
<section>
    <div class="posts-img" style="background-image: url('uploads/posts/pexels-george-milton-6954180.jpg'); padding-top:15%;">
        <h3 class="text-center post-title"><b>L'équipe <?= SITE_NAME; ?></b></h3>
    </div>
    <div>
        <div class="container content">
            <div class="row">
                <div class="col-10 mx-auto" style="padding:20px;">
                    <div class="post-content" style="padding: 20px;">
                        <div class="container">

                            <div class="row text-center">
                                <?= Team::displayTeam(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>