<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class CustomersFilter extends ApiFilter
{
    protected array $allowedParams = [
        'name' => ['eq'],
        'type' => ['eq', 'ne'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'postalCode' => ['eq', 'gt', 'gte', 'lt', 'lte']
    ];

    protected array $columMap = [
        'postalCode' => 'postal_code'
    ];

}
