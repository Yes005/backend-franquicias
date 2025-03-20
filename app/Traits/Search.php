<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;


/**
 * Trait Search
 * @package App\Traits
 * @version 1.0.0 
 */
trait Search
{

    /**
     * Tipos de relaciones
     * @var array
     */
    private $types = [
        HasMany::class,
        BelongsToMany::class,
        HasOne::class,
        BelongsTo::class
    ];

    /**
     * Operadores permitidos para las columnas
     * @var array
     */
    private $operators = ['CONCAT', 'FORMAT', 'SUM', 'COUNT', 'AVG', 'MAX', 'MIN', 'NOW'];


    /**
     * Obtener la relaciones de un modelo
     * @return Collection
     */
    public function relations(): Collection
    {
        $methods = (new ReflectionClass($this))->getMethods();

        $relations = collect($methods)->map(function ($method) {

            if ($method->class != get_class($this)) return;

            if (in_array($method->getReturnType(), $this->types)) {

                return $method->name;
            }
        });
        return $relations->filter();
    }


    /**
     * Buscar en las columnas de un modelo
     * @param $query
     * @param $search
     * @param $columns
     * @return void
     */
    public  function searchRaw($query, $search, $columns, $returnFalse = false)
    {

        if (count($columns) == 0 && $returnFalse) return $query->whereRaw('1 = 0');

        return $query->where(function ($query) use ($search, $columns) {
            collect($columns)->each(function ($column) use ($query, $search) {
                $query->orWhereRaw("LOWER($column) LIKE ?", ["%" . strtolower($search) . "%"]);
            });
        });
    }


    /**
     * Buscar en las columnas de un modelo
     * @param $query
     * @param $search
     * @param $columns
     * @param $relation
     */
    public function searchWhereHas(
        $query,
        $search,
        $columns,
        $relation,
        $or = false,
        $returnFalse = false
    ) {

        $method = $or ? 'orWhereHas' : 'whereHas';

        return  $query->$method($relation, function ($query) use ($search, $columns, $returnFalse) {
            $this->searchRaw($query, $search, $columns, $returnFalse);
        });
    }

    /**
     * Obtener las columnas de una relación
     * @param $relation
     * @return Collection
     */

    public function relationsColumns($relation)
    {

        $relation = explode('.', $relation);

        $model = $this;

        foreach ($relation as $rel) {
            $model = $model->$rel()->getRelated();
        }

        return collect(Schema::getColumns($model->getTable()))
            ->pluck('name');
    }

    /**
     * Obtener las columnas de un modelo
     * @return Collection
     */
    public function columns()
    {
        return collect(Schema::getColumns($this->getTable()))
            ->pluck('name');
    }


    /**
     * Filtrar las columnas de un modelo
     * @param $columns
     * @param null $related
     * @return array
     */
    public function columnsFilter($columns, $related = null)
    {
        if ($related)
            return $this->operatorsColumns($columns, $this->relationsColumns($related))
                ->toArray();

        return $this->operatorsColumns($columns, $this->columns())->toArray();
    }


    /**
     *  Filtrar las columnas de un modelo si cumplen con las condiciones
     * @param $columns
     * @param $tableColumns
     * @return Collection
     */
    public function operatorsColumns($columns, $tableColumns)
    {
        return collect($columns)->filter(function ($column) use ($tableColumns) {

            $havePermittedChars = collect($this->operators)->contains(function ($char) use ($column) {
                return str_contains($column, $char);
            });

            if ($havePermittedChars || $tableColumns->contains($column)) return $column;
        });
    }
}
