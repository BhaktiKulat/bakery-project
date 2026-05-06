<?php
require_once 'php/session.php';

// Read all feedback to display them
$feedbacks = readJsonFile('data/feedback.json');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews - Sweet Crumbs</title>
    <link rel="stylesheet" href="css/style.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        .feedback-container { max-width: 800px; margin: 40px auto; padding: 0 5%; }
        .feedback-card { background: white; padding: 25px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); margin-bottom: 20px; }
        .stars { color: #ffc107; font-size: 20px; margin-bottom: 10px; }
        
        .form-card { background: var(--secondary-color); padding: 30px; border-radius: var(--radius-lg); margin-top: 40px; }
        .rating-select { font-size: 24px; cursor: pointer; color: #ccc; }
        .rating-select.selected { color: #ffc107; }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="index.html" class="logo"><span>🍰</span> Sweet Crumbs</a>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="customize.html">Customize</a></li>
        </ul>
    </nav>

    <div class="feedback-container">
        
        <div style="text-align: center; margin-bottom: 40px;">
            <h2>What our Sweet Customers Say</h2>
            <p style="color: var(--text-light);">Read reviews about our custom desserts!</p>
        </div>

        <?php if(empty($feedbacks)): ?>
            <p style="text-align:center;">No reviews yet. Be the first!</p>
        <?php else: ?>
            <?php foreach(array_reverse($feedbacks) as $fb): ?>
                <div class="feedback-card">
                    <div class="stars">
                        <?php for($i=0; $i<$fb['rating']; $i++) echo '<ion-icon name="star"></ion-icon>'; ?>
                    </div>
                    <p style="font-size: 16px; margin-bottom: 10px;">"<?php echo htmlspecialchars($fb['comment']); ?>"</p>
                    <p style="color: var(--text-light); font-size: 14px;">- <?php echo htmlspecialchars($fb['name']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if(isLoggedIn()): ?>
            <div class="form-card">
                <h3>Leave a Review</h3>
                <form action="php/save-feedback.php" method="POST">
                    <input type="hidden" name="rating" id="rating-val" value="5">
                    
                    <div style="margin: 15px 0;" id="star-selector">
                        <ion-icon name="star" class="rating-select selected" data-val="1"></ion-icon>
                        <ion-icon name="star" class="rating-select selected" data-val="2"></ion-icon>
                        <ion-icon name="star" class="rating-select selected" data-val="3"></ion-icon>
                        <ion-icon name="star" class="rating-select selected" data-val="4"></ion-icon>
                        <ion-icon name="star" class="rating-select selected" data-val="5"></ion-icon>
                    </div>

                    <div class="form-group">
                        <textarea name="comment" rows="4" required placeholder="Tell us how much you loved it..." style="width:100%; padding:15px; border-radius:8px; border:1px solid #ddd;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
        <?php else: ?>
            <div style="text-align:center; margin-top: 40px;">
                <p>Please <a href="login.php" style="color:var(--primary-color);">login</a> to leave a review.</p>
            </div>
        <?php endif; ?>

    </div>

    <script>
        // Simple star rating script
        const stars = document.querySelectorAll('.rating-select');
        const input = document.getElementById('rating-val');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const val = parseInt(this.dataset.val);
                input.value = val;
                
                stars.forEach((s, index) => {
                    if(index < val) s.classList.add('selected');
                    else s.classList.remove('selected');
                });
            });
        });
    </script>
</body>
</html>
