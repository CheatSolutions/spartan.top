# A simple but beautiful website for the anti cheat project.

## Structure

- `config.php`: every piece of content and pricing (price, plans, FAQ, featured reviews, features, nav).
- `layout.php`: shared head, navbar, footer, floating buy bar and helpers used by every page.
- `index.php`: the homepage (hero, trust bar, reviews carousel, features, pricing, FAQ, final call to action).
- `reviews/index.php`: the full wall of reviews. `contributors/` permanently redirects to the homepage.
- `paypal/` and `stripe/`: redirects to the checkout of the two plans (annual purchase / annual subscription).

## Common edits

- Change the price: `$price_eur` in `config.php` (the monthly price and every label follow automatically).
- Change which reviews appear in the carousel: `$featured_reviews` (matched by name).
- Show a refund/guarantee promise under the plans: fill `$guarantee` (empty by default, so nothing is shown).
