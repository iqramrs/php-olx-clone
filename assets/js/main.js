// ====================
// NAVBAR FUNCTIONALITY
// ====================

document.addEventListener("DOMContentLoaded", function () {
  // Set active link
  const currentLocation = location.pathname;
  const navLinks = document.querySelectorAll(".nav-link");

  navLinks.forEach((link) => {
    if (link.getAttribute("href") === currentLocation) {
      link.classList.add("active");
    }
  });

  initializeNavbar();
});

function initializeNavbar() {
  const navbar = document.querySelector(".navbar");
  let lastScrollTop = 0;

  window.addEventListener("scroll", function () {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop && scrollTop > 100) {
      // Scrolling down - hide navbar
      navbar.style.transform = "translateY(-100%)";
      navbar.style.transition = "transform 0.3s ease";
    } else {
      // Scrolling up - show navbar
      navbar.style.transform = "translateY(0)";
    }

    // Update shadow based on scroll position
    if (scrollTop > 0) {
      navbar.style.boxShadow = "0 8px 16px rgba(0, 0, 0, 0.12)";
    } else {
      navbar.style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.08)";
    }

    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
  });
}

// ====================
// IMAGE LAZY LOADING
// ====================

if ("IntersectionObserver" in window) {
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.classList.add("loaded");
        observer.unobserve(img);
      }
    });
  });

  document.querySelectorAll("img[data-src]").forEach((img) => {
    imageObserver.observe(img);
  });
}

// ====================
// SEARCH FORM VALIDATION
// ====================

const searchForm = document.querySelector(".search-bar form");
if (searchForm) {
  searchForm.addEventListener("submit", function (e) {
    const searchInput = searchForm.querySelector('input[type="text"]');
    const query = searchInput.value.trim();

    if (query.length < 2) {
      e.preventDefault();
      alert("Masukkan minimal 2 karakter untuk mencari");
      return false;
    }
  });
}

// ====================
// SMOOTH SCROLL FOR NAVIGATION
// ====================

document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    const href = this.getAttribute("href");

    // Skip if it's just an anchor without ID
    if (href === "#") {
      e.preventDefault();
      return;
    }

    const target = document.querySelector(href);
    if (target) {
      e.preventDefault();
      target.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
    }
  });
});

// ====================
// TOOLTIP FUNCTIONALITY
// ====================

const tooltipTriggerList = document.querySelectorAll("[data-tooltip]");
tooltipTriggerList.forEach((triggerEl) => {
  triggerEl.addEventListener("mouseenter", function () {
    const tooltipText = this.getAttribute("data-tooltip");
    const tooltip = document.createElement("div");
    tooltip.className = "tooltip";
    tooltip.textContent = tooltipText;
    document.body.appendChild(tooltip);

    const rect = triggerEl.getBoundingClientRect();
    tooltip.style.position = "fixed";
    tooltip.style.left =
      rect.left + rect.width / 2 - tooltip.offsetWidth / 2 + "px";
    tooltip.style.top = rect.top - 10 + "px";

    triggerEl.addEventListener("mouseleave", function () {
      tooltip.remove();
    });
  });
});

// ====================
// PRICE FORMATTER
// ====================

function formatPrice(price) {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(price);
}

// ====================
// DATE FORMATTER
// ====================

function formatDate(date) {
  const options = {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  };
  return new Date(date).toLocaleDateString("id-ID", options);
}

// ====================
// NOTIFICATION HANDLER
// ====================

function showNotification(message, type = "info") {
  const notification = document.createElement("div");
  notification.className = `notification notification-${type}`;
  notification.textContent = message;
  notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 4px;
        background: ${
          type === "success"
            ? "#4caf50"
            : type === "error"
            ? "#f44336"
            : "#2196f3"
        };
        color: white;
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;

  document.body.appendChild(notification);

  setTimeout(() => {
    notification.style.animation = "slideOut 0.3s ease";
    setTimeout(() => notification.remove(), 300);
  }, 3000);
}

// ====================
// ADD TO FAVORITES (LOCAL STORAGE)
// ====================

function addToFavorites(adId) {
  let favorites = JSON.parse(localStorage.getItem("favorites")) || [];

  if (!favorites.includes(adId)) {
    favorites.push(adId);
    localStorage.setItem("favorites", JSON.stringify(favorites));
    showNotification("Ditambahkan ke favorit", "success");
    return true;
  } else {
    favorites = favorites.filter((id) => id !== adId);
    localStorage.setItem("favorites", JSON.stringify(favorites));
    showNotification("Dihapus dari favorit", "info");
    return false;
  }
}

function isFavorite(adId) {
  const favorites = JSON.parse(localStorage.getItem("favorites")) || [];
  return favorites.includes(adId);
}

// ====================
// ANIMATIONS
// ====================

const style = document.createElement("style");
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .tooltip {
        background: #333;
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 1000;
        pointer-events: none;
        animation: fadeIn 0.3s ease;
    }

    img.loaded {
        animation: fadeIn 0.3s ease;
    }
`;
document.head.appendChild(style);

// ====================
// CONSOLE EASTER EGG
// ====================

console.log(
  "%c🚀 OLX Clone - Jual Beli Online",
  "font-size: 20px; color: #0099ff; font-weight: bold;"
);
console.log("%cDeveloped with ❤️", "font-size: 14px; color: #ffb400;");
