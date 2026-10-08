// Spartan website behaviour: loading transition, smooth scrolling, accordions, plan picker, review carousel, buy bar and click tracking.

const snowflakes = {
  "particles": {
    "number": {
      "value": 80,
      "density": {
        "enable": true,
        "value_area": 800
      }
    },
    "color": {
      "value": "#4ade80"
    },
    "shape": {
      "type": "edge",
      "stroke": {
        "width": 0,
        "color": "#000000"
      },
      "polygon": {
        "nb_sides": 5
      },
      "image": {
        "src": "img/github.svg",
        "width": 100,
        "height": 100
      }
    },
    "opacity": {
      "value": 0.25,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 1,
        "opacity_min": 0.1,
        "sync": false
      }
    },
    "size": {
      "value": 1,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 40,
        "size_min": 0.1,
        "sync": false
      }
    },
    "line_linked": {
      "enable": false,
      "distance": 150,
      "color": "#ffffff",
      "opacity": 0.4,
      "width": 1
    },
    "move": {
      "enable": true,
      "speed": 4,
      "direction": "top",
      "random": false,
      "straight": true,
      "out_mode": "out",
      "bounce": false,
      "attract": {
        "enable": false,
        "rotateX": 600,
        "rotateY": 1200
      }
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": false,
        "mode": "repulse"
      },
      "onclick": {
        "enable": false,
        "mode": "push"
      },
      "resize": true
    },
    "modes": {
      "grab": {
        "distance": 400,
        "line_linked": {
          "opacity": 1
        }
      },
      "bubble": {
        "distance": 400,
        "size": 40,
        "duration": 2,
        "opacity": 8,
        "speed": 3
      },
      "repulse": {
        "distance": 200,
        "duration": 0.4
      },
      "push": {
        "particles_nb": 4
      },
      "remove": {
        "particles_nb": 2
      }
    }
  },
  "retina_detect": true
};

