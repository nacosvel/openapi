<a id="readme-top"></a>

# OpenAPI

A lightweight OpenAPI HTTP kernel built on Guzzle, providing extensible request builders, endpoint chaining, and middleware pipelines.

[![GitHub Tag][GitHub Tag]][GitHub Tag URL]
[![Total Downloads][Total Downloads]][Packagist URL]
[![Packagist Version][Packagist Version]][Packagist URL]
[![Packagist PHP Version Support][Packagist PHP Version Support]][Repository URL]
[![Packagist License][Packagist License]][Repository URL]

<!-- TABLE OF CONTENTS -->
<details>
    <summary>Table of Contents</summary>
    <ol>
        <li><a href="#installation">Installation</a></li>
        <li><a href="#usage">Usage</a></li>
        <li><a href="#contributing">Contributing</a></li>
        <li><a href="#contributors">Contributors</a></li>
        <li><a href="#license">License</a></li>
    </ol>
</details>

<!-- INSTALLATION -->

## Installation

You can install the package via [Composer]:

```bash
composer require nacosvel/openapi
```

<p align="right">[<a href="#readme-top">back to top</a>]</p>

<!-- USAGE EXAMPLES -->

## Usage

### Builder Initialization

```php
use Nacosvel\OpenAPI\Builder;

$instance = Builder::factory([
    'mchid' => '190000****',
], [
    'base_uri' => 'https://httpspot.dev/',
]);
```

### Middleware Registration

```php
use Nacosvel\OpenAPI\Middleware\Middleware;

$instance->addMiddleware([
    new Middleware($builder->getClientDecorator()->getConfig()),
]);
```

### Synchronous Request

```php
$response = $builder->chain('anything/{code}')->get([
    'query' => [
        'id' => 1,
    ],
    'code'  => rand(100000, 999999),
]);

var_dump($response->getBody()->getContents());
```

### Asynchronous Requests

```php
use Psr\Http\Message\ResponseInterface;

$response = $builder->anything->_code_->getAsync([
    'query' => [
        'id' => 1,
    ],
    'code'  => rand(100000, 999999),
])->then(function (ResponseInterface $response) {
    return $response->getBody()->getContents();
})->wait();

var_dump($response);
```

<!-- CONTRIBUTING -->

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">[<a href="#readme-top">back to top</a>]</p>

<!-- CONTRIBUTORS -->

## Contributors

Thanks goes to these wonderful people:

<a href="https://github.com/nacosvel/openapi/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=nacosvel/openapi" alt="contrib.rocks image" />
</a>

Contributions of any kind are welcome!

<p align="right">[<a href="#readme-top">back to top</a>]</p>

<!-- LICENSE -->

## License

Distributed under the MIT License (MIT). Please see [License File] for more information.

<p align="right">[<a href="#readme-top">back to top</a>]</p>

[GitHub Tag]: https://img.shields.io/github/v/tag/nacosvel/openapi

[Total Downloads]: https://img.shields.io/packagist/dt/nacosvel/openapi?style=flat-square

[Packagist Version]: https://img.shields.io/packagist/v/nacosvel/openapi

[Packagist PHP Version Support]: https://img.shields.io/packagist/php-v/nacosvel/openapi

[Packagist License]: https://img.shields.io/github/license/nacosvel/openapi

[GitHub Tag URL]: https://github.com/nacosvel/openapi/tags

[Packagist URL]: https://packagist.org/packages/nacosvel/openapi

[Repository URL]: https://github.com/nacosvel/openapi

[GitHub Open Issues]: https://github.com/nacosvel/openapi/issues

[Composer]: https://getcomposer.org

[License File]: https://github.com/nacosvel/openapi/blob/main/LICENSE
