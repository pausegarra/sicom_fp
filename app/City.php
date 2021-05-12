<?php

namespace App;

use App\Services\NavisionService;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'city','code','county',
    ];

    public static function getNav() {
        $navService = new NavisionService;
        $navService->url = env('NAV_BASE_URL') . "codigopostal";
        
        $arr = [];
        while (true) {
            $products = $navService->listAll();
            foreach ($products['value'] as $key => $product) {
                $arr[] = $product;
            }
            
            if (!isset($products['@odata.nextLink'])) 
                return $arr;
            
            $navService->url = $products['@odata.nextLink'];
        }
    }
}
