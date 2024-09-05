<?php

namespace App\Http\Livewire\Orders;

use App\Models\AppSettings;
use App\Models\ProductDetails;
use Livewire\Component;

class OrdersForm extends Component
{
    public $customer_id;
    public $total_amount = 0;
    public $amount_of_lf = 0;
    public $orderedProducts = [];
    public $active_products = [];
    public $app_settings = [];
    public $local_forwarding = "";
    public $tax_percent = 0;

    // Things Remaining:
    // Complete Form Submission with validation 
    // Auto generate quotation no
    // view quotation detail page


    public function mount()
    {

        //Mount app settings for quotation
        $this->app_settings = AppSettings::get_app_settings();

        //products to be shown to make quotation
        $this->active_products = ProductDetails::where('isActive',1)->get();

        //set tax percent 
        $this->tax_percent = floatval($this->app_settings->tax_percent)/100;
        //quotation products array
        $this->orderedProducts = [
            [
                'product_id' => '',
                'product_nos' => 1,
                'product_packaging' => 0,
                'product_quantity' => 1,
                'product_price' => 0,
                'product_tax' => $this->app_settings->tax_percent,
                'product_selected' => false
            ]
        ];
    }

    public function render()
    {
        return view('livewire.orders.orders-form');
    }

    //event ot add item row in form 
    public function addProduct($i)
    {
        //Mount app settings for quotation
        $this->app_settings = AppSettings::get_app_settings();

        $this->orderedProducts [] = [
            'product_id' => 'na_'.$i,
            'product_nos' => 1,
            'product_packaging' => 0,
            'product_quantity' => 1,
            'product_price' => 0,
            'product_tax' => $this->app_settings->tax_percent,
            'product_selected' => false
        ];   
    }

    //event to remove product
    public function removeProduct($index)
    {
        unset($this->orderedProducts[$index]);
        array_values($this->orderedProducts);
    }

    //event to change product_price and product_packaging based on product_id selected
    public function updateProductPrice($productId_index)
    {
        $arr = explode("_",$productId_index);
        $product_id = $arr[0];
        $index = $arr[1];
        if($product_id == 'na'){
            $this->orderedProducts[$index]['product_selected'] = false;
        }else{
            $this->orderedProducts[$index]['product_selected'] = true;
        }

        // dd($this->orderedProducts[0]['product_selected']);

        if($this->orderedProducts[$index]['product_selected']){
            $get_product = ProductDetails::findOrFail($product_id);
            // dd($get_product);
            $this->orderedProducts[$index]['product_price'] = floatval($get_product->product_price);
            // $this->orderedProducts[$index]['product_price'] = round((floatval($get_product->product_price) * floatval($this->orderedProducts[$index]['product_tax'])/100) + floatval($get_product->product_price),2);
            $this->orderedProducts[$index]['product_packaging'] = intval($get_product->product_packaging);
        }else{
            $this->orderedProducts[$index]['product_price'] = 0;
            $this->orderedProducts[$index]['product_packaging'] = 0;
            $this->orderedProducts[$index]['product_quantity'] = 1;
            return false;
        }

    }

    //calculate product price based on orderedProducts index
    public function calcProductPrice($index)
    {
        $product_id = $this->orderedProducts[$index]['product_id'];
        $get_product = ProductDetails::findOrFail($product_id);
        // $product_taxed_price = (floatval($get_product->product_price) * floatval($this->orderedProducts[$index]['product_tax'])/100) + floatval($get_product->product_price);
        $final_product_price = floatval($get_product->product_price);
        $this->orderedProducts[$index]['product_price'] = round($final_product_price * intval($this->orderedProducts[$index]['product_nos']),2);
    }

    //method to increment Product Nos
    public function incrementProductNos($index)
    {
        $product_id = $this->orderedProducts[$index]['product_id'];
        // dd($product_id);
        if($product_id == '' || $product_id == 'na_0'){
            $this->orderedProducts[$index]['product_selected'] = false;
        }else{
            $this->orderedProducts[$index]['product_selected'] = true;
        }


        if($this->orderedProducts[$index]['product_selected']){
            $get_product = ProductDetails::findOrFail($product_id);
            if($this->orderedProducts[$index]['product_nos'] >= 1){
                $this->orderedProducts[$index]['product_nos'] +=1;
                $this->calcProductPrice($index);
                $this->orderedProducts[$index]['product_quantity'] = intval($get_product->product_packaging) * $this->orderedProducts[$index]['product_nos']; 
            }else{
                $this->orderedProducts[$index]['product_nos'] == 1;
                $this->calcProductPrice($index);
                $this->orderedProducts[$index]['product_quantity'] = intval($get_product->product_packaging) * $this->orderedProducts[$index]['product_nos'];
            }
        }else{
            return false;
        }

    }
    
    //method to decrement Product Nos
    public function decrementProductNos($index)
    {
        $product_id = $this->orderedProducts[$index]['product_id'];

        if($product_id == '' || $product_id == 'na_0'){
            $this->orderedProducts[$index]['product_selected'] = false;
        }else{
            $this->orderedProducts[$index]['product_selected'] = true;
        }

        if($this->orderedProducts[$index]['product_selected']){
            
            $get_product = ProductDetails::findOrFail($product_id);
            if($this->orderedProducts[$index]['product_nos'] <= 1){
                $this->orderedProducts[$index]['product_nos'] == 1;
                $this->calcProductPrice($index);
                $this->orderedProducts[$index]['product_quantity'] = intval($get_product->product_packaging) * $this->orderedProducts[$index]['product_nos'];
            }else{
                $this->orderedProducts[$index]['product_nos'] -=1;
                $this->calcProductPrice($index);
                $this->orderedProducts[$index]['product_quantity'] = intval($get_product->product_packaging) * $this->orderedProducts[$index]['product_nos'];
            }

        }else{
            return false;
        }

    }

    //event to calculate Total with gst
    public function calcTotalOfInvoice()
    {
        $this->total_amount = array_sum(array_column($this->orderedProducts,'product_price'));
        return $this->total_amount = ($this->total_amount * $this->tax_percent) + $this->total_amount + floatval($this->amount_of_lf);
    }

    //event to set local forwarding
    public function setLf()
    {
        if($this->local_forwarding == "no"){
            $this->amount_of_lf = 0;
        }
    }

}
