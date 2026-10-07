<?php
// Shared layout and helpers used by every page of the website.
// This file only defines functions, so it prints nothing if it is opened directly.

function sp_e($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Asset URL with a version suffix so visitors always get the latest CSS/JS after a deployment
function sp_asset(string $path): string
{
    global $website_url;
    $file = __DIR__ . '/' . $path;
    $version = is_file($file) ? filemtime($file) : false;
    return rtrim($website_url, '/') . '/' . $path . ($version ? '?v=' . $version : '');
}

function sp_money(float $amount): string
{
    return number_format($amount, 2, '.', '');
}

// Rounded down to the nearest ten, e.g. 96 reviews are shown as "90+"
function sp_review_milestone(array $reviews): int
{
    return (int)(floor(count($reviews) / 10) * 10);
}

// Picks the highlighted reviews (by name, in the configured order) for the homepage carousel
function sp_pick_reviews(array $reviews, array $featured, int $limit = 18): array
{
    $picked = [];

    if (!empty($featured)) {
        $byName = [];

        foreach ($reviews as $review) {
            $byName[trim((string)($review['name'] ?? ''))] = $review;
        }

        foreach ($featured as $name) {
            if (isset($byName[$name])) {
                $picked[] = $byName[$name];
            }
        }
    }
    return array_slice(empty($picked) ? $reviews : $picked, 0, $limit);
}

// Profile picture with the first letter of the name as a fallback for missing or broken images
function sp_avatar(array $review): string
{
    $name = trim((string)($review['name'] ?? ''));
    $initial = function_exists('mb_substr')
        ? mb_strtoupper(mb_substr($name, 0, 1, 'UTF-8'), 'UTF-8')
        : strtoupper(substr($name, 0, 1));
    $picture = trim((string)($review['picture'] ?? ''));
    $html = '<span class="avatar" aria-hidden="true">' . sp_e($initial);

    if ($picture !== '' && !str_contains($picture, 'assets/img/picture.png')) {
        $html .= '<img src="' . sp_e($picture) . '" alt="" width="40" height="40" loading="lazy" '
            . 'referrerpolicy="no-referrer" onerror="this.remove()">';
    }
    return $html . '</span>';
}

function sp_head(array $page = []): void
{
    global $website_url, $website_title, $website_description, $website_icon, $website_banner, $website_color;
    $title = $page['title'] ?? $website_title;
    $description = $page['description'] ?? $website_description;
    $canonical = rtrim($website_url, '/') . '/' . ltrim($page['path'] ?? '', '/');
    $schemas = $page['schemas'] ?? [];
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>document.documentElement.className += ' js';</script>
    <?php if (!empty($page['home'])) : ?>
        <script src='https://www.idealistic.ai/.scripts/v1/portal.js' data-portal='8jfKNAFjqn86yiLI'
                id='idealistic-script' defer></script>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2051186056820234"
                crossorigin="anonymous"></script>
    <?php endif; ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-779938233"></script>
    <script> window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'AW-779938233'); </script>
    <title><?= sp_e($title) ?></title>
    <link rel="canonical" href="<?= sp_e($canonical) ?>">
    <link rel="icon" type="image/png" href="<?= sp_e($website_icon) ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= sp_e($website_icon) ?>">
    <meta name="title" content="<?= sp_e($title) ?>">
    <meta name="description" content="<?= sp_e($description) ?>">
    <meta name="theme-color" content="<?= sp_e($website_color) ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Spartan AntiCheat">
    <meta property="og:url" content="<?= sp_e($canonical) ?>">
    <meta property="og:title" content="<?= sp_e($title) ?>">
    <meta property="og:description" content="<?= sp_e($description) ?>">
    <meta property="og:image" content="<?= sp_e($website_banner) ?>">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= sp_e($canonical) ?>">
    <meta property="twitter:title" content="<?= sp_e($title) ?>">
    <meta property="twitter:description" content="<?= sp_e($description) ?>">
    <meta property="twitter:image" content="<?= sp_e($website_banner) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="<?= sp_e(sp_asset('assets/css/bootstrap.min.css')) ?>">
    <link rel="stylesheet" href="<?= sp_e(sp_asset('assets/css/styles.css')) ?>">
    <script src="<?= sp_e(sp_asset('assets/js/particles.min.js')) ?>" defer></script>
    <?php foreach ($schemas as $schema) : ?>
        <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
    <?php endforeach; ?>
</head>
    <?php
}

