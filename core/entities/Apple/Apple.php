<?php

namespace core\entities\Apple;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Apple model
 *
 * Переменные
 * - цвет (устанавливается при создании объекта случайным)
 * - дата появления (устанавливается при создании объекта случайным unixTmeStamp)
 * - дата падения (устанавливается при падении объекта с дерева)
 * - статус (на дереве / упало)
 * - сколько съели (%)
 * - другие необходимые переменные, для определения состояния.
 * Состояния
 * - висит на дереве
 * - упало/лежит на земле
 * - гнилое яблоко
 * @property integer $id
 * @property integer $color
 * @property string $size
 * @property integer $status
 * @property integer $created_at
 * @property integer $drop_at
 *
 *
 */
class Apple extends ActiveRecord
{
    const STATUS_ON_TREE = 0;
    const STATUS_DROP = 1;
    const STATUS_EATEN = 2;
    const STATUS_ROTTEN = 3;


    const GREEN = 0;
    const YELLOW = 1;
    const RED = 2;



    public static function create(): self
    {
        $apple = new Apple();
        $apple->created_at = mt_rand(1, time());
        $apple->status = self::STATUS_ON_TREE;
        $apple->color = rand(0,2);
        return $apple;
    }

    public function edit(int $status, int $size): void
    {
        $this->status = $status;
        $this->size = $size;
    }

    public function isOnTree(): bool
    {
        return $this->status === self::STATUS_ON_TREE;
    }

    public function isDrop(): bool
    {
        return $this->status === self::STATUS_DROP;
    }

    public function isRotten(): bool
    {
        return $this->status === self::STATUS_ROTTEN;
    }

    /**
     * Function for set new size
     *
     * @param string $eat the percent of size
     *
     * @return void
     * @throws \Exception
     */
    function eat(string $eat){
        $newEat = $eat/100;
        $this->canEat($newEat);

        if($newEat>$this->size){
            throw new \Exception('Откусить больше, чем есть - нельзя');
        } else {
            $this->size = $this->size - $newEat;
        }
    }

    /**
     * Check abot eating apple
     *
     * @param string $eat
     * @return bool
     * @throws \Exception
     */
    function canEat(string $eat){

        $this->checkNumeric($eat);
        $this->isBigger($eat);
        $this->isSmaller($eat);

        if($this->isOnTree()){
            throw new \Exception('Висит на дереве, должно упасть');
        }
        if($this->isRotten()){
            throw new \Exception('Испорчено - будет плохо');
        }
        return true;
    }

    /**
     * @param string $eat
     * @throws \Exception
     */
    function checkNumeric (string $eat){
        if(!is_numeric($eat)) {
            throw new \Exception('Укажите число XX');
        }
    }

    /**
     * @param string $eat
     * @throws \Exception
     */
    function isBigger (string $eat) {
        if($eat > 1) {
            throw new \Exception('Указано больше, чем одно яблоко');
        }
    }

    /**
     * @param string $eat
     * @throws \Exception
     */
    function isSmaller (string $eat) {
        if($eat<0) {
            throw new \Exception('Указано меньше, чем можно откусить');
        }
    }
    /**
     * Function for fall To Ground
     *
     * @return void
     */
    function fallToGround(){
        $this->status = self::STATUS_DROP;
    }



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%apples}}';
    }

    public function beforeSave($insert)
    {
        if($this->status==Apple::STATUS_DROP){
            $this->drop_at=time();
        }
        return parent::beforeSave($insert); //
    }

    public function afterFind()
    {
        if($this->status==Apple::STATUS_DROP && time()-$this->drop_at>5*3600){
            $this->status=Apple::STATUS_ROTTEN;
        }
        parent::afterFind();
    }

    /**
     * @inheritdoc
     */


    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }


}