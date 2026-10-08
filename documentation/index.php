<?php
include('/var/www/spartan/config.php');
include('/var/www/spartan/layout.php');
include('/var/www/spartan/docs.php');

$docs = sp_docs_list();
$requested = isset($_GET['page']) && is_string($_GET['page']) ? strtolower(trim($_GET['page'])) : '';
$doc = $requested !== '' ? ($docs[$requested] ?? null) : null;
$price = sp_money($price_eur);
$content = null;
$headings = [];
$bodyHtml = '';
$status = 200;

if ($requested !== '' && $doc === null) {
    $status = 404;
} elseif ($doc !== null) {
    $content = sp_docs_content($doc);

    if ($content === null) {
        $status = 503;
    } else {
        $bodyHtml = sp_markdown($content, $docs, $headings);
    }
}

if ($status !== 200) {
    http_response_code($status);

    if ($status === 503) {
        header('Retry-After: 300');
    }
}

// Previous and next pages, in the order of the sidebar
$previous = null;
$next = null;

if ($doc !== null) {
    $keys = array_keys($docs);
    $position = array_search($doc['slug'], $keys, true);
    $previous = $position > 0 ? $docs[$keys[$position - 1]] : null;
    $next = $position < count($keys) - 1 ? $docs[$keys[$position + 1]] : null;
}

// Pages grouped for the sidebar and the index
$groups = [];

foreach ($docs as $item) {
    $groups[$item['group']][] = $item;
}

if ($doc !== null) {
    $pageTitle = $doc['title'] . ' | Spartan AntiCheat Documentation';
    $pageDescription = $doc['description'] !== ''
        ? $doc['description']
        : 'Spartan AntiCheat documentation: ' . $doc['title'] . '.';
    $pagePath = 'documentation/?page=' . rawurlencode($doc['slug']);
} else {
    $pageTitle = $status === 404 ? 'Page not found | Spartan AntiCheat Documentation' : 'Spartan AntiCheat Documentation | Setup, Configuration & Commands';
    $pageDescription = 'Everything you need to install, configure and get the most out of Spartan AntiCheat: activation, settings, checks, commands, permissions and more.';
    $pagePath = 'documentation/';
}

$crumbs = [['Spartan AntiCheat', $website_url], ['Documentation', sp_docs_url()]];

if ($doc !== null) {
    $crumbs[] = [$doc['title'], sp_docs_url($doc['slug'])];
}

sp_head([
    'title' => $pageTitle,
    'description' => $pageDescription,
    'path' => $pagePath,
    'noindex' => $status !== 200,
    'breadcrumbs' => $crumbs
]);
?>

