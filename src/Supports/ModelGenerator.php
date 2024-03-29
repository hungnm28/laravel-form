<?php

namespace Hungnm28\LaravelForm\Supports;

use Illuminate\Database\Eloquent\Model;

class ModelGenerator
{

    public $model;

    private $doctrineTypeMapping = [
        'string' => [
            'enum', 'geometry', 'geometrycollection', 'linestring',
            'polygon', 'multilinestring', 'multipoint', 'multipolygon',
            'point',
        ],
    ];

    protected  $defaultTypeMapping = [
      "json"=>[]
        ,"array"=>[]
    ];

    protected $fieldRulerMapping = [
        "name" => "string"
        , "email" => "email"
        , "password" => "required|min:8"
        , "url" => "url"
        , "slug" => "required|string"
    ];

    public function __construct($name)
    {
        $this->getModel($name);
    }

    public function getFields()
    {
        $columns = $this->getTableColumns();
        $fields = [];
        foreach ($columns as $column) {
            $name = $column->getName();
            $type = $column->getType()->getName();
            $notnull = $column->getNotnull();
            $ruler = "";
            if ($notnull) $ruler = data_get($this->fieldRulerMapping, $name, $ruler);
            $fields[$name] = (object)[
                "name" => $name
                , "label" => $this->formatLabel($name)
                , "type" => $type
                , "notnull" => $notnull
                , "default" =>$column->getDefault()
                , "rule" => $ruler
            ];
        }
        $this->fields = (object)$fields;
        return (object)$fields;
    }

    protected function getTableColumns()
    {
        if (!$this->model->getConnection()->isDoctrineAvailable()) {
            throw new \Exception(
                'You need to require doctrine/dbal: ~2.3 in your own composer.json to get database columns. '
            );
        }

        $table = $this->model->getConnection()->getTablePrefix() . $this->model->getTable();
        /** @var \Doctrine\DBAL\Schema\MySqlSchemaManager $schema */
        $schema = $this->model->getConnection()->getDoctrineSchemaManager();
        // custom mapping the types that doctrine/dbal does not support
        $databasePlatform = $schema->getDatabasePlatform();

        foreach ($this->doctrineTypeMapping as $doctrineType => $dbTypes) {
            foreach ($dbTypes as $dbType) {
                $databasePlatform->registerDoctrineTypeMapping($dbType, $doctrineType);
            }
        }

        $database = null;
        if (strpos($table, '.')) {
            list($database, $table) = explode('.', $table);
        }
        return $schema->listTableColumns($table, $database);
    }

    protected function formatLabel($value)
    {
        return ucfirst(str_replace(['-', '_'], ' ', $value));
    }

    protected function getModel($model)
    {

        if ($model instanceof Model) {
            return $this->model = $model;
        }
        if (class_exists($model) && is_subclass_of($model, Model::class)) {
            return $this->model = new $model();
        }
        $model = "App\\Models\\$model";
        if (class_exists($model) && is_subclass_of($model, Model::class)) {
            return $this->model = new $model();
        }
        throw new \InvalidArgumentException("Invalid model [$model] !");
    }

}
