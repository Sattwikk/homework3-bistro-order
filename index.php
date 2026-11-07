<?php
require __DIR__ . '/order_functions.php';

// Stop the browser from showing a cached copy of the form after a reset.
header('Cache-Control: no-store, no-cache, must-revalidate');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chez Session | Order Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="site-header">
        <h1>Chez Session</h1>
        <p class="tagline">A small bistro with a good memory</p>
        <nav aria-label="Main">
            <ul>
                <li><a href="index.php" aria-current="page">Order Form</a></li>
                <li><a href="about.php">How It Works</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <p class="welcome-note"><?= welcomeMessage(); ?></p>

        <section class="card">
            <h2>Build Your Order</h2>

            <form action="process_order.php" method="post">
                <div class="field">
                    <label for="dessert">Dessert</label>
                    <select id="dessert" name="dessert">
                        <option value="none">-- Choose a dessert --</option>
<?php foreach (DESSERT_PRICES as $name => $price): ?>
                        <option value="<?= htmlspecialchars($name); ?>" <?= dessertSelected($name); ?>><?= htmlspecialchars($name); ?> ($<?= number_format($price, 2); ?>)</option>
<?php endforeach; ?>
                    </select>
                </div>

                <div class="field">
                    <label for="drink">Drink</label>
                    <select id="drink" name="drink">
                        <option value="none">-- Choose a drink --</option>
<?php foreach (DRINK_PRICES as $name => $price): ?>
                        <option value="<?= htmlspecialchars($name); ?>" <?= drinkSelected($name); ?>><?= htmlspecialchars($name); ?> ($<?= number_format($price, 2); ?>)</option>
<?php endforeach; ?>
                    </select>
                </div>

                <fieldset class="field">
                    <legend>Drink size</legend>
                    <div class="radio-row">
<?php foreach (SIZE_UPCHARGE as $size => $extra): ?>
                        <label class="radio-option">
                            <input type="radio" name="drinkSize" value="<?= $size; ?>" <?= drinkSizeSelected($size); ?>>
                            <?= $size; ?><?= $extra > 0 ? ' (+$' . number_format($extra, 2) . ')' : ''; ?>
                        </label>
<?php endforeach; ?>
                    </div>
                </fieldset>

                <div class="button-row">
                    <button type="submit" class="btn btn-primary">Send to Kitchen</button>
                    <a href="forget_order.php" class="btn btn-secondary">Forget Order</a>
                </div>
            </form>
        </section>

        <section class="card insight-card" aria-labelledby="guidance-heading">
            <h2 id="guidance-heading">Live Guidance</h2>
            <p><?= htmlspecialchars(completionMessage()); ?></p>
            <p class="insight-note"><?= htmlspecialchars(pairingSuggestion()); ?></p>
        </section>

        <section class="card insight-card pricing-grid" aria-label="Saved order estimate">
            <div>
                <h2>Estimated Total</h2>
                <p class="price-figure"><?= htmlspecialchars(formattedTotal()); ?></p>
            </div>
            <div>
                <h2>Order Profile</h2>
                <p><?= htmlspecialchars(orderProfile()); ?></p>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <p>Chez Session &middot; Web Programming Homework 03</p>
    </footer>
</body>
</html>
