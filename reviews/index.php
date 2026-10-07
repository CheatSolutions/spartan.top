<?php
include('/var/www/spartan/config.php');
include('/var/www/spartan/layout.php');

$price = sp_money($price_eur);

sp_head([
    'title' => 'Spartan AntiCheat Reviews | What Server Owners Say',
    'description' => 'Read what Minecraft server owners say about Spartan AntiCheat: ' . count($reviews) . ' real reviews from SpigotMC and BuiltByBit buyers.',
    'path' => 'reviews/'
]);
?>

<body>
<header>
    <div id="dots"></div>

    <?php sp_navbar(); ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center header-content">
                <h1>Reviews</h1>
                <p class="mb-5 term-desc">We have a large proven track record of happy customers
                    who love our anti cheat. Take a look at some of the <?= count($reviews) ?> reviews below.</p>
                <a class="primary-button solid large" href="<?= sp_e(rtrim($website_url, '/')) ?>/#pricing"
                   data-track="reviews_header_cta">Get Spartan &middot; &euro;<?= $price ?>/year</a>
            </div>
        </div>
    </div>
</header>

<main>
    <div class="container">
        <div class="row h-100">
            <?php foreach ($reviews as $review) : ?>
                <div class="col-lg-4 mb-4 review-col">
                    <div class="review">
                        <div class="d-flex gap-3 align-items-center">
                            <?= sp_avatar($review) ?>
                            <p class="review-user"><?= sp_e(trim($review['name'])) ?></p>
                        </div>
                        <p><?= sp_e($review['review']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="col-12 mb-4 text-center mt-5">
                <a class="primary-button" href="<?= sp_e($store_link) ?>">View more on BuiltByBit</a>
            </div>
        </div>
    </div>

    <section id="start">
        <div class="container">
            <div class="final-cta">
                <h2><?= sp_e($final_title) ?></h2>
                <p><?= sp_e($final_description) ?> Protection starts today for just &euro;<?= $price ?> a year.</p>
                <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
                    <?php foreach ($plans as $plan) : ?>
                        <a class="primary-button <?= !empty($plan['highlight']) ? 'solid' : '' ?> large"
                           href="<?= sp_e($plan['url']) ?>" data-track="<?= sp_e($plan['provider']) ?>_reviews"
                           data-plan="<?= sp_e($plan['name']) ?>"><?= sp_e($plan['cta']) ?></a>
                    <?php endforeach; ?>
                </div>
                <p class="final-note">Try it free with 5 players or less: <a href="<?= sp_e($free_link) ?>">get the
                        free version</a>.</p>
            </div>
        </div>
    </section>
</main>

<?php sp_footer(); ?>
<?php sp_scripts(); ?>
</body>

</html>
