<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isRoot) {
            return 'Root website goes here!';
        }

        $customer = $request->customer;

        return $customer->name;
    }
}
