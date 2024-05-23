<?php
class Job {
    private $conn;
    private $table_name = "jobs";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createJob($jobData) {
        // Implementation for creating a job post
    }

    public function getJobs() {
        // Implementation for retrieving all job posts
    }

    public function deleteJob($jobId) {
        // Implementation for deleting a job post
    }
}
?>
