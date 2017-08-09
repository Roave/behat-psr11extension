# PSR-11 Container extension for Behat

Allows injecting services from a PSR-11-compatibile container in a Behat context.

Created with lots of help from @ciaranmcnulty.

## Usage

First require the extension and dependencies with Composer:

```bash
$ composer require --dev roave/behat-psr11extension
```

First, if you don't already have one, create a file that will be included by the extension that returns a PSR-11
compatible container, for example using `Zend\ServiceManager`:

```php
<?php
declare(strict_types=1);

use Zend\ServiceManager\Config;
use Zend\ServiceManager\ServiceManager;

// Load configuration
$config = require __DIR__ . '/config.php';

// Build container
$container = new ServiceManager();
(new Config($config['dependencies']))->configureServiceManager($container);

// Inject config
$container->setService('config', $config);

return $container;
```

Then enable the extension in `behat.yml`:

```yaml
  extensions:
    Roave\BehatPsrContainer\PsrContainerExtension:
      container: 'config/container.php'
```

Then enable the use of the `psr_container` service container (this is provided by the extension) in your `behat.yml`
suite configuration, for example:

```yaml
default:
  suites:
    my_suite:
      services: "@psr_container"
```

And finally, add the names of any services required by your contexts in `behat.yml`, for example:

```yaml
default:
  suites:
    my_suite:
      services: "@psr_container"
      contexts:
        - MyBehatTestSuite\MyContext:
          - "@Whatever\\Service\\Name"
```

Just for clarity (and hopefully ease of understanding), this would be the equivalent of doing this in plain PHP:

```php
<?php
declare(strict_types=1);

$container = require 'config/container.php';

$context = new \MyBehatTestSuite\MyContext($container->get('Whatever\Service\Name'));
```
