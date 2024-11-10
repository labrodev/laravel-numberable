<?php

declare(strict_types=1);

namespace Labrodev\Numberable;

use Illuminate\Support\Str;
use Carbon\Carbon;

trait ModelHasNumber
{
    /**
     * @return void
     */
    public static function bootModelHasNumber(): void
    {
        static::created(function ($model) {
            /** @var static $model */
            if ($model->isModelHasNumberTraitValueGenerated() === false) {
                if (isset($model->id)) {
                    $model->{$model->modelHasNumberTraitColumn()} = $model->generateNumberByTraitModelHasNumber($model->id);
                    $model->withoutEvents(function () use ($model) {
                        $model->save();
                    });
                }
            }
        });
    }

    /**
     * Method represents the fetch logic of attribute
     * if column / attribute is overridden in model
     * and if needed extended logic of fetching value
     * then it should be added as public method
     * in Model class with appropriate name
     *
     * @return string
     */
    public function getNumberAttribute(): string
    {
        return $this->attributes[$this->modelHasNumberTraitColumn()] ?? 'undefined';
    }

    /**
     * Name for column / attribute which represents the logic of generated number
     * @return string
     */
    protected function modelHasNumberTraitColumn(): string
    {
        return 'number'; // Default implementation, can be overridden by model
    }

    /**
     * Method to check if the number is already generated or not
     *
     * @return boolean
     */
    private function isModelHasNumberTraitValueGenerated(): bool
    {
        $attributes = [];

        if (method_exists($this, 'getAttributes')) {
            $attributes = $this->getAttributes();
        }

        $name = $this->modelHasNumberTraitColumn();

        return isset($attributes[$name]) && $attributes[$name] !== null;
    }

    /**
     * This method could be overwritten in model where trait is used
     * so you may define your own custom logic for document number generation
     * based on modelId
     *
     * @param integer $modelId
     * @return string
     */
    protected function generateNumberByTraitModelHasNumber(int $modelId): string
    {
        // Use the current year as the base for the document number.
        $currentYear = Carbon::now()->year;

        // Ensure the prediction number has a valid default.
        $predictionNumber = $this->predictionNumberForTraitModelHasNumber();

        // Calculate the length for padding based on the prediction number.
        $paddingLength = strlen((string) $predictionNumber);

        return $currentYear . Str::padLeft((string) $modelId, $paddingLength, '0');
    }

    /**
     * You may overwrite prediction number (how many model items be during the calendar year
     *
     * @return integer
     */
    protected function predictionNumberForTraitModelHasNumber(): int
    {
        return 10000;
    }
}
