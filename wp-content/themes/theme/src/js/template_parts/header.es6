const tourIframe = document.querySelector('.popup__simple.tour iframe, .popup__simple-tour')
const isBookModal = document.querySelector('.book-modal')
const tourUrl = tourIframe ? tourIframe.getAttribute('data-url') : null

const openSpinnerTour = () => {
  const iframe = document.querySelector('.spinner iframe');
  const headerPopup = document.querySelector('.header__popup');
  if (!iframe) return false;

  let targetOrigin = '*';
  try {
    if (iframe.src) targetOrigin = new URL(iframe.src, window.location.href).origin;
  } catch (_) { }

  iframe.contentWindow.postMessage({ type: "OPEN_SPINNER_TOUR" }, targetOrigin);
  headerPopup && headerPopup.classList.remove('open');
  return true;
}

const openSpinnerFloorMap = () => {
  const iframe = document.querySelector('.spinner iframe');
  if (!iframe) return false;

  let targetOrigin = '*';
  try {
    if (iframe.src) targetOrigin = new URL(iframe.src, window.location.href).origin;
  } catch (_) { }

  iframe.contentWindow.postMessage({ type: "OPEN_FLOOR_MAP" }, targetOrigin);
  return true;
}

const isTourOpenMobile = () => {
  const footerBtns = document.querySelector('.footer__buttons');
  return !!(footerBtns && footerBtns.classList.contains('hide') && window.innerWidth <= 900);
}

const isTourMenuLink = (link) => {
  if (!link) return false;
  if (link.classList.contains('tours-link')) return true;
  if (link.closest('li') && link.closest('li').classList.contains('tours-link')) return true;
  if (/3d\s*tours?/i.test((link.textContent || '').trim())) return true;

  const href = link.getAttribute('href');
  if (href && href.startsWith('#')) {
    const target = document.querySelector(href);
    if (target && target.classList.contains('tour')) return true;
  }
  return false;
}

document.addEventListener('DOMContentLoaded', () => {
  const menuButton = document.querySelector('.header__button');
  const popup = document.querySelector('.header__popup');
  const closeButton = document.querySelector('.header__popup-close');
  menuButton.addEventListener('click', () => {
    if (!isBookModal) {
      popup.classList.toggle('open');
    } else {
      bookDemoModal()
    }
  });

  closeButton.addEventListener('click', () => {
    popup.classList.remove('open');
  });

});

////////////////////////

const bookDemoModal = () => {
  const popup = document.querySelector('#contact-form');
  if (!popup) return;
  popup.classList.add('open');
}

document.addEventListener('DOMContentLoaded', () => {
  const menuLinks = document.querySelectorAll('.header__popup-menu a');
  const headerContacts = document.querySelectorAll('.header__contact');
  const footerPdf = document.querySelector('.footer__price');
  const headerPopup = document.querySelector('.header__popup');

  menuLinks.forEach(link => {
    const href = link.getAttribute('href');

    // EXPLORE / 3D TOURS → spinner VR tour
    if (isTourMenuLink(link)) {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        if (isBookModal) {
          bookDemoModal();
          return;
        }
        openSpinnerTour();
      });
      return;
    }

    if (!href || !href.startsWith('#')) return;

    link.addEventListener('click', (e) => {
      const popup = document.querySelector(href);

      if (link.parentElement.classList.contains('pdf-link') && window.innerWidth < 900) {
        e.preventDefault();
        window.open(
          'https://clearviewdrive.app/wp-content/uploads/2026/03/Clear-View-Drive-Collateral.pdf',
          '_blank',
          'noopener'
        );
        headerPopup.classList.remove('open');
        return;
      }


      if (!popup) return;

      if (popup.classList.contains('tour')) {
        e.preventDefault();
        openSpinnerTour();
        return;
      }

      e.preventDefault();
      if (headerPopup) {
        headerPopup.classList.remove('open');
      }
      popup.classList.add('open');
    });
  });
  headerContacts.forEach(headerContact => {
    headerContact.addEventListener('click', (e) => {
      e.preventDefault();
      bookDemoModal()
    })
  })



  footerPdf.addEventListener('click', (e) => {
    if (!isBookModal) {
      const href = footerPdf.getAttribute('href');
      if (!href || !href.startsWith('#')) return;
      const popup = document.querySelector(href);
      if (!popup) return;
      e.preventDefault();
      popup.classList.add('open');
    } else {
      bookDemoModal()
    }
  })

  document.addEventListener('click', (e) => {
    if (e.target.classList.contains('popup__contact-close')) {
      const popup = e.target.closest('.popup__contact');
      const thanksBlock = popup.querySelector('.popup__thanks');
      popup.classList.remove('open', 'thanks');
      if (thanksBlock) {
        thanksBlock.classList.remove('active');
      }
    }
  })


  const iframe = document.querySelector('iframe');
  window.addEventListener('blur', () => {
    if (document.activeElement === iframe) {
      if (headerPopup) {
        headerPopup.classList.remove('open');
      }
    }
  });
});

document.addEventListener('click', (e) => {
  if (e.target.classList.contains('popup__simple-close')) {
    const popup = e.target.closest('.popup__simple');

    if (popup.classList.contains('tour') && tourIframe) {
      tourIframe.removeAttribute('src')
    }


    popup.classList.remove('open');
  }
});

