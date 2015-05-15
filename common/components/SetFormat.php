<?php namespace common\components;

/** How to use?
 * Add "use common\components\Setup;"
 * And use in code "SetFormat::convert($model->created_at, 'datetime')"
 */

class SetFormat {
  const DATETIME_FORMAT = 'php:d-M-y H:i:s';
  const DATE_FORMAT = 'php:d-M-y';
  const TIME_FORMAT = 'php:H:i:s';
  public static function convert($dateStr, $type='date', $format = null) {
    if ($type === 'datetime') {
      $fmt = ($format == null) ? self::DATETIME_FORMAT : $format;
    } elseif ($type === 'time') {
      $fmt = ($format == null) ? self::TIME_FORMAT : $format;
    } else {
      $fmt = ($format == null) ? self::DATE_FORMAT : $format;
    } return \Yii::$app->formatter->asDate($dateStr, $fmt);
  }
}