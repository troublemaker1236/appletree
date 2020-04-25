<?php

namespace core\forms\manage\Apple;

use yii\base\Model;

class AppleCreateForm extends Model
{
    public $status;
    public $size;
    public $color;
    public $created_at;


    public function rules(): array
    {
        return [
            ['size', 'integer', 'max' => 100],
        ];
    }
}