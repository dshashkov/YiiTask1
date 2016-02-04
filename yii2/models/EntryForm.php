<?php
/**
 * Created by PhpStorm.
 * User: denshash
 * Date: 02.02.16
 * Time: 17:10
 */
namespace app\models;

use yii\base\Model;

class EntryForm extends Model
{
    public $name;
    public $email;

    public function rules()
    {
        return[
            [['name','email'], 'required'],
            ['email','email']
        ];
    }
}