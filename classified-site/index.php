<!-- index.php -->
<?php include 'includes/header.php'; ?>

<?php
// Connect to DB
$conn = new mysqli("localhost", "root", "", "classified_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get latest 4 ads
$ads = $conn->query("SELECT * FROM ads ORDER BY created_at DESC LIMIT 4");
?>

<style>
/* Existing hero styles */
.hero {
  min-height: 80vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #007bff, #00c2ff);
  color: white;
  text-align: center;
  padding: 20px;
  animation: fadeIn 1s ease-in;
}
.hero h1 {
  font-size: 48px;
  margin-bottom: 10px;
  animation: slideUp 0.8s ease-in-out;
}
.hero p {
  font-size: 18px;
  opacity: 0.9;
}
.cta-btn, .add-post-btn {
  margin-top: 30px;
  padding: 14px 28px;
  border: 2px solid white;
  background: transparent;
  color: white;
  font-size: 16px;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.4s ease;
}
.cta-btn:hover, .add-post-btn:hover {
  background: white;
  color: #007bff;
  transform: scale(1.05);
}
@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity: 1;}
}
@keyframes slideUp {
  0% { transform: translateY(20px); opacity: 0; }
  100% { transform: translateY(0); opacity: 1; }
}
@media (max-width: 600px) {
  .hero h1 { font-size: 30px; }
  .cta-btn { padding: 12px 20px; font-size: 14px; }
}

/* Ads section styles */
.latest-ads {
  padding: 40px 20px;
  background: #f9f9f9;
  text-align: center;
}
.latest-ads h2 {
  font-size: 32px;
  margin-bottom: 30px;
  color: #007bff;
}
.ads-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  max-width: 1200px;
  margin: auto;
}
.ad-card {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  overflow: hidden;
  transition: transform 0.3s ease;
}
.ad-card:hover {
  transform: translateY(-5px);
}
.ad-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
}
.ad-details {
  padding: 15px;
  text-align: left;
}
.ad-details h3 {
  margin: 0 0 10px;
  font-size: 20px;
}
.ad-details p {
  margin: 5px 0;
  color: #555;
}
.view-btn {
  display: inline-block;
  margin-top: 10px;
  padding: 8px 15px;
  border: 2px solid #007bff;
  background: transparent;
  color: #007bff;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  transition: all 0.3s ease;
}
.view-btn:hover {
  background: #007bff;
  color: #fff;
}
</style>

<section class="hero">
  <div>
    <h1>Welcome to ClassifyX</h1>
    <p>Post. Search. Buy. Sell. All in one global platform.</p>
    <a href="post-ad.php" class="add-post-btn">Post Your First Ad</a>
  </div>
</section>

<!-- Latest Ads Section -->
<section class="latest-ads">
  <h2>Latest Ads</h2>
  <div class="ads-container">
    <?php while($row = $ads->fetch_assoc()) { ?>
      <div class="ad-card">
        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Ad Image">
        <div class="ad-details">
          <h3><?php echo htmlspecialchars($row['title']); ?></h3>
          <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($row['price'] ?? 'N/A'); ?></p>
          <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
          <a href="view-ad.php?id=<?php echo $row['id']; ?>" class="view-btn">View Details</a>
        </div>
      </div>
    <?php } ?>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
