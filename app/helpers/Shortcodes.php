<?php

namespace App\Helpers;

class shortcodes
{

  public static function shortcodeAttrs($text)
  {
    $atts = [];
    $pattern = '/([^\s=]+)\s*=\s*"([^"]+)"(?:\s|$)|([^\s=]+)\s*=\s*"([^"]+)"(?:\s|$)|([^\s=]+)\s*=\s*([^\s""]+)(?:\s|$)|"([^"]+)"(?:\s|$)|(\S+)(?:\s|$)/';
    preg_match_all($pattern, (string) $text, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
      if (!empty($match[1]))
        $atts[strtolower($match[1])] = stripcslashes($match[2]);
      elseif (!empty($match[3]))
        $atts[strtolower($match[3])] = stripcslashes($match[4]);
      elseif (!empty($match[5]))
        $atts[strtolower($match[5])] = stripcslashes($match[6]);
      elseif (isset($match[7]) and strlen($match[7]))
        $atts[] = stripcslashes($match[7]);
      elseif (isset($match[8]))
        $atts[] = stripcslashes($match[8]);
    }
    return $atts;
  }

  public static function makeShortcode($content)
  {
    $shortcodes = ['image' => 'shortcodeImage', 'caption' => 'shortcodeCaption', 'gallery' => 'shortcodeGallery', 'intro' => 'shortcodeIntro', 'blockquote' => 'shortcodeBlockquote', 'youtube' => 'shortcodeYoutube'];

    $pattern = '/\[([^\s\]]+)(.*?)\]/';

    $content = preg_replace_callback($pattern, function ($matches) use ($shortcodes, $content) {
      $tag = $matches[1];
      $atts = shortcodes::shortcodeAttrs($matches[2]);
      $shortcode = $shortcodes[$tag] ?? null;
      if (!$shortcode) return '';
      return call_user_func("App\\Helpers\\shortcodes::$shortcode", $atts, $content);
    }, (string) $content);

    return $content;
  }


  public static function shortcodeImage($atts, $content)
  {
    $url = $atts['url'] ?? '';
    return '<img class="img-single" src="' . $url . '" />';
  }

  public static function shortcodeCaption($atts, $content)
  {
    $text = $atts['text'] ?? '';
    return '<figcaption class="figure-caption text-center">' . $text . '</figcaption>';
  }

  public static function shortcodeGallery($atts, $content)
  {
    $html = '<div class="gallery text-center">';
    foreach ($atts as $url) {
      $html .= '<img class="img-gallery" src="' . $url . '"/>';
    }
    $html .= '</div>';
    return $html;
  }

  public static function shortcodeYoutube($atts, $content)
  {
    $video_id = $atts['id'] ?? '';
    return '<div class="text-center"><iframe style="margin:20px 0 20px 0;" width="560" height="315" src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
  }

  public static function shortcodeIntro($atts, $content)
  {
    $text = $atts['text'] ?? '';
    return '<p style="font-weight:bold;">' . $text . '</p>';
  }

  public static function shortcodeBlockquote($atts, $content)
  {
    $text = $atts['text'] ?? '';
    return '<blockquote> ' . $text . '</blockquote>';
  }

  public static function removeShortcodes($text)
  {
    $pattern = '/\[([^\s\]]+)(.*?)\]/';
    $text = preg_replace($pattern, '', (string) $text);
    return $text;
  }
}
