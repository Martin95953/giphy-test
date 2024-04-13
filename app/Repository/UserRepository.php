<?php

namespace App\Repository;

use App\Models\Gif;
use App\Models\User;

class UserRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function search(array $data): User | null
    {
        return $this->model->where($data)->first();
    }

    public function show($userId): User
    {
        return $this->model->find($userId)->with('gifs')->first();
    }

    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with('gifs')->get();
    }
}
