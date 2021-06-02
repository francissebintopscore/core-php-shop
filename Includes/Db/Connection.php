<?php
namespace Includes\Db;

class Connection
{
    
    /**
     * The name of the db host.
     *
     * @var string
     */
    protected $host    = DB_HOST;

    /**
     * The username of the database.
     *
     * @var string
     */
    protected $user    = DB_USER;

    /**
     * The password
     *
     * @var string
     */
    protected $psw     = DB_PSW;

    /**
     * Database name
     *
     * @var string
     */
    protected $db      = DB;

    /**
     * Database name
     *
     * @var string
     */
    protected $connection;


    public function __construct()
    {
        $conn = new \mysqli($this->host, $this->user, $this->psw, $this->db);
        if ($conn->connect_error) {
            return false;
        }

        $this->connection = $conn;
    }

    protected function getConnection()
    {
        return $this->connection;
    }
}
