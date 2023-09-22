<?php

namespace App\Core\Controller\Traits;

trait Paginator
{

    /**
     * Sort the response
     *
     * @var array
     */
    protected $sortResponse = [
        'sort' => false,
        'by' => 'DESC',
        'order' => '',
    ];

    /**
     * Page size on response
     *
     * @var int
     */
    protected $pageSize = 15;

    /**
     * Gets from the request the sort field to use on the response.
     *
     * @return self
     */
    public function sortByRequestCheck()
    {
        if (request()->has('sortBy')) {
            $this->sortResponse['sort'] = true;

            $this->sortResponse['by'] = strtolower(request()->get('sortBy'));

            if (request()->has('sortOrder')) {
                $orderBy = strtoupper(request()->get('sortOrder'));

                $this->sortResponse['order'] = (in_array($orderBy, ['ASC', 'DESC'])) ? $orderBy : 'DESC';
            }
        }
        return $this;
    }

    /**
     * Gets from the request the page size field to use when paginates the response.
     *
     * @return self
     */
    public function pageSizeRequestCheck()
    {
        if (request()->has('pageSize')) {
            if (is_numeric(request()->get('pageSize'))) {
                $this->pageSize = (int)request()->get('pageSize');

                if ($this->pageSize == 1) {
                    $this->pageSize = 2;
                }
            }
        }
        return $this;
    }
}
