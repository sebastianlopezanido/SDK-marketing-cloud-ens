<?php

namespace App\Core\Controller\Traits;

/**
 * Trait Resource
 * @package App\Core\Controller\Traits
 */
trait LaravelResource
{

    /**
     * Laravel Resource Instance
     *
     * @var \Illuminate\Http\Resources\Json\JsonResource
     */
    protected $resource;

    /**
     * Eloquent Model Entity
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Array of scope identifiers for resources to include.
     *
     * @var array
     */
    protected $requestedIncludes = [];

    /**
     * Array of scope identifiers for resources to exclude.
     *
     * @var array
     */
    protected $requestedExcludes = [];

    /**
     * Array of requested fieldsets.
     *
     * @var array
     */
    protected $requestedFieldsets = [];

    /**
     * Array containing modifiers as keys and an array value of params.
     *
     * @var array
     */
    protected $includeParams = [];

    /**
     * Upper limit to how many levels of included data are allowed.
     *
     * @var int
     */
    protected $recursionLimit = 10;

    /**
     * The character used to separate modifier parameters.
     *
     * @var string
     */
    protected $paramDelimiter = '|';

    /**
     * Get Requested Includes.
     *
     * @return array
     */
    public function getRequestedIncludes()
    {
        return $this->requestedIncludes;
    }

    /**
     * Get Requested Excludes.
     *
     * @return array
     */
    public function getRequestedExcludes()
    {
        return $this->requestedExcludes;
    }

    /**
     * Gets the includes on the request for the response.
     *
     * @return self
     */
    protected function setIncludes()
    {
        if (request()->has('include')) {
            $this->parseIncludes(camel_case(request()->input('include')));
        }

        return $this;
    }

    /**
     * Instantiate a laravel resource from a eloquent model instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $modelInstance
     * @param \Illuminate\Http\Resources\Json\JsonResource|null $jsonResource
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    protected function item($modelInstance, $jsonResource = null)
    {
        if (!is_null($jsonResource)) {
            $resource = $jsonResource::make($modelInstance);
        } else {
            $resource = $this->resource::make($modelInstance);
        }

        return $resource;
    }

    /**
     * Create collection using laravel resources as schema for each item.
     *
     * @param $collection
     * @param \Illuminate\Http\Resources\Json\JsonResource|null $jsonResource
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    protected function collection($collection, $jsonResource = null)
    {
        if (is_null($jsonResource)) {
            $resource = $this->resource::collection($collection);
        } else {
            $resource = $jsonResource::collection($collection);
        }
        return $resource;
    }

    private function parseIncludes($includes)
    {
        // Wipe these before we go again
        $this->requestedIncludes = $this->includeParams = [];

        if (is_string($includes)) {
            $includes = explode(',', $includes);
        }

        if (!is_array($includes)) {
            throw new \InvalidArgumentException(
                'The parseIncludes() method expects a string or an array. ' . gettype($includes) . ' given'
            );
        }

        foreach ($includes as $include) {
            list($includeName, $allModifiersStr) = array_pad(explode(':', $include, 2), 2, null);

            // Trim it down to a cool level of recursion
            $includeName = $this->trimToAcceptableRecursionLevel($includeName);

            if (in_array($includeName, $this->requestedIncludes)) {
                continue;
            }
            $this->requestedIncludes[] = $includeName;

            // No Params? Bored
            if ($allModifiersStr === null) {
                continue;
            }

            // Matches multiple instances of 'something(foo|bar|baz)' in the string
            // I guess it ignores : so you could use anything, but probably don't do that
            preg_match_all('/([\w]+)(\(([^\)]+)\))?/', $allModifiersStr, $allModifiersArr);

            // [0] is full matched strings...
            $modifierCount = count($allModifiersArr[0]);

            $modifierArr = [];

            for ($modifierIt = 0; $modifierIt < $modifierCount; $modifierIt++) {
                // [1] is the modifier
                $modifierName = $allModifiersArr[1][$modifierIt];

                // and [3] is delimited params
                $modifierParamStr = $allModifiersArr[3][$modifierIt];

                // Make modifier array key with an array of params as the value
                $modifierArr[$modifierName] = explode($this->paramDelimiter, $modifierParamStr);
            }

            $this->includeParams[$includeName] = $modifierArr;
        }

        // This should be optional and public someday, but without it includes would never show up
        $this->autoIncludeParents();

        return $this;
    }

    /**
     * Auto-include Parents
     *
     * Look at the requested includes and automatically include the parents if they
     * are not explicitly requested. E.g: [foo, bar.baz] becomes [foo, bar, bar.baz]
     *
     * @internal
     *
     * @return void
     */
    protected function autoIncludeParents()
    {
        $parsed = [];

        foreach ($this->requestedIncludes as $include) {
            $nested = explode('.', $include);

            $part = array_shift($nested);
            $parsed[] = $part;

            while (count($nested) > 0) {
                $part .= '.' . array_shift($nested);
                $parsed[] = $part;
            }
        }

        $this->requestedIncludes = array_values(array_unique($parsed));
    }

    /**
     * Trim to Acceptable Recursion Level
     *
     * Strip off any requested resources that are too many levels deep, to avoid DiCaprio being chased
     * by trains or whatever the hell that movie was about.
     *
     * @internal
     *
     * @param string $includeName
     *
     * @return string
     */
    protected function trimToAcceptableRecursionLevel($includeName)
    {
        return implode('.', array_slice(explode('.', $includeName), 0, $this->recursionLimit));
    }
}
