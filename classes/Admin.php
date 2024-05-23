<?php
require_once 'User.php';

class Admin extends User
{
    protected $table_name = "users";

    public function addAlumni($alumniData)
    {
        // Check if required fields are set
        if (!isset($alumniData['username'], $alumniData['email'], $alumniData['password'])) {
            throw new Exception("All fields are required.");
        }

        // Sanitize input data
        $username = htmlspecialchars(strip_tags($alumniData['username']));
        $email = htmlspecialchars(strip_tags($alumniData['email']));
        $password = htmlspecialchars(strip_tags($alumniData['password']));

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }

        // Hash the password
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insert 
        $query = "INSERT INTO " . $this->table_name . " (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($query);

        // Bind values
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $passwordHash);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new Exception("Unable to add alumni.");
        }
    }

    public function viewAlumni()
    {
        // Implementation for viewing alumni
        try {
            $query = "SELECT username,email,role FROM ".$this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $alumni = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $alumni;
        } catch(Exception $e) {
            throw new Exception("Error viewing alumni: ". $e->getMessage());
        }
    }

    public function updateAlumni($alumniId, $alumniData)
    {
        // Implementation for updating alumni
    }

    public function deleteAlumni($alumniId)
    {
        // Implementation for deleting alumni
    }

    public function postJob($jobData)
{
    // Check if required fields are set
    if (!isset($jobData['job_title'], $jobData['job_description'], $jobData['company_name'], $jobData['location'], $jobData['job_type'])) {
        throw new Exception("All fields are required.");
    }

    // Sanitize input data
    $jobTitle = htmlspecialchars(strip_tags($jobData['job_title']));
    $jobDescription = htmlspecialchars(strip_tags($jobData['job_description']));
    $companyName = htmlspecialchars(strip_tags($jobData['company_name']));
    $location = htmlspecialchars(strip_tags($jobData['location']));
    $jobType = htmlspecialchars(strip_tags($jobData['job_type']));
    $salary = isset($jobData['salary']) ? htmlspecialchars(strip_tags($jobData['salary'])) : null;
    $experienceLevel = isset($jobData['experience_level']) ? htmlspecialchars(strip_tags($jobData['experience_level'])) : null;
    $educationLevel = isset($jobData['education_level']) ? htmlspecialchars(strip_tags($jobData['education_level'])) : null;
    $skills = isset($jobData['skills']) ? htmlspecialchars(strip_tags($jobData['skills'])) : null;
    $postedBy = $_SESSION['username'];

    // Insert into database
    $query = "INSERT INTO jobs (job_title, job_description, company_name, location, job_type, salary, experience_level, education_level, skills, posted_by) 
              VALUES (:job_title, :job_description, :company_name, :location, :job_type, :salary, :experience_level, :education_level, :skills, :posted_by)";
    $stmt = $this->conn->prepare($query);

    // Bind values
    $stmt->bindParam(":job_title", $jobTitle);
    $stmt->bindParam(":job_description", $jobDescription);
    $stmt->bindParam(":company_name", $companyName);
    $stmt->bindParam(":location", $location);
    $stmt->bindParam(":job_type", $jobType);
    $stmt->bindParam(":salary", $salary);
    $stmt->bindParam(":experience_level", $experienceLevel);
    $stmt->bindParam(":education_level", $educationLevel);
    $stmt->bindParam(":skills", $skills);
    $stmt->bindParam(":posted_by", $postedBy);

    if ($stmt->execute()) {
        return true;
    } else {
        throw new Exception("Unable to post job.");
    }
}

}
