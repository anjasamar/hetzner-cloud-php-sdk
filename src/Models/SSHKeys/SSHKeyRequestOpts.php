<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 13:51.
 */

namespace atsicorp\HetznerCloud\Models\SSHKeys;

use atsicorp\HetznerCloud\RequestOpts;

class SSHKeyRequestOpts extends RequestOpts
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $fingerprint;

    /**
     * RequestOpts constructor.
     *
     * @param  $name
     * @param  $fingerprint
     * @param  $perPage
     * @param  $page
     * @param  $labelSelector
     */
    public function __construct(string $name = null, string $fingerprint = null, int $perPage = null, int $page = null, string $labelSelector = null)
    {
        parent::__construct($perPage, $page, $labelSelector);
        $this->name = $name;
        $this->fingerprint = $fingerprint;
    }
}
