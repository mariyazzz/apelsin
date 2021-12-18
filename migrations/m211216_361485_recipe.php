<?php

use yii\db\Migration;

class m211216_361485_recipe extends Migration {
  public function up() {
    $this->createTable('recipe', [
      'id'         => $this->primaryKey(),
      'user_id'    => $this->bigInteger()->unsigned(),
      'title'      => $this->string(30),
      'photo'      => $this->string(200),
      'calories'   => $this->integer()->unsigned()->defaultValue(0),
      'created_at' => $this->integer(),
      'updated_at' => $this->integer(),
    ]);
    $this->addForeignKey('recipe_user', 'recipe', 'user_id', 'user', 'id', 'SET NULL');
  }

  public function down() {
    $this->dropForeignKey('recipe_user', 'recipe');
    $this->dropTable('recipe');
  }
}
