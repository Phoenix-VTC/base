<?php

namespace App\Rules\Events;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class UniqueForDay implements Rule
{
    public ?int $except;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($except = null)
    {
        $this->except = $except;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $value = Carbon::parse($value)->toDateString();

        ray(Event::query()
        ->where('id', '!=', $this->except)
        ->whereDate('start_date', $value)
        ->get());

        return Event::query()
            ->where('id', '!=', $this->except)
            ->whereDate('start_date', $value)
            ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'This :attribute is already taken.';
    }
}
