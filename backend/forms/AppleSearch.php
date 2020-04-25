<?php

namespace backend\forms;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\Apple\Apple;

class AppleSearch extends Model
{

    public $id;
    public $color;
    public $size;
    public $status;
    public $created_at;
    public $drop_at;

    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'status'], 'integer'],
            [['color'], 'string']
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Apple::find();
        $count = count(Apple::find()->all());

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $count
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'color' => $this->color,
        ]);

        $query
            ->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}