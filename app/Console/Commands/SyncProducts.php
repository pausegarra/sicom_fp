<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Product;
use Exception;

class SyncProducts extends Command
{
    private $navService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza los productos con NAV';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        $filters = [
            '$filter' => "Integracion_SICOM eq true and Blocked eq false and Cod_Tipo_producto eq 'PRODUCTOACABADO'",
        ];
        $products = Product::getNav($filters);

        $x = 1;
        $total = count($products);
        
        DB::beginTransaction();
        try {
            Product::where('active',1)
                ->update(['active' => 0]);
            
            foreach ($products as $key => $product) {
                Product::updateOrCreate([
                    'erpId' => $product['No'],
                ],[
                    'name'   => $product['Description'],
                    'erpId'  => $product['No'],
                    'price'  => $product['Unit_Price'],
                    'active' => 1,
                    'type'   => ($product['Cod_Clasif_producto'] == 'MERCHANDISING') ? 'merchan' : 'product',
                ]);

                print("\033[2J\033[;H");
                echo $x++ . " / $total";
            }
        } catch (Exception $e){
            DB::rollBack();
        }
        DB::commit();
    }
}