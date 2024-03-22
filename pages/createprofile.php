<!-- pages/create_profile.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile - Elderly Care Connect</title>
    <link rel="stylesheet" href="../css/createprofile.css">
</head>
<body>
    <div class="container-createprofile">
        <h2>Create New Profile</h2>
        <form action="homepage.php" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="summary">Summary:</label>
            <textarea id="summary" name="summary" required></textarea>
            <label for="picture">Picture:</label>
            <input type="file" id="picture" name="picture" accept="image/*" required>
            <button type="submit">Create Profile</button>
        </form>
    </div>
</body>
</html>

