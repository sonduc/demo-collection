<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function demo1(Request $request)
    {
        $data = collect($request->all()['products'])->filter(function ($item) {
            return in_array($item['product_type'], ['Wallet', 'Lamp']);
        })->flatMap(function ($item) {
            return $item['variants'];
        })->sum('price');
        return $this->respondSuccess($data);
    }

    public function demo2()
    {
        $shifts = [
            'Shipping_Steve_A7',
            'Sales_B9',
            'Support_Tara_K11',
            'J15',
            'Warehouse_B2',
            'Shipping_Dave_A6',
        ];
        $shiftIds = collect($shifts)->map(function ($shift) {
            return collect(explode('_', $shift))->last();
        });
        return $this->respondSuccess($shiftIds);
    }

    public function demo3()
    {
        $data = [
            'Opening brace must be the last content on the line',
            'Closing brace must be on a line by itself',
            'Each PHP statement must be on a line by itself',
        ];
        $result = collect($data)->map(function ($message) {
            return "- {$message}\n";
        })->implode('');
        return $this->respondSuccess($result);
    }
}
