<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}


// DB connection
$conn = new mysqli("localhost", "root", "", "classified_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submit logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION["username"];
    $category = $_POST["category"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $location = $_POST["location"];
    $phone = $_POST["phone"];
    $name = $_POST["name"];
    $tags = $_POST["tags"];

    // Handle image upload
    $image = $_FILES["image"]["name"];
    $target = "uploads/" . basename($image);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target);

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO ads (username, category, title, description, location, phone, name, image, tags) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $username, $category, $title, $description, $location, $phone, $name, $image, $tags);

    if ($stmt->execute()) {
        header("Location: view-ads.php");
        exit();
    } else {
        echo "Something went wrong!";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  
  <title>Post Ad | ClassifyX</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f7f7f7;
    }

    .container {
      max-width: 600px;
      margin: 30px auto;
      background: #fff;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #007bff;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input, textarea, select {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 12px;
      background: #007bff;
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #0056b3;
    }

    .category-select {
      margin-bottom: 25px;
    }

    @media (max-width: 600px) {
      .container {
        margin: 20px;
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Header include -->
   

  <!-- Post Ad Container -->
  <div class="container">
    <h2>Post Your Ad</h2>

    <!-- Ad Form -->
<form action="post-ad.php" method="POST" enctype="multipart/form-data">


  <label for="category">Select Category:</label>
  <select id="category" name="category" required>
    <option value="">-- Select --</option>
    <option value="electronics">Electronics</option>
    <option value="vehicles">Vehicles</option>
    <option value="realestate">Real Estate</option>
    <option value="jobs">Jobs</option>
    <option value="services">Services</option>
  </select>

  <label for="title">Ad Title:</label>
  <input type="text" id="title" name="title" placeholder="Enter Ad Title" required>

  <label for="description">Description:</label>
  <textarea id="description" name="description" rows="5" placeholder="Enter description here..." required></textarea>

  <label for="location">Location:</label>
  <input type="text" id="location" name="location" placeholder="Enter your location" required>

  <label for="phone">Phone Number:</label>
  <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>

  <label for="name">Your Name:</label>
  <input type="text" id="name" name="name" placeholder="Enter your name" required>

  <label for="image">Upload Image:</label>
  <input type="file" id="image" name="image" accept="image/*" required>

  <label for="tags">Tags:</label>
  <input type="text" id="tags" name="tags" placeholder="Example: mobile, iPhone, used">

  <button type="submit">Submit Ad</button>
</form>

    
</body>
</html>
