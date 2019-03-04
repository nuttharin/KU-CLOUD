<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function create(array $attributes);

    public function update(array $attributes);

    public function all($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc');

    public function find($id);

    public function findOneOrFail($id);

    public function findBy(array $data);

    public function findOneBy(array $data);

    public function findOneByOrFail(array $data);

    public function delete();
}
