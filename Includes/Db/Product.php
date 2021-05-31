<?php
namespace Includes\Db;

class Product extends Query{

    protected $table = 'products';


    // public function findAll(){
    //     $sql = "SELECT * FROM `products` WHERE `status`=?";

    //     $result = $this->sqlSelect( $sql, 's', 'publish' );
        
    //     return $this->extractOutput( $result );
    // }

    // public function find($id){

    //     $sql = "SELECT * FROM `products` WHERE `id`=?";

    //     $result = $this->sqlSelect( $sql, 'i', $id );

    //     return $this->extractOutput( $result );
    // }

    public static function getProductStock( $id ){

    }
} 