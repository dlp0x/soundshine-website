<?php

namespace App\Helpers;

class Texter
{
  public static function cutText($text, $lg_max): string
  {
    if (mb_strlen((string) $text) > $lg_max) {
      $text = mb_substr((string) $text, 0, $lg_max);
      $last_space = mb_strrpos($text, " ");
      $text = mb_substr($text, 0, $last_space) . "...";
    }
    return $text;
  }

  const ACCENTS = [
    "&" => "&amp",
    "è" => "e"
  ];

  public static function replaceAccents(string $str): string
  {
    return str_replace(array_keys(self::ACCENTS), array_values(self::ACCENTS), $str);
  }

  public static function test_replace(string $day): string
  {
    $arrayDays = ['&1', '&2', '&3', '&4', '&5', '&6', '&0'];
    $nameDays = [_("monday") . ' ', _("tuesday") . ' ', _("wednesday") . ' ', _("thursday") . ' ', _("friday") . ' ',  _("saturday") . ' ', _("sunday")];

    return str_replace($arrayDays, $nameDays, $day);
  }

  public static function convertTime($seconds)
  {
    $H = floor($seconds / 3600);
    $i = ($seconds / 60) % 60;
    $s = $seconds % 60;
    return sprintf("%02d:%02d", $i, $s);
  }

  public static function giveMetheHour($hourset)
  {
    $phpdate = strtotime((string) $hourset);
    $mysqldate = date('H:i', $phpdate);
    echo "<span class='timeSet'>" . $mysqldate . "</span>";
  }

  /**
   * This function converts a date to a specified format and language,
   * and displays the day and/or hour in the specified language if specified.
   *
   * @param string $date The date to be converted.
   * @param string $format The desired date format.
   * @param string $language The desired language.
   * @param bool $day Whether to display the day in the specified language.
   * @param bool $hour Whether to display the hour in the specified language.
   */

  public static function convertDate($date, $format, $language, $day, $hour)
  {
    // Check if the language is French
    if ($language == 'french') {
      // Define arrays of English and French days and months
      $english_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
      $french_days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
      $english_months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
      $french_months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];
      // Replace English days and months with French equivalents
      $date = str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date))));
    }

    // Check if the day should be displayed in French
    if ($day) {
      // Define arrays of English and French days
      $english_days = ['&1', '&2', '&3', '&4', '&5', '&6', '&0'];
      $french_days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
      // Replace English days with French equivalents
      $date = str_replace($english_days, $french_days, $date);
    }

    // Check if the hour should be displayed in French
    if ($hour) {
      // Define arrays of English and French hours
      $english_hour = ['&1', '&2', '&3', '&4', '&5', '&6', '&7', '&8', '&9', '&10', '&11', '&12', '&13', '&14', '&15', '&16', '&17', '&18', '&19', '&20', '&21', '&22', '&23', '&00'];
      $french_hour = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '00'];
      // Replace English hours with French equivalents
      $date = str_replace($english_hour, $french_hour, $date);
    }

    // Return the converted date
    return $date;
  }
}// End of Date class