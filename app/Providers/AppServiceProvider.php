<?php

namespace App\Providers;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Ramsey\Uuid\Exception\BuilderNotFoundException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        Builder::macro('search', function ($search, $columns, $filter = null, $include = false) {
            /** @var Builder $this */

            if (is_null($search)) {
                return $this;
            }

            $model = $this->getModel();
            $methodsRules = ['searchRaw', 'searchWhereHas', 'relations', 'columnsFilter'];

            $wheres = collect($this->query->wheres);

            if (!collect(get_class_methods($model))
                ->some(fn($method) => in_array($method, $methodsRules)))
                throw new Exception("La tabla {$model->getTable()} necesita el trait Search");

            $relations =  !is_array($filter) ? $model->relations() : collect($filter);


            $query = $this->where(function ($query) use ($search, $columns, $model, $relations) {
                return $model->searchRaw(
                    $query,
                    $search,
                    $model->columnsFilter($columns),
                    $relations->count() == 0
                );
            });

            if ($include) $query->with($relations->toArray());

            if ($relations->count() == 0) return $query;


            $method = $wheres->count() > 0 ? 'where' : 'orWhere';

            $query = $this->$method(function ($query) use ($relations, $model, $search, $columns) {
                $relations->each(
                    fn($relation, $index) => $model->searchWhereHas(
                        $query,
                        $search,
                        $model->columnsFilter($columns, $relation),
                        $relation,
                        $index > 0,
                        true
                    )
                );
            });

            return $query;
        });
    }
}
