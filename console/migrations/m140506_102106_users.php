<?php

use yii\base\InvalidConfigException;
use yii\db\Migration;
use yii\db\Schema;
use yii\rbac\DbManager;

/** How to setup Users w/ RBAC?

 1. Check this createTable('{{%user}}',[]) for required fields
 2. In /common/config/main.php add User module, authManager and User component.

    'modules' => [
      'user' => [ 'class' => 'common\modules\user\Module', ],
    ],
    'components' => [
      'authManager' => [
        'class' => 'yii\rbac\DbManager',
        'defaultRoles' => [ 'user', 'moder', 'manager', 'admin', 'supersu' ],
      ],
    ],

 3. In /console/controllers/ add RbacController.php
 4. Use the following command: yii migrate
 5. In /backend/config/main.php add following components // And use another session name for frontend

    'user' => [
      'identityClass' => 'common\modules\user\models\User',
      'enableAutoLogin' => true,
    ],
    'session' => [
      'name' => 'BACKENDID',
      'savePath' => __DIR__ . '/../tmp',
    ],

 6. Use the following command: "yii rbac/init 1" for apply roles and make assignment supersu for user id = 1
 7. Ready. Now you can use RBAC via following code:
    If (Yii::$app->user->can('admin')) { … }

 * or

    public function behaviors() {
      return [
        'access' => [
          'class' => AccessControl::className(),
          'rules' => [
            [
              'actions' => ['login', 'error'],
              'allow' => true,
            ],
            [
              'actions' => ['logout', 'index'],
              'allow' => true,
              'roles' => ['@'],
            ],
            [
              'actions' => ['upload', 'index'],
              'allow' => true,
              'roles' => ['@'],
            ],
          ],
        ],
        // ...
      ];
    }

 */


class m140506_102106_users extends Migration {

  protected function getAuthManager() {
    $authManager = Yii::$app->getAuthManager();
    if (!$authManager instanceof DbManager) {
      throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
    }
    return $authManager;
  }

  public function up() {
    $authManager = $this->getAuthManager();
    $this->db = $authManager->db;

    $tableOptions = null;
    if ($this->db->driverName === 'mysql') {
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    }

    $this->createTable($authManager->ruleTable, [
      'name' => Schema::TYPE_STRING . '(64) NOT NULL',
      'data' => Schema::TYPE_TEXT,
      'created_at' => Schema::TYPE_INTEGER,
      'updated_at' => Schema::TYPE_INTEGER,
      'PRIMARY KEY (name)',
    ], $tableOptions);

    $this->createTable($authManager->itemTable, [
      'name' => Schema::TYPE_STRING . '(64) NOT NULL',
      'type' => Schema::TYPE_INTEGER . ' NOT NULL',
      'description' => Schema::TYPE_TEXT,
      'rule_name' => Schema::TYPE_STRING . '(64)',
      'data' => Schema::TYPE_TEXT,
      'created_at' => Schema::TYPE_INTEGER,
      'updated_at' => Schema::TYPE_INTEGER,
      'PRIMARY KEY (name)',
      'FOREIGN KEY (rule_name) REFERENCES ' . $authManager->ruleTable . ' (name) ON DELETE SET NULL ON UPDATE CASCADE',
    ], $tableOptions);

    $this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');

    $this->createTable($authManager->itemChildTable, [
      'parent' => Schema::TYPE_STRING . '(64) NOT NULL',
      'child' => Schema::TYPE_STRING . '(64) NOT NULL',
      'PRIMARY KEY (parent, child)',
      'FOREIGN KEY (parent) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
      'FOREIGN KEY (child) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
    ], $tableOptions);

    $this->createTable($authManager->assignmentTable, [
      'item_name' => Schema::TYPE_STRING . '(64) NOT NULL',
      'user_id' => Schema::TYPE_STRING . '(64) NOT NULL',
      'created_at' => Schema::TYPE_INTEGER,
      'PRIMARY KEY (item_name, user_id)',
      'FOREIGN KEY (item_name) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
    ], $tableOptions);

    $this->createTable('{{%user}}', [
      'id' => Schema::TYPE_PK,
      'username' => Schema::TYPE_STRING . ' NOT NULL',
      'avatar' => Schema::TYPE_STRING . ' NOT NULL',
      'email' => Schema::TYPE_STRING . ' NOT NULL',
      'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
      'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
      'password_reset_token' => Schema::TYPE_STRING,
      'role' => Schema::TYPE_STRING . ' NOT NULL',
      'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
      'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
      'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
    ], $tableOptions);
  }

  public function down() {
    $authManager = $this->getAuthManager();
    $this->db = $authManager->db;
    $this->dropTable($authManager->assignmentTable);
    $this->dropTable($authManager->itemChildTable);
    $this->dropTable($authManager->itemTable);
    $this->dropTable($authManager->ruleTable);
    $this->dropTable('{{%user}}');
    $this->dropTable('{{%messages}}');
  }

}
