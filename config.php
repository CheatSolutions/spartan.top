<?php

// Pricing (single source of truth: every price on the website is derived from these)
$price_eur = 21.99;
$price_usd = 25; // Approximate
$price_per_month_eur = round($price_eur / 12, 2);

// Meta Information
$website_url = 'https://spartan.top/';
$website_description = 'Minecraft anti-cheat plugin for Java & Bedrock servers, 1.7 to the latest version. Trusted since 2016. Free up to 5 players, then ' . number_format($price_eur, 2) . ' EUR a year.';
$website_title = 'Minecraft Anti-Cheat Plugin for Java & Bedrock | Spartan';
$website_name = 'Spartan AntiCheat';
$website_same_as = [
    'https://builtbybit.com/resources/11196/',
    'https://modrinth.com/plugin/spartan-anticheat',
    'https://www.patreon.com/SpartanAntiCheat',
    'https://github.com/CheatSolutions'
];
$website_icon = 'https://spartan.top/assets/img/logo.webp';
$website_banner = 'https://spartan.top/assets/img/mtfuji.jpg';
$website_color = '#0a0f0c';


// Powered by (shown at the top and the bottom of every page)
$powered_by = [
    'name' => 'Idealistic AI',
    'url' => 'https://www.idealistic.ai',
    'logo' => 'https://spartan.top/assets/img/idealistic.svg',
    'label' => 'Powered by',
    'tagline' => 'Where humans and AI talk in harmony'
];

// Navbar
$logo = 'https://spartan.top/assets/img/logo.png';
$navlinks = [
    'Home' => 'https://www.idealistic.ai/spartan',
    'Pricing' => 'https://spartan.top/#pricing',
    'Reviews' => 'https://spartan.top/reviews',
    'Documentation' => 'https://spartan.top/documentation/',
    'Discord' => 'https://spartan.top/discord',
    'Videos' => 'https://spartan.top/videos'
];
$nav_cta = [
    'label' => 'Get Spartan',
    'url' => 'https://spartan.top/#pricing'
];

// Header
$alert = 'Trusted by server owners since 2016';
$h1 = 'Stop Minecraft cheaters. <span>Keep your players.</span>';
$description = 'Spartan AntiCheat is the longest living paid Minecraft anti-cheat: one plugin that protects your <strong>Java & Bedrock</strong> server on every version from 1.7 to the latest.';
$hero_cta = 'Get Spartan';
$hero_secondary_cta = 'Try it free';
$free_link = 'https://modrinth.com/plugin/spartan-anticheat';
$free_note = 'Free for servers with 5 players or less';
$human_support_link = 'https://builtbybit.com/members/cheatsolutions.63108/';

// Trust bar (the review count is calculated automatically from the reviews below)
$stats = [
    [
        'value' => '2016',
        'label' => 'Protecting servers since'
    ],
    [
        'value' => '1.7 → Latest',
        'label' => 'Minecraft versions supported'
    ],
    [
        'value' => 'Java + Bedrock',
        'label' => 'One plugin, both editions'
    ],
    [
        'value' => '{reviews}+',
        'label' => 'Real buyer reviews'
    ]
];

// Features
$enable_features = true;
$features_title = 'Everything you need to keep cheaters out';
$features_description = 'At least part of it, we bring a lot more!';

$features = [
    [
        'icon' => '📈',
        'title' => 'Proven Longevity',
        'description' => 'The longest-standing paid Minecraft anti-cheat, actively developed since 2016. A reliable, battle-tested solution built for the long term.'
    ],
    [
        'icon' => '🚀',
        'title' => 'Extensive Detection Coverage',
        'description' => 'A constantly expanding arsenal of checks covering combat, movement, world interactions, and more to ensure absolute server protection.'
    ],
    [
        'icon' => '🔥',
        'title' => 'Java & Bedrock Support',
        'description' => 'One of the rare anti-cheats offering native, simultaneous cheat detection for both Java and Bedrock (via Geyser) players. 2 birds with 1 stone!'
    ],
    [
        'icon' => '📦',
        'title' => 'Universal Compatibility',
        'description' => 'Seamlessly supports every Minecraft version from 1.7 up to the latest release, with guaranteed updates for new Minecraft versions.'
    ],
    [
        'icon' => '🛠',
        'title' => 'Effortless Setup',
        'description' => 'Deploy instantly using our intuitive in-game GUI and simple configs, while retaining deep customization and a developer API for advanced users.'
    ],
    [
        'icon' => '🤝',
        'title' => 'Comprehensive Support',
        'description' => 'Backed by a massive, active community, thorough documentation, AI support on Discord and human support on BuiltByBit.'
    ]
];