(function () {
  'use strict';

  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ---------- Background particles ----------
  if (!reduceMotion && typeof particlesJS === 'function' && document.getElementById('dots')) {
    particlesJS('dots', snowflakes);
  }

  // ---------- Loading transition (first visit of a session, never rendered for crawlers) ----------
  const splash = document.getElementById('splash');

  if (splash && document.documentElement.classList.contains('splash-on')) {
    const started = window.__splashStart || Date.now();
    const minimum = reduceMotion ? 250 : 1300;
    let hidden = false;

    function hideSplash() {
      if (hidden) {
        return;
      }
      hidden = true;
      setTimeout(function () {
        document.documentElement.classList.add('splash-out');

        try {
          sessionStorage.setItem('spartanSplash', '1');
        } catch (e) {
          // Nothing to remember without storage
        }
        setTimeout(function () {
          splash.remove();
          document.documentElement.classList.remove('splash-on', 'splash-out');
        }, 750);
      }, Math.max(0, minimum - (Date.now() - started)));
    }

    if (document.readyState === 'complete') {
      hideSplash();
    } else {
      window.addEventListener('load', hideSplash, {once: true});
    }
    setTimeout(hideSplash, 3500);
  }

  // ---------- Eased scrolling for in-page links ----------
  let scrollFrame = null;

  function stopScroll() {
    if (scrollFrame !== null) {
      cancelAnimationFrame(scrollFrame);
      scrollFrame = null;
    }
  }

  function easeInOutCubic(t) {
    return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
  }

  function smoothScrollTo(target) {
    stopScroll();
    const start = window.scrollY;
    const distance = target - start;

    if (reduceMotion || Math.abs(distance) < 2) {
      window.scrollTo(0, target);
      return;
    }
    const duration = Math.min(1100, Math.max(450, Math.abs(distance) * 0.4));
    const begin = performance.now();

    function frame(now) {
      const progress = Math.min(1, (now - begin) / duration);
      window.scrollTo(0, start + distance * easeInOutCubic(progress));
      scrollFrame = progress < 1 ? requestAnimationFrame(frame) : null;
    }

    scrollFrame = requestAnimationFrame(frame);
  }

  // The visitor always wins: any manual scrolling cancels the animation
  ['wheel', 'touchstart', 'keydown', 'mousedown'].forEach(function (name) {
    window.addEventListener(name, stopScroll, {passive: true});
  });

  document.addEventListener('click', function (event) {
    const link = event.target.closest('a[href*="#"]');

    if (!link || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey) {
      return;
    }
    const url = new URL(link.href, window.location.href);

    if (url.origin !== window.location.origin || url.pathname !== window.location.pathname || url.search !== window.location.search || !url.hash || url.hash === '#') {
      return;
    }
    const target = document.getElementById(decodeURIComponent(url.hash.slice(1)));

    if (!target) {
      return;
    }
    event.preventDefault();
    smoothScrollTo(Math.max(0, target.getBoundingClientRect().top + window.scrollY - 16));
    history.pushState(null, '', url.hash);
  });

  // ---------- Animated accordions (FAQ answers close each other, documentation blocks are independent) ----------
  function animateDetails(details, opening) {
    const summary = details.querySelector(':scope > summary');
    const startHeight = details.offsetHeight;

    if (details._animation) {
      details._animation.cancel();
      details._animation = null;
    }
    details.classList.toggle('is-open', opening);

    if (reduceMotion || !details.animate) {
      details.open = opening;
      return;
    }

    const borders = details.offsetHeight - details.clientHeight;

    if (opening) {
      details.open = true;
    }
    const endHeight = opening ? details.offsetHeight : summary.offsetHeight + borders;
    details.style.overflow = 'hidden';
    details._animation = details.animate(
      {height: [startHeight + 'px', endHeight + 'px']},
      {duration: opening ? 480 : 380, easing: 'cubic-bezier(0.22, 1, 0.36, 1)'}
    );
    details._animation.onfinish = function () {
      details.open = opening;
      details._animation = null;
      details.style.overflow = '';
    };
    details._animation.oncancel = function () {
      details.style.overflow = '';
    };
  }

  document.querySelectorAll('details[data-accordion]').forEach(function (details) {
    const summary = details.querySelector(':scope > summary');
    const group = details.getAttribute('data-accordion');
    details.classList.toggle('is-open', details.open);

    summary.addEventListener('click', function (event) {
      event.preventDefault();
      const opening = !details.classList.contains('is-open');

      if (opening && group) {
        document.querySelectorAll('details[data-accordion="' + group + '"].is-open').forEach(function (other) {
          if (other !== details) {
            animateDetails(other, false);
          }
        });
      }
      animateDetails(details, opening);
    });
  });

  // The documentation sidebar starts collapsed on small screens
  document.querySelectorAll('.doc-sidebar').forEach(function (sidebar) {
    if (window.innerWidth < 992) {
      sidebar.open = false;
    }
  });

  // ---------- Plan picker (choose a billing style, then the matching checkout appears) ----------
  document.querySelectorAll('[data-plan-picker]').forEach(function (picker) {
    const choices = picker.querySelectorAll('[data-plan-choice]');
    const panels = picker.querySelectorAll('[data-plan-panel]');

    choices.forEach(function (choice) {
      choice.addEventListener('click', function () {
        const id = choice.getAttribute('data-plan-choice');
        let active = null;
        picker.classList.add('has-choice');
        choices.forEach(function (other) {
          other.setAttribute('aria-pressed', other === choice ? 'true' : 'false');
        });
        panels.forEach(function (panel) {
          const match = panel.getAttribute('data-plan-panel') === id;
          panel.classList.toggle('is-active', match);

          if (match) {
            active = panel;
          }
        });

        // Make sure the checkout is fully visible, especially on phones
        requestAnimationFrame(function () {
          const rect = active.getBoundingClientRect();

          if (rect.bottom > window.innerHeight - 20 || rect.top < 60) {
            smoothScrollTo(Math.max(0, rect.top + window.scrollY - 90));
          }
        });
      });
    });
  });

  // ---------- Documentation search ----------
  document.querySelectorAll('[data-doc-filter]').forEach(function (input) {
    const cards = document.querySelectorAll('[data-doc-card]');
    const groups = document.querySelectorAll('[data-doc-group]');
    const empty = document.querySelector('.doc-empty');

    input.addEventListener('input', function () {
      const words = input.value.toLowerCase().split(/\s+/).filter(Boolean);
      let visible = 0;

      cards.forEach(function (card) {
        const haystack = card.getAttribute('data-search') || '';
        const match = words.every(function (word) {
          return haystack.indexOf(word) !== -1;
        });
        card.hidden = !match;
        visible += match ? 1 : 0;
      });
      groups.forEach(function (group) {
        group.hidden = !group.querySelector('[data-doc-card]:not([hidden])');
      });

      if (empty) {
        empty.hidden = visible > 0;
      }
    });
  });

  // ---------- Scroll reveal ----------
  const revealItems = document.querySelectorAll('.reveal');

  if ('IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('in');
          revealObserver.unobserve(entry.target);
        }
      });
    }, {threshold: 0.08});
    revealItems.forEach(function (el) {
      revealObserver.observe(el);
    });
  } else {
    revealItems.forEach(function (el) {
      el.classList.add('in');
    });
  }

  // ---------- Review carousel ----------
  document.querySelectorAll('[data-carousel]').forEach(function (root) {
    const track = root.querySelector('.carousel-track');
    const prev = root.querySelector('.prev');
    const next = root.querySelector('.next');
    const dotsBox = root.querySelector('.carousel-dots');
    const slides = Array.from(track.children);
    const behavior = reduceMotion ? 'auto' : 'smooth';
    let timer = null;
    let hovering = false;
    let visible = false;
    let frame = null;
    let pageHeights = [];

    if (slides.length < 2) {
      return;
    }

    // Distance between the start of two neighbouring slides
    function step() {
      return slides[1].offsetLeft - slides[0].offsetLeft;
    }

    function perView() {
      return Math.max(1, Math.round(track.clientWidth / step()));
    }

    function atStart() {
      return track.scrollLeft <= 4;
    }

    function atEnd() {
      return track.scrollLeft + track.clientWidth >= track.scrollWidth - 4;
    }

    function goTo(index) {
      track.scrollTo({left: Math.min(index, slides.length - 1) * step(), behavior: behavior});
    }

    function move(direction) {
      if (direction > 0 && atEnd()) {
        goTo(0);
      } else if (direction < 0 && atStart()) {
        track.scrollTo({left: track.scrollWidth, behavior: behavior});
      } else {
        track.scrollBy({left: direction * step() * perView(), behavior: behavior});
      }
    }

    // Every page is as tall as its own tallest card (not the tallest card of the whole carousel), so no card has dead space
    function measurePages() {
      const perPage = perView();
      pageHeights = [];
      slides.forEach(function (slide) {
        slide.style.minHeight = '';
      });

      for (let i = 0; i < slides.length; i += perPage) {
        const group = slides.slice(i, i + perPage);
        const tallest = Math.max.apply(null, group.map(function (slide) {
          return slide.offsetHeight;
        }));
        group.forEach(function (slide) {
          slide.style.minHeight = tallest + 'px';
        });
        pageHeights.push(tallest);
      }
    }

    function fitHeight(page) {
      const style = window.getComputedStyle(track);
      const padding = parseFloat(style.paddingTop) + parseFloat(style.paddingBottom);

      if (pageHeights[page] !== undefined) {
        track.style.height = (pageHeights[page] + padding) + 'px';
      }
    }

    function updateDots() {
      const dots = Array.from(dotsBox.children);

      if (dots.length === 0) {
        return;
      }
      let page = atEnd() ? dots.length - 1 : Math.round(track.scrollLeft / step() / perView());
      page = Math.min(dots.length - 1, Math.max(0, page));
      dots.forEach(function (dot, index) {
        dot.classList.toggle('active', index === page);
      });
      fitHeight(page);
    }

    function buildDots() {
      dotsBox.innerHTML = '';
      const pages = Math.ceil(slides.length / perView());

      for (let i = 0; i < pages; i++) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.tabIndex = -1;
        dot.setAttribute('aria-label', 'Go to page ' + (i + 1));
        dot.addEventListener('click', function () {
          stopAutoplay();
          goTo(i * perView());
        });
        dotsBox.appendChild(dot);
      }
      updateDots();
    }

    // Autoplay stops for good as soon as the visitor takes control
    function stopAutoplay() {
      clearInterval(timer);
      timer = null;
    }

    function startAutoplay() {
      if (reduceMotion) {
        return;
      }
      timer = setInterval(function () {
        if (!hovering && visible && !document.hidden) {
          move(1);
        }
      }, 6500);
    }

    prev.addEventListener('click', function () {
      stopAutoplay();
      move(-1);
    });
    next.addEventListener('click', function () {
      stopAutoplay();
      move(1);
    });
    track.addEventListener('keydown', function (event) {
      if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
        stopAutoplay();
      }
    });
    track.addEventListener('touchstart', stopAutoplay, {passive: true});
    track.addEventListener('wheel', stopAutoplay, {passive: true});
    root.addEventListener('mouseenter', function () {
      hovering = true;
    });
    root.addEventListener('mouseleave', function () {
      hovering = false;
    });
    track.addEventListener('focusin', function () {
      hovering = true;
    });
    track.addEventListener('focusout', function () {
      hovering = false;
    });
    track.addEventListener('scroll', function () {
      if (frame === null) {
        frame = requestAnimationFrame(function () {
          frame = null;
          updateDots();
        });
      }
    }, {passive: true});

    function layout() {
      measurePages();
      buildDots();
    }

    let resizeTimer = null;
    window.addEventListener('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(layout, 150);
    });

    // Text height changes once the web font and the images are ready
    window.addEventListener('load', layout);

    if (document.fonts && document.fonts.ready) {
      document.fonts.ready.then(layout);
    }

    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (entries) {
        visible = entries[0].isIntersecting;
      }, {threshold: 0.3}).observe(root);
    } else {
      visible = true;
    }

    layout();
    startAutoplay();
  });

  // ---------- Floating buy bar ----------
  const buyBar = document.getElementById('buyBar');

  if (buyBar) {
    const hero = document.querySelector('.hero');
    const busy = new Set();
    let scheduled = false;

    function renderBuyBar() {
      scheduled = false;
      const threshold = hero ? hero.offsetHeight * 0.85 : 500;
      buyBar.classList.toggle('show', window.scrollY > threshold && busy.size === 0);
    }

    function scheduleRender() {
      if (!scheduled) {
        scheduled = true;
        requestAnimationFrame(renderBuyBar);
      }
    }

    // Hide the bar while the plans (or the final call to action) are already on screen
    if ('IntersectionObserver' in window) {
      const watcher = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            busy.add(entry.target.id);
          } else {
            busy.delete(entry.target.id);
          }
        });
        scheduleRender();
      }, {threshold: 0.15});
      ['pricing', 'start'].forEach(function (id) {
        const el = document.getElementById(id);

        if (el) {
          watcher.observe(el);
        }
      });
    }

    window.addEventListener('scroll', scheduleRender, {passive: true});
    window.addEventListener('resize', scheduleRender);
    scheduleRender();
  }

  // ---------- Click tracking (sent to Google Ads / Analytics when available) ----------
  document.addEventListener('click', function (event) {
    const el = event.target.closest('[data-track]');

    if (!el || typeof gtag !== 'function') {
      return;
    }
    const id = el.getAttribute('data-track');
    const price = window.SPARTAN_PRICE || 0;
    const checkout = ['stripe', 'paypal', 'tebex', 'paddle'].some(function (provider) {
      return id.indexOf(provider) === 0;
    });

    if (checkout) {
      gtag('event', 'begin_checkout', {
        currency: 'EUR',
        value: price,
        items: [{
          item_id: id,
          item_name: el.getAttribute('data-plan') || 'Spartan AntiCheat',
          price: price,
          quantity: 1
        }]
      });
    } else {
      gtag('event', 'select_promotion', {promotion_name: id});
    }
  });
})();
