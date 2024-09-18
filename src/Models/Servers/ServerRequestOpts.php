<?php

namespace atsicorp\HetznerCloud\Models\Servers;

use atsicorp\HetznerCloud\RequestOpts;

/**
 * Class ServerRequestOpts.
 */
class ServerRequestOpts extends RequestOpts
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $status;

    /**
     * RequestOpts constructor.
     *
     * @param  $name
     * @param  $status
     * @param  $perPage
     * @param  $page
     * @param  $labelSelector
     */
    public function __construct(string $name = null, string $status = null, int $perPage = null, int $page = null, string $labelSelector = null)
    {
        $this->name = $name;
        $this->status = $status;
        parent::__construct($perPage, $page, $labelSelector);
    }
}