// Pricing plans (both plans cost the same; visitors choose the billing style they prefer and the matching checkout appears)
$pricing_title = 'How would you like to pay?';
$pricing_description = 'One price: ' . number_format($price_eur, 2) . ' EUR a year. Pick the billing style you prefer and your checkout appears.';
$pricing_hint = 'Choose a billing style above to see your checkout.';
$plans = [
    [
        'id' => 'subscription',
        'provider' => 'stripe',
        'icon' => '🔄',
        'choice_title' => 'Set & forget',
        'choice_description' => 'Renews automatically every year, so you never lose protection.',
        'name' => 'Annual Subscription',
        'tagline' => 'Spartan keeps protecting your server year after year, with nothing to remember.',
        'cta' => 'Subscribe with Stripe',
        'url' => 'https://spartan.top/stripe',
        'perks' => [
            'Renews automatically every year',
            'Never worry about expiry or forgetting to renew',
            'Cancel anytime'
        ],
        'fine_print' => 'Secure checkout by Stripe'
    ],
    [
        'id' => 'purchase',
        'provider' => 'paypal',
        'icon' => '🧾',
        'choice_title' => 'No recurring',
        'choice_description' => 'Pay once for a full year. Nothing is ever charged automatically.',
        'name' => 'Annual Purchase',
        'tagline' => 'One payment. One year. No auto-renewal and no surprise charges.',
        'cta' => 'Pay once with PayPal',
        'url' => 'https://spartan.top/paypal',
        'perks' => [
            'A single payment covers a full year',
            'No auto-renewal, so no surprise charges',
            'You decide if and when to renew'
        ],
        'fine_print' => 'Secure checkout by PayPal'
    ]
];

// Everything both plans include
$plan_includes = [
    'Full Edition for Java & Bedrock',
    'Every Minecraft version from 1.7 to the latest',
    'All updates, new detections and fixes',
    'Documentation, AI support on Discord & human support on BuiltByBit',
    'In-game GUI, deep configs & developer API'
];

// Optional promise shown under the plans. Leave empty unless you officially offer it (e.g. a refund policy).
$guarantee = '';

// How it works
$steps_title = 'Protected in three simple steps';
$steps = [
    [
        'title' => 'Pick your plan',
        'description' => 'Choose set & forget or no recurring. Same Spartan, same price.'
    ],
    [
        'title' => 'Get your license',
        'description' => 'Send us your proof of purchase on BuiltByBit and you will usually receive your downloadable license within hours.'
    ],
    [
        'title' => 'Install in minutes',
        'description' => 'Drop Spartan into your plugins folder and tune it from the in-game GUI. It works right out of the box.'
    ]
];
$steps_link = [
    'label' => 'Read the full activation guide',
    'url' => 'https://spartan.top/documentation/?page=enable-purchase'
];

// Frequently asked questions (answers may contain HTML)
$faq_title = 'Questions? Answered.';
$faq = [
    [
        'q' => 'What is the difference between the Annual Subscription and the Annual Purchase?',
        'a' => 'Both give you the exact same Spartan for the same price. The <strong>Annual Subscription</strong> (Stripe) renews automatically every year so your protection never lapses, and you can cancel anytime. The <strong>Annual Purchase</strong> (PayPal) is a single payment that covers one year: we never charge you again automatically, you simply choose whether to renew when the year is up.'
    ],
    [
        'q' => 'How do I get Spartan after I pay?',
        'a' => 'After paying with PayPal, Stripe or Tebex, <a href="https://builtbybit.com/conversations/add?to=CheatSolutions">open a conversation with us on BuiltByBit</a> and attach your proof of purchase. We usually reply within hours with your downloadable license. The full steps are in the <a href="https://spartan.top/documentation/?page=enable-purchase">activation guide</a>.'
    ],
    [
        'q' => 'What does my server need to run Spartan?',
        'a' => 'Good single-core CPU performance, 384MB+ of RAM for Spartan and a server TPS of 19 or more. Check the <a href="https://spartan.top/documentation/?page=system-requirements">system requirements</a> for the details.'
    ],
    [
        'q' => 'Can I try Spartan before buying it?',
        'a' => 'Yes! Spartan is free for servers with 5 players or less. <a href="https://modrinth.com/plugin/spartan-anticheat">Download it from Modrinth</a>, test it on your server and upgrade whenever you are ready.'
    ],
    [
        'q' => 'Does Spartan protect Bedrock players too?',
        'a' => 'Yes. Spartan natively detects cheats from both Java and Bedrock (via Geyser) players at the same time, so a single plugin covers your whole community.'
    ],
    [
        'q' => 'Which Minecraft versions are supported?',
        'a' => 'Every version from 1.7 up to the latest release, with updates guaranteed for new Minecraft versions.'
    ],
    [
        'q' => 'Will it flag my legitimate players?',
        'a' => 'No anti-cheat is perfect, which is why Spartan is highly configurable so you can tune it to your server\'s gameplay. If a false positive ever slips through, report it to our human support team on <a href="https://builtbybit.com/members/cheatsolutions.63108/">BuiltByBit</a>. Reviewers regularly mention fixes arriving within hours.'
    ],
    [
        'q' => 'How do I get help?',
        'a' => 'Start with the <a href="https://spartan.top/documentation">documentation</a>, then ask our AI support on <a href="https://spartan.top/discord">Discord</a> any time. If you want a real person, our human support team is available on <a href="https://builtbybit.com/members/cheatsolutions.63108/">BuiltByBit</a>.'
    ],
    [
        'q' => 'Which payment methods can I use?',
        'a' => 'Stripe (cards and supported wallets) for the annual subscription, PayPal for the annual purchase, and Tebex or Paddle if you prefer them.'
    ],
    [
        'q' => 'I bought Spartan on SpigotMC. Can I transfer for free?',
        'a' => 'Yes. If you purchased on SpigotMC less than a year ago, your transfer to BuiltByBit is free. <a href="https://spartan.top/discord">Request it on Discord</a> and you will not need to buy again.'
    ]
];

