# InputToDate

This is a really simple library to convert user input to a Carbon object without
having to worry about the possible exceptions that maybe thrown with bad or empty
input.

If you're using a framework (such as Laravel) you should still validate user input
if you want to send them nice errors about invalid input.

## Features
- Parse user input to a Carbon object.
- Throw an Exception or return a default upon error/empty input.
- Fluent API

##Usage

The following example would return a Carbon object with the correct date.
```php
    $user_input = '01/01/2016 09:30:30'
    $date = InputToDate::create('d/m/Y H:i:s')
                        ->convert($user_input);
```

The following example has incorrect input, and will return `null` as we have asked it to by running
the `setReturnNullOnFailure()` method.
```php
    $user_input = '01/01/2016 09:30:30'
    $date = InputToDate::create('d/m/Y')
                        ->setReturnNullOnFailure()
                        ->convert($user_input);
```

The following example will return this current time as its incorrect, but as have asked
for a default of `Carbon::now()`.
```php
    $user_input = '01/01/2016 09:30:30'
    $date = InputToDate::create('d/m/Y')
                        ->setDefault(Carbon::now())
                        ->convert($user_input);
```

The following will throw an `InvalidArgumentException` exception as the input is incorrect
and we have not set any other default. You can also explicitly add the `throwException()`
method.
```php
    $user_input = '01/01/2016 09:30:30'
    $date = InputToDate::create('d/m/Y')
                        ->convert($user_input);
```

## Contribute
Pull requests are more than welcome.
