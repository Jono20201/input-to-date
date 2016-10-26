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
    $date = InputToDate::create($user_input)
                        ->setFormat('d/m/Y H:i:s')
                        ->convert();
```

The following example has incorrect input, and will return `null` as we have no default
and we have not asked it to throw an exception.
```php
    $user_input = '01/01/2016 09:30:30'
    $date = InputToDate::create($user_input)
                        ->setFormat('d/m/Y')
                        ->convert();
```

The following example will return this current time as its incorrect, but as have asked
for a default of `Carbon::now()`.
```php
    $user_input = '01/01/2016 09:30:30'
    $date = InputToDate::create($user_input)
                        ->setFormat('d/m/Y')
                        ->setDefault(Carbon::now())
                        ->convert();
```

The following will throw an `InvalidArgumentException` exception as the input is incorrect.
```php
    $user_input = '01/01/2016 09:30:30'
    $date = InputToDate::create($user_input)
                        ->setFormat('d/m/Y')
                        ->throwException()
                        ->convert();
```

## Contribute
Pull requests are more than welcome.
