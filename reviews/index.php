<?php
chdir("../");
include('config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-779938233"></script>
    <script> window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'AW-779938233'); </script>
    <title><?= $website_title ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= $website_icon ?>">
    <meta name="title" content="<?= $website_title ?>">
    <meta name="description" content="<?= $website_description ?>">
    <meta name="theme-color" coontent="<?= $website_color ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $website_url ?>">
    <meta property="og:title" content="<?= $website_title ?>">
    <meta property="og:description" content="<?= $website_description ?>">
    <meta property="og:image" content="<?= $website_banner ?>">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= $website_url ?>">
    <meta property="twitter:title" content="<?= $website_title ?>">
    <meta property="twitter:description" content="<?= $website_description ?>">
    <meta property="twitter:image" content="<?= $website_banner ?>">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="../assets/js/particles.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>


<body>
<header style="margin-bottom: 50px;">
    <div id="dots"></div>

    <nav class="navbar navbar-dark navbar-expand-lg" data-aos="fade-down">
        <div class="container d-flex">
            <a class="navbar-brand" href="#">

                <!-- Navigation Logoo -->
                <img alt="Company logo" width="100" height="100" src="<?= $logo ?>">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ms-auto text-center">

                    <!-- Navigation Links -->
                    <?php
                    foreach ($navlinks as $link => $location) :
                        ?>
                        <li class="nav-links">
                            <a href="<?= $location ?>"><?= $link ?></a>
                        </li>
                    <?php
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center header-content">

                <h1 data-aos="fade-up">Reviews</h1>
                <p class="mb-5 term-desc" data-aos="fade-up">We have a large proven track record of happy customers
                    who love our anti cheat. Take a look at some of the countless ones below.</p>
            </div>
        </div>
    </div>
</header>

<main>
    <div class="container">
        <div class="row h-100">
            <?php foreach ($reviews as $review) : ?>
                <div class="col-lg-4 mb-4 review-col" data-aos="fade-up">
                    <div class="review">
                        <div class="d-flex gap-3 align-items-center">
                            <img width="25" height="25" alt="Review profile picture" src="<?= $review['picture']; ?>">
                            <p class="review-user"><?= $review['name']; ?></p>
                        </div>
                        <p><?= $review['review']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="col-12 mb-4 text-center mt-5" data-aos="fade-up">
                <a class="primary-button" href="<?= $store_link ?>">View More</a>
            </div>
        </div>
    </div>
</main>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/index.js"></script>
</body>

</html>