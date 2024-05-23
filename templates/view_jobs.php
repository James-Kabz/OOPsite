<?php
session_start();

require_once '../config.php';
require_once '../classes/Alumni.php';

$database = new Database();
$db = $database->getConnection();

$admin = new Alumni($db);
$jobs = $admin->viewJob();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Jobs</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-blue-200 min-h-screen">
    <?php include('header.php'); ?>
    <div class="container mx-auto mt-8 p-4">
        <div class="w-full max-w-4xl mx-auto bg-blue-200 p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-center mb-6">Job Listings</h1>
            <?php if (!empty($jobs)): ?>
                <div class="grid gap-6">
                    <?php foreach ($jobs as $job): ?>
                        <div class="p-6 bg-blue-300 rounded-lg shadow-md">
                            <h2 class="text-4xl font-bold mb-2"><?php echo htmlspecialchars($job['job_title']); ?></h2>
                            <p class="mb-2"><strong>Company:</strong> <?php echo htmlspecialchars($job['company_name']); ?></p>
                            <p class="mb-2"><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                            <p class="mb-2"><strong>Type:</strong> <?php echo htmlspecialchars($job['job_type']); ?></p>
                            <p class="mb-2"><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
                            <p class="mb-2"><strong>Experience Level:</strong> <?php echo htmlspecialchars($job['experience_level']); ?></p>
                            <p class="mb-2"><strong>Education Level:</strong> <?php echo htmlspecialchars($job['education_level']); ?></p>
                            <p class="mb-2"><strong>Skills:</strong> <?php echo htmlspecialchars($job['skills']); ?></p>
                            <p class="mb-2"><strong>Posted By:</strong> <?php echo htmlspecialchars($job['posted_by']); ?></p>
                            <p> <strong>Job Description : <br></strong><?php echo nl2br(htmlspecialchars($job['job_description'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center">No job listings available.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
