AOS.init();

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
}

particlesJS("dots", snowflakes);



document.addEventListener('DOMContentLoaded', function() {
  const categories = new Set();
  document.querySelectorAll('[data-category]').forEach(function(el) {
      const category = el.getAttribute('data-category');
      if (category) {
          categories.add(category);
      }
  });

  const buttonsContainer = document.createElement('div');

  const allButton = document.createElement('button');
  allButton.innerText = 'All';
  allButton.className = 'catbtn active';
  allButton.onclick = function() { 
      setActiveButton(allButton);
      filterProducts('all'); 
  };
  buttonsContainer.appendChild(allButton);

  categories.forEach(function(category) {
      const button = document.createElement('button');
      button.innerText = category;
      button.className = 'catbtn';
      button.onclick = function() { 
          setActiveButton(button);
          filterProducts(category); 
      };
      buttonsContainer.appendChild(button);
  });

  const targetElement = document.querySelector('#categoryContainer');
  if (targetElement) {
      targetElement.appendChild(buttonsContainer);
  }

  function filterProducts(category) {
      document.querySelectorAll('[data-category]').forEach(function(el) {
          el.style.display = (category === 'all' || el.getAttribute('data-category') === category) ? '' : 'none';
      });
  }

  function setActiveButton(activeButton) {
      const allButtons = buttonsContainer.querySelectorAll('.catbtn');
      allButtons.forEach(button => {
          button.classList.remove('active');
      });
      activeButton.classList.add('active');
  }
});