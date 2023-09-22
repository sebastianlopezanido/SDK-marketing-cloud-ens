<?php

namespace App\Core\Controller;

use App\Core\Controller\Traits\CommonResponse;
use App\Core\Controller\Traits\Error;
use App\Core\Controller\Traits\LaravelResource;
use App\Core\Controller\Traits\LaravelResponse;
use App\Core\Controller\Traits\Meta;
use App\Core\Controller\Traits\Paginator;
use App\Core\Controller\Traits\Response;
use App\Http\Controllers\Controller;

/**
 * Class BaseController
 * @property $transformer
 * @property $fractal
 * @package App\Core
 */
abstract class BaseController extends Controller
{
    use CommonResponse, Error, LaravelResource, LaravelResponse, Meta, Paginator, Response;

    /**
     * BaseController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        // set the requested includes
        $this->setIncludes();

        // set the requested sort field
        $this->sortByRequestCheck();

        // set the requested page size and number
        $this->pageSizeRequestCheck();
    }
}