// Community and help
$discord_widget_url = 'https://discord.com/widget?id=289384242075533313&theme=dark';
$community_title = 'Help is always close';
$community_description = 'Whether you are installing for the first time or fine-tuning an advanced config, there is a place to get answers.';
$help_options = [
    [
        'icon' => '📚',
        'title' => 'Documentation',
        'description' => 'Guides for every config file, command and permission.',
        'label' => 'Browse the documentation',
        'url' => 'https://spartan.top/documentation/'
    ],
    [
        'icon' => '🤖',
        'title' => 'AI support on Discord',
        'description' => 'Ask our AI assistant on the Discord server, right from the widget.',
        'label' => 'Join the Discord server',
        'url' => 'https://spartan.top/discord'
    ],
    [
        'icon' => '🧑',
        'title' => 'Human support on BuiltByBit',
        'description' => 'Want a real person? Message us on BuiltByBit.',
        'label' => 'Contact human support',
        'url' => $human_support_link
    ]
];

// Documentation (Markdown files fetched from GitHub, cached for an hour and rendered on the website).
// New files added to the repository appear automatically; the details below only improve how they are presented.
$docs_repo_url = 'https://github.com/CheatSolutions/Important-Information/tree/main/documentation';
$docs_raw_base = 'https://raw.githubusercontent.com/CheatSolutions/Important-Information/main/documentation/';
$docs_api_url = 'https://api.github.com/repos/CheatSolutions/Important-Information/contents/documentation';
$docs_groups = ['Getting started', 'Configuration', 'Usage', 'More'];
$docs_fallback_files = [
    'enable purchase .md', 'system requirements .md', 'download protocollib .md', 'get help .md',
    'settings .md', 'checks .md', 'advanced .md', 'messages .md', 'message translations .md', 'compatibility .md',
    'SQL database .md', 'install discord webhook .md',
    'commands and permissions .md', 'player info menu .md', 'blocked hacks .md'
];
$docs_meta = [
    'enable-purchase' => ['title' => 'Enable your purchase', 'group' => 'Getting started', 'order' => 1,
        'description' => 'Activate Spartan after buying with PayPal, Stripe, Tebex, Patreon, BuiltByBit or Polymart.'],
    'system-requirements' => ['title' => 'System requirements', 'group' => 'Getting started', 'order' => 2,
        'description' => 'CPU, RAM, storage, TPS and latency recommendations for your server.'],
    'download-protocollib' => ['title' => 'Download ProtocolLib', 'group' => 'Getting started', 'order' => 3,
        'description' => 'Many detections need the ProtocolLib plugin to work.'],
    'get-help' => ['title' => 'Get help', 'group' => 'Getting started', 'order' => 4,
        'description' => 'How to report false positives, hack bypasses and console errors so they get fixed fast.'],
    'settings' => ['title' => 'Settings', 'group' => 'Configuration', 'order' => 1,
        'description' => 'General options for punishments, logs, notifications and purchases (settings.yml).'],
    'checks' => ['title' => 'Checks', 'group' => 'Configuration', 'order' => 2,
        'description' => 'Enable, silence and punish every check separately for Java and Bedrock (checks.yml).'],
    'advanced' => ['title' => 'Advanced', 'group' => 'Configuration', 'order' => 3,
        'description' => 'Fine-tune the inner workings of individual checks (advanced.yml).'],
    'messages' => ['title' => 'Messages', 'group' => 'Configuration', 'order' => 4,
        'description' => 'Customize every message, color and placeholder (messages.yml).'],
    'message-translations' => ['title' => 'Message translations', 'group' => 'Configuration', 'order' => 5,
        'description' => 'Ready-made messages.yml files in many languages.'],
    'compatibility' => ['title' => 'Compatibility', 'group' => 'Configuration', 'order' => 6,
        'description' => 'The plugins Spartan is compatible with (compatibility.yml).'],
    'sql-database' => ['title' => 'SQL database', 'group' => 'Configuration', 'order' => 7,
        'description' => 'Connect Spartan to an SQL database (sql.yml).'],
    'install-discord-webhook' => ['title' => 'Discord webhooks', 'group' => 'Configuration', 'order' => 8,
        'description' => 'Create Discord webhooks and add their URLs to Spartan.'],
    'commands-and-permissions' => ['title' => 'Commands & permissions', 'group' => 'Usage', 'order' => 1,
        'description' => 'Every Spartan command with the permission it needs.'],
    'player-info-menu' => ['title' => 'Player info menu', 'group' => 'Usage', 'order' => 2,
        'description' => 'Understand the reasons shown when you check a player in-game.'],
    'blocked-hacks' => ['title' => 'Blocked hacks', 'group' => 'Usage', 'order' => 3,
        'description' => 'The hacks Spartan detects, grouped by category.']
];

// Final call to action
$final_title = 'Give your players the fair game they deserve.';
$final_description = 'Join the server owners who stopped worrying about cheaters.';

// Products
$displayUnlisted = false;
$currency = '';

// Reviews
$store_link = 'https://builtbybit.com/resources/11196/reviews';
$reviews_title = 'Server owners love Spartan';
$reviews_description = 'Real reviews from SpigotMC & BuiltByBit buyers.';
// Reviews highlighted in the homepage carousel (matched by name, shown in this order). Leave empty to use the first reviews.
$featured_reviews = [
    'BloodyBelgian',
    'jcardonne',
    'quack988',
    'HiveramXII',
    'MClaus',
    'mfnalex',
    'xwolfyxNL',
    'Potato_IQ',
    'louanbastos',
    'ImIllusion',
    'Noobcrafteryt',
    'Jameswong',
    'PrestigeElmo',
    'Spaex',
    'adrianlugo',
    'Galexrt',
    'DaringDoughnut',
    'doubiovo'
];

