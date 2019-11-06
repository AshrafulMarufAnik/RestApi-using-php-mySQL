<?php
class user{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $userId;
    public $name;
    public $title;
    public $body;
    public $status;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read users
    function read(){
 
        // select all query
        $query = "SELECT * FROM users";
 
        // prepare query statement
        $stmt = $this->conn->prepare($query);
 
        // execute query
        $stmt->execute();
 
        return $stmt;
    }

    // write product
    function create(){
 
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    userId=:userId, name=:name, title=:title, body=:body, status=:status";
 
        // prepare query
        $stmt = $this->conn->prepare($query);
 
        // sanitize
        $this->userId=htmlspecialchars(strip_tags($this->userId));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->body=htmlspecialchars(strip_tags($this->body));
        $this->status=htmlspecialchars(strip_tags($this->status));
 
        // bind values
        $stmt->bindParam(":userId", $this->userId);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":body", $this->body);
        $stmt->bindParam(":status", $this->status);
 
        // execute query
        if($stmt->execute()){
            return true;
        }
 
        return false;
     
    }

    // update the product
    function update(){
 
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    userId = :userId,
                    name = :name,
                    title = :title,
                    body = :body,
                    status = :status
                WHERE
                    userId = :userId";
 
        // prepare query statement
        $stmt = $this->conn->prepare($query);
 
        // sanitize
        $this->userId=htmlspecialchars(strip_tags($this->userId));
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->body=htmlspecialchars(strip_tags($this->body));
        $this->status=htmlspecialchars(strip_tags($this->status));
 
        // bind new values
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':status', $this->status);
 
        // execute the query
        if($stmt->execute()){
            return true;
        }
 
        return false;
    }
}

?>