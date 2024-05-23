<?php
require_once 'User.php';

class Alumni extends User {
    protected $table_name = "alumnis";

    public function createProfile($profileData, $profilePicture) {
        try {
            $sql = "INSERT INTO " . $this->table_name . " 
                    (username, email, name, location, phone, description, education, profile_picture) 
                    VALUES 
                    (:username, :email, :name, :location, :phone, :description, :education, :profile_picture)";
            $stmt = $this->conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':username', $profileData['username']);
            $stmt->bindParam(':email', $profileData['email']);
            $stmt->bindParam(':name', $profileData['name']);
            $stmt->bindParam(':location', $profileData['location']);
            $stmt->bindParam(':phone', $profileData['phone']);
            $stmt->bindParam(':description', $profileData['description']);
            $stmt->bindParam(':education', $profileData['education']);
            $stmt->bindParam(':profile_picture', $profilePicture);

            // Execute the query
            if ($stmt->execute()) {
                return true;
            }

            return false;
        } catch (Exception $e) {
            throw new Exception("Error creating profile: " . $e->getMessage());
        }
    }

    public function viewJob() {
    $query = "SELECT job_title, job_description, company_name, location, job_type, salary, experience_level, education_level, skills, posted_by FROM jobs";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function applyJob($jobId) {
        // Implementation for applying to a job
    }
}
?>