$reviews = [
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/281/281154.jpg',
        'name' => 'Zaniquelli',
        'review' => "I've been using this plugin for a few years, and I've noticed a significant improvement in its quality over time. It's a great plugin and definitely worth having.",
    ],
    [
        'name' => 'Smartiehga',
        'review' => "Its a good anti cheat that does what it supposed to obviously you have flase flags here and there but those are fixed pretty fast they work on the plugin activly and it does what its supposed to.",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/l/1046/1046865.jpg',
        'name' => 'BloodyBelgian',
        'review' => "Simply the best anti cheat out there, I've tried a bunch of different ones, this is by far the most versitile and best option out there.",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/1805/1805631.jpg',
        'name' => 'PinkAxolotl3123',
        'review' => 'Love Spartan! Had ZERO issues! I love the support on the discord server! Would rate 9 stars if I could!',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/30/30415.jpg',
        'name' => 'Flamel',
        'review' => 'A fairly good anti-cheat plugin. Works as intended and provides extra safety for our projects. May require an adjust here and there, but overall its a good software. Thanks for the constant updates and support.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/26/26530.jpg',
        'name' => 'xwolfyxNL',
        'review' => 'Spartan is a very advanced AC that updates multiple times a week. There is no ac on the market with such quick and good support. Continue the good work!',
    ],
    [
        'name' => 'ville222222',
        'review' => 'Very nice. good detections, good support. Theres no anticheat that updates this frequently. Very solid! few falses which will be fixed soon. still falses less frequently than any other anticheat that will detect something.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/1036/1036145.jpg',
        'name' => 'giladc',
        'review' => "The plugin does work very good, and does work in a few version that i found that they doesn't work on other plugins like from the oldest to the newest, i confirm its works, and trust me, you wanna buy it",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/1438/1438790.jpg',
        'name' => 'SuchBlue',
        'review' => 'The only AntiCheat plugin that has stood the test of time. It has existed for more than half a decade, and still gets even better with every update. Perfect for servers who want their server to be free of cheaters. Must-have plugin.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/70/70089.jpg',
        'name' => 'Zyrathing',
        'review' => "Great plugin! Despite what's being written it detects many hacks and gives you plenty of ways to deal with hackers. Personally, I like to set it to silent so it detects but doesn't teleport back.",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/1/1119.jpg',
        'name' => 'padakoys',
        'review' => 'This plugin enhances server safety by providing anti-cheat measures, advanced player monitoring, and effective tools for preventing malicious activities, ensuring a secure and enjoyable gaming environment. What else do you need?',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/351/351831.jpg',
        'name' => 'jcardonne',
        'review' => 'Never took the time to write a review. Clearly the best anti-cheat on the market rn. Since 2016, well documented and maintained. As a developer I can only applaud',
    ],
    [
        'name' => 'Cyden',
        'review' => "Absolutely amazing Anti-Cheat that works fast, very reliable, and so easy to configure! This Developer also gives Amazing support. If not the best, it's one of the best Anti-cheats!!!",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/586/586212.jpg',
        'name' => 'ItzJustSamuel',
        'review' => "The functions are actively being improved day to day being optimized even more, it's the start the new concepts of understanding for him which he is actively looking for, it's worth it in my book!",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/598/598430.jpg',
        'name' => 'HiveramXII',
        'review' => 'The best anticheat ever. Tested with at least 9 cheats differents, some of them were paid. Honestly, if you buy this, you will dont have the need of having staff. Nothing more to say. Thanks for everything.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/784/784701.jpg',
        'name' => 'louanbastos',
        'review' => 'Excellent support for the best Anticheat on the market. Blocks all Java and Bedrock threats. I totally recommend it.',
    ],
    [
        'name' => 'doubiovo',
        'review' => 'This is the best version of anti-cheating I have ever used. Misjudgment almost never occurs. It takes up very little performance. This plug-in is worth buying',
    ],
    [
        'picture' => 'https://secure.gravatar.com/avatar/2e5550b215646cb1cc9d6d924bfb1454?s=48&d=https%3A%2F%2Fstatic.spigotmc.org%2Fstyles%2Fspigot%2Fxenforo%2Favatars%2Favatar_male_s.png',
        'name' => 'Timongseidel',
        'review' => 'Very good plugin I used this plugin before and and it is great also the support I reported a small issue and on the same/next day it was fixed im not sure.',
    ],
    [
        'name' => 'Radiant_Shiny',
        'review' => "The author is probably the most devoted person to his creation that I've ever seen. There is no other developer on this platform who would spend hours on developing a plugin and providing support for it.",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/103/103273.jpg',
        'name' => 'wescvavv7415',
        'review' => 'Elytra control should be added. Best cheat plugin author gives instant support and solves instantly. Thanks to the author for many years of development',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/158/158168.jpg',
        'name' => 'Noobcrafteryt',
        'review' => 'Been using Spartan for years now. Have loved it ever since purchase. Never needed support, but from what I read he provides great support. This plugin is WELL WORTH the price of admission. Hands down the best anti-cheat!',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/1045/1045141.jpg',
        'name' => 'EvilPandaMan',
        'review' => 'Great plugin, one of the easiest to setup and pretty reliable for your checks. Perfect? not quite, I think it is really hard if not impossible to have a plugin detect every cheat possible, but VERY very reliable and it does a great job. Recommended.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/862/862896.jpg',
        'name' => 'vsgroup',
        'review' => 'This plugin is amazing. The level of support from Vagdedes is amazing. A fantastic seller to work with.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/1425/1425637.jpg',
        'name' => 'dsevvv',
        'review' => 'Author kindly solved all concerns I had with this product. Would highly recommend to anyone looking for an anti-cheat for their JAVA server.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/307/307591.jpg',
        'name' => 'KingJustin123',
        'review' => "One of the best anti-cheats I've ever had the experience of working with, The Developer is very considerate and responsive in providing support and regular updates to the plugin. Would highly recommend it!",
    ],
    [
        'picture' => 'https://secure.gravatar.com/avatar/d5624b1453153d3b73f6d9ebd09fe807?s=48&d=https%3A%2F%2Fstatic.spigotmc.org%2Fstyles%2Fspigot%2Fxenforo%2Favatars%2Favatar_male_s.png',
        'name' => 'CS_Birb',
        'review' => 'Reliable anti-cheat, regularly updated and enhanced, with an easy to use developer API. To top it all of is a very friendly developer who seems to really show a lot of care and passion for this project. Well worth the purchase!',
    ],
    [
        'name' => 'HiuyuTing',
        'review' => 'Working very well on latest minecraft versions, good adaptability with other plugins. Staff is helpful, attitude is nice.Highly recommended.',
    ],
    [
        'name' => 'UnleqitQ',
        'review' => 'Way best anticheat so far. Recognizes itself false positives! Easily my number one recommendation.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/1257/1257742.jpg',
        'name' => 'EviLDeEdZ',
        'review' => 'Like the anti cheat part, like the frequent updates. Have made many friends buyt his for their server too and all are happy with it <3',
    ],
    [
        'picture' => 'https://secure.gravatar.com/avatar/b6a6d51561714487105ac2c3091224a0?s=48&d=https%3A%2F%2Fstatic.spigotmc.org%2Fstyles%2Fspigot%2Fxenforo%2Favatars%2Favatar_s.png',
        'name' => 'mfnalex',
        'review' => "Easily the best anti-cheat plugin out there! I'm not even running a public server, only a small one for friends - you'll be amazed how many people are cheating D: TL;DR: Best anti cheat out there, you should definitely get Spartan ASAP :)",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/238/238951.jpg',
        'name' => 'NightLeaf',
        'review' => "I've been using this plugin since this plugin was released, and this plugin completely prevents Hacker from using Cheats. I've never seen this plugin has been bypassed!!",
    ],
    [
        'name' => 'kiwimc',
        'review' => 'This guy has the best Anti Cheat on the market. His support is absolutely amazing and i recommend this to all users look for an Anti Cheat. The money I spent on it is well worth it!',
    ],
    [
        'name' => 'wlm123',
        'review' => 'The developer is very positive. I like him very much. I recommend his anti cheating because the developer is very enthusiastic',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/530/530584.jpg',
        'name' => 'KevinOrellana',
        'review' => 'I will be sincere in this writing, if you buy the plugin and it does not meet your expectations is because you did not configure it well on your server. 10/10',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/1023/1023297.jpg',
        'name' => 'fffilm',
        'review' => "Very good plugin, I don't know why someone would leave a bad review, there are bugs tell the author he will quickly solve, and he is very friendly, although my English is not good, but he is still very patient to answer my questions.",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/894/894323.jpg',
        'name' => 'scott005577',
        'review' => 'Spartan antichat is very worth buying. Its developers are very efficient in fixing bugs and optimizing performance. It is worth the price',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/798/798734.jpg',
        'name' => 'Quared',
        'review' => "Amazing anti-cheat. The default config is quite good, although it isn't perfect. Overall, works very well with my server.",
    ],
    [
        'name' => 'schnubbi2583',
        'review' => 'Very easy installation, usage and configutation. The developer is very kind and always reachable. I can recommend this plugin - it is a must have!',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/545/545255.jpg',
        'name' => 'Cobrex',
        'review' => 'Have tried many different anti-cheats and this is by far the best I have come across (in my view). Offers so much, very configurable and regularly updated. A major positive for me is that the dev is approachable and takes the time to answer your questions. Recommend',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/1162/1162538.jpg',
        'name' => 'adrianlugo',
        'review' => 'The best cheat detection, cheat mitigation, and customer support. Consistent and impactful updates!',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/1306/1306679.jpg',
        'name' => 'quack988',
        'review' => "Literally the best anticheat I've ever bought. With me buying Verus, Alice, Matrix, etc.. none of them worked as well as this. It's definitely worth the money if you want a solid anticheat.",
    ],
    [
        'name' => 'Jgibbz328',
        'review' => 'Amazing plugin! A must have for servers. Save yourself and your admins some time, and let Spartan do all the work of finding and punishing hackers.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/900/900881.jpg',
        'name' => 'Dummyperson',
        'review' => "Quick response and update. Any issues, he's willing to fix it which helps the server owners to ask for help regarding the config tweaking, issues, developer API, or the plugin itself.",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/101/101530.jpg',
        'name' => 'MClaus',
        'review' => "I've bought almost all popular premium anti cheats and so far this is the best I see. It is well maintained with fast support. I regret not buying this sooner so I would have not wasted my money to other ACs.",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/546/546335.jpg',
        'name' => 'ImIllusion',
        'review' => 'Has an actual API unlike the competition. There have been a few false positives but I have made a developer report and they have been fixed and automatically applied to my server by the developer within hours.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/884/884750.jpg',
        'name' => 'Potato_IQ',
        'review' => 'Has so much less false positives than 99.99% of the other anicheats. Has so many features that are easy to configure, and if you need help contact dev in discord. I would definitely recommend it, worth every penny.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/0/970.jpg',
        'name' => 'Galexrt',
        'review' => 'Great communication from the developer, always got quick help in case something came up. Definitely worth the price.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/381/381889.jpg',
        'name' => 'Enderslayer1938',
        'review' => "I had an issue with my server in the configuration of the plugin, now after the support I got, it works very well! Bedrock anti-cheat works very well now and I'm glad I purchased this plugin!",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/202/202535.jpg',
        'name' => 'Listarax',
        'review' => "Great plugin ! I had two, three problems but it was fixed the same day after I bought the premium version :) it's really worth it and since then I haven't had any problem with cheaters (at least I haven't seen them yet X))",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/281/281843.jpg',
        'name' => 'DaringDoughnut',
        'review' => 'Works right out of the box, the developer helped me over Discord very promptly, would recommend for the easy use and instant support.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/67/67352.jpg',
        'name' => 'HotPotato',
        'review' => 'Consistent support & community support, nice community in the Discord server and the plugin works as intended.',
    ],
    [
        'name' => 'XxXTrollMasterHD',
        'review' => 'Very good AntiCheat. The support of this plugin is epic. The dev is always friendly and answering questions within minutes. I really recommend this ressource to everyone.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/627/627660.jpg',
        'name' => 'CONBlaze',
        'review' => 'By far the easiest to use anticheat that I have. It is also one of the few anticheats I can also expect to work just fine both on 1.8 and 1.16',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/990/990551.jpg',
        'name' => 'Rizraz',
        'review' => 'The perfect anti-cheat for a server with Survival, 99.9 % that the warnings are correct, sometimes false, but this is immediately corrected by the plugin Developer, so if you want to protect your server and Your players from cheaters, Spartan is the perfect option for You.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/624/624927.jpg',
        'name' => 'Thanarangsima',
        'review' => 'Really worth the price, one of the best support on the discord. Many features, if found any bugs or have some suggestions. Supports on the discord will help you with that. Really nice!',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/926/926536.jpg',
        'name' => 'fapret',
        'review' => 'Very nice anticheat, detects very well the cheaters, i also had a problem using the ban command with bedrock players (non related with cheats) and the developer helped me very fast!',
    ],
    [
        'name' => 'xemles',
        'review' => "Really responsive developer, got a few false positives, but if you report them to the dev, he'll do everything he can to make the plugin more compatible :)",
    ],
    [
        'name' => 'nikitushu ',
        'review' => 'Very determined author. Stable, regular updates. Nice support. Best anti-cheat on spigot so far!',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/149/149267.jpg',
        'name' => 'mleynful',
        'review' => 'The dev really puts effort into this and it shows, frequent updates and always improving!',
    ],
    [
        'name' => 'sbud',
        'review' => 'Very good customer support. Fixed my issues in seconds. Highly recommend. Thank you very much :)',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/969/969665.jpg',
        'name' => 'GGUC',
        'review' => 'Best anti-cheat, Catches hackers. The price might be scary but fear not, with the best customizability and even great out-of-the-box config, it will make moderating so much easier.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/382/382584.jpg',
        'name' => 'Korallo',
        'review' => 'Great and fast support, plugin dev is self dealing with customers problems, and that is huge advantage',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/158/158361.jpg',
        'name' => 'InsiderAnh',
        'review' => 'Honestly a very good resource, not failed, and if you have given false positives with asking for support and helping you to configure it will suffice, besides if you want to do something special the plugin gives you a sufficient API, I hope for the best of this plugin.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/765/765844.jpg',
        'name' => 'TimDosedla',
        'review' => 'Works great, everything is editable, the author of the plugin responded immediately to all the questions I asked would recommend',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/15/15481.jpg',
        'name' => 'PrestigeElmo',
        'review' => 'Absolutely phenomenal, the anti cheat just works great, any issues I have had was dealt directly with the developer and resolved within the hour. I would recommend anyone with any size server to switch to spartan.',
    ],
    [
        'picture' => 'https://secure.gravatar.com/avatar/9a7e6673eabd49740dbc997fd23898eb?s=48&d=https%3A%2F%2Fstatic.spigotmc.org%2Fstyles%2Fspigot%2Fxenforo%2Favatars%2Favatar_male_s.png',
        'name' => 'xDefQon',
        'review' => 'The best anti cheat tried so far! Above all, the support (via discord) is spectacular, for any problems the answer is almost immediate, friendly and professional! :)',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/969/969330.jpg',
        'name' => 'Galajus',
        'review' => 'Works great, no lags, many options for customization, fast support and helpfull discord :D',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/34/34632.jpg',
        'name' => 'IFkvase',
        'review' => 'Developer help me to solve problem. My opinion about plugin is - Nice plugin and quick support! Thanks!',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/300/300825.jpg',
        'name' => 'AdvancedStrafe',
        'review' => 'VERY AWESOME PLUGGIN WELL MADE! would deff rec to any big or small servers! Come check my TOWNY server 1.16*ANY play.skiesmc.net',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/898/898002.jpg',
        'name' => 'Spaex',
        'review' => 'Loving this Developer and loving this anti-cheat. Best Premium Ressource on the market and worth every cent.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/298/298132.jpg',
        'name' => 'skino0',
        'review' => 'Very good anticheat!I suggesting it to everyone who wants one good anticheat to prevent hackers! Im using it also in my server! play.vaniland.xyz',
    ],
    [
        'name' => 'SandoMCBrad',
        'review' => "One of the best AntiCheat plugin's there are out there. The Dev helps you with everything. (Setup, Support, etc)",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/42/42029.jpg',
        'name' => 'Alec',
        'review' => 'Works amazing, detects most hacked clients, owner is very helpful and will personally reach out to you to fix suitable problems! 10/10',
    ],
    [
        'name' => 'Joeywp',
        'review' => 'Got some incompatibilies on my themepark server I use this plugin at, but other than that it works fine most of the time, especially considering the very specific technical setup of my server. So far contacted support twice or thrice, and so far the response has been very quick.',
    ],
    [
        'name' => 'Xarius86',
        'review' => 'The developer is incredibly responsive to any and all concerns. Updates are released often and fixes are implemented incredibly quickly.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/441/441814.jpg',
        'name' => 'Jameswong',
        'review' => 'Out of all paid plugins, they have the best discord response time, and they actually care about talking.. Even after getting so many Downloads, their support service is top notch. Fixes or bugs are repaired live. just awesome.',
    ],
    [
        'name' => 'WeasalCrafter',
        'review' => 'I messaged the guy for some help, and almost immediately got results from them. Great plugin and easy to read configs. Definitely suggest to anyone looking to block hacking.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/886/886261.jpg',
        'name' => 'Obviouslee',
        'review' => 'Amazing anticheat. The developer gives quick support and helps fixes issues within minutes. I recommend this anticheat over any others.',
    ],
    [
        'name' => 'Loyisa',
        'review' => 'Maybe Spartan is not the best anticheat, but this anticheat has the best support',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/692/692829.jpg',
        'name' => 'FabianAdrian',
        'review' => 'The best anticheat out there! Very easy to configure, support is fast and great and detections work without problems.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/746/746725.jpg',
        'name' => 'AkosVR',
        'review' => 'This plugin is beeng developed very well. Almost evrery update improves something new. I hope you can keep it up. :)',
    ],
    [
        'picture' => 'https://secure.gravatar.com/avatar/52b50a0f6b414dd54f50f59621a1c90e?s=48&d=https%3A%2F%2Fstatic.spigotmc.org%2Fstyles%2Fspigot%2Fxenforo%2Favatars%2Favatar_male_s.png',
        'name' => 'KiCKx_',
        'review' => 'The developer is incredibly responsive and helpful with solving issues and false positives. The plugin itself is very customizable and reliable. Constant updates and bug fixes are just icing on the cake.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/16/16395.jpg',
        'name' => 'ridalarry',
        'review' => 'In my opinion this is the best anticheat, the price is affordable and the detections are really good. The plugin gets fast updates and the developer is really helpful before and after buying the plugin and one of the fastest plugin support I have ever got.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/1058/1058642.jpg',
        'name' => 'nullexe',
        'review' => 'Very well made plugin, is worth every cent, super easy to use and configure, and developer is active, friendly and responds very quickly to any questions or support. Would definitely recommend to anyone seeking an anti-cheat for their server network.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/1035/1035829.jpg',
        'name' => 'xIdentified',
        'review' => "Awesome plugin, author gives good support aswell. This combined with paper's anti xray will stop essentially any hackers from joining",
    ],
    [
        'picture' => 'https://secure.gravatar.com/avatar/a828c76268607949e06fac2428ff6f2e?s=48&d=https%3A%2F%2Fstatic.spigotmc.org%2Fstyles%2Fspigot%2Fxenforo%2Favatars%2Favatar_male_s.png',
        'name' => 'Haugli92',
        'review' => 'Great product. Developer fix bugs faster than any developer I know of. 5/5! or more!',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/737/737582.jpg',
        'name' => 'JP2K',
        'review' => 'Great AntiCheat, with fantastic support! Customization is fast and easy. Highly recommend it!',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/425/425422.jpg',
        'name' => 'Justsnoopy30',
        'review' => '5 Star Plugin - Excellent AntiCheat - Developer addresses and fixes problems very quickly. Handled every hack thrown at it gracefully, and much improved false positive detection. Only getting better and better!',
    ],
    [
        'name' => 'TheNoNinja',
        'review' => 'I have the plugin for some time now and had some questions. I asked the developer on discord and had an answer in mere minutes. Great support, awesome detection, and a great plugin overall. Defiantly a must have!',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/660/660555.jpg',
        'name' => 'Chocco',
        'review' => 'Good fraud protection and developer assistance. Thank you for your help! My rating for the plugin is 5 stars',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/299/299876.jpg',
        'name' => 'Quantum_Gaming',
        'review' => 'Really love this plugin 10/10. The developer is super nice and helpful with any issue I encounter! Highly recommend having this plugin on your server, players well love it!',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/843/843805.jpg',
        'name' => 'Hatti',
        'review' => "An anticheat with many options, the developer is very friendly and very attentive to the problems that can happen with the plugin, I would like to give this anticheat 10 stars, but I can't, so here are my 5 stars, thank you very much!",
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/503/503259.jpg',
        'name' => 'WhiteShadowDK',
        'review' => 'Perfect anti-cheat, the developer is active and takes community feedback very seriously. The plugin is easily customized from inside the server, which is a huge plus, and it makes for a very user-friendly experience.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/314/314871.jpg',
        'name' => 'x3mp',
        'review' => 'Anti-Cheat wasnt what I expected. Developer was quick to response and willing to work towards a solution.',
    ],
    [
        'picture' => 'https://www.spigotmc.org/data/avatars/s/24/24005.jpg',
        'name' => 'ssamjh',
        'review' => "Really friendly developer with regular updates. This anti-cheat has handled almost every type of server I've thrown at it, minigames, SMP, and even games with non-vanilla mechanics (with a bit of tweaking).",
    ],
    [
        'picture' => 'https://secure.gravatar.com/avatar/4341e725f0e2aa56f984e66273468645?s=48&d=https%3A%2F%2Fstatic.spigotmc.org%2Fstyles%2Fspigot%2Fxenforo%2Favatars%2Favatar_s.png',
        'name' => 'Daleth',
        'review' => 'Works great, dev is very responsive - especially considering the numerous quantity of my questions and questionable responsibility for him to even answer. Nice plugin, nice dev, good support. Well worth the money.',
    ]
];


