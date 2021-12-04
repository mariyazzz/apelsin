<?php

use app\models\User;
use yii\db\Migration;

class m210109_123000_user extends Migration {
  public function up() {
    $tableOptions = null;
    if ($this->db->driverName === 'mysql') {
      $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    }

    $this->createTable('{{%user}}', [
      'id'                   => $this->bigPrimaryKey()->unsigned(),
      'username'             => $this->string(32),
      'auth_key'             => $this->string(32)->notNull(),
      'access_token'         => $this->string(40)->notNull(),
      'password_hash'        => $this->string()->notNull(),
      'oauth_client'         => $this->string(),
      'oauth_client_user_id' => $this->string(),
      'email'                => $this->string()->notNull(),
      'status'               => $this->smallInteger()->notNull()->defaultValue(User::STATUS_ACTIVE),
      'created_at'           => $this->integer(),
      'updated_at'           => $this->integer(),
      'logged_at'            => $this->integer(),
      'is_deleted'           => $this->boolean()->defaultValue(0),
    ], $tableOptions);

    $this->createTable('{{%user_profile}}', [
      'user_id'  => $this->bigPrimaryKey()->unsigned(),
      'fullname' => $this->string(),
      'locale'   => $this->string(32)->notNull(),
    ], $tableOptions);

    $this->addForeignKey('fk_user', '{{%user_profile}}', 'user_id', '{{%user}}', 'id', 'cascade', 'cascade');

  }

  public function down() {
    $this->dropForeignKey('fk_user', '{{%user_profile}}');
    $this->dropTable('{{%user_profile}}');
    $this->dropTable('{{%user}}');

  }
}
