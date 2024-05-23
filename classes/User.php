<?php
class User {
    protected $conn;
    protected $table_name;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Common methods for user management can be added here.
}
?>
