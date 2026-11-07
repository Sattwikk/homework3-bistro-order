<?php
session_start();

date_default_timezone_set('America/New_York');

const NOT_SELECTED = '(not selected)';

const DESSERT_PRICES = [
    'Cheesecake'     => 4.25,
    'Chocolate Cake' => 4.50,
    'Carrot Cake'    => 4.00,
    'Tiramisu'       => 4.75,
];

const DRINK_PRICES = [
    'Coffee'        => 2.25,
    'Hot Chocolate' => 2.75,
    'Root Beer'     => 2.50,
    'Tea'           => 2.00,
    'Milk'          => 1.75,
];

const SIZE_UPCHARGE = [
    'Small'  => 0.00,
    'Medium' => 0.60,
    'Large'  => 1.15,
];

/**
 * Returns the cleaned value if it is on the menu, otherwise the fallback.
 * Empty strings, "none", and anything not in the allowed list all become (not selected).
 */
function cleanChoice(string $raw, array $allowed): string {
    $value = trim($raw);

    if ($value === '' || $value === 'none' || !array_key_exists($value, $allowed)) {
        return NOT_SELECTED;
    }

    return $value;
}

/**
 * Reads the posted order, saves it into the session, and returns the receipt text.
 */
function order(): string {
    $_SESSION['dessert']   = cleanChoice($_POST['dessert'] ?? '', DESSERT_PRICES);
    $_SESSION['drink']     = cleanChoice($_POST['drink'] ?? '', DRINK_PRICES);
    $_SESSION['drinkSize'] = cleanChoice($_POST['drinkSize'] ?? '', SIZE_UPCHARGE);

    return 'Dessert: ' . htmlspecialchars($_SESSION['dessert']) . '<br>'
         . 'Drink: ' . htmlspecialchars($_SESSION['drink']) . '<br>'
         . 'Drink size: ' . htmlspecialchars($_SESSION['drinkSize']);
}

function sessionValue(string $key): string {
    return $_SESSION[$key] ?? NOT_SELECTED;
}

/* ---------- Restore helpers ---------- */

function dessertSelected(string $dessert): string {
    return ($_SESSION['dessert'] ?? '') === $dessert ? 'selected' : '';
}

function drinkSelected(string $drink): string {
    return ($_SESSION['drink'] ?? '') === $drink ? 'selected' : '';
}

function drinkSizeSelected(string $drinkSize): string {
    return ($_SESSION['drinkSize'] ?? '') === $drinkSize ? 'checked' : '';
}

/* ---------- Progress, pairing and pricing extras ---------- */

function completedChoiceCount(): int {
    $count = 0;

    foreach (['dessert', 'drink', 'drinkSize'] as $key) {
        if (sessionValue($key) !== NOT_SELECTED) {
            $count++;
        }
    }

    return $count;
}

function completionMessage(): string {
    $count = completedChoiceCount();

    if ($count === 3) {
        return 'Your order is complete.';
    }

    if ($count === 0) {
        return 'Start by choosing a dessert, a drink, and a size.';
    }

    return "You have completed {$count} of 3 order choices.";
}

function pairingSuggestion(): string {
    $dessert = sessionValue('dessert');
    $drink   = sessionValue('drink');

    if ($dessert === NOT_SELECTED || $drink === NOT_SELECTED) {
        return 'Select both a dessert and a drink to see a suggested pairing.';
    }

    $pairings = [
        'Cheesecake|Coffee'   => 'Cheesecake and coffee make a classic cafe-style combo.',
        'Chocolate Cake|Milk' => 'Chocolate cake and milk are a rich, familiar pairing.',
        'Tiramisu|Coffee'     => 'Tiramisu and coffee double up on the espresso flavor.',
        'Carrot Cake|Tea'     => 'Carrot cake and tea make a lighter, balanced combination.',
    ];

    return 'Suggested pairing: '
        . ($pairings["{$dessert}|{$drink}"] ?? "{$dessert} with {$drink} gives the order a custom bistro feel.");
}

function dessertPrice(): float {
    return DESSERT_PRICES[sessionValue('dessert')] ?? 0.0;
}

function drinkPrice(): float {
    $drink = sessionValue('drink');

    if (!isset(DRINK_PRICES[$drink])) {
        return 0.0;
    }

    return DRINK_PRICES[$drink] + (SIZE_UPCHARGE[sessionValue('drinkSize')] ?? 0.0);
}

function estimatedTotal(): float {
    return dessertPrice() + drinkPrice();
}

function formattedTotal(): string {
    return '$' . number_format(estimatedTotal(), 2);
}

function pricingNote(): string {
    if (sessionValue('drink') !== NOT_SELECTED && sessionValue('drinkSize') === NOT_SELECTED) {
        return 'Choose a drink size to finalize the drink price.';
    }

    if (completedChoiceCount() === 0) {
        return 'Your estimated total will update once you start building an order.';
    }

    return 'The estimate is based on your current dessert, drink, and size.';
}

function orderProfile(): string {
    $total = estimatedTotal();

    if ($total >= 6.5) {
        return 'Full cafe combo';
    }

    if ($total >= 4.0) {
        return 'Balanced dessert break';
    }

    if ($total > 0) {
        return 'Light snack order';
    }

    return 'No selections yet';
}

/* ---------- Cookie helpers (recognition only, never order data) ---------- */

function cookiePath(): string {
    // Scope the cookie to this project folder, not the whole shared server.
    return rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/') . '/';
}

function welcomeMessage(): string {
    if (isset($_COOKIE['lastVisit'])) {
        return 'Welcome back! Your last order was placed ' . htmlspecialchars($_COOKIE['lastVisit']) . '.';
    }

    return 'First time at Chez Session? Welcome in!';
}
