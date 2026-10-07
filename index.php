<?php
include('/var/www/spartan/config.php');
include('/var/www/spartan/layout.php');

$featured = sp_pick_reviews($reviews, $featured_reviews);
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
        '@type' => 'Product',
        'name' => 'Spartan AntiCheat',
        'description' => $website_description,
        'image' => $website_banner,
        'brand' => ['@type' => 'Brand', 'name' => 'Spartan AntiCheat'],
        'offers' => [
            '@type' => 'Offer',
            'price' => $price,
            'priceCurrency' => 'EUR',
            'availability' => 'https://schema.org/InStock',
            'url' => $website_url . '#pricing'
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

<main>
    <section class="stats-bar">
        <div class="container">
            <div class="row g-3">
                <?php foreach ($stats as $stat) : ?>
                    <div class="col-6 col-lg-3">
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
                        <figure class="review-slide">
                            <span class="quote-mark" aria-hidden="true">&ldquo;</span>
                            <blockquote><p><?= sp_e($review['review']) ?></p></blockquote>
                            <figcaption>
                                <?= sp_avatar($review) ?>
                                <span><strong><?= sp_e(trim($review['name'])) ?></strong><small>Customer review</small></span>
                            </figcaption>
                        </figure>
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
                    <?php foreach ($features as $feature) : ?>
                        <div class="col-lg-4 col-md-6 mb-4">
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

            <div class="row justify-content-center g-4">
                <?php foreach ($plans as $plan) : ?>
                    <div class="col-lg-5 col-md-8">
                        <div class="plan<?= !empty($plan['highlight']) ? ' plan-featured' : '' ?>">
                            <span class="plan-badge"><?= sp_e($plan['badge']) ?></span>
                            <h3 class="plan-name"><?= sp_e($plan['name']) ?></h3>
                            <p class="plan-tagline"><?= sp_e($plan['tagline']) ?></p>

                            <div class="plan-price">
                                <span class="plan-currency">&euro;</span>
                                <span class="plan-amount"><?= sp_e(explode('.', $price)[0]) ?></span>
                                <span class="plan-cents">.<?= sp_e(explode('.', $price)[1] ?? '00') ?></span>
                                <span class="plan-period">/year</span>
                            </div>
                            <p class="plan-sub">Just &euro;<?= $price_month ?> a month &middot; approx. <?= (int)$price_usd ?> USD</p>

                            <a class="primary-button <?= !empty($plan['highlight']) ? 'solid' : '' ?> block"
                               href="<?= sp_e($plan['url']) ?>" data-track="<?= sp_e($plan['provider']) ?>"
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

            <?php if (!empty($guarantee)) : ?>
                <p class="guarantee"><?= sp_e($guarantee) ?></p>
            <?php endif; ?>

            <?php if (count($plans) >= 2) : ?>
                <div class="plan-help">
                    <div><strong>Want zero interruptions?</strong>
                        Go with the <?= sp_e($plans[0]['name']) ?>. Spartan simply keeps protecting your server.
                    </div>
                    <div><strong>Want zero surprises?</strong>
                        Go with the <?= sp_e($plans[1]['name']) ?>. You pay once and nothing is ever charged again by itself.
                    </div>
                </div>
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
                    <div class="col-md-4">
                        <div class="step">
                            <span class="step-number"><?= $index + 1 ?></span>
                            <h3><?= sp_e($step['title']) ?></h3>
                            <p><?= sp_e($step['description']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section id="faq" class="reveal">
        <div class="container faq-container">
            <div class="section-titles">
                <h2><?= sp_e($faq_title) ?></h2>
            </div>
            <?php foreach ($faq as $item) : ?>
                <details class="faq-item">
                    <summary><?= sp_e($item['q']) ?></summary>
                    <p><?= $item['a'] ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="start" class="reveal">
        <div class="container">
            <div class="final-cta">
                <h2><?= sp_e($final_title) ?></h2>
                <p><?= sp_e($final_description) ?> Protection starts today for just &euro;<?= $price ?> a year.</p>
                <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
                    <?php foreach ($plans as $plan) : ?>
                        <a class="primary-button <?= !empty($plan['highlight']) ? 'solid' : '' ?> large"
                           href="<?= sp_e($plan['url']) ?>" data-track="<?= sp_e($plan['provider']) ?>_final"
                           data-plan="<?= sp_e($plan['name']) ?>"><?= sp_e($plan['cta']) ?></a>
                    <?php endforeach; ?>
                </div>
                <p class="final-note">Questions first? <a href="https://spartan.top/discord">Talk to us on Discord</a>.</p>
            </div>
        </div>
    </section>
</main>

<?php sp_footer(); ?>
<?php sp_scripts(['paddle' => true]); ?>
</body>

</html>
