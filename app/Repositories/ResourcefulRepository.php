<?php

namespace App\Repositories;

use App\Contracts\ResourcefulInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ResourcefulRepository implements ResourcefulInterface
{
    protected $model;

    protected $name;

    public function __construct($model)
    {
        $this->model = $model;
        $this->name = strtolower(class_basename($model));
    }

    public function index()
    {
        $model = $this->model::all();
        $trashed_model = $this->model::onlyTrashed()->get();

        return [
            Str::plural($this->name) => $model,
            'trashed_'.Str::plural($this->name) => $trashed_model,
        ];
    }

    public function create()
    {
        return [];
    }

    public function store(FormRequest $request)
    {
        $model = $this->model::create($request->validated());

        return [
            strtolower($this->name) => $model,
        ];
    }

    public function show(Model $model)
    {
        return [
            strtolower($this->name) => $model,
        ];
    }

    public function edit(Model $model)
    {
        return [
            strtolower($this->name) => $model,
        ];
    }

    public function update(FormRequest $request, Model $model)
    {
        $model = $model->update($request->validated());

        return [
            strtolower($this->name) => $model,
        ];
    }

    public function destroy(Model $model)
    {
        return $model->delete();
    }
}
