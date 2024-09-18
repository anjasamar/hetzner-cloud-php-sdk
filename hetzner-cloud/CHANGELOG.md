# Changelog

## 2.5.0 (12.10.2021)

- Upgrade to GitHub-native Dependabot by @dependabot-preview in https://github.com/anjasamar/hetzner-cloud-php-sdk/pull/73
- Fixed error on firewall rule when no port is present by @stefangeorgescu in https://github.com/anjasamar/hetzner-cloud-php-sdk/pull/72
- change test classes prefix namespace to atsicorp\Tests by @masoudniki in https://github.com/anjasamar/hetzner-cloud-php-sdk/pull/74
- Adding "type" const by @ThomasLandauer in https://github.com/anjasamar/hetzner-cloud-php-sdk/pull/78
- Implement `Model::setHttpClient()` by @mutec in https://github.com/anjasamar/hetzner-cloud-php-sdk/pull/80
- Fixing docblock by @ThomasLandauer in https://github.com/anjasamar/hetzner-cloud-php-sdk/pull/76
- Keep Hetzner's snake_case for properties by @ThomasLandauer in https://github.com/anjasamar/hetzner-cloud-php-sdk/pull/75
- [FEATURE] Add firewalls parameter for server by @ayacoo in https://github.com/anjasamar/hetzner-cloud-php-sdk/pull/82
- fixes nullable port by @jprangenbergde in https://github.com/anjasamar/hetzner-cloud-php-sdk/pull/81

## 2.4.0 (12.03.2021)

- Add support for Firewalls

## 2.3.0 (03.02.2021)

- Add support for creating Certificates
- Add support for creating resources with labels
- Allow setting of "null" `$dnsPtr` value on `changeReverseDNS` of FloatingIP & Server, this resets the DNS PTR to the
  default value
- Support PHP 8.0
- Improve Creating Floating IPs

## 2.2.2 (05.10.2020)

**Bugfixes:**

- Wrong Import Path on src/Models/Actions/ActionRequestOpts.php
- Server->createImage did not work correctly when specifying not label

**Notes:**

- Improved code quality with phpstan

## 2.2.1 (22.07.2020)

