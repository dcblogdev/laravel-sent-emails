<?php

namespace Dcblogdev\LaravelSentEmails\database\factories;

use Dcblogdev\LaravelSentEmails\Models\SentEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

class SentEmailFactory extends Factory
{
    protected $model = SentEmail::class;

    public function definition(): array
    {
        return [
            'date' => date('Y-m-d H:i:s'),
            'from' => fake()->email,
            'to' => fake()->email,
            'cc' => fake()->email,
            'bcc' => fake()->email,
            'subject' => fake()->sentence,
            'body' => fake()->realText,
        ];
    }
}
