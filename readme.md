# LumenApiGateway

[![Software license][ico-license]](LICENSE)
[![Coveralls](https://coveralls.io/repos/github/triadev/LumenApiGateway/badge.svg?branch=master)](https://coveralls.io/github/triadev/LumenApiGateway?branch=master)
[![CodeCov](https://codecov.io/gh/triadev/LumenApiGateway/branch/master/graph/badge.svg)](https://codecov.io/gh/triadev/LumenApiGateway)
[![Latest stable][ico-version-stable]][link-packagist]
[![Latest development][ico-version-dev]][link-packagist]
[![Monthly installs][ico-downloads-monthly]][link-downloads]
[![Travis][ico-travis]][link-travis]

## Requirements
* PHP >= 7.1

## Installation
>composer create-project triadev/lumen-api-gateway

## Authentication

### Personal-Access-Token
```
1. php artisan passport:client --personal
2. php artisan gateway:personal-access-token:create
```

## Reporting Issues
If you do find an issue, please feel free to report it with GitHub's bug tracker for this project.

Alternatively, fork the project and make a pull request. :)

## Other

### Project related links
- [Wiki](https://github.com/triadev/LumenApiGateway/wiki)
- [Issue tracker](https://github.com/triadev/LumenApiGateway/issues)

### Author
- [Christopher Lorke](mailto:christopher.lorke@gmx.de)

### License
The code for LumenApiGateway is distributed under the terms of the MIT license (see [LICENSE](LICENSE)).

[ico-license]: https://img.shields.io/github/license/triadev/LumenApiGateway.svg?style=flat-square
[ico-version-stable]: https://img.shields.io/packagist/v/triadev/lumen-api-gateway.svg?style=flat-square
[ico-version-dev]: https://img.shields.io/packagist/vpre/triadev/lumen-api-gateway.svg?style=flat-square
[ico-downloads-monthly]: https://img.shields.io/packagist/dm/triadev/lumen-api-gateway.svg?style=flat-square
[ico-travis]: https://travis-ci.org/triadev/LumenApiGateway.svg?branch=master

[link-packagist]: https://packagist.org/packages/triadev/lumen-api-gateway
[link-downloads]: https://packagist.org/packages/triadev/lumen-api-gateway/stats
[link-travis]: https://travis-ci.org/triadev/LumenApiGateway
