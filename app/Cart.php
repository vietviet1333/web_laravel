<?php
    namespace App;
    class Cart{
        public $dulieu = null;
        public $totalprice = 0;
        public $totalquanty = 0;

        public function __construct($cart){
            if($cart){
                $this->dulieu=$cart->dulieu;
                $this->totalprice=$cart->totalprice;
                $this->totalquanty=$cart->totalquanty;
            }
        }
        public function AddCart($product,$id_product){
            $newproduct=['quanty'=>0,'price'=>$product->price,'productinfo'=>$product];
            if($this->dulieu){
                if(array_key_exists($id_product,$this->dulieu)){
                   $newproduct=$this->dulieu[$id_product];
                }
            }
            $newproduct['quanty']++;
            $newproduct['price']=$newproduct['quanty']*$product->price;
            $this->dulieu[$id_product] = $newproduct;
            $this->totalprice += $product->price;
            $this->totalquanty++;
        }
        public function Delete($id){
            $this->totalquanty-=$this->dulieu[$id]['quanty'];
            $this->totalprice-=$this->dulieu[$id]['price'];
            unset($this->dulieu[$id]);
        }

    }
?>