document.addEventListener('wpcf7mailsent', function (event) {
  const popup = event.target.closest('.popup__contact');
  const thanksBlock = popup.querySelector('.popup__thanks');
  const form = event.target;

  if (thanksBlock) {
    thanksBlock.classList.add('active');
  }
  popup.classList.add('thanks');

  setTimeout(() => {
    form.dispatchEvent(new Event('reset'));
    popup.classList.remove('open')
    if (thanksBlock) {
      thanksBlock.classList.remove('active');
      popup.classList.remove('thanks');
    }

  }, 5000);
});


window.addEventListener("message", function (event) {
  if (event.data.type === "OPEN_WP_MODAL") {


    const popup = document.querySelector('.popup__contact');
    popup.classList.add('open')
  }
});
window.addEventListener("message", function (event) {
  if (event.data.type === "OPEN_WP_PDF") {


    const popup = document.querySelector('.popup__contact.second');
    popup.classList.add('open')
  }
});


const apartmentsLink = document.querySelector('.apartments-link')
apartmentsLink && apartmentsLink.addEventListener('click', (e) => {
  e.preventDefault()
  const iframe = document.querySelector('.spinner iframe');
  const headerPopup = document.querySelector('.header__popup');
  if (iframe && headerPopup) {
    iframe.contentWindow.postMessage(
      { type: "APARTMENTS" },
      window.location.origin
    );

    headerPopup.classList.remove('open');
  }
})

const toursLinks = document.querySelectorAll('.tours-link')
toursLinks.forEach(toursLink => {
  toursLink && toursLink.addEventListener('click', (e) => {
    e.preventDefault()
    if (isBookModal) {
      bookDemoModal()
      return
    }
    if (isTourOpenMobile()) {
      openSpinnerFloorMap()
      return
    }
    openSpinnerTour()
  })
})



const contacts = document.querySelectorAll('.popup__contact');
const modals = document.querySelectorAll('.popup__simple')

modals.length && modals.forEach(modal => {
  const wrapper = modal.querySelector('.popup__simple-wrapper');
  modal.addEventListener('click', (e) => {
    if (!wrapper.contains(e.target)) {
      modal.classList.remove('open');
    }
  });
})

contacts.length && contacts.forEach(contact => {
  const wrapperContact = contact.querySelector('.popup__contact-wrapper');
  contact.addEventListener('click', (e) => {
    if (!wrapperContact.contains(e.target)) {
      contact.classList.remove('open');
    }
  });
})

document.addEventListener("DOMContentLoaded", function () {

  const popup = document.querySelector(".popup__simple.video");

  if (!popup) return;

  const video = popup.querySelector(".popup__simple-video");
  const playBtn = popup.querySelector(".popup__simple-play");
  const preview = popup.querySelector(".popup__simple-prev");
  const closeBtn = popup.querySelector(".popup__simple-close");

  playBtn.addEventListener("click", function () {
    playBtn.style.display = "none";

    if (preview) {
      preview.style.display = "none";
    }

    video.style.display = "block";
    video.currentTime = 0;
    video.play();
  });

  closeBtn.addEventListener("click", function () {

    video.pause();
    video.currentTime = 0;

    playBtn.style.display = "block";

    if (preview) {
      preview.style.display = "block";
    }

    video.style.display = "none";
  });

});

document.addEventListener("DOMContentLoaded", function () {
  const initPopupGallery = (root) => {
    if (!root) return;

    const img = root.querySelector(".popup__gallery-img");
    const thumbs = Array.prototype.slice.call(root.querySelectorAll(".popup__gallery-thumb"));
    const currentEl = root.querySelector(".popup__gallery-current");
    const prevBtn = root.querySelector(".popup__gallery-prev");
    const nextBtn = root.querySelector(".popup__gallery-next");
    if (!img || !thumbs.length) return;

    let index = 0;

    const show = (i) => {
      index = (i + thumbs.length) % thumbs.length;
      const thumb = thumbs[index];
      img.src = thumb.getAttribute("data-full") || img.src;
      img.alt = thumb.getAttribute("data-alt") || "";
      img.setAttribute("data-index", String(index));
      if (currentEl) currentEl.textContent = String(index + 1);
      thumbs.forEach((t, ti) => {
        if (ti === index) t.classList.add("is-active");
        else t.classList.remove("is-active");
      });
    };

    prevBtn && prevBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      show(index - 1);
    });
    nextBtn && nextBtn.addEventListener("click", (e) => {
      e.stopPropagation();
      show(index + 1);
    });
    thumbs.forEach((t) => {
      t.addEventListener("click", (e) => {
        e.stopPropagation();
        show(Number(t.getAttribute("data-index")) || 0);
      });
    });

    document.addEventListener("keydown", (e) => {
      if (!root.classList.contains("open")) return;
      if (e.key === "ArrowLeft") show(index - 1);
      if (e.key === "ArrowRight") show(index + 1);
      if (e.key === "Escape") root.classList.remove("open");
    });

    const mo = new MutationObserver(() => {
      if (root.classList.contains("open")) show(0);
    });
    mo.observe(root, { attributes: true, attributeFilter: ["class"] });
  };

  Array.prototype.forEach.call(
    document.querySelectorAll(".popup__simple.gallery, .popup__simple.floorplan"),
    initPopupGallery
  );
});

const footerBtns = document.querySelector('.footer__buttons')
window.addEventListener("message", function (event) {
  if (event.data.type === "SPINNER_IS_OPEN") {
    // Коли я перейшов на спінер
    footerBtns && footerBtns.classList.remove('hide')
  }
});
window.addEventListener("message", function (event) {
  if (event.data.type === "TOUR_IS_OPEN") {
    // Коли я перейшов на тур
    footerBtns && footerBtns.classList.add('hide')
  }
});
