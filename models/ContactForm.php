<?php
namespace app\models;

use yii\base\Model;


class ContactForm extends Model
{
    public $surname;
    public $name;
    public $mail;
    public $tel;
    public $checkboxList;


    public function rules()
{
    return [
        
        [['surname','name', 'checkboxList','tel'], 'required'],
        [['surname','name'], 'string','max' => 30],
        [['mail'],'email'],
        [['tel'], 'string'],
    ['tel', 'match', 'pattern' => '/^(8)(\d{3})[-](\d{3})[-](\d{2})[-](\d{2})/', 'message' => 'Телефона, должно быть в формате 8XXX-XXX-XX-XX'],
       
       
       
       
     
    ];
}



}

