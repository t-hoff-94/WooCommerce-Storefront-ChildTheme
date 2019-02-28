import $ from 'jquery';

class HomeSlider {
  constructor() {
    this.els = $(".hero-slider");
    this.initSlider();
  }

  initSlider() {
    this.els.slick({
      // autoplay: true,
      arrows: false,
      dots: true
    });
  }
}

export default HomeSlider;
