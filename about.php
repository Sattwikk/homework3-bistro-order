<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chez Session | How It Works</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="site-header">
        <h1>Chez Session</h1>
        <p class="tagline">How the bistro remembers your order</p>
        <nav aria-label="Main">
            <ul>
                <li><a href="index.php">Order Form</a></li>
                <li><a href="about.php" aria-current="page">How It Works</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="card">
            <h2>The Request Loop</h2>
            <ol class="steps">
                <li><strong>index.php</strong> shows the form: a dessert menu, a drink menu, and drink size buttons.</li>
                <li>Pressing <em>Send to Kitchen</em> sends the choices to the server with a POST request.</li>
                <li><strong>process_order.php</strong> calls <code>order()</code>, which saves the choices in <code>$_SESSION</code> and builds the receipt.</li>
                <li>Anything left blank is saved as <em>(not selected)</em>.</li>
                <li><em>Order Again!</em> goes back to index.php. The browser sends the same session ID cookie, so the server finds the saved order.</li>
                <li>The restore helpers print <code>selected</code> on the saved menu options and <code>checked</code> on the saved size.</li>
                <li><strong>forget_order.php</strong> clears the session and calls <code>session_destroy()</code>, so the form starts fresh.</li>
            </ol>
        </section>

        <section class="card">
            <h2>Sessions and Cookies</h2>
            <p>A <strong>session</strong> stores the order on the server. The browser only holds a random session ID that tells the server which saved order belongs to this visitor.</p>
            <p>A <strong>cookie</strong> is stored in the browser itself. This site uses one small cookie, <code>lastVisit</code>, only to greet returning guests. The order is never stored in a cookie.</p>
        </section>
    </main>

    <footer class="site-footer">
        <p>Chez Session &middot; Web Programming Homework 03</p>
    </footer>
</body>
</html>
