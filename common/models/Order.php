<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $phone
 * @property string $address
 * @property string $email
 * @property string $notes
 * @property string $status
 *
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord {

  const STATUS_NEW = 'Новый';
  const STATUS_IN_PROGRESS = 'В процессе';
  const STATUS_DONE = 'Обработан';

  public function behaviors() {
    return [
      TimestampBehavior::className(),
    ];
  }

  public static function tableName() {
    return 'order';
  }

  public function rules() {
    return [
      [['phone', 'email'], 'required'],
      [['notes'], 'string'],
      [['phone', 'email'], 'string', 'max' => 255],
      [['email'], 'email'],
    ];
  }

  public function attributeLabels() {
    return [
      'id' => '№',
      'created_at' => 'Создан',
      'updated_at' => 'Обновлен',
      'phone' => 'Телефон',
      'address' => 'Адрес',
      'email' => 'E-mail',
      'notes' => 'Заметка',
      'status' => 'Статус',
    ];
  }

  /** @return \yii\db\ActiveQuery */
  public function getOrderItems() {
    return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
  }

  public function beforeSave($insert) {
    if (parent::beforeSave($insert)) {
      if ($this->isNewRecord) {
        $this->status = self::STATUS_NEW;
      } else {
        $this->status = self::STATUS_DONE;
      }
      return true;
    } else {
      return false;
    }
  }

  public static function getStatuses() {
    return [
      self::STATUS_DONE => 'Обработан',
      self::STATUS_IN_PROGRESS => 'В процессе',
      self::STATUS_NEW => 'Новый',
    ];
  }

  public function sendEmail() {
    return Yii::$app->mailer->compose('order', ['order' => $this])
      ->setTo(Yii::$app->params['adminEmail'])
      ->setFrom(Yii::$app->params['adminEmail'])
      ->setSubject('New order #' . $this->id)
      ->send();
  }

}
