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
    public static function updateStock( $qty, $id ){
        $query = new Query();
        try 
        {
            $stmt = $query->conn->prepare("UPDATE `products` SET `stock`= (`stock`-?) WHERE `id`=?");

            $stmt->bind_param('ii', $qty, $id);
            $stmt->execute();

            if( !$stmt->error )
            {
                return true;
            }
            return false;
            $stmt->close();
            $query->conn->close();

        } 
        catch (\Throwable $th) 
        {
            return false;
        }
       
    }
} 