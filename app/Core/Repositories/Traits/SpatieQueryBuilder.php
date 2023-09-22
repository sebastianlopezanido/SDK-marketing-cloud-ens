<?php

namespace App\Core\Repositories\Traits;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

trait SpatieQueryBuilder
{
    protected function buildFor(string $model = null)
    {
        $this->queryBuilder = QueryBuilder::for($model ?? $this->model->getMorphClass());

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    private function setBuilder()
    {
        if (is_null($this->queryBuilder)) {
            if (is_null($this->model)) {
                throw new \Exception("Debe setear el modelo para que el paquete spatie pueda funcionar.");
            }

            $this->buildFor();
        }

        return $this;
    }

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    protected function allowedSorts(array $sorts = null)
    {
        $this->setBuilder();

        $this->queryBuilder = $this->queryBuilder->allowedSorts($sorts ?? $this->model->allowed_sorts);

        return $this;
    }

    protected function allowedIncludes(array $includes = null)
    {
        $this->setBuilder();

        $this->queryBuilder = $this->queryBuilder->allowedIncludes($includes ?? $this->model->allowed_includes);

        return $this;
    }

    protected function allowedFilters(array $filters = null)
    {
        $this->setBuilder();

        $this->queryBuilder = $this->queryBuilder->allowedFilters($filters ?? $this->model->allowed_filters);

        return $this;
    }

    protected function allowedAppends(array $appends = null)
    {
        $this->setBuilder();

        $this->queryBuilder = $this->queryBuilder->allowedAppends($appends ?? $this->model->allowed_appends);

        return $this;
    }

    protected function allowedFields(array $fields = null)
    {
        $this->setBuilder();

        $this->queryBuilder = $this->queryBuilder->allowedFields($fields ?? $this->model->allowed_fields);

        return $this;
    }


}