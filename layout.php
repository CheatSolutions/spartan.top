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

    if ($picture !== '') {
        $html .= '<img src="' . sp_e($picture) . '" alt="" width="40" height="40" loading="lazy" '
            . 'referrerpolicy="no-referrer" onerror="this.remove()">';
    }
    return $html . '</span>';
}

// Estimates how well a review is written (0-100): capitalisation, punctuation, typos, substance and a sensible length
function sp_review_score(array $review): float
{
    $text = trim((string)($review['review'] ?? ''));
    $length = mb_strlen($text, 'UTF-8');
    $score = 50.0;

    $score += preg_match('/^\p{Lu}/u', $text) ? 8 : -8;
    $score += preg_match('/[.!?)"\']\s*$/u', $text) ? 6 : -4;
    $score -= min(12, 4 * (int)preg_match_all('/[.!?]\s+\p{Ll}/u', $text));
    $score -= min(10, 5 * (int)preg_match_all('/\bi\b/u', $text));
    $score -= min(9, 3 * (int)preg_match_all('/\b\p{Lu}{4,}\b/u', $text));
    $score -= min(10, 5 * (int)preg_match_all('/[!?]{2,}|\.{2,}/u', $text));
    $score -= 3 * (int)preg_match_all('/\s{2,}/u', $text);

    foreach (['versitile', 'flase', 'activly', 'pluggin', 'defiantly', 'recomend', 'ressource', 'configutation', 'evrery',
                 'beeng', 'helpfull', 'buyt', 'deff', 'anicheat', 'anticheats that', 'wanna'] as $typo) {
        if (stripos($text, $typo) !== false) {
            $score -= 6;
        }
    }
    $sentences = max(1, (int)preg_match_all('/[.!?]+(?:\s|$)/u', $text));
    $score += $sentences >= 3 ? 10 : ($sentences === 2 ? 6 : 0);

    if ($length >= 90 && $length <= 260) {
        $score += 10;
    } elseif ($length >= 60 && $length <= 330) {
        $score += 4;
    } elseif ($length < 45) {
        $score -= 10;
    } elseif ($length > 330) {
        $score -= 6;
    }
    $words = preg_split('/\s+/u', mb_strtolower($text, 'UTF-8'), -1, PREG_SPLIT_NO_EMPTY);

    if (count($words) >= 8 && count(array_unique($words)) / count($words) < 0.7) {
        $score -= 4;
    }
    $substance = 0;

    foreach (['support', 'update', 'config', 'api', 'bedrock', 'java', 'false positive', 'detect', 'documentation', 'version',
                 'worth', 'best', 'excellent', 'amazing', 'perfect', 'reliable'] as $keyword) {
        if (stripos($text, $keyword) !== false) {
            $substance += 2;
        }
    }
    $score += min(10, $substance);

    if (preg_match('/\bplay\.|https?:|www\.|\.(net|xyz|com)\b/i', $text)) {
        $score -= 30;
    }

    if (preg_match('/not the best|wasn\'?t what i expected/i', $text)) {
        $score -= 25;
    }
    return max(0.0, min(100.0, $score));
}

// Best written reviews first, while every row of cards gets reviews of a similar length so they sit well next to each other
function sp_arrange_reviews(array $reviews, int $columns = 3): array
{
    $items = [];

    foreach (array_values($reviews) as $index => $review) {
        $items[] = [
            'review' => $review,
            'score' => sp_review_score($review),
            'length' => mb_strlen(trim((string)($review['review'] ?? '')), 'UTF-8'),
            'index' => $index
        ];
    }
    usort($items, function ($a, $b) {
        return [$b['score'], $a['index']] <=> [$a['score'], $b['index']];
    });
    $arranged = [];

    while (!empty($items)) {
        $row = [array_shift($items)];

        while (count($row) < $columns && !empty($items)) {
            $target = array_sum(array_column($row, 'length')) / count($row);
            $best = 0;
            $bestCost = INF;

            // Only the next few best reviews are considered, so quality drifts down slowly instead of jumping around
            foreach (array_slice($items, 0, 14, true) as $position => $candidate) {
                $cost = abs($candidate['length'] - $target) / max(60, $target) + 0.06 * $position;

                if ($cost < $bestCost) {
                    $best = $position;
                    $bestCost = $cost;
                }
            }
            $row[] = $items[$best];
            array_splice($items, $best, 1);
        }

        // Cards in the same row share one type size, so neighbours never look mismatched
        $average = array_sum(array_column($row, 'length')) / count($row);
        $size = $average <= 125 ? 'is-short' : ($average <= 195 ? 'is-medium' : 'is-long');

        foreach ($row as $item) {
            $item['review']['_size'] = $size;
            $arranged[] = $item['review'];
        }
    }
    return $arranged;
}

