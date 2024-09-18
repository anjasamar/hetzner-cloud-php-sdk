<?php

/**
 * Created by PhpStorm.
 * User: Anjas Amar Pradana
 * Date: 18.09.24
 * Time: 20:40.
 */

namespace atsicorp\Tests\Unit;

use GuzzleHttp\Client;
use atsicorp\HetznerCloud\HetznerAPIClient;
use atsicorp\HetznerCloud\Models\Actions\Actions;
use atsicorp\HetznerCloud\Models\Datacenters\Datacenters;
use atsicorp\HetznerCloud\Models\Firewalls\Firewalls;
use atsicorp\HetznerCloud\Models\FloatingIps\FloatingIps;
use atsicorp\HetznerCloud\Models\Images\Images;
use atsicorp\HetznerCloud\Models\LoadBalancers\LoadBalancers;
use atsicorp\HetznerCloud\Models\LoadBalancerTypes\LoadBalancerTypes;
use atsicorp\HetznerCloud\Models\Locations\Locations;
use atsicorp\HetznerCloud\Models\Networks\Networks;
use atsicorp\HetznerCloud\Models\Prices\Prices;
use atsicorp\HetznerCloud\Models\PrimaryIps\PrimaryIps;
use atsicorp\HetznerCloud\Models\Servers\Servers;
use atsicorp\HetznerCloud\Models\Servers\Types\ServerTypes;
use atsicorp\HetznerCloud\Models\SSHKeys\SSHKeys;
use atsicorp\HetznerCloud\Models\Volumes\Volumes;
use atsicorp\Tests\TestCase;

/**
 * Class BasicClientTest.
 */
class BasicClientTest extends TestCase
{
    public function testGetApiToken()
    {
        $token = 'IAmTheTestToken';
        $client = new HetznerAPIClient($token);
        $this->assertEquals($token, $client->getApiToken());
    }

    public function testSetBaseUrl()
    {
        $baseUrl = 'https://api.hetzner.cloud/v1/';
        $client = new HetznerAPIClient('IAmTheTestToken', $baseUrl);
        $this->assertEquals($baseUrl, $client->getBaseUrl());
        $client->setBaseUrl('changed');
        $this->assertEquals('changed', $client->getBaseUrl());
    }

    public function testSetUserAgent()
    {
        $userAgent = 'UserAgent';
        $client = new HetznerAPIClient('IAmTheTestToken', '', $userAgent);
        $this->assertEquals($userAgent, $client->getUserAgent());
        $client->setUserAgent('changed');
        $this->assertEquals('changed', $client->getUserAgent());
    }

    public function testSetHttpClient()
    {
        $client = new HetznerAPIClient('IAmTheTestToken', '');
        $httpClient = new Client();
        $client->setHttpClient($httpClient);
        $this->assertEquals($httpClient, $client->getHttpClient());
    }

    public function testMethodsReturnCorrectInstance()
    {
        $this->assertInstanceOf(Actions::class, $this->hetznerApi->actions());
        $this->assertInstanceOf(Servers::class, $this->hetznerApi->servers());
        $this->assertInstanceOf(ServerTypes::class, $this->hetznerApi->serverTypes());
        $this->assertInstanceOf(Images::class, $this->hetznerApi->images());
        $this->assertInstanceOf(Prices::class, $this->hetznerApi->prices());
        $this->assertInstanceOf(Locations::class, $this->hetznerApi->locations());
        $this->assertInstanceOf(Datacenters::class, $this->hetznerApi->datacenters());
        $this->assertInstanceOf(FloatingIps::class, $this->hetznerApi->floatingIps());
        $this->assertInstanceOf(PrimaryIps::class, $this->hetznerApi->primaryIps());
        $this->assertInstanceOf(SSHKeys::class, $this->hetznerApi->sshKeys());
        $this->assertInstanceOf(Volumes::class, $this->hetznerApi->volumes());
        $this->assertInstanceOf(Networks::class, $this->hetznerApi->networks());
        $this->assertInstanceOf(Firewalls::class, $this->hetznerApi->firewalls());
        $this->assertInstanceOf(LoadBalancers::class, $this->hetznerApi->loadBalancers());
        $this->assertInstanceOf(LoadBalancerTypes::class, $this->hetznerApi->loadBalancerTypes());
    }
}
