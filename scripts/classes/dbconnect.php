<?php
abstract class DbConnect
{
    protected $server;
    protected $user;
    protected $password;
    protected $db;
    protected $table;

    function __construct($server = "localhost", $user = "root", $password = "", $db = "test", $table = "users")
    {
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->db = $db;
        $this->table = $table;
    }
}
?>