// One review card, used by the homepage carousel and the reviews page. Short quotes get larger type so cards feel full.
function sp_review_card(array $review, string $class = ''): string
{
    $text = trim((string)($review['review'] ?? ''));
    $length = mb_strlen($text, 'UTF-8');
    $size = $review['_size'] ?? ($length <= 125 ? 'is-short' : ($length <= 195 ? 'is-medium' : 'is-long'));

    return '<figure class="review-card ' . $size . ($class !== '' ? ' ' . $class : '') . '">'
        . '<blockquote><p>' . sp_e($text) . '</p></blockquote>'
        . '<figcaption>' . sp_avatar($review)
        . '<span><strong>' . sp_e(trim((string)($review['name'] ?? ''))) . '</strong><small>Customer review</small></span>'
        . '</figcaption></figure>';
}

// Search engines, social previews, uptime monitors and scripts must never see the loading transition
function sp_is_crawler(): bool
{
    $agent = strtolower((string)($_SERVER['HTTP_USER_AGENT'] ?? ''));

    if ($agent === '') {
        return true;
    }
    return (bool)preg_match(
        '/bot|crawl|spider|slurp|mediapartners|facebookexternalhit|facebot|embedly|preview|pinterest|whatsapp|telegram|'
        . 'discord|slack|skype|bing|yandex|baidu|duckduck|sogou|exalead|ia_archiver|semrush|ahrefs|mj12|dotbot|petalbot|'
        . 'lighthouse|pagespeed|gtmetrix|pingdom|uptime|monitor|headless|phantomjs|puppeteer|playwright|selenium|'
        . 'curl|wget|python|httpclient|okhttp|go-http|libwww|php\/|\bjava\//',
        $agent
    );
}

// Printed right after <body>: the skip link and, for the first visit of a session, the big logo transition
function sp_body_start(): void
{
    global $website_icon, $powered_by;
    ?>
<a class="skip-link" href="#main">Skip to content</a>
<div class="powered-bar">
    <a href="<?= sp_e($powered_by['url']) ?>" data-track="powered_by_top" aria-label="<?= sp_e($powered_by['label'] . ' ' . $powered_by['name']) ?>">
        <span><?= sp_e($powered_by['label']) ?></span>
        <img src="<?= sp_e($powered_by['logo']) ?>" alt="" width="24" height="24">
        <strong><?= sp_e($powered_by['name']) ?></strong>
    </a>
</div>
    <?php if (!sp_is_crawler()) : ?>
<div id="splash" aria-hidden="true">
    <div class="splash-inner">
        <img class="splash-logo" src="<?= sp_e($website_icon) ?>" alt="" width="340" height="340" decoding="async">
        <div class="splash-bar"><span></span></div>
    </div>
</div>
<script>
    (function () {
        var splash = document.getElementById('splash');

        try {
            if (sessionStorage.getItem('spartanSplash') || navigator.webdriver) {
                splash.remove();
                return;
            }
        } catch (e) {
            splash.remove();
            return;
        }
        window.__splashStart = Date.now();
        document.documentElement.classList.add('splash-on');
    })();
</script>
    <?php endif;
}

