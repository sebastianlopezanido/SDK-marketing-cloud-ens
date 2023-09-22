<?php

namespace App\Core\Services;

use App\Core\Models\BaseEntity;
use App\Core\Repositories\BaseRepository;
use App\Core\Repositories\BaseRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService implements BaseServiceInterface
{
    /**
     * @var BaseRepositoryInterface
     */
    protected $localRepository;

    /**
     * BaseService constructor.
     * @param BaseRepository|null $localRepository
     */
    public function __construct(BaseRepository $localRepository = null)
    {
        $this->localRepository = $localRepository;
    }

    public function one($id): BaseEntity
    {
        if (isset($this->localRepository)) {
            return $this->localRepository->findByID($id);
        } else {
            return null;
        }
    }

    /**
     * Returns all records.
     * If $take is 0 then brings all records
     * If $paginate is true returns Paginator instance.
     *
     * @param int $take
     * @param bool $paginate
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all($take = 0, $paginate = false)
    {
        return $this->localRepository->getAll($take, $paginate);
    }

    public function listPaginated(
        int $pageSize = 15,
        $sorted = false,
        $sortedBy = '',
        $sortedOrder = '',
        array $where = []
    ): LengthAwarePaginator
    {
        if (isset($this->localRepository)) {
            $result = $this->localRepository->getModel();
            $result = $result->where($where);
            if ($sorted) {
                if ($this->verifySortField($sortedBy)) {
                    $result = $result->orderBy($sortedBy, $sortedOrder);
                }
            }
            if ($pageSize == 0) {
                $items = $result->get();
                return new LengthAwarePaginator($items, $items->count(), $items->count(), 1, []);
            } else {
                return $result->paginate($pageSize);
            }
        } else {
            return null;
        }
    }

    public function listPaginatedCustom(
        int $pageSize = 15,
        $sorted = false,
        $sortedBy = '',
        $sortedOrder = '',
        array $where = []
    ): LengthAwarePaginator
    {
        if (isset($this->localRepository)) {
            $result = $this->localRepository->getModel();
            $result = $result->where($where);
            if ($sorted) {
                if ($this->verifySortField($sortedBy)) {
                    $result = $result->orderByRaw("NLSSORT({$sortedBy}, 'NLS_SORT = BINARY_AI') {$sortedOrder}");
                }
            }
            if ($pageSize == 0) {
                $items = $result->get();
                return new LengthAwarePaginator($items, $items->count(), $items->count(), 1, []);
            } else {
                return $result->paginate($pageSize);
            }
        } else {
            return null;
        }
    }

    public function store(array $data): BaseEntity
    {
        if (isset($this->localRepository)) {
            return $this->localRepository->store($data);
        } else {
            return null;
        }
    }

    /**
     * @param string $field
     *
     * @return bool
     */
    public function verifySortField($field): bool
    {
        return in_array($field, $this->getAvailableSortFields());
    }

    public function getAvailableSortFields(): array
    {
        if (isset($this->localRepository)) {
            if ($this->localRepository->getModel()->allowed_sorts) {
                return $this->localRepository->getModel()->allowed_sorts;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public function getAvailableFilterFields(): array
    {
        if (isset($this->localRepository)) {
            if ($this->localRepository->getModel()->allowed_filters) {
                return $this->localRepository->getModel()->allowed_filters;
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

}
