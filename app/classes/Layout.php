<?php
/*How to use classes 
RewindRadio\Class::functionName();
*/

namespace App\Classes;

class Layout
{
  /**
   * Displays a player widget with artist and played song information
   * 
   * @return void
   */
  public static function getPlayer()
  {
    echo '
<div class="wdgt_comingSoon">Artist - Played Song</div>
</div> 
<div class="col-12"></div>
';
  }

  /**
   * Displays the site's brand logo or text
   * 
   * @return void
   */

  public static function getBrandLogo()
  {
    echo "<a class='navbar-brand' href='/'>";
    if (LOGO_URL) {
      echo "<img src='" . LOGO_URL . "' width='300' height='75'></a>";
    } else {
      echo '
<a href="/" type="button" class="btn btn-dark">
<span class="badge text-dark" style="background-color:#f19135;">
<i class="bi bi-headphones m-0"></i></span><span style="text-transform: uppercase;font-weight: bold;"> ' . SITE_NAME . '</span>
</a>';
    }
  }

  /**
   * Displays a social media icon with a link
   * 
   * @param string $name The name of the social media platform
   * @param string $url The URL for the social media platform
   * 
   * @return void
   */

  public static function socialIcons(string $name, string $url)
  {
    return "<li class='nav-item ms-4 my-auto'><a class='link-dark' href=" . $url . " target='_blank'><i class='bi bi-" . $name . "'></i></a></li>";
  }

  /**
   * This function gets the cover image for a given artist and track,
   * and displays the image or a placeholder if the image is not available.
   *
   * @param string $showArtist The name of the artist.
   * @param string $showTrack The name of the track.
   */

  public static function getCoverImage($showArtist, $showTrack, $fileName)
  {
    // Define the replacements to be made in the file path
    $replacements = [
      "'" => "",
      "." => "",
      "jpg" => ".jpg",
      " & " => " ",
      "/public" => SITE_URL . "/public/",
      "'", "&#39;"
    ];

    // Build the file path for the cover image
    $imgPath = '/covers/' . $fileName . '.jpg';
    $imgPath = str_replace(array_keys($replacements), array_values($replacements), $imgPath);

    // Check if the cover image file exists
    if (file_exists($imgPath)) {
      // If the file exists, output the image element
      echo "<img src='" . urldecode($imgPath) . "' alt='cover' class='rounded-4 img-cover'>";
    } else {
      // If the file does not exist, build the URL for the Last.fm API request
      $url = "http://ws.audioscrobbler.com/2.0/?method=track.getInfo&api_key=" . LASTFM_APIKEY . "&artist=" . urlencode($showArtist) . "&track=" . urlencode($showTrack) . "";
      $xml = @simplexml_load_file($url);
      // Check if the XML document is not empty and the image element exists
      if (isset($xml->track->album->image[2])) {
        // If the image element exists, output the image element
        echo "<img src='", ((string) $xml->track->album->image[2]), "' alt='cover-lastfm' class='rounded-4 img-cover'>";
        // Check if the cover image file is empty and readable
        if (is_readable($imgPath) && filesize($imgPath) == 0) {
          // If the file is empty and readable, create the file and save the image
          file_put_contents($imgPath, file_get_contents(((string) $xml->track->album->image[2])));
        }
      } else {
        // If the image element does not exist, output the default "no cover" image
        echo "<img src='http://rewind.radio/images/ncover.png' alt='no-cover' class='rounded-4 img-cover'>";
      }
    }
  }
} /* close Layout class */

// }

/* ['no_copyright_txt'] = Créé avec beaucoup de :heart: par noordaStudios. 
Vous penser enlever ces lignes ? Construisez votre site web vous même!
Mais pensez-vous avoir les connaissances et/ou la patience d'apprendre, de développer, d\'haïr et d\'aimer VOTRE script ? 
Bien sûr que vous pouvez prendre celui-ci, le modifier à votre guise, je n'ai absolument rien contre ça, mais de grâce
laissez au moins un brin de reconnaissance au développeur que je suis en laissant cette marque dans le code de votre site web. 
Même pas sur votre page! Juste un petit mot entre développeurs, parce que si vous êtes entrain de lire ça et de le comprendre, 
c'est que vous être doué.e en php/html/css ! Sur ce, merci d'utiliser ce script et merde avec votre projet ! 

/* ['no_copyright_txt'] = Created with lot of :heart: by noordaStudios.
 Do you think to remove theses lines? Build your website yourself!
 But do you think you have the knowledge or the patience to learn, grow, hate and love YOUR script?
 Of course you can take this one, tweak it to your liking, I have absolutely nothing against that, but please
 leave at least a bit of recognition to the developer that I am by leaving this mark in the code of this script.
 Not even on your page! Just a quick note between developers, because if you're reading this and understanding it,
 it means that you are good at php/html/css! With that said, thank you for using this script and good luck with your project!

 -- noordaStudios */