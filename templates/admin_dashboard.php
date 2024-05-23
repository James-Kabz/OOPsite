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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_alumni'])) {
        try {
            $admin->addAlumni($_POST);
            $_SESSION['message'] = "Alumni added successfully";
        } catch (Exception $e) {
            $_SESSION['message'] = "Error adding alumni: " . $e->getMessage();
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body class="bg-blue-200 min-h-screen flex flex-col">
    <?php include('admin_header.php'); ?>
    <div class="w-full max-w-4xl mx-auto bg-blue-200 p-14 rounded-lg shadow-lg mt-8">
        <h1 class="text-3xl font-bold text-center mb-6">Admin Dashboard</h1>
        <form method="post" class="mb-6">
            <h2 class="text-2xl font-semibold mb-4">Add Alumni</h2>
            <div class="mb-4">
                <input type="text" name="username" placeholder="Username" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" name="add_alumni" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Add Alumni</button>
        </form>
        <!-- <div class="mt-8">
            <a href="post_job.php" class="w-full bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 block text-center">Post Job</a>
        </div> -->
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
