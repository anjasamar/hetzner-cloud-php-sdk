<?php

namespace atsicorp\HetznerCloud\Models\Servers\Types;

use atsicorp\HetznerCloud\RequestOpts;

/**
 * Class ServerRequestOpts.
 */
class ServerTypesRequestOpts extends RequestOpts
{
    /**
     * @var string
     */
    public $name;

    /**
     * RequestOpts constructor.
     *
     * @param  $name
     * @param  $status
     * @param  $perPage
     * @param  $page
     * @param  $labelSelector
     */
    public function __construct(string $name = null, int $perPage = null, int $page = null, string $labelSelector = null)
    {
        $this->name = $name;
        parent::__construct($perPage, $page, $labelSelector);
    }
}
