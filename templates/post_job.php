<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once '../config.php';
require_once '../classes/Admin.php';

$database = new Database();
$db = $database->getConnection();

$admin = new Admin($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_job'])) {
    try {
        $admin->postJob($_POST);
        $_SESSION['message'] = "Job was successfully posted.";
    } catch (Exception $e) {
        $_SESSION['message'] = "Error while posting job: " . $e->getMessage();
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Job</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body class="bg-blue-200 min-h-screen flex flex-col">
    <?php include('admin_header.php'); ?>
    <div class="w-full max-w-5xl mx-auto bg-blue-200 p-8 rounded-lg shadow-lg mt-2">
        <h1 class="text-3xl font-bold text-center mb-6">Post Job</h1>
        <form method="post">
            <div class="mb-4 text-gray-700">
                <input type="text" name="job_title" placeholder="Job Title" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
            </div>
            <div class="mb-4">
                <textarea name="job_description" placeholder="Job Description" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"></textarea>
            </div>
            <div class="mb-4">
                <input name="company_name" placeholder="Company Name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"></input>
            </div>
            <div class="mb-4">
                <input name="location" placeholder="Location" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"></input>
            </div>
            <div class="mb-4">
                <select name="job_type" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                    <option value="" disabled selected>Select Job Type</option>
                    <option value="Full-time">Full-time</option>
                    <option value="Part-time">Part-time</option>
                    <option value="Contract">Contract</option>
                </select>
            </div>
            <div class="mb-4">
                <input type="number" name="salary" placeholder="Salary" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"></input>
            </div>
            <div class="mb-4">
                <textarea name="experience_level" placeholder="Experience Level" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"></textarea>
            </div>
            <div class="mb-4">
                <input name="education_level" placeholder="Education Level" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"></input>
            </div>
            <div class="mb-4">
                <input name="skills" placeholder="Skills" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"></input>
            </div>
            <button type="submit" name="post_job" class="w-full bg-blue-500 tblue-200 py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Post Job</button>
        </form>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Toastify({
                    text: "<?php echo $_SESSION['message']; ?>",
                    duration: 3000,
                    gravity: "top", 
                    position: 'right', 
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                    stopOnFocus: true 
                }).showToast();
            });
        </script>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</body>
</html>
