<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyFinancials extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'email',
        'cnpj',
        'bar_code',
        'value',
        'due_date',
        'fees'
    ];
}
