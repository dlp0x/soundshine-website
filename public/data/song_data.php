<?php

date_default_timezone_set('America/Toronto');         //Change this to your time/zone
$datafile = "data/data.txt";                                //How is named the txt file?
$pswd = "khth30n3";                                    //The password set in rdj options

if ((isset($_POST["xpwd"])) && (isset($_POST["title"]))) {
    $xpwd = stripcslashes($_POST["xpwd"]);
    if ($xpwd == $pswd) { //please change the password here and in now playing info plugin!
        $data = stripcslashes($_POST["title"]);

        $Handle = fopen($datafile, 'w');
        fwrite($Handle, "" . $data . "\n");
        fclose($Handle);
    }
} else {
?>
    <div id="main">
        <?php
        $str = file_get_contents($datafile);
        $str = nl2br($str, true); // for XHMTL (in other words <br />). Use false for <br>. i.e $str = nl2br($str, false);
        echo $str;
        ?>
    </div>
<?php
}
?>