<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 13:51.
 */

namespace atsicorp\HetznerCloud\Models\Volumes;

use atsicorp\HetznerCloud\RequestOpts;

class VolumeRequestOpts extends RequestOpts
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
        parent::__construct($perPage, $page, $labelSelector);
        $this->name = $name;
        $this->status = $status;
    }
}
