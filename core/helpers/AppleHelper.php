<?php

namespace core\helpers;

use core\entities\Apple\Apple;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class AppleHelper
{
    const STATUS_ON_TREE = 0;
    const STATUS_DROP = 1;
    const STATUS_ROTTEN = 2;

    const GREEN = 0;
    const YELLOW = 1;
    const RED = 2;

    public static function statusList(): array
    {
        return [
            Apple::STATUS_ON_TREE => 'Висит на дереве',
            Apple::STATUS_DROP => 'Упало',
            Apple::STATUS_ROTTEN => 'Испорчено',
        ];
    }

    public static function colorList(): array
    {
        return [
            Apple::GREEN => 'Зеленое',
            Apple::YELLOW => 'Желтое',
            Apple::RED => 'Красное',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function colorName($color): string
    {
        return ArrayHelper::getValue(self::colorList(), $color);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Apple::STATUS_ON_TREE:
                $class = 'label label-success';
                break;
            case Apple::STATUS_DROP:
                $class = 'label label-danger';
                break;

            case Apple::STATUS_ROTTEN:
                $class = 'label label-default';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }


    public static function colorLabel($color): string
    {
        switch ($color) {
            case Apple::GREEN:
                $class = 'label label-success';
                break;
            case Apple::RED:
                $class = 'label label-danger';
                break;

            case Apple::YELLOW:
                $class = 'label label-warning';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::colorList(), $color), [
            'class' => $class,
        ]);
    }
}