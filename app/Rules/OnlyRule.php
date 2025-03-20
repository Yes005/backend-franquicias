<?php


namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Closure;
use Illuminate\Support\Facades\DB;

class OnlyRule implements ValidationRule
{

    private string $table;
    private string $column;
    private array $values;
    private string $columnFilter;

    public function __construct(
        string $table,
        string $column,
        array $values,
        string $columnFilter = 'id',
    ) {
        $this->table = $table;
        $this->columnFilter = $columnFilter;
        $this->column = $column;
        $this->values = $values;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = DB::table($this->table)
            ->whereIn($this->column, $this->values)
            ->where($this->columnFilter, $value)
            ->exists();

        if (!$result) {
            $fail("El $attribute contiene un valor no permitido.");
        }
    }
}
