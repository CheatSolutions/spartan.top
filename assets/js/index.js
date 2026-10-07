// Spartan website behaviour: background particles, scroll reveal, review carousel, buy bar and click tracking.

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
      "value": "#b6a3ce"
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

    let resizeTimer = null;
    window.addEventListener('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(buildDots, 150);
    });

    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (entries) {
        visible = entries[0].isIntersecting;
      }, {threshold: 0.3}).observe(root);
    } else {
      visible = true;
    }

    buildDots();
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
