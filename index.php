<?php
include('/var/www/spartan/config.php');
include('/var/www/spartan/layout.php');
include('/var/www/spartan/docs.php');

$featured = sp_arrange_reviews(sp_pick_reviews($reviews, $featured_reviews));
$review_milestone = sp_review_milestone($reviews);
$price = sp_money($price_eur);
$price_month = sp_money($price_per_month_eur);

// Payment methods that are not one of the main plans (e.g. Tebex, Paddle)
$other_methods = [];

foreach ($products['data']['products'] as $product) {
    if ((!$displayUnlisted && $product['unlisted'] === true) || $product['private'] === true) {
        continue;
    }
    $other_methods[] = $product;
}

$schemas = [
    [
        '@context' => 'https://schema.org',
        '@type' => 'SoftwareApplication',
        'name' => $website_name,
        'description' => $website_description,
        'image' => $website_banner,
        'url' => $website_url,
        'applicationCategory' => 'GameApplication',
        'applicationSubCategory' => 'Minecraft anti-cheat plugin',
        'operatingSystem' => 'Any (Java servers running Spigot, Paper or compatible forks, Bedrock players via Geyser)',
        'softwareVersion' => '1.7 to the latest Minecraft version',
        'publisher' => ['@type' => 'Organization', 'name' => $powered_by['name'], 'url' => $powered_by['url']],
        'offers' => [
            [
                '@type' => 'Offer',
                'name' => 'Free for servers with 5 players or less',
                'price' => '0',
                'priceCurrency' => 'EUR',
                'availability' => 'https://schema.org/InStock',
                'url' => $free_link
            ],
            [
                '@type' => 'Offer',
                'name' => 'Full Edition (Java & Bedrock), annual',
                'price' => $price,
                'priceCurrency' => 'EUR',
                'availability' => 'https://schema.org/InStock',
                'url' => $website_url . '#pricing'
            ]
        ]
    ],
    [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(function ($item) {
            return [
                '@type' => 'Question',
                'name' => $item['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($item['a'])]
            ];
        }, $faq)
    ]
];

sp_head(['home' => true, 'paddle' => true, 'schemas' => $schemas]);
?>

<body>
<?php sp_body_start(); ?>
<header class="hero">
    <div id="dots"></div>

    <?php sp_navbar(); ?>

    <div class="container text-center text-lg-start">
        <div class="row header-content align-items-center">
            <div class="col-lg-6">
                <div class="header-alert d-flex align-items-center gap-2 m-auto m-lg-0">
                    <img alt="" width="20" height="20" src="https://spartan.top/assets/img/icons/lightning.png">
                    <p><?= sp_e($alert) ?></p>
                </div>
                <h1><?= $h1 ?></h1>
                <p class="hero-description"><?= $description ?></p>

                <div class="hero-actions d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                    <a class="primary-button solid large" href="#pricing" data-track="hero_cta">
                        <?= sp_e($hero_cta) ?> <span class="button-price">&middot; &euro;<?= $price ?>/year</span>
                    </a>
                    <a class="primary-button large" href="<?= sp_e($free_link) ?>"><?= sp_e($hero_secondary_cta) ?></a>
                </div>

                <ul class="hero-assurances justify-content-center justify-content-lg-start">
                    <li>Pay once with PayPal or subscribe with Stripe</li>
                    <li><?= sp_e($free_note) ?></li>
                </ul>
            </div>

            <div class="col-lg-6 mt-5 mt-lg-0">
                <img alt="A Spartan warrior guarding a Minecraft landscape" class="w-100 header-img"
                     width="1500" height="1031" fetchpriority="high"
                     src="<?= sp_e(sp_asset('assets/img/mtfuji-800.jpg')) ?>"
                     srcset="<?= sp_e(sp_asset('assets/img/mtfuji-800.jpg')) ?> 800w, <?= sp_e(sp_asset('assets/img/mtfuji.jpg')) ?> 1500w"
                     sizes="(min-width: 992px) 540px, 100vw">
            </div>
        </div>
    </div>
</header>

<main id="main">
    <section class="stats-bar">
        <div class="container">
            <div class="row g-3">
                <?php foreach ($stats as $index => $stat) : ?>
                    <div class="col-6 col-lg-3 reveal" style="--i: <?= $index ?>">
                        <div class="stat">
                            <strong><?= sp_e(str_replace('{reviews}', (string)$review_milestone, $stat['value'])) ?></strong>
                            <span><?= sp_e($stat['label']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="reviews" class="reveal">
        <div class="container">
            <div class="section-titles">
                <h2><?= sp_e($reviews_title) ?></h2>
                <p><?= sp_e($reviews_description) ?></p>
            </div>

            <div class="carousel" data-carousel aria-roledescription="carousel" aria-label="Customer reviews">
                <div class="carousel-track" tabindex="0">
                    <?php foreach ($featured as $review) : ?>
                        <?= sp_review_card($review, 'review-slide') ?>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-btn prev" type="button" aria-label="Previous reviews">&lsaquo;</button>
                <button class="carousel-btn next" type="button" aria-label="Next reviews">&rsaquo;</button>
                <div class="carousel-dots" aria-hidden="true"></div>
            </div>

            <div class="text-center mt-4 carousel-more">
                <a class="text-link" href="https://spartan.top/reviews">Read all <?= count($reviews) ?> reviews &rarr;</a>
            </div>
        </div>
    </section>

    <?php if ($enable_features) : ?>
        <section id="about" class="reveal">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center section-titles">
                        <h2><?= sp_e($features_title) ?></h2>
                        <p><?= sp_e($features_description) ?></p>
                    </div>
                </div>

                <div class="row">
                    <?php foreach ($features as $index => $feature) : ?>
                        <div class="col-lg-4 col-md-6 mb-4 reveal" style="--i: <?= $index % 3 ?>">
                            <div class="feature-div">
                                <div class="feature-icon">
                                    <?= (str_contains($feature['icon'], ".")
                                        ? "<img alt=\"\" src=\"" . sp_e($feature['icon']) . "\">"
                                        : sp_e($feature['icon'])) ?>
                                </div>
                                <h3><?= sp_e($feature['title']) ?></h3>
                                <p><?= sp_e($feature['description']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif ?>

    <section id="pricing" class="reveal">
        <div class="container">
            <div class="section-titles">
                <h2><?= sp_e($pricing_title) ?></h2>
                <p><?= sp_e($pricing_description) ?></p>
            </div>

            <div class="plan-picker" data-plan-picker>
                <div class="plan-choices">
                    <?php foreach ($plans as $plan) : ?>
                        <button type="button" class="plan-choice" data-plan-choice="<?= sp_e($plan['id']) ?>"
                                data-track="choose_<?= sp_e($plan['id']) ?>" aria-pressed="false">
                            <span class="choice-icon" aria-hidden="true"><?= sp_e($plan['icon']) ?></span>
                            <span class="choice-text">
                                <strong><?= sp_e($plan['choice_title']) ?></strong>
                                <small><?= sp_e($plan['choice_description']) ?></small>
                            </span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <p class="plan-hint"><?= sp_e($pricing_hint) ?></p>

                <div class="plan-stage">
                    <?php foreach ($plans as $plan) : ?>
                        <div class="plan-panel" data-plan-panel="<?= sp_e($plan['id']) ?>">
                            <div class="plan">
                                <span class="plan-badge"><?= sp_e($plan['name']) ?></span>
                                <h3 class="plan-name"><?= sp_e($plan['choice_title']) ?></h3>
                                <p class="plan-tagline"><?= sp_e($plan['tagline']) ?></p>

                                <div class="plan-price">
                                    <span class="plan-currency">&euro;</span>
                                    <span class="plan-amount"><?= sp_e(explode('.', $price)[0]) ?></span>
                                    <span class="plan-cents">.<?= sp_e(explode('.', $price)[1] ?? '00') ?></span>
                                    <span class="plan-period">/year</span>
                                </div>
                                <p class="plan-sub">Just &euro;<?= $price_month ?> a month &middot; approx. <?= (int)$price_usd ?> USD</p>

                                <a class="primary-button solid block" href="<?= sp_e($plan['url']) ?>"
                                   data-track="<?= sp_e($plan['provider']) ?>"
                                   data-plan="<?= sp_e($plan['name']) ?>"><?= sp_e($plan['cta']) ?></a>
                                <p class="plan-fine"><?= sp_e($plan['fine_print']) ?></p>

                                <ul class="plan-perks">
                                    <?php foreach ($plan['perks'] as $perk) : ?>
                                        <li class="highlight"><?= sp_e($perk) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <ul class="plan-perks">
                                    <?php foreach ($plan_includes as $perk) : ?>
                                        <li><?= sp_e($perk) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if (!empty($guarantee)) : ?>
                <p class="guarantee"><?= sp_e($guarantee) ?></p>
            <?php endif; ?>

            <?php if (!empty($other_methods)) : ?>
                <p class="alt-pay">Prefer another way to pay?
                    <?php foreach ($other_methods as $index => $product) : ?>
                        <?php $method = trim(preg_replace('/\s*\(.*?\)/', '', $product['title'])); ?>
                        <?= $index > 0 ? '&middot;' : '' ?>
                        <?php if (!empty($product['is_paddle'])) : ?>
                            <button type="button" class="paddle_button link-button" data-track="<?= sp_e(strtolower($method)) ?>"
                                    data-items='[{"priceId": "<?= sp_e($product['paddle_price_id']) ?>", "quantity": 1}]'><?= sp_e($method) ?></button>
                        <?php else : ?>
                            <a href="<?= sp_e($product['purchase_url']) ?>"
                               data-track="<?= sp_e(strtolower($method)) ?>"><?= sp_e($method) ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </p>
            <?php endif; ?>

            <div class="free-band">
                <div>
                    <h3>Not ready to buy? Try Spartan free.</h3>
                    <p><?= sp_e($free_note) ?>. Test it on your own server and upgrade whenever you are ready.</p>
                </div>
                <a class="primary-button" href="<?= sp_e($free_link) ?>">Get the free version</a>
            </div>
        </div>
    </section>

    <section class="reveal">
        <div class="container">
            <div class="section-titles">
                <h2><?= sp_e($steps_title) ?></h2>
            </div>
            <div class="row g-4">
                <?php foreach ($steps as $index => $step) : ?>
                    <div class="col-md-4 reveal" style="--i: <?= $index ?>">
                        <div class="step">
                            <span class="step-number"><?= $index + 1 ?></span>
                            <h3><?= sp_e($step['title']) ?></h3>
                            <p><?= sp_e($step['description']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <p class="text-center mt-4"><a class="text-link" href="<?= sp_e($steps_link['url']) ?>"><?= sp_e($steps_link['label']) ?> &rarr;</a></p>
        </div>
    </section>

    <section id="faq" class="reveal">
        <div class="container faq-container">
            <div class="section-titles">
                <h2><?= sp_e($faq_title) ?></h2>
            </div>
            <?php foreach ($faq as $item) : ?>
                <details class="faq-item" data-accordion="faq">
                    <summary><?= sp_e($item['q']) ?></summary>
                    <div class="faq-body"><p><?= $item['a'] ?></p></div>
                </details>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="community" class="reveal">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h2><?= sp_e($community_title) ?></h2>
                    <p class="mb-4"><?= sp_e($community_description) ?></p>
                    <ul class="help-list">
                        <?php foreach ($help_options as $option) : ?>
                            <li>
                                <span class="help-icon" aria-hidden="true"><?= sp_e($option['icon']) ?></span>
                                <div>
                                    <strong><?= sp_e($option['title']) ?></strong>
                                    <span><?= sp_e($option['description']) ?></span>
                                    <a class="text-link" href="<?= sp_e($option['url']) ?>"><?= sp_e($option['label']) ?> &rarr;</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="widget-frame">
                        <iframe src="<?= sp_e($discord_widget_url) ?>" width="350" height="500" allowtransparency="true"
                                frameborder="0" loading="lazy" title="Spartan AntiCheat on Discord"
                                sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="start" class="reveal">
        <div class="container">
            <div class="final-cta">
                <h2><?= sp_e($final_title) ?></h2>
                <p><?= sp_e($final_description) ?> Protection starts today for just &euro;<?= $price ?> a year.</p>
                <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
                    <?php foreach ($plans as $index => $plan) : ?>
                        <a class="primary-button <?= $index === 0 ? 'solid' : '' ?> large"
                           href="<?= sp_e($plan['url']) ?>" data-track="<?= sp_e($plan['provider']) ?>_final"
                           data-plan="<?= sp_e($plan['name']) ?>"><?= sp_e($plan['cta']) ?></a>
                    <?php endforeach; ?>
                </div>
                <p class="final-note">Questions first? Browse the <a href="<?= sp_e(sp_docs_url()) ?>">documentation</a>, ask our AI support on <a href="https://spartan.top/discord">Discord</a>
                    or reach our human support on <a href="<?= sp_e($human_support_link) ?>">BuiltByBit</a>.</p>
            </div>
        </div>
    </section>
</main>

<?php sp_footer(); ?>
<?php sp_scripts(['paddle' => true]); ?>
</body>

</html>
