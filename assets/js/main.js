// cart popup
  const openCartBtn = document.getElementById('openCartBtn');
  const closeCartBtn = document.getElementById('closeCartBtn');
  const cartPanel = document.getElementById('cartPanel');
  const overlay = document.getElementById('overlay');
  const panel = document.getElementById('panel');

  openCartBtn.addEventListener('click', () => {
    cartPanel.classList.remove('hidden');
    setTimeout(() => {
      overlay.classList.remove('pointer-events-none', 'opacity-0');
      overlay.classList.add('opacity-100');
      panel.classList.remove('translate-x-full');
      panel.classList.add('translate-x-0');
    }, 10);
  });

  closeCartBtn.addEventListener('click', () => {
    panel.classList.remove('translate-x-0');
    panel.classList.add('translate-x-full');
    overlay.classList.remove('opacity-100');
    overlay.classList.add('opacity-0');
    setTimeout(() => {
      overlay.classList.add('pointer-events-none');
      cartPanel.classList.add('hidden');
    }, 500);
  });

  const carousel = document.getElementById('carousel');
  const prevButton = document.getElementById('prev');
  const nextButton = document.getElementById('next');
  
  function scrollCarousel(direction) {
      const itemWidth = carousel.querySelector('.carousel-item').offsetWidth;
      const maxScroll = carousel.scrollWidth - carousel.clientWidth;
      let scrollAmount = carousel.scrollLeft + direction * itemWidth;
  
      // Ensure scrollAmount is within the bounds
      if (scrollAmount < 0) {
          scrollAmount = 0;
      } else if (scrollAmount > maxScroll) {
          scrollAmount = maxScroll;
      }
  
      // Scroll to the calculated position, ensuring it snaps to the nearest item
      carousel.scrollTo({
          left: scrollAmount,
          behavior: 'smooth'
      });
  }
  
