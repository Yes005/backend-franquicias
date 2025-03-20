<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class ExistOrRule implements ValidationRule
{

    private string $table;

    private array $columns;

    public function __construct(string $table, array $columns)
    {
        $this->table = $table;
        $this->columns = $columns;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $exist = DB::table($this->table)->where(function ($query) use ($value) {
            collect($this->columns)
                ->each(fn($column) => $query->orWhere($column, $value));
        })->exists();


        if (!$exist) {
            $fail("El campo :attribute seleccionado no existe.");
        }
    }
}
