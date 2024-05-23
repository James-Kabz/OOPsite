<?php
session_start();

require_once '../config.php';
require_once '../classes/Admin.php';

$database = new Database();
$db = $database->getConnection();

$alumni = new Admin($db);

try {
    $alumniList = $alumni->viewAlumni();
} catch (Exception $e) {
    $_SESSION['message'] = "Error fetching alumni: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body class="bg-blue-200 min-h-screen flex flex-col ">
    <?php include('admin_header.php')?>
    <div class="w-full max-w-7xl  mx-auto bg-blue-300 p-8 rounded-lg shadow-lg mt-10">
        <h1 class="text-3xl font-bold text-center mb-6">Alumni List</h1>
        <table class=" min-w-full bg-blue-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-blue-300">Username</th>
                     <th class="py-2 px-4 bg-blue-300">Role</th>
                    <th class="py-2 px-4 bg-blue-300">Email</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <?php if (!empty($alumniList)): ?>
                    <?php foreach ($alumniList as $alumnus): ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($alumnus['username']); ?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($alumnus['role'])?></td>
                            <td class="border px-4 py-2"><?php echo htmlspecialchars($alumnus['email']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="border px-4 py-2 text-center">No alumni found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
