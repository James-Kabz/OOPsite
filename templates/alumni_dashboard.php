<?php
session_start();

require_once '../config.php';
require_once '../classes/Alumni.php';

$database = new Database();
$db = $database->getConnection();

$alumni = new Alumni($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create_profile'])) {
        // Handle file upload
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["profile_picture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is real or fake
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $_SESSION['message'] = "File is not an image.";
        }

        // file exists
        if (file_exists($targetFile)) {
            $uploadOk = 0;
            $_SESSION['message'] = "File already exists.";
        }

        // file size
        if ($_FILES["profile_picture"]["size"] > 500000) {
            $uploadOk = 0;
            $_SESSION['message'] = "File is too large.";
        }

        //  file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $uploadOk = 0;
            $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }

        //  error
        if ($uploadOk == 0) {
            $_SESSION['message'] = isset($_SESSION['message']) ? $_SESSION['message'] : "Sorry, your file was not uploaded.";
        } else {
            // Create uploads directory if it doesn't exist
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                try {
                    $result = $alumni->createProfile($_POST, $targetFile);
                    if ($result) {
                        $_SESSION['message'] = "Profile created successfully";
                    } else {
                        $_SESSION['message'] = "Error creating profile in the database.";
                    }
                } catch (Exception $e) {
                    $_SESSION['message'] = "Error creating profile: " . $e->getMessage();
                }
            } else {
                // Log the error
                error_log("move_uploaded_file error: " . print_r(error_get_last(), true));
                $_SESSION['message'] = "Sorry, there was an error uploading your file.";
            }
        }

        // avoid form resubmission
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
    <title>Create Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body class="bg-blue-200 min-h-screen flex flex-col">
    <?php include('header.php'); ?>
    <div id="#home" class="flex-grow flex items-center justify-center">
        <div class="w-full max-w-3xl mx-auto bg-blue-100 p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-center mb-6">Create Profile</h1>
            <form method="POST" enctype="multipart/form-data" class="mb-6 ">
                <div class="mb-4">
                    <input type="text" name="username" placeholder="Username" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <input type="text" name="name" placeholder="Name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <input type="text" name="location" placeholder="Location" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <input type="text" name="phone" placeholder="Phone" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <textarea name="description" placeholder="Personal Description" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="mb-4">
                    <textarea name="education" placeholder="Education" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="mb-4">
                    <input type="file" name="profile_picture" required class=" px-4 py-2  rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" name="create_profile" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Create Profile</button>
            </form>
        </div>
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
