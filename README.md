Atournayre Fixtures Bundle
================

This bundle helps creating fixtures (with Alice).

## Requirements
Symfony ``6.2.*``

PHP ``>=8.2``

## Install
Use [Composer] to install the package:

### Composer
```shell
composer require atournayre/fixtures-bundle --dev
```
### Register bundle

```php
// config/bundles.php

return [
    // ...
    Hautelook\AliceBundle\HautelookAliceBundle::class => ['dev' => true, 'test' => true],
    Atournayre\Bundle\FixtureBundle\AtournayreFixtureBundle::class => ['dev' => true, 'test' => true],
    // ...
]
```


Features
----------
Command to load fixtures:
```shell
php bin/console fixtures
```

Events:
* BeforeFixturesEvent
* AfterFixturesEvent

Providers: 
* DateTime
* Entity
* Uuid
* Hash password

## Examples
### Fixtures
```yaml
App\Entity\User:
  admin:
    # id: '<uuidV1()>'
    id: '<uuidV4()>'
    # id: '<uuidV6()>'
    # id: '<uuidV7()>'
    # id: '<uuidV8(uuid)>'
    email: 'admin@example.com'
    password: '<hashPassword(super_password)>'
    # The current date with specific time
    dateTime: '<currentDateWithTime(09:10)>'
    # The current date with random hour
    otherDateTime: '<randomHourWithDate()>'
    # A related entity identified by its id
    relatedEntity: '<entity<1, App\Entity\RelatedEntity)>'
    # A related entity identified by its uuid
    otherRelatedEntity: '<entity<b8ecc665-0d81-4a09-8ede-2c23a4355836, App\Entity\RelatedEntity)>'
```

### Events
Documentation : https://symfony.com/doc/current/event_dispatcher.html#defining-event-listeners-with-php-attributes
```php
<?php
namespace App\Listener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Atournayre\Bundle\FixtureBundle\Event\AfterFixturesEvent;

#[AsEventListener]
readonly class AfterFixtureListener
{
    public function __invoke(AfterFixturesEvent $event): void
    {
        // Your code    
    }
}
```

Contribute
----------

Contributions to the package are always welcome!

* Report any bugs or issues you find on the [issue tracker].
* You can grab the source code at the package's [Git repository].

## License
All contents of this package are licensed under the [MIT license].

[Composer]: https://getcomposer.org

[The Community Contributors]: https://github.com/atournayre/fixtures-bundle/graphs/contributors

[issue tracker]: https://github.com/atournayre/fixtures-bundle/issues

[Git repository]: https://github.com/atournayre/fixtures-bundle

[MIT license]: LICENSE