function sp_navbar(): void
{
    global $logo, $navlinks, $nav_cta, $website_url;
    ?>
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container d-flex">
            <a class="navbar-brand" href="<?= sp_e($website_url) ?>">
                <img alt="Spartan AntiCheat" width="72" height="72" src="<?= sp_e($logo) ?>">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ms-auto text-center align-items-lg-center">
                    <?php foreach ($navlinks as $label => $location) : ?>
                        <li class="nav-links">
                            <a href="<?= sp_e($location) ?>"><?= sp_e($label) ?></a>
                        </li>
                    <?php endforeach; ?>
                    <li class="nav-links nav-cta">
                        <a class="primary-button solid small" href="<?= sp_e($nav_cta['url']) ?>"
                           data-track="nav_cta"><?= sp_e($nav_cta['label']) ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
}

function sp_footer(): void
{
    global $logo, $website_url, $free_link;
    $base = rtrim($website_url, '/');
    ?>
<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <a href="<?= sp_e($website_url) ?>">
                    <img alt="Spartan AntiCheat" width="64" height="64" loading="lazy" src="<?= sp_e($logo) ?>">
                </a>
                <p class="mt-3">The longest living paid Minecraft anti-cheat. Protecting Java & Bedrock servers
                    since 2016.</p>
            </div>
            <div class="col-6 col-lg-3">
                <h4>Spartan</h4>
                <ul>
                    <li><a href="<?= sp_e($base) ?>/#pricing">Pricing</a></li>
                    <li><a href="<?= sp_e($base) ?>/reviews">Reviews</a></li>
                    <li><a href="<?= sp_e($free_link) ?>">Free version</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-4">
                <h4>Resources</h4>
                <ul>
                    <li><a href="<?= sp_e($base) ?>/documentation">Documentation</a></li>
                    <li><a href="<?= sp_e($base) ?>/discord">Discord</a></li>
                    <li><a href="<?= sp_e($base) ?>/videos">Videos</a></li>
                    <li><a href="<?= sp_e($base) ?>/stats">Live statistics</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2016-<?= date('Y') ?> Spartan AntiCheat. Not affiliated with Mojang Studios or Microsoft.
                Minecraft is a trademark of Mojang Synergies AB.</p>
        </div>
    </div>
</footer>
    <?php
}

// Floating "buy" reminder, shown once the visitor scrolls past the top of the page
function sp_buy_bar(): void
{
    global $website_url, $price_eur, $price_per_month_eur;
    ?>
<div class="buy-bar" id="buyBar">
    <div class="buy-bar-text">
        <strong>Spartan AntiCheat</strong>
        <span>&euro;<?= sp_money($price_eur) ?>/year &middot; about &euro;<?= sp_money($price_per_month_eur) ?>/month</span>
    </div>
    <a class="primary-button solid small" href="<?= sp_e(rtrim($website_url, '/')) ?>/#pricing"
       data-track="sticky_bar">Get Spartan</a>
</div>
    <?php
}

function sp_scripts(array $page = []): void
{
    global $price_eur;
    sp_buy_bar();
    ?>
<script>window.SPARTAN_PRICE = <?= json_encode((float)$price_eur) ?>;</script>
<script src="<?= sp_e(sp_asset('assets/js/bootstrap.min.js')) ?>" defer></script>
<script src="<?= sp_e(sp_asset('assets/js/index.js')) ?>" defer></script>
    <?php if (!empty($page['paddle'])) : ?>
    <!-- Paddle.js Setup -->
<script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>
<script type="text/javascript">
    Paddle.Environment.set('production');
    Paddle.Initialize({
        token: 'live_70322f80b2ae7f8e648ea587754'
    });
</script>
    <?php endif;
}
