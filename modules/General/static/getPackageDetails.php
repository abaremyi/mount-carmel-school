<?php
require_once '../../../config/database.php';

header('Content-Type: text/html');

$packageId = $_GET['package_id'] ?? 0;

try {
    $db = Database::getInstance();
    
    // Get package info
    $stmt = $db->prepare("SELECT * FROM tourism_packages WHERE id = ?");
    $stmt->execute([$packageId]);
    $package = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$package) {
        echo '<div class="error-message">Package not found</div>';
        exit;
    }
    
    // Get package days
    $stmt = $db->prepare("SELECT * FROM package_days WHERE package_id = ? ORDER BY day_number");
    $stmt->execute([$packageId]);
    $days = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($days)) {
        echo '<div class="error-message">No itinerary found for this package</div>';
        exit;
    }
    
    // Generate HTML
    ?>
    <div class="package-details-holder">
        <!-- Left Navigation -->
        <div class="left-nav">
            <div class="nav-title"><?php echo htmlspecialchars($package['title']); ?></div>
            <ul class="nav-menu">
                <?php foreach ($days as $day): ?>
                    <li class="det-nav-item" data-day="<?php echo $day['day_number']; ?>">
                        <a href="#" class="det-nav-link">Day <?php echo $day['day_number']; ?>: <?php echo htmlspecialchars($day['title']); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Right Content Area - Will be populated by JavaScript -->
        <?php foreach ($days as $day): ?>
            <div id="day-<?php echo $day['day_number']; ?>" class="right-content day-content" style="display: none;">
                <img src="../../../assets/image/<?php echo htmlspecialchars($day['image']); ?>" 
                     alt="<?php echo htmlspecialchars($day['title']); ?>" class="content-image">
                <div class="content-details">
                    <p class="details-text">
                        <?php echo htmlspecialchars($day['description']); ?>
                    </p>
                    <button class="action-button" onclick="handleBooking(<?php echo $package['id']; ?>)">
                        Book Your Stay Now
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
} catch (PDOException $e) {
    echo '<div class="error-message">Error loading package details</div>';
}
?>