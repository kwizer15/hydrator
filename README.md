# Hydrator

A simple hydrator without mapping.

## Why

Hydrate an instance simply with a data source.

## How

Instantiate the hydrator and call the hydrate method with the object to hydrate and the data source

```php
class MyClass
{
    private $foo;
}

$myDatas = ['foo' => 'bar'];
$hydrator = new \Kwizer\Hydrator\Hydrator();
$myObject = $hydrator->hydrate(MyClass::class, $myDatas);
```

You can directly hydrate an object already instantiated.

```php
$myObject = new MyClass();
$myObject = $hydrator->hydrate($myObject, $myDatas);
```

Or hydrate with an object source

```php
$datas = new \stdClass();
$datas->foo = 'bar';
$myObject = $hydrator->hydrate(MyClass::class, $myDatas);
```

The hyrator uses the with methods and set methods first if presents, then directly the property, breaking accessibility if necessary.

## Installation

```bash
composer require kwizer/hydrator
```
