<?php

namespace core\forms\manage\Apple;

use core\entities\Apple\Apple;
use yii\base\Model;

class AppleEditForm extends Model
{
    public $status;
    public $size;
    public $color;


    public function __construct(Apple $apple, $config = [])
    {
        $this->status = $apple->status;
        $this->size = $apple->size;
        $this->color = $apple->color;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['size', 'integer', 'max' => 100],
        ];
    }
}