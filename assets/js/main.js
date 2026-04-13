// ── NAVBAR SCROLL EFFECT ──
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
  if (window.scrollY > 60) {
    navbar.classList.add('scrolled');
  } else {
    navbar.classList.remove('scrolled');
  }
}, { passive: true });

// ── MOBILE NAV TOGGLE ──
const navToggle = document.getElementById('navToggle');
const navLinks  = document.getElementById('navLinks');

navToggle.addEventListener('click', () => {
  navLinks.classList.toggle('active');
  navToggle.innerHTML = navLinks.classList.contains('active') ? '&#10005;' : '&#9776;';
});

// Close menu when a link is clicked
navLinks.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', () => {
    navLinks.classList.remove('active');
    navToggle.innerHTML = '&#9776;';
  });
});

// Close menu when clicking outside
document.addEventListener('click', (e) => {
  if (!navLinks.contains(e.target) && !navToggle.contains(e.target)) {
    navLinks.classList.remove('active');
    navToggle.innerHTML = '&#9776;';
  }
});

// ── SMOOTH SCROLL for anchor links ──
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      const offset = 80;
      const top = target.getBoundingClientRect().top + window.scrollY - offset;
      window.scrollTo({ top, behavior: 'smooth' });
    }
  });
});

// ── SCROLL REVEAL ANIMATION ──
const revealElements = document.querySelectorAll(
  '.feature-card, .gallery-item, .info-card, .about-img-wrap, .stat-item, .video-placeholder'
);

const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach((entry, i) => {
    if (entry.isIntersecting) {
      // Stagger delay
      setTimeout(() => {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }, (entry.target.dataset.delay || 0) * 100);
      revealObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

revealElements.forEach((el, i) => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(24px)';
  el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
  el.dataset.delay = i % 4; // stagger within each row
  revealObserver.observe(el);
});

// ── FORM VALIDATION ──
const contactForm = document.getElementById('contactForm');
if (contactForm) {
  contactForm.addEventListener('submit', function (e) {
    const nama    = this.querySelector('#nama').value.trim();
    const no_hp   = this.querySelector('#no_hp').value.trim();
    const kategori = this.querySelector('#kategori').value;
    const pesan   = this.querySelector('#pesan').value.trim();

    if (!nama || !no_hp || !kategori || !pesan) {
      e.preventDefault();
      alert('Harap isi semua field yang bertanda *');
      return;
    }

    // Basic phone number validation
    const phoneRegex = /^[0-9\+\-\s]{8,20}$/;
    if (!phoneRegex.test(no_hp)) {
      e.preventDefault();
      alert('Nomor HP tidak valid. Gunakan format: 082255650226');
      return;
    }

    // Submit button feedback
    const btn = this.querySelector('.btn-submit');
    btn.innerHTML = 'Mengirim... &#8987;';
    btn.disabled = true;

    // AJAX Submission to avoid scrolling / reload
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('is_ajax', '1');

    fetch(this.action, {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      let alertBox = document.querySelector('.dynamic-alert');
      if (!alertBox) {
        alertBox = document.createElement('div');
        alertBox.className = 'dynamic-alert';
        this.parentNode.insertBefore(alertBox, this);
      }
      
      alertBox.style.marginBottom = '16px';
      if (data.status === 'success') {
        alertBox.className = 'dynamic-alert alert-success';
        alertBox.innerHTML = '&#10004; ' + data.message;
        this.reset();
      } else {
        alertBox.className = 'dynamic-alert alert-error';
        alertBox.innerHTML = '&#10006; ' + data.message;
      }
      
      btn.innerHTML = 'Kirim Pesan &rarr;';
      btn.disabled = false;
    })
    .catch(error => {
      alert('Gagal mengirim pesan, pastikan Anda terhubung ke internet.');
      btn.innerHTML = 'Kirim Pesan &rarr;';
      btn.disabled = false;
    });
  });
}

// ── ACTIVE NAV LINK ON SCROLL ──
const sections = document.querySelectorAll('section[id]');
window.addEventListener('scroll', () => {
  const scrollY = window.scrollY + 120;
  sections.forEach(sec => {
    if (scrollY >= sec.offsetTop && scrollY < sec.offsetTop + sec.offsetHeight) {
      navLinks.querySelectorAll('a').forEach(a => a.classList.remove('active'));
      const activeLink = navLinks.querySelector(`a[href="#${sec.id}"]`);
      if (activeLink) activeLink.classList.add('active');
    }
  });
}, { passive: true });
