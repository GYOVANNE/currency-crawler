<?php

declare(strict_types=1);

namespace App\Shared\Repository;

use App\Shared\Repository\Contracts\RepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

abstract class RepositoryAbstract implements RepositoryInterface
{
    protected $entity;

    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    protected function resolveEntity()
    {
        if (!method_exists($this, 'entity')) {
            throw new Exception('entity not defined');
        }

        return app()->make($this->entity());
    }

    abstract protected function entity();

    public function all()
    {
        return $this->entity->get();
    }

    public function count()
    {
        return $this->entity->count();
    }

    public function first()
    {
        return $this->entity->first();
    }

    public function find($id)
    {
        $model = $this->getModel($id);

        if (!$model) {
            throw new Exception('model not found');
        }

        return $model;
    }

    protected function getModel($item)
    {
        return ($item instanceof Model) ? $item : $this->entity->find($item);
    }

    public function findWhere($column, $value)
    {
        return $this->entity->where($column, $value)->get();
    }

    public function create(array $properties)
    {
        return $this->entity->create($properties);
    }

    public function update($id, array $properties)
    {
        $this->getModel($id)->update($properties);
        return $this->getModel($id);
    }

    public function delete($id)
    {
        return $this->getModel($id)->delete();
    }

    public function setEntity($entity)
    {
        $this->entity = $entity;
        return $this;
    }

}
