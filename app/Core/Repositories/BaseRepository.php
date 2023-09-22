<?php

namespace App\Core\Repositories;

use App\Core\Models\BaseEntity;
use App\Core\Repositories\Traits\SpatieQueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\AbstractPaginator as Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    use SpatieQueryBuilder;

    /**
     * @var BaseEntity
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model|BaseEntity $model
     */
    public function __construct(Model $model)
    {
        $this->setModel($model);
    }

    /**
     * @return Model|BaseEntity
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param Model|BaseEntity $model
     * @return $this
     */
    protected function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @param string $model
     * @return BaseRepository
     */
    protected function model(string $model)
    {
        return $this->setModel(app($model));
    }

    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    protected function newQuery()
    {
        return $this->model->newQuery();
    }

    /**
     * @return EloquentQueryBuilder|QueryBuilder
     */
    protected function newModel()
    {
        $this->allowedFilters();
        return $this->queryBuilder;
    }

    /**
     * @param EloquentQueryBuilder|QueryBuilder $query
     * @param int $take
     * @param bool $paginate
     *
     * @return EloquentCollection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function doQuery($query = null, $take = 15, $paginate = true)
    {
        if (is_null($query)) {
            $query = $this->newQuery();
        }

        if ($paginate) {
            return $query->paginate($take);
        }
        if (is_numeric($take) && $take > 0) {
            $query->take($take);
        }

        return $query->get();
    }

    /**
     * Returns all records.
     * If $take is false then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int $take
     * @param bool $paginate
     *
     * @return EloquentCollection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($take = 15, $paginate = true)
    {
        return $this->doQuery(null, $take, $paginate);
    }

    /**
     * @param string $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists($column, $key = null)
    {
        return $this->newQuery()->lists($column, $key);
    }

    /**
     * Retrieves a record by his id
     * If fail is true $ fires ModelNotFoundException.
     *
     * @param int $id
     * @param bool $fail
     *
     * @return Model
     */
    public function findByID($id, $fail = true)
    {
        if ($fail) {
            return $this->newQuery()->findOrFail($id);
        }
        return $this->newQuery()->find($id);
    }

    /**
     * @param QueryBuilder|\Spatie\QueryBuilder\QueryBuilder $query
     * @param int $pageSize
     * @param bool $sorted
     * @param string $sortBy
     * @param string $sortOrder
     * @param array $sortableFields
     * @return LengthAwarePaginator|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function rawPagination($query,
                                  int $pageSize,
                                  bool $sorted = false,
                                  string $sortBy = '',
                                  string $sortOrder = 'DESC',
                                  array $sortableFields = [])
    {
        // check sort on service and here check if null
        if ($sorted) {
            if (in_array($sortBy, $sortableFields)) {
                $query = $query->orderBy($sortBy, $sortOrder);
            }
        }

        if ($pageSize == 0) {
            $items = $query->get();
            return new LengthAwarePaginator($items, $items->count(), $items->count(), 1, []);
        } else {
            return $query->paginate($pageSize);
        }
    }

    protected function grant_access()
    {
        DB::executeProcedure(config('constants.db.procedures.core_tables_access'), []);
    }
}
