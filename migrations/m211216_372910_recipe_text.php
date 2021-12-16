<?php

use yii\db\Migration;

class m211216_372910_recipe_text extends Migration {
  public function up() {
    $this->addColumn('recipe', 'text', $this->text());
  }

  public function down() {
    $this->dropColumn('recipe', 'text');
  }
}
