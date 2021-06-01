<?php
namespace Includes\Db;

use Includes\Db\Connection;

class Query extends Connection{


    protected $conn;
    protected $sql;
    protected $_where;
    protected $_whereParms = array();
    protected $_format;
    protected $_select;

    public function __construct()
    {
        parent::__construct();
        $this->conn = (object)$this->getConnection();
    }

    public function select( $column ){
        $this->_select .= $column;
    }

    public function where( $column, $compare, $value){

        if ($this->initialWhere()) {
            $this->_where .= sprintf( " %s %s ?", $column, $compare );
        }
        else{
            $this->_where .= sprintf( " AND %s %s ?", $column, $compare );
        }
        $this->_format .= $this->formatMapper($value);
        $this->_whereParms =  [...$this->_whereParms,$value];
    }

    public function whereOr( $column, $compare, $value){
        $this->_where .= sprintf( " OR %s %s ?", $column, $compare );
        $this->_format .= $this->formatMapper($value);
        $this->_whereParms =  [...$this->_whereParms,$value];
    }

    public function initialWhere(){

        if( $this->_where ){
            return false;
        }

        return true;

    }
    public function formatMapper( $value ){
        
        $type = gettype($value);
        return $type[0];
    }
    public function get(){
       
        $sql = "SELECT $this->_select FROM $this->table WHERE $this->_where";
        $result = $this->sqlSelect2( $sql, $this->_format , $this->_whereParms );
        $result = $this->extractOutput( $result );
        return $result;

    }

    public function sqlSelect2( $query, $format = '' , $params ) {

        $vars = array();
        foreach( $params as $key => $value ){
            $vars = [...$vars, $value];
        }

		$stmt = $this->conn->prepare($query);
		if($format) {
			$stmt->bind_param($format, ...$vars);
		}
		if($stmt->execute()) {
			$res = $stmt->get_result();
			$stmt->close();
			return $res;
		}
		$stmt->close();
        $this->conn->close();
		return false;

	}

    protected function extractOutput( $result ){

        $output = array();

        if ( $result && $result->num_rows >0 ) {
            while ($row = $result->fetch_assoc()) {
                $output = [$row,...$output];
            }
        }
        return $output;
    }
    
    public function findAll(){
        $sql = "SELECT * FROM $this->table WHERE `status`=?";

        $result = $this->sqlSelect( $sql, 's', 'publish' );
        
        return $this->extractOutput( $result );
    }

    public function find($id, $selects='*'){

        $sql = "SELECT $selects FROM $this->table WHERE `id`=?";

        $result = $this->sqlSelect( $sql, 'i', $id );

        return $this->extractOutput( $result );
    }

    public function rawQuery($sql){
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        }
    }

    
    public static function update( $data, $id, $table ){
        $query = new Query();
        try 
        {
            $stmt = $query->conn->prepare("UPDATE $table SET `cart_items`=? WHERE `id`=?");

            $stmt->bind_param('si', $data['cart_items'], $id);
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