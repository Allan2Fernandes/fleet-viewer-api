<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateMockEventsData extends Data
{
    public function __construct(
        public int $fleet_size
    ) {}

    public static function rules(ValidationContext $context = null): array
    {
        return [
            'fleet_size' => [
                'required',
                'integer',
                'between:0,500',
            ],
        ];
    }
}
