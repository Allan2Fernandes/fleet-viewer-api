<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetRobotsLatestEventData extends Data
{
    public function __construct(
        public array $robot_ids
    ) {}

      public static function rules(ValidationContext $context = null): array
    {
        return [
            'robot_ids' => [],
            'robot_ids.*' => ['required', 'string'],
        ];
    }
}
