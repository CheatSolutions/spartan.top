# A simple but beautiful website for the anti cheat project.

## Structure

- `config.php`: every piece of content and pricing (price, plans, FAQ, featured reviews, features, nav, documentation and Discord settings).
- `layout.php`: shared head, navbar, footer, first-visit loading transition, floating buy bar and helpers used by every page.
- `docs.php`: fetches the documentation from GitHub (raw files, cached for an hour) and renders it as website pages.
- `index.php`: the homepage (hero, trust bar, reviews carousel, features, pricing, steps, FAQ, community, final call to action).
- `documentation/`: the documentation index and pages (`/documentation/?page=slug`). New Markdown files added to the GitHub folder appear automatically.
- `reviews/`: the full wall of reviews. `contributors/` permanently redirects to the homepage.
- `paypal/` and `stripe/`: redirects to the checkout of the two plans (no recurring / set & forget).
- Short links such as `discord/`, `videos/`, `download/`, `tebex/` are plain redirects and are used outside of the website.

## Common edits

- Change the price: `$price_eur` in `config.php` (the monthly price and every label follow automatically).
- Change which reviews appear in the carousel: `$featured_reviews` (matched by name).
- Show a refund/guarantee promise under the plans: fill `$guarantee` (empty by default, so nothing is shown).
- Rename, describe or regroup a documentation page: `$docs_meta` (keyed by the page slug).
- The documentation cache lives in the system temp folder (`spartan-docs`). Delete it to force a refresh.
