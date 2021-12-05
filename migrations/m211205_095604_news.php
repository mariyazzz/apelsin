<?php

use yii\db\Migration;

class m211205_095604_news extends Migration {
  public function up() {
    $this->createTable('news', [
      'id'         => $this->primaryKey(),
      'user_id'    => $this->integer()->notNull(),
      'text' => $this->text(),
      'title'=> $this->string(30),
      'photo'=> $this->string(200),
      'created_at' => $this->integer(),
      'updated_at' => $this->integer(),
    ]);
  }

  public function down() {
    $this->dropTable('news');
  }
}
