<?php

namespace app\models;

use app\models\Yii;
use Codeception\Lib\Console\Message;
use yii\base\Model;

class CalculateForm extends Model {
  const ACTIVITY_0 = 0;
  const ACTIVITY_1 = 1;
  const ACTIVITY_2 = 2;
  const ACTIVITY_3 = 3;
  const ACTIVITY_4 = 4;

  public $age;

  public $growth;

  public $weight;

  public $gender;

  public $active_doing;

  public $result;

  public static $coefficient_labels = [
    self::ACTIVITY_0 => 'Сидячий',
    self::ACTIVITY_1 => 'Слегка активный',
    self::ACTIVITY_2 => 'Умеренно активный',
    self::ACTIVITY_3 => 'Очень активный',
    self::ACTIVITY_4 => 'Экстремально активный',
  ];

  private $coefficient = [
    self::ACTIVITY_0 => 1.2,
    self::ACTIVITY_1 => 1.375,
    self::ACTIVITY_2 => 1.55,
    self::ACTIVITY_3 => 1.725,
    self::ACTIVITY_4 => 1.9,
  ];

  public function rules() {
    return [
      [['age', 'growth', 'weight', 'gender', 'gender', 'active_doing'], 'required'],
    ];
  }

  public function calculate() {
    $activity_coefficient = $this->coefficient[$this->active_doing];
    if ($this->gender == 1) { //woman
      $result = (665.1 + 9.563 * $this->weight + 1.85 * $this->growth - 4.676 * $this->age) * $activity_coefficient;
    } else {
      $result = (66.5 + 13.75 * $this->weight + 5.003 * $this->growth - 6.775 * $this->age) * $activity_coefficient;
    }

    $this->result = $result;
  }

}