<body>
<?php sp_body_start(); ?>
<header class="header-compact">
    <div id="dots"></div>

    <?php sp_navbar('Documentation'); ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center header-content">
                <?php if ($doc !== null) : ?>
                    <nav class="breadcrumbs" aria-label="Breadcrumb">
                        <a href="<?= sp_e(sp_docs_url()) ?>">Documentation</a>
                        <span aria-hidden="true">/</span>
                        <span><?= sp_e($doc['group']) ?></span>
                    </nav>
                    <h1><?= sp_e($doc['title']) ?></h1>
                    <?php if ($doc['description'] !== '') : ?>
                        <p class="term-desc"><?= sp_e($doc['description']) ?></p>
                    <?php endif; ?>
                <?php elseif ($status === 404) : ?>
                    <h1>Page not found</h1>
                    <p class="term-desc">We could not find that documentation page. Try one of the pages below.</p>
                <?php else : ?>
                    <h1>Documentation</h1>
                    <p class="term-desc">Everything you need to install, configure and master Spartan.</p>
                    <div class="doc-search">
                        <input type="search" placeholder="Search the documentation" aria-label="Search the documentation"
                               autocomplete="off" data-doc-filter>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<main id="main">
    <div class="container">
        <?php if ($doc === null) : ?>
            <?php foreach ($groups as $groupName => $items) : ?>
                <section class="doc-group" data-doc-group>
                    <h2><?= sp_e($groupName) ?></h2>
                    <div class="row g-3">
                        <?php foreach ($items as $index => $item) : ?>
                            <div class="col-md-6 col-lg-4 doc-card-col" data-doc-card
                                 data-search="<?= sp_e(strtolower($item['title'] . ' ' . $item['description'])) ?>">
                                <a class="doc-card" href="<?= sp_e(sp_docs_url($item['slug'])) ?>">
                                    <strong><?= sp_e($item['title']) ?></strong>
                                    <span><?= sp_e($item['description']) ?></span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
            <p class="doc-empty text-center" hidden>No pages match your search.</p>
        <?php else : ?>
            <div class="row g-5">
                <aside class="col-lg-3">
                    <details class="doc-sidebar" open>
                        <summary>All documentation</summary>
                        <?php foreach ($groups as $groupName => $items) : ?>
                            <h2><?= sp_e($groupName) ?></h2>
                            <ul>
                                <?php foreach ($items as $item) : ?>
                                    <li><a href="<?= sp_e(sp_docs_url($item['slug'])) ?>"<?= $doc['slug'] === $item['slug'] ? ' class="active" aria-current="page"' : '' ?>><?= sp_e($item['title']) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endforeach; ?>
                    </details>
                </aside>

                <article class="col-lg-9 doc-article">
                    <?php if ($status === 503) : ?>
                        <div class="doc-notice">
                            <strong>This page is temporarily unavailable.</strong>
                            <p>Please try again in a few minutes, or <a href="<?= sp_e($docs_repo_url) ?>">read it on GitHub</a>.</p>
                        </div>
                    <?php else : ?>
                        <?php if (count($headings) >= 4) : ?>
                            <nav class="doc-toc" aria-label="On this page">
                                <strong>On this page</strong>
                                <ul>
                                    <?php foreach ($headings as $heading) : ?>
                                        <li class="level-<?= (int)$heading['level'] ?>"><a href="#<?= sp_e($heading['id']) ?>"><?= sp_e(trim(strip_tags($heading['text']), ' :')) ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>

                        <div class="doc-content"><?= $bodyHtml ?></div>

                        <div class="doc-pager">
                            <?php if ($previous !== null) : ?>
                                <a class="doc-prev" href="<?= sp_e(sp_docs_url($previous['slug'])) ?>"><small>Previous</small><?= sp_e($previous['title']) ?></a>
                            <?php endif; ?>
                            <?php if ($next !== null) : ?>
                                <a class="doc-next" href="<?= sp_e(sp_docs_url($next['slug'])) ?>"><small>Next</small><?= sp_e($next['title']) ?></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </article>
            </div>
        <?php endif; ?>

        <?php if ($doc === null && $status === 404) : ?>
            <p class="text-center mt-4"><a class="text-link" href="<?= sp_e(sp_docs_url()) ?>">Back to the documentation &rarr;</a></p>
        <?php endif; ?>

        <section class="doc-help">
            <div class="free-band">
                <div>
                    <h3>Still stuck?</h3>
                    <p>Ask our AI support on Discord, or message our human support on BuiltByBit.</p>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <a class="primary-button" href="https://spartan.top/discord">Discord (AI support)</a>
                    <a class="primary-button" href="<?= sp_e($human_support_link) ?>">Human support</a>
                </div>
            </div>
            <p class="text-center mt-4 doc-cta">New to Spartan? <a class="text-link" href="<?= sp_e(rtrim($website_url, '/')) ?>/#pricing" data-track="docs_cta">Get Spartan for &euro;<?= $price ?>/year</a>
                or <a class="text-link" href="<?= sp_e($free_link) ?>">try it free</a>.</p>
        </section>
    </div>
</main>

<?php sp_footer(); ?>
<?php sp_scripts(); ?>
</body>

</html>
