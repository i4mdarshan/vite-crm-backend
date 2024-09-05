<?php

namespace App\Http\Livewire\Quotations;

use App\Models\AppSettings;
use App\Models\ProductDetails;
use Livewire\Component;

class QuotationForm extends Component
{   
    public $total_amount = 0;
    public $amount_of_lf = 0;
    public $quotationProducts = [];
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
        $this->quotationProducts = [
            [
                'product_id' => 'na_0',
                'product_nos' => 1,
                'product_packaging' => 0,
                'product_quantity' => 1,
                'product_price' => 0,
                'product_tax' => $this->app_settings->tax_percent,
                'product_selected' => false
            ]
        ];

        //
    }

    public function render()
    {
        return view('livewire.quotations.quotation-form');
    }

    //event ot add item row in form 
    public function addProduct($i)
    {
        //Mount app settings for quotation
        $this->app_settings = AppSettings::get_app_settings();

        $this->quotationProducts [] = [
            'product_id' => 'na_'.strval(intval($i)+1),
            'product_nos' => 1,
            'product_packaging' => 0,
            'product_quantity' => 1,
            'product_price' => 0,
            'product_tax' => $this->app_settings->tax_percent,
            'product_selected' => false
        ];   
    }

    //event to remove product (Bug here : if all rows are removed app crashes, if first row removed product gets reset) => solved
    public function removeProduct($index)
    {
        if(count($this->quotationProducts) > 1){
            unset($this->quotationProducts[$index]);
            array_values($this->quotationProducts);
        }else{
            return false;
        }
    }

    //event to change product_price and product_packaging based on product_id selected
    public function updateProductPrice($productId_index)
    {
        $arr = explode("_",$productId_index);
        $product_id = $arr[0];
        $index = $arr[1];
        if($product_id == 'na'){
            $this->quotationProducts[$index]['product_selected'] = false;
        }else{
            $this->quotationProducts[$index]['product_selected'] = true;
        }

        // dd($this->quotationProducts[0]['product_selected']);

        if($this->quotationProducts[$index]['product_selected']){
            $get_product = ProductDetails::findOrFail($product_id);
            // dd($get_product);
            $this->quotationProducts[$index]['product_price'] = floatval($get_product->product_price);
            // $this->quotationProducts[$index]['product_price'] = round((floatval($get_product->product_price) * floatval($this->quotationProducts[$index]['product_tax'])/100) + floatval($get_product->product_price),2);
            $this->quotationProducts[$index]['product_packaging'] = intval($get_product->product_packaging);
            $this->quotationProducts[$index]['product_quantity'] = intval($get_product->product_packaging) * intval($this->quotationProducts[$index]['product_nos']);
        }else{
            $this->quotationProducts[$index]['product_price'] = 0;
            $this->quotationProducts[$index]['product_packaging'] = 0;
            $this->quotationProducts[$index]['product_quantity'] = 1;
            return false;
        }

    }

    //calculate product price based on quotationProducts index
    public function calcProductPrice($index)
    {
        $product_id = $this->quotationProducts[$index]['product_id'];
        $get_product = ProductDetails::findOrFail($product_id);
        // $product_taxed_price = (floatval($get_product->product_price) * floatval($this->quotationProducts[$index]['product_tax'])/100) + floatval($get_product->product_price);
        $final_product_price = floatval($get_product->product_price);
        $this->quotationProducts[$index]['product_price'] = round($final_product_price * intval($this->quotationProducts[$index]['product_nos']),2);
    }

    //method to increment Product Nos
    public function incrementProductNos($index)
    {
        $product_id = $this->quotationProducts[$index]['product_id'];
        // dd($product_id);
        if($product_id == '' || $product_id == 'na_0'){
            $this->quotationProducts[$index]['product_selected'] = false;
        }else{
            $this->quotationProducts[$index]['product_selected'] = true;
        }


        if($this->quotationProducts[$index]['product_selected']){
            $get_product = ProductDetails::findOrFail($product_id);
            if($this->quotationProducts[$index]['product_nos'] >= 1){
                $this->quotationProducts[$index]['product_nos'] +=1;
                $this->calcProductPrice($index);
                $this->quotationProducts[$index]['product_quantity'] = intval($get_product->product_packaging) * $this->quotationProducts[$index]['product_nos']; 
            }else{
                $this->quotationProducts[$index]['product_nos'] == 1;
                $this->calcProductPrice($index);
                $this->quotationProducts[$index]['product_quantity'] = intval($get_product->product_packaging) * $this->quotationProducts[$index]['product_nos'];
            }
        }else{
            return false;
        }

    }
    
    //method to decrement Product Nos
    public function decrementProductNos($index)
    {
        $product_id = $this->quotationProducts[$index]['product_id'];

        if($product_id == '' || $product_id == 'na_0'){
            $this->quotationProducts[$index]['product_selected'] = false;
        }else{
            $this->quotationProducts[$index]['product_selected'] = true;
        }

        if($this->quotationProducts[$index]['product_selected']){
            
            $get_product = ProductDetails::findOrFail($product_id);
            if($this->quotationProducts[$index]['product_nos'] <= 1){
                $this->quotationProducts[$index]['product_nos'] == 1;
                $this->calcProductPrice($index);
                $this->quotationProducts[$index]['product_quantity'] = intval($get_product->product_packaging) * $this->quotationProducts[$index]['product_nos'];
            }else{
                $this->quotationProducts[$index]['product_nos'] -=1;
                $this->calcProductPrice($index);
                $this->quotationProducts[$index]['product_quantity'] = intval($get_product->product_packaging) * $this->quotationProducts[$index]['product_nos'];
            }

        }else{
            return false;
        }

    }

    //event to calculate Total with gst
    public function calcTotalOfInvoice()
    {
        $this->total_amount = array_sum(array_column($this->quotationProducts,'product_price'));
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
