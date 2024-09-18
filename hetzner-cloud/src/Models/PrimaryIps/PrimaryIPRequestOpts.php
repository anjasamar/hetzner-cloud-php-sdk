<?php

namespace atsicorp\HetznerCloud\Models\PrimaryIps;

use atsicorp\HetznerCloud\RequestOpts;

/**
 * Class PrimaryIPRequestOpts.
 */
class PrimaryIPRequestOpts extends RequestOpts
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