- Make package requirements less strict
- Bugfix: getByName functions had a wrong return type and failed when a resource was not found by name [#50](https://github.com/anjasamar/hetzner-cloud-php-sdk/issues/50)

## 2.2.0 (22.06.2020)

- Feature: Allow specifying labels on `createImage`
- Feature: Allow creation of Servers with Networks
- Bugfix: The name of ISOs is not set on private ISOs, use the ID instead

## 2.1.0 (04.05.2020)

- Bugfix: Fix wrong Guzzle Client Type on Server, Volume and FloatingIp Model.
- Feature: Allow overriding of Guzzle Client configuration on `atsicorp\HetznerCloud\Clients\GuzzleClient`

## 2.0.1 (29.01.2020)

- Bugfix: Floating IP description which can be null [#36](https://github.com/anjasamar/hetzner-cloud-php-sdk/pull/36)

## 2.0.0 (24.01.2020)

- The `all`-Method on the Models return now every entity of the requested resource. For the old behavior see `list`-Method
- Added `list`-Method which allows a better control over getting many entities
- Added Request Opts for `SSHKey`, `Location`, `Datacenter`, `Image` and `Action`
- Added `Resources` Interface to all Root Resource Clients like `Networks` and implemented all methods
- Added `Resource` Interface to all specific resource clients like `Server` and implemented all methods

- Removed deprecated functions: `Server->changeName()`

## 1.8.2 (11.11.2019)

- Fix wrong pagination Parameter (#29)

## 1.8.1 (21.10.2019)

- Fix labels translation from json to array in `Image`, `Network`, `SSHKey` and `Volume`

## 1.8.0 (18.09.2019)

- Add ability to get `Datacenters`, `FloatingIPs`, `Images`, `Locations` and `ServerTypes` per name (`getByName`)
- Add `name` support to Floating IPs

## 1.7.1 (01.08.2019)

- Add missing `networks()` - method on `HetznerAPIClient`

## 1.7.0 (10.07.2019)

- Add `Networks` support ( `atsicorp\HetznerCloud\Models\Networks\Networks` & `atsicorp\HetznerCloud\Models\Networks\Network`)
- Add `networkZone` property to `atsicorp\HetznerCloud\Models\Locations\Location`

## 1.6.2 (27.05.2019)

- Add `volumes` and `automount` parameters to `atsicorp\HetznerCloud\Models\Servers\Servers` - `createInDatacenter` and `createInLocation`
- Add `created` property to `atsicorp\HetznerCloud\Models\Servers\Server`

## 1.6.1 (27.05.2019)

- Add `automount` and `format` parameters to `atsicorp\HetznerCloud\Models\Volumes\Volumes` - `create`
- Add `created` property to `atsicorp\HetznerCloud\Models\FloatingIps\FloatingIp`
- Improve test coverage
- Add `root_passwort` to response of `atsicorp\HetznerCloud\Models\Servers\Server` - `rebuildFromImage` (https://github.com/anjasamar/hetzner-cloud-php-sdk/issues/17)

## 1.6.0 (08.05.2019)

- Setting the UserAgent is now possible with `atsicorp\HetznerCloud\HetznerAPIClient` - `setUserAgent()`
- Setting the Base URL is now possible with `atsicorp\HetznerCloud\HetznerAPIClient` - `setBaseUrl()`

## 1.5.1 (29.03.2019)

- Fix a bug on the `atsicorp\HetznerCloud\RequestOpts` - `buildQuery()` method

## 1.5.0 (28.03.2019)

- Implement `getByName` method on `atsicorp\HetznerCloud\Models\Servers\Servers` and `atsicorp\HetznerCloud\Models\Volumes\Volumes`.
- Implement `waitUntilCompleted` method on `atsicorp\HetznerCloud\Models\Actions\Action`
- Add `atsicorp\HetznerCloud\Models\Servers\ServerRequestOpts` for better control over the `all`-Method on `atsicorp\HetznerCloud\Models\Servers\Servers`
- Add `atsicorp\HetznerCloud\Models\Volumes\VolumeRequestOpts` for better control over the `all`-Method on `atsicorp\HetznerCloud\Models\Volumes\Volumes`

## 1.4.0 (27.02.2019)

- Implement `metrics` method on `atsicorp\HetznerCloud\Models\Servers\Server` (@paulus7, https://github.com/anjasamar/hetzner-cloud-php-sdk/pull/10)

## 1.3.1 (20.02.2019)

- Fix a error on the update methods.

## 1.3.0 (05.11.2018)

- Add Volumes support (`atsicorp\HetznerCloud\Models\Volumes\Volumes` & `atsicorp\HetznerCloud\Models\Volumes\Volume`)
- Add all API Response headers to every `atsicorp\HetznerCloud\APIResponse`

##### Deprecation

- Deprecate and ignore the `$backup_window` parameter on `atsicorp\HetznerCloud\Models\Server\Server::enableBackups`

## 1.2.0 (06.09.2018)

- Add `httpClient`-Method to `atsicorp\HetznerCloud\HetznerAPIClient`
- Add `labels`-Property to `atsicorp\HetznerCloud\Models\FloatingIp\FloatingIP`
- Add `labels`-Property to `atsicorp\HetznerCloud\Models\Server\Server`
- Add `labels`-Property to `atsicorp\HetznerCloud\Models\Image\Image`
- Add `labels`-Property to `atsicorp\HetznerCloud\Models\SSHKey\SSHKey`
- Add `update`-Method to `\atsicorp\HetznerCloud\Models\FloatingIp\FloatingIp`-Model for easily updateing the server meta data
  ```php
  $floatingIP->update(['description' => 'my-updated-floating-description','labels' => ['Key' => 'value]);
  ```
- Add `update`-Method to `\atsicorp\HetznerCloud\Models\SSHKey\SSHKey`-Model for easily updateing the server meta data
  ```php
  $floatingIP->update(['name' => 'my-updated-sshkey-name','labels' => ['Key' => 'value]);
  ```
- You can now use the `labels`-Key on every `update`-Method, for easily updating the Labels
- Add `atsicorp\HetznerCloud\RequestOpts` - Class for easily customize the request opts. Could be used for filtering with the label selector.
- Add the parameter `$requestOpts` to all `all`-Methods

---

## 1.1.0 (14.08.2018)

- Add `update`-Method to `\atsicorp\HetznerCloud\Models\Servers\Server`-Model for easily updateing the server meta data
  ```php
  $server->update(['name' => 'my-updated-server-name']);
  ```
- Soft Deprecating the `changeName`-Method on `\atsicorp\HetznerCloud\Models\Servers\Server`-Model, please use the `update`-Method now. As of Version 1.5.0 this method will trigger a `Deprecated`
- Rename `ApiResponse` to `APIResponse

---

## 1.0.0 (09.08.2018)

##### Breaking Changes

- _Servers Class_
  The `create` method was split into two different methods `createInLocation` for creating a server in a location and `createInDatacenter`for creating a server in a datacenter

- _All "action" like `Server::powerOn()` methods_ now return an instance of `atsicorp\HetznerCloud\ApiResponse` instead an instance of `atsicorp\HetznerCloud\Models\Actions\Action`. If you want to the the underlying action object just use the value _action_ as parameter of the `getResponsePart` on the `atsicorp\HetznerCloud\ApiResponse` object. Of course you could use _server_ or _wss_url_ as parameter like in the official Hetzner Cloud documentation

- _All resource object constructors_ now require an instance of the internal GuzzleHttpClient `atsicorp\HetznerCloud\Clients\GuzzleClient` if you use the shortcut methods this is done for you.

##### Non Breaking Changes

###### Shortcut methods

The `HetznerApiClient`- object has now a method for every resource, for easily accessing the underlying object.
Instead of

```php
// < v1.0.0
$apiKey = '{InsertApiTokenHere}';

$hetznerClient = new \atsicorp\HetznerCloud\HetznerAPIClient($apiKey);
$serverEndpoint = new  \atsicorp\HetznerCloud\Models\Servers\Servers();
$serverEndpoint->all();
```

you could now do simply

```php
// >= v1.0.0
$apiKey = '{InsertApiTokenHere}';

$hetznerClient = new \atsicorp\HetznerCloud\HetznerAPIClient($apiKey);
$hetznerClient->servers()->all();
```
