<?php

namespace core\services\manage;


use core\entities\Apple\Apple;
use core\forms\manage\Apple\AppleCreateForm;
use core\forms\manage\Apple\AppleEditForm;
use core\repositories\AppleRepository;

class AppleManageService
{
    private $repository;

    public function __construct(AppleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(): Apple
    {
        $apple = Apple::create();
        $this->repository->save($apple);
        return $apple;
    }

    public function edit($id, AppleEditForm $form): void
    {
        $apple = $this->repository->get($id);
        $apple->edit(
            $form->status,
            $form->size
        );
        $this->repository->save($apple);
    }

    public function remove($id): void
    {
        $apple = $this->repository->get($id);
        $this->repository->remove($apple);
    }

    public function removeAll(): void
    {
        $this->repository->removeAll();
    }
}