<?php

namespace atsicorp\HetznerCloud\Models\FloatingIps;

use atsicorp\HetznerCloud\RequestOpts;

/**
 * Class FloatingIPRequestOpts.
 */
class FloatingIPRequestOpts extends RequestOpts
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
