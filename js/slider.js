var splide = new Splide('.splide', {
    type: 'loop',
    perPage: 3,
    rewind: false,
    autoplay: true,
    interval: 2500,
    breakpoints: {
      640: {
        perPage: 2,
        gap: '.7rem',
        height: '12rem',
      },
      480: {
        perPage: 1,
        gap: '.7rem',
        height: '12rem',
      },
    },
  });

  splide.mount();