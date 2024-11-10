<?php

use Labrodev\Numberable\Tests\MockModel;
use Carbon\Carbon;

test('number is automatically set by generateNumberByTraitModelHasNumber method', function () {
    // Set the current year for the expected number format
    $currentYear = Carbon::now()->year;

    // Create an instance of MockModel and set the ID for testing
    $mockModel = new MockModel();
    $mockModel->id = 1;

    // Use reflection to access the protected method
    $method = new ReflectionMethod(MockModel::class, 'generateNumberByTraitModelHasNumber');
    $method->setAccessible(true);

    // Invoke the protected method with the mock ID
    $generatedNumber = $method->invoke($mockModel, $mockModel->id);

    // Calculate the expected number
    $expectedNumber = $currentYear . str_pad((string) $mockModel->id, 5, '0', STR_PAD_LEFT);

    // Assert that the generated number matches the expected value
    expect($generatedNumber)->toBe($expectedNumber);
});

