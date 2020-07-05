<?php


namespace App\Traits;


/**
 * This trait allows the resource to be detailed at specific times.
 *
 * Trait DetailedResource
 * @package App\Traits
 */
trait DetailedResource
{
    /**
     * @var bool|null
     */
    private $detailed = null;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param bool $detailed
     * @return void
     */
    public function __construct($resource, $detailed = false)
    {
        parent::__construct($resource);
        $this->detailed = $detailed;
    }

    /**
     * Resolve the resource to an array.
     *
     * @param \Illuminate\Http\Request|null $request
     * @return array
     */
    public function resolve($request = null)
    {
        $data = parent::resolve($request);

        if ($this->detailed) {
            $data = $this->details($data);
        }

        return $data;
    }

    /**
     * Sets the additional details of the resource.
     *
     * @param array $data
     * @return array
     */
    private function details(array $data): array
    {
        return $data;
    }
}
