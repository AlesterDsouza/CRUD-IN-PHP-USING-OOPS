<?php

require_once 'db.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new db();
    }

    // Encrypt password before saving to the database
    public function create($UserName, $Password) {
        $encryptedPassword = base64_encode($Password);
        $stmt = $this->db->conn->prepare("INSERT INTO crud_1 (UserName, Password) VALUES (?, ?)");
        $stmt->bind_param("ss", $UserName, $encryptedPassword);
        return $stmt->execute();
    }

    // Decrypt password when fetching from the database
    public function read() {
        $result = $this->db->conn->query("SELECT * FROM crud_1");
        $users = $result->fetch_all(MYSQLI_ASSOC);
 
        // foreach($users as &$user){
        //     $user['Password']=base64_decode($user['Password']);
        // }
        return $users;
    }

    public function update($id, $UserName, $Password) {
        $encryptedPassword = base64_encode($Password);
        $stmt = $this->db->conn->prepare("UPDATE crud_1 SET UserName = ?, Password = ? WHERE ID = ?");
        $stmt->bind_param("ssi", $UserName, $encryptedPassword, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->db->conn->prepare("DELETE FROM crud_1 WHERE ID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function find($id) {
        $stmt = $this->db->conn->prepare("SELECT * FROM crud_1 WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        if ($user) {
            $user['Password'] = base64_decode($user['Password']);
        }
        return $user;
    }
}
?>