function sp_head(array $page = []): void
{
    global $website_url, $website_title, $website_description, $website_icon, $website_banner, $website_color,
           $website_name, $website_same_as, $logo, $powered_by;
    $title = $page['title'] ?? $website_title;
    $description = $page['description'] ?? $website_description;
    $canonical = rtrim($website_url, '/') . '/' . ltrim($page['path'] ?? '', '/');
    $baseUrl = rtrim($website_url, '/') . '/';
    // Site-wide structured data: who the website belongs to, and that it is a website
    $schemas = array_merge([[
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => $baseUrl . '#organization',
                'name' => $website_name,
                'url' => $baseUrl,
                'logo' => $logo,
                'sameAs' => $website_same_as,
                'parentOrganization' => ['@type' => 'Organization', 'name' => $powered_by['name'], 'url' => $powered_by['url']]
            ],
            [
                '@type' => 'WebSite',
                '@id' => $baseUrl . '#website',
                'url' => $baseUrl,
                'name' => $website_name,
                'inLanguage' => 'en',
                'publisher' => ['@id' => $baseUrl . '#organization']
            ]
        ]
    ]], $page['schemas'] ?? []);

    if (!empty($page['breadcrumbs'])) {
        $items = [];

        foreach (array_values($page['breadcrumbs']) as $index => $crumb) {
            $items[] = ['@type' => 'ListItem', 'position' => $index + 1, 'name' => $crumb[0], 'item' => $crumb[1]];
        }
        $schemas[] = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
    }
    $noindex = !empty($page['noindex']);
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
    <?php if ($noindex) : ?>
        <meta name="robots" content="noindex, follow">
    <?php else : ?>
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <?php endif; ?>
    <meta name="author" content="<?= sp_e($website_name) ?>">
    <link rel="canonical" href="<?= sp_e($canonical) ?>">
    <link rel="icon" type="image/png" href="<?= sp_e($website_icon) ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= sp_e($website_icon) ?>">
    <meta name="title" content="<?= sp_e($title) ?>">
    <meta name="description" content="<?= sp_e($description) ?>">
    <meta name="theme-color" content="<?= sp_e($website_color) ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= sp_e($website_name) ?>">
    <meta property="og:locale" content="en_US">
    <meta property="og:url" content="<?= sp_e($canonical) ?>">
    <meta property="og:title" content="<?= sp_e($title) ?>">
    <meta property="og:description" content="<?= sp_e($description) ?>">
    <meta property="og:image" content="<?= sp_e($website_banner) ?>">
    <meta property="og:image:width" content="1500">
    <meta property="og:image:height" content="1031">
    <meta property="og:image:alt" content="<?= sp_e($website_name) ?>: a Spartan warrior guarding a Minecraft landscape">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= sp_e($canonical) ?>">
    <meta property="twitter:title" content="<?= sp_e($title) ?>">
    <meta property="twitter:description" content="<?= sp_e($description) ?>">
    <meta property="twitter:image" content="<?= sp_e($website_banner) ?>">
    <meta property="twitter:image:alt" content="<?= sp_e($website_name) ?>: a Spartan warrior guarding a Minecraft landscape">

    <?php if (!sp_is_crawler()) : ?>
        <link rel="preload" as="image" href="<?= sp_e($website_icon) ?>">
    <?php endif; ?>
    <?php if (!empty($page['home'])) : ?>
        <link rel="preload" as="image" fetchpriority="high"
              href="<?= sp_e(sp_asset('assets/img/mtfuji-800.jpg')) ?>"
              imagesrcset="<?= sp_e(sp_asset('assets/img/mtfuji-800.jpg')) ?> 800w, <?= sp_e(sp_asset('assets/img/mtfuji.jpg')) ?> 1500w"
              imagesizes="(min-width: 992px) 540px, 100vw">
    <?php endif; ?>
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

function sp_navbar(string $active = ''): void
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
                        <li class="nav-links<?= $label === $active ? ' active' : '' ?>">
                            <a href="<?= sp_e($location) ?>"<?= $label === $active ? ' aria-current="page"' : '' ?>><?= sp_e($label) ?></a>
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
    global $logo, $website_url, $free_link, $human_support_link, $powered_by;
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
                    <li><a href="<?= sp_e($base) ?>/documentation/">Documentation</a></li>
                    <li><a href="<?= sp_e($base) ?>/discord">Discord (AI support)</a></li>
                    <li><a href="<?= sp_e($human_support_link) ?>">Human support (BuiltByBit)</a></li>
                    <li><a href="<?= sp_e($base) ?>/videos">Videos</a></li>
                </ul>
            </div>
        </div>
        <a class="powered-card footer-powered" href="<?= sp_e($powered_by['url']) ?>" data-track="powered_by_bottom">
            <img src="<?= sp_e($powered_by['logo']) ?>" alt="" width="44" height="44" loading="lazy">
            <span>
                <small><?= sp_e($powered_by['label']) ?></small>
                <strong><?= sp_e($powered_by['name']) ?></strong>
                <em><?= sp_e($powered_by['tagline']) ?></em>
            </span>
            <span class="powered-arrow" aria-hidden="true">&rarr;</span>
        </a>
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
