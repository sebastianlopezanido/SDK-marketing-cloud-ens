<?php

namespace App\Core\Services;

use App\Core\Models\BaseEntity;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseServiceInterface
{
    public function one(int $id): BaseEntity;

    public function listPaginated(int $pageSize, $sorted, $sortedBy, $sortedOrder, array $where): LengthAwarePaginator;

    public function store(array $data): BaseEntity;
}
