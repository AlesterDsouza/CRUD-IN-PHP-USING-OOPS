<?php
require_once 'db1.php';

class User1{
    private $db;

    public function __construct() {
        $this->db = new db1();
    }

    public function create1($firstName, $lastName, $mobileNumber, $email, $address, $profilePic) {
        $stmt = $this->db->conn->prepare("INSERT INTO tblusers (FirstName, LastName, MobileNumber, Email, Address, ProfilePic) VALUES (?, ?, ?, ?, ?, ?)");
        // $stmt->bind_param("ssisss", $firstName, $lastName, $mobileNumber, $email, $address, $profilePic);
        $stmt->bind_param("ssisss", $firstName, $lastName, $mobileNumber, $email, $address, $profilePic);
        return $stmt->execute();
    }

    public function read1() {
        $result = $this->db->conn->query("SELECT * FROM tblusers");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function update1($id, $firstName, $lastName, $mobileNumber, $email, $address, $profilePic) {
        $stmt = $this->db->conn->prepare("UPDATE tblusers SET FirstName = ?, LastName = ?, MobileNumber = ?, Email = ?, Address = ?, ProfilePic = ? WHERE ID = ?");
        $stmt->bind_param("ssisssi", $firstName, $lastName, $mobileNumber, $email, $address, $profilePic, $id);
        return $stmt->execute();
    }

    public function mobileNumberExists($mobileNumber) {
        // Fix: Access conn through $this->db
        $stmt = $this->db->conn->prepare("SELECT * FROM tblusers WHERE MobileNumber = ?");
        $stmt->bind_param('s', $mobileNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Returns true if the mobile number exists
    }

    public function emailExists($email){

        $stmt = $this->db->conn->prepare("SELECT * FROM tblusers WHERE Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Returns true if the email exists
    
    }

    public function delete1($id) {
        $stmt = $this->db->conn->prepare("DELETE FROM tblusers WHERE ID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function find1($id) {
        $stmt = $this->db->conn->prepare("SELECT * FROM tblusers WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function fetchUsers($search = '', $limit = 5, $offset = 0) {
        $query = "SELECT * FROM tblusers WHERE FirstName LIKE ? OR LastName LIKE ? OR MobileNumber LIKE ? OR Email LIKE ? OR Address LIKE ? LIMIT ? OFFSET ?";
        $stmt = $this->db->conn->prepare($query);
        $likeSearch = "%$search%";
        $stmt->bind_param('ssssiii', $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        return $users;
    }

    // Method to count total users for pagination purposes
    public function countUsers($search = '') {
        $query = "SELECT COUNT(*) as total FROM tblusers WHERE FirstName LIKE ? OR LastName LIKE ? OR MobileNumber LIKE ? OR Email LIKE ? OR Address LIKE ?";
        $stmt = $this->db->conn->prepare($query);
        $likeSearch = "%$search%";
        $stmt->bind_param('sssss', $likeSearch, $likeSearch, $likeSearch, $likeSearch, $likeSearch);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }


    // public function search1($firstName, $lastName, $mobileNumber, $email, $address){
    //        $stmt=$this->db->conn->prepare(" SELECT * from tblusers where FirstName like %?% OR LastName like %?% OR MobileNumber like %?% OR Email like %?%  OR Address like %?% " );
    //        $stmt->bind_param("ssisss", $firstName, $lastName, $mobileNumber, $email, $address);
    //        return $stmt->fetch_all(MYSQLI_ASSOC);
    // }
}
?>
