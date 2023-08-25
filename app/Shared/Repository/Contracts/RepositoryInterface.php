<?php

declare(strict_types=1);

namespace App\Shared\Repository\Contracts;

interface RepositoryInterface
{
    public function all();

    public function find($id);

    public function findWhere($column, $value);

    public function create(array $properties);

    public function update($id, array $properties);

    public function delete($id);
}
