# session

A simple, zero dependency PHP session abstraction library for PHP 7.2+

## Usage

Construct an instance of `Imjoehaines\Session\Session` by passing the `$_SESSION` superglobal to its constructor

```php
use Imjoehaines\Session\Session;

$session = new Session($_SESSION);
```

Changes to the `$_SESSION` superglobal will be reflected in the Session instance

```php
use Imjoehaines\Session\Session;

$session = new Session($_SESSION);

$_SESSION['a'] = 1;

assert($session->has('a') === true);
```

## API

1. [`set`](#set)
1. [`has`](#has)
1. [`get`](#get)
1. [`delete`](#delete)
1. [`clear`](#clear)

### set

The set method allows you to set the given `$key` to the given `$value`

```php
use Imjoehaines\Session\Session;

$session = new Session($_SESSION);

$session->set('a_string_key', 'any_value');
```

### has

The has method returns `true` if the given key exists in the session and `false` if it does not

```php
use Imjoehaines\Session\Session;

$session = new Session($_SESSION);

$session->set('a_string_key', 'any_value');

assert($session->has('a_string_key') === true);
```

### get

The get method returns the value of the given `$key` if it exists in the session. If the key does not exist then an `OutOfBoundsException` will be thrown

```php
use Imjoehaines\Session\Session;

$session = new Session($_SESSION);

$session->set('a_string_key', 'any_value');

assert($session->get('a_string_key') === 'any_value');

// Throws OutOfBoundsException with message 'The key "not in the session" was not found in the session'
$session->get('not in the session');
```

### delete

The delete method removes the given `$key` from the session if it exists. If the key does not exist then an `OutOfBoundsException` will be thrown

```php
use Imjoehaines\Session\Session;

$session = new Session($_SESSION);

$session->set('a_string_key', 'any_value');

$session->delete('a_string_key');

assert($session->has('a_string_key') === false);

// Throws OutOfBoundsException with message 'The key "a_string_key" was not found in the session'
$session->delete('a_string_key');
```

### clear

The clear method removes all keys from the session

```php
use Imjoehaines\Session\Session;

$session = new Session($_SESSION);

$session->set('a_string_key', 'any_value');
$session->set('another_key', 123);

$session->clear();

assert($session->has('a_string_key') === false);
assert($session->has('another_key') === false);
```
