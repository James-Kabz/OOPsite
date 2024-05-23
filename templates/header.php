<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="sticky top-0 z-10 py-4 bg-blue-600 text-white relative py-4">
        <div class="container mx-auto flex justify-between items-center ">
            <h1 class="text-3xl font-bold ml-5">Alumni Dashboard</h1>
            <nav class="mr-20">
                <ul class="flex space-x-10 ">
                    <li><a href="alumni_dashboard.php" class="hover:text-gray-300">Create Profile</a></li>
                    <li><a href="view_jobs.php" class="hover:text-gray-300">View Jobs</a></li>
                    <li><a href="applyJob.php" class="hover:text-gray-300 mr-10">Apply for Job</a></li>

                    <button class="bg-red-700 text-white py-1 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"><li><a href="logout.php">Logout</a></li></button>
                </ul>
            </nav>
        </div>
    </header>