// Products (PayPal and Stripe are unlisted here because they are shown as the main plans above)
$products = [
    'data' => [
        'products' => [
            [
                'uniqid' => '1',
                'title' => 'BuiltByBit (Formally MC-Market)',
                'price_display' => '24.99 USD',
                'purchase_url' => 'https://builtbybit.com/resources/11196',
                'purchase_description' => 'Purchase',
                'unlisted' => true,
                'private' => false,
                'image' => '',
                'categories' => [
                    [
                        'title' => 'Full Edition (Java & Bedrock)'
                    ]
                ]
            ],
            [
                'uniqid' => '3',
                'title' => 'Voxel (Formally Polymart)',
                'price_display' => '24.99 USD',
                'purchase_url' => 'https://voxel.shop/product/350',
                'purchase_description' => 'Purchase',
                'unlisted' => true,
                'private' => false,
                'image' => '',
                'categories' => [
                    [
                        'title' => 'Full Edition (Java & Bedrock)'
                    ]
                ]
            ],
            [
                'uniqid' => '5',
                'title' => 'Java / Bukkit Edition',
                'price_display' => 'Patreon',
                'purchase_url' => 'https://www.patreon.com/SpartanAntiCheat',
                'purchase_description' => '1 Week Free!',
                'unlisted' => true,
                'private' => false,
                'image' => '',
                'categories' => [
                    [
                        'title' => 'Patreon'
                    ]
                ]
            ],
            [
                'uniqid' => '6',
                'title' => 'Bedrock / Geyser Edition',
                'price_display' => 'Patreon',
                'purchase_url' => 'https://www.patreon.com/SpartanAntiCheat',
                'purchase_description' => '1 Week Free!',
                'unlisted' => true,
                'private' => false,
                'image' => '',
                'categories' => [
                    [
                        'title' => 'Patreon'
                    ]
                ]
            ],
            [
                'uniqid' => '7',
                'title' => 'Java & Bedrock Edition',
                'price_display' => 'Patreon',
                'purchase_url' => 'https://www.patreon.com/SpartanAntiCheat',
                'purchase_description' => '1 Week Free!',
                'unlisted' => true,
                'private' => false,
                'image' => '',
                'categories' => [
                    [
                        'title' => 'Patreon'
                    ]
                ]
            ],
            [
                'uniqid' => '8',
                'title' => 'PayPal',
                'price_display' => '21.99 EUR (Approx. 25 USD)',
                'purchase_url' => 'https://spartan.top/paypal',
                'purchase_description' => 'Purchase',
                'unlisted' => true,
                'private' => false,
                'image' => '',
                'categories' => [
                    [
                        'title' => 'Full Edition (Java & Bedrock)'
                    ]
                ]
            ],
            [
                'uniqid' => '9',
                'title' => 'Stripe',
                'price_display' => '21.99 EUR (Approx. 25 USD)',
                'purchase_url' => 'https://spartan.top/stripe',
                'purchase_description' => 'Purchase',
                'unlisted' => true,
                'private' => false,
                'image' => '',
                'categories' => [
                    [
                        'title' => 'Full Edition (Java & Bedrock)'
                    ]
                ]
            ],
            [
                'uniqid' => '10',
                'title' => 'Tebex (Formerly Buycraft)',
                'price_display' => '21.99 EUR (Approx. 25 USD)',
                'purchase_url' => 'https://spartan.top/tebex',
                'purchase_description' => 'Purchase',
                'unlisted' => false,
                'private' => false,
                'image' => '',
                'categories' => [
                    [
                        'title' => 'Full Edition (Java & Bedrock)'
                    ]
                ]
            ],
            [
                'uniqid' => '12',
                'title' => 'Paddle',
                'price_display' => '21.99 EUR (Approx. 25 USD)',
                'purchase_url' => '#',
                'purchase_description' => 'Purchase',
                'unlisted' => false,
                'private' => false,
                'image' => '',
                'categories' => [
                    [
                        'title' => 'Full Edition (Java & Bedrock)'
                    ]
                ],
                'is_paddle' => true,
                'paddle_price_id' => 'pri_01m1c7mvy2gtxh9v2p2cqkytdt'
            ],
            [
                'uniqid' => '11',
                'title' => 'SpigotMC Buyers',
                'price_display' => 'SpigotMC > BuiltByBit',
                'purchase_url' => 'https://spartan.top/discord',
                'purchase_description' => 'Transfer',
                'unlisted' => true,
                'private' => false,
                'image' => '',
                'categories' => [
                    [
                        'title' => 'SpigotMC > BuiltByBit Transfers'
                    ]
                ]
            ]
        ]
    ],
];