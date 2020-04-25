<?php

namespace core\repositories;

use core\entities\Apple\Apple;

class AppleRepository
{

    public function get($id): Apple
    {
        return $this->getBy(['id' => $id]);
    }

    public function save(Apple $apple): void
    {
        if (!$apple->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Apple $apple): void
    {
        if (!$apple->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function removeAll(): void
    {
        $models = Apple::find()->all();
        foreach ($models as $model) {
            $model->delete();
        }
    }

    private function getBy(array $condition): Apple
    {
        if (!$apple = Apple::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('Apple not found.');
        }
        return $apple;
    }
}