<?php

namespace App\Services\Resource;

use App\Services\Resource\DataTable\DataTable;
use App\Services\Resource\Form\Form;
use App\Services\Resource\Navigation\Navigation;

abstract class Resource
{
    /**
     * The associated model for this resource.
     *
     * @var string
     */
    public static $model;

    /**
     * The name of the resource (singular or plural as needed).
     *
     * @var string
     */
    public static $name;

    /**
     * The icon of the resource
     *
     * @var string
     */
    public static $icon;

    /**
     * The route of the resource
     *
     * @var string
     */
    public static $route;

    public function get()
    {
        return [
            'name' => static::$name,
            'icon' => static::$icon,
            'model' => static::$model,
            'route' => static::$route,
            'dataTable' => $this->dataTable(),
            'form' => $this->form(),
            'headers' => $this->navigation()->headers,
            'menus' => $this->navigation()->menus,
        ];
    }

    /**
     * Get the base query builder for the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query()
    {
        if (! isset(static::$model) || ! class_exists(static::$model)) {
            throw new \RuntimeException('Resource model is not defined or invalid.');
        }

        return static::$model::query();
    }

    /**
     * Configure the dataTable for the resource.
     */
    abstract public function dataTable(): DataTable;

    /**
     * Configure the dataTable for the resource.
     */
    abstract public function form(): Form;

    /**
     * Configure the navigation for the resource.
     */
    abstract public function navigation(): Navigation;
}
