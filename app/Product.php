<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\NavisionService;

class Product extends Model
{
    private $navService;

    protected $fillable = [
        'name','price','active','erpId','type',
    ];

    public static function getNav($filters = []) {
        $navService = new NavisionService;
        $navService->url = env('NAV_BASE_URL') . "Producto?" . http_build_query($filters);
        
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
