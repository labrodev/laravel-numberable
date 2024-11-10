# Numberable for Laravel

Numberable is a Laravel package that provides a reusable trait for automatically assigning a number to Eloquent models upon their creation.

By default it generates a unique document number based on the model's ID and the current year. This method can be customized in individual models that use the trait, allowing for flexible document numbering logic.

- Base Year: Uses the current year as the prefix for the document number.
- Prediction Number: Sets a default "prediction number" (e.g., 10000), determining the minimum length of the number portion.
- Padding: Pads the model ID with leading zeros to match the length of the prediction number, ensuring consistent document number lengths.

For example, if the current year is 2024 and the model ID is 45 and prediction number is 10000, the generated document number would be: 202400045.

But you are free to provide your own logic of generation for specific models. 

You just need to overwrite method `protected function generateNumberByTraitModelHasNumber(int $modelId): string` in your model. 

## Installation

To install the package, run the following command in your Laravel project:

```bash
composer require labrodev/numberable
```

## Requirements

- PHP 8.1 or higher

## Configuration

After installing the package, no additional configuration is needed to start using the UUID trait in your models.

## Usage

To use the `ModelHasNumber` trait, simply include it in your Eloquent model:

```php 

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Labrodev\Uuidable\ModelHasNumber;

class ExampleModel extends Model
{
    use ModelHasNumber;
}
```

Ensure that your model has 'number' column in model database table. 

If it is not, you may add it through Laravel migration: 

```php
$table->string('number');
```

## Override number column name

If the column in your database table designated for document number storage has a name different from the default, you can customize the trait to accommodate this. 

Simply override the trait method in your model by adding the following method with your specific column name:

```php 
/**
* @return string
*/
protected function modelHasNumberTraitColumn(): string
{
    return 'your-number-column-name';
}
```

## Overwrite logic of number generation

You may overwrite logic of number generation by customize logic in overwritten method in your model:

```php 
/**
* @return string
*/
protected function generateNumberByTraitModelHasNumber(int $modelId): string
{
    // your own logic to generate a number 
}
```

If you want to keep basic logic by generating number based on current year + prediction number + model ID,
but there is a necessity to adjust prediction number value, you may add method to your model:

```php
protected function predictionNumberForTraitModelHasNumber(): int 
{
   return 10000; // your prediction number
}
```

## Testing

To run the tests included with the package, execute the following command:

```bash
composer test
```

For static analysis to check the package code, execute the followin command: 

```bash
composer analyse
```

## Security

If you discover any security-related issues, please email admin@labrodev.com instead of using the issue tracker.

## Credits

Labro Dev

## License

The MIT License (MIT). Please see License File for more information.
