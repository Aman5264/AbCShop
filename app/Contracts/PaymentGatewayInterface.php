<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface PaymentGatewayInterface
{
    public function initiate(array $data);
    public function verify(Request $request);
}
