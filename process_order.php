<?php
require __DIR__ . '/order_functions.php';

// Only a form submission should change the saved order.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$orderSummary = order();

// Stamp the visit (recognition only). Must run before any output.
setcookie('lastVisit', date('l, F j, Y g:i a'), time() + 86400, cookiePath());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chez Session | Your Receipt</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="site-header">
        <h1>Chez Session</h1>
        <p class="tagline">Your order is in the kitchen</p>
        <nav aria-label="Main">
            <ul>
                <li><a href="index.php">Order Form</a></li>
                <li><a href="about.php">How It Works</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="card">
            <h2>Receipt</h2>
            <div class="receipt-card"><?= $orderSummary; ?></div>

            <div class="button-row">
                <a href="index.php" class="btn btn-primary">Order Again!</a>
                <a href="forget_order.php" class="btn btn-secondary">Forget Order</a>
            </div>
        </section>

        <section class="card insight-card" aria-labelledby="feedback-heading">
            <h2 id="feedback-heading">Order Feedback</h2>
            <p><?= htmlspecialchars(completionMessage()); ?></p>
            <p class="insight-note"><?= htmlspecialchars(pairingSuggestion()); ?></p>
        </section>

        <section class="card insight-card pricing-grid" aria-label="Order estimate">
            <div>
                <h2>Estimated Total</h2>
                <p class="price-figure"><?= htmlspecialchars(formattedTotal()); ?></p>
            </div>
            <div>
                <h2>Order Profile</h2>
                <p><?= htmlspecialchars(orderProfile()); ?></p>
            </div>
            <p class="insight-note full-width-note"><?= htmlspecialchars(pricingNote()); ?></p>
        </section>
    </main>

    <footer class="site-footer">
        <p>Chez Session &middot; Web Programming Homework 03</p>
    </footer>
</body>
</html>
