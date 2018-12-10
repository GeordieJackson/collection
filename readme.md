# Simple collection

> *composer require geordiejackson/collection*


## Remit

This lightweight collection package is intended for use in small to medium sized projects. It offers many of the methods of framework collections without the overhead of having to install a framework core to access them.

### Usage: turning arrays into collections

> *use geordiejackson/collection*

$array = ['one', 'two', 'three]; 

```php
$collection = new Collection($array);
```

or
```php
$collection = Collection::make($array);
```
or use the *collect()* helper method
```php
$collection = collect($array);
```