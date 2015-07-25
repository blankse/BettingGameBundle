# BettingGameBundle

This bundle provides a betting game for your sport club website.
It extends the eZ Publish CMS to a backend tab. Here you can manage the betting game.

It is very early status of the bundle. There are content types for the frontend planned.

## Functionality

...

## How to install

1. Add to composer
```sh
$ composer require blankse/bettinggamebundle
```

2. Add bundle to kernel (ezpublish/EzPublishKernel.php)
```php
new Blankse\BettingGameBundle\BettingGameBundle(),
```

3. Updating database schema
```sh
$ php ezpublish/console doctrine:schema:update --force
```