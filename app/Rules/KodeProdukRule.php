<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class KodeProdukRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^DM\d{2,}$/', (string) $value)) {
            $fail(':attribute harus menggunakan format DM diikuti minimal 2 angka, contohnya DM86 atau DM172.');
        }
    }
}
