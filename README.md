# Chez Session - Homework 03

A PHP bistro order form that remembers a customer's dessert, drink, and drink size using PHP sessions.

## Files
| File | Role |
|---|---|
| `index.php` | Order form; restores saved choices with the helper functions |
| `process_order.php` | Receives the POST, calls `order()`, prints the receipt, sets the `lastVisit` cookie |
| `order_functions.php` | `session_start()`, `order()`, restore helpers, pricing/pairing extras |
| `forget_order.php` | Clears the session, calls `session_destroy()`, redirects to the form |
| `about.php` | Explains the request loop |
| `styles.css` | Layout and styling |

## Session variables
`$_SESSION['dessert']`, `$_SESSION['drink']`, `$_SESSION['drinkSize']`. Empty, `none`, or off-menu values are stored as `(not selected)`.

## Run locally
Put the `hw3` folder in XAMPP/MAMP `htdocs` and open `http://localhost/hw3/index.php`.
