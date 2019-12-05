<?php

namespace frontend\models;

use yii\base\Model;

class FormSearchTask extends Model
{
    public $categories = [];
    public $myCity = null;
    public $remoteWork = null;
    public $period = 'all';
    public $searchName = null;

    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'myCity' => 'Мой город',
            'remoteWork' => 'Удаленная работа',
            'period' => 'Период',
            'searchName' => 'Поиск по названию',
        ];
    }

    public function rules()
    {
        return [
            [['categories', 'myCity', 'remoteWork', 'period', 'searchName'], 'safe']
        ];
    }
}
