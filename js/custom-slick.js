'use strict';

class Carousel {
  CarouselSlickQuickView() {
    jQuery("#tbay-quick-view-content .woocommerce-product-gallery__wrapper").each(function () {
      let _this = jQuery(this);

      if (_this.children().length == 0 || _this.hasClass("slick-initialized")) {
        return;
      }

      var _config = {
        slidesToShow: 1,
        infinite: false,
        focusOnSelect: true,
        dots: true,
        arrows: false,
        adaptiveHeight: true,
        mobileFirst: true,
        vertical: false,
        cssEase: "ease",
        settings: "unslick",
        rtl: _this.parent(".woocommerce-product-gallery").data("rtl") === "yes"
      };
      jQuery(".variations_form").on("woocommerce_variation_select_change", function () {
        _this.slick("slickGoTo", 0);
      });

      _this.slick(_config);
    });
  }

  CarouselSlick() {
    var _this = this;

    if (jQuery(".owl-carousel[data-carousel=owl]:visible").length === 0) return;
    jQuery(".owl-carousel[data-carousel=owl]:visible:not(.scroll-init)").each(function () {
      _this._initCarouselSlick(jQuery(this));
    });
    jQuery(".owl-carousel[data-carousel=owl]:visible.scroll-init").waypoint(function () {
      let el = jQuery(jQuery(this)[0].element);

      _this._initCarouselSlick(el);
    }, {
      offset: "100%"
    });
  }

  _initCarouselSlick(el) {
    var _this = this;

    if (el.hasClass("slick-initialized")) {
      return;
    }

    if (jQuery(window).width() > 767) {
      el.slick(_this._getSlickConfigOption(el));
    } else if (!el.data("unslick")) {
      el.slick(_this._getSlickConfigOption(el));
    }
  }

  _getSlickConfigOption(el) {
    var slidesToShow = jQuery(el).data("items"),
        rows = jQuery(el).data("rows") ? parseInt(jQuery(el).data("rows")) : 1,
        desktop = jQuery(el).data("desktopslick") ? jQuery(el).data("desktopslick") : slidesToShow,
        desktopsmall = jQuery(el).data("desktopsmallslick") ? jQuery(el).data("desktopsmallslick") : slidesToShow,
        tablet = jQuery(el).data("tabletslick") ? jQuery(el).data("tabletslick") : slidesToShow,
        landscape = jQuery(el).data("landscapeslick") ? jQuery(el).data("landscapeslick") : 2,
        mobile = jQuery(el).data("mobileslick") ? jQuery(el).data("mobileslick") : 2;
    let enonumber = slidesToShow < jQuery(el).children().length ? true : false,
        enonumber_mobile = 2 < jQuery(el).children().length ? true : false;
    let pagination = enonumber ? Boolean(jQuery(el).data("pagination")) : false,
        nav = enonumber ? Boolean(jQuery(el).data("nav")) : false,
        loop = enonumber ? Boolean(jQuery(el).data("loop")) : false,
        auto = enonumber ? Boolean(jQuery(el).data("auto")) : false;
    var _config = {
      dots: pagination,
      arrows: nav,
      infinite: loop,
      speed: jQuery(el).data("speed") ? jQuery(el).data("speed") : 500,
      autoplay: auto,
      autoplaySpeed: jQuery(el).data("autospeed") ? jQuery(el).data("autospeed") : 2000,
      cssEase: "ease",
      slidesToShow: slidesToShow,
      slidesToScroll: slidesToShow,
      mobileFirst: true,
      vertical: false,
      prevArrow: '<button type="button" class="slick-prev">' + themename_settings.slick_prev + "</button>",
      nextArrow: '<button type="button" class="slick-next">' + themename_settings.slick_next + "</button>",
      rtl: jQuery("html").attr("dir") == "rtl"
    };

    if (rows > 1) {
      _config.slidesToShow = 1;
      _config.slidesToScroll = 1;
      _config.rows = rows;
      _config.slidesPerRow = slidesToShow;
      var settingsFull = {
        slidesPerRow: slidesToShow
      },
          settingsDesktop = {
        slidesPerRow: desktop
      },
          settingsDesktopsmall = {
        slidesPerRow: desktopsmall
      },
          settingsTablet = {
        slidesPerRow: tablet,
        infinite: false
      },
          settingsLandscape = jQuery(el).data("unslick") ? "unslick" : {
        slidesPerRow: landscape,
        infinite: false
      },
          settingsMobile = jQuery(el).data("unslick") ? "unslick" : {
        slidesPerRow: mobile,
        infinite: false
      };
    } else {
      var settingsFull = {
        slidesToShow: slidesToShow,
        slidesToScroll: slidesToShow
      },
          settingsDesktop = {
        slidesToShow: desktop,
        slidesToScroll: desktop
      },
          settingsDesktopsmall = {
        slidesToShow: desktopsmall,
        slidesToScroll: desktopsmall
      },
          settingsTablet = {
        slidesToShow: tablet,
        slidesToScroll: tablet,
        infinite: false
      },
          settingsLandscape = jQuery(el).data("unslick") ? "unslick" : {
        slidesToShow: landscape,
        slidesToScroll: landscape,
        infinite: false
      },
          settingsMobile = jQuery(el).data("unslick") ? "unslick" : {
        slidesToShow: mobile,
        slidesToScroll: mobile,
        infinite: false
      };
    }

    var settingsArrows = jQuery(el).data("nav") ? {
      arrows: false,
      dots: enonumber_mobile
    } : "";
    settingsLandscape = jQuery(el).data("unslick") ? settingsLandscape : jQuery.extend(true, settingsLandscape, settingsArrows);
    settingsMobile = jQuery(el).data("unslick") ? settingsMobile : jQuery.extend(true, settingsMobile, settingsArrows);
    _config.responsive = [{
      breakpoint: 1600,
      settings: settingsFull
    }, {
      breakpoint: 1199,
      settings: settingsDesktop
    }, {
      breakpoint: 991,
      settings: settingsDesktopsmall
    }, {
      breakpoint: 767,
      settings: settingsTablet
    }, {
      breakpoint: 575,
      settings: settingsLandscape
    }, {
      breakpoint: 0,
      settings: settingsMobile
    }];
    return _config;
  }

  getSlickTabs() {
    var _this = this;

    jQuery("ul.nav-tabs li a").on("shown.bs.tab", event => {
      let carouselItemTab = jQuery(jQuery(event.target).attr("href")).find(".owl-carousel[data-carousel=owl]:visible");
      let carouselItemDestroy = jQuery(jQuery(event.relatedTarget).attr("href")).find(".owl-carousel[data-carousel=owl]");

      if (carouselItemDestroy.hasClass("slick-initialized")) {
        carouselItemDestroy.slick("unslick");
      }

      if (!carouselItemTab.hasClass("slick-initialized")) {
        carouselItemTab.slick(_this._getSlickConfigOption(carouselItemTab));
      }
    });
  }

  _carouselBlurAddClass() {
    if (jQuery(".tbay-element").hasClass("carousel-blur")) {
      jQuery('.tbay-element.carousel-blur').parents('.elementor-top-section').addClass('elementor-product-carousel-blur');
    }
  }

}

class Slider {
  tbaySlickSlider() {
    jQuery(".flex-control-thumbs").each(function () {
      if (jQuery(this).children().length == 0 || jQuery(this).hasClass("slick-initialized")) return;
      var _config = {
        vertical: jQuery(this).parent(".woocommerce-product-gallery").data("layout") === "vertical",
        slidesToShow: jQuery(this).parent(".woocommerce-product-gallery").data("columns"),
        infinite: false,
        focusOnSelect: true,
        settings: "unslick",
        prevArrow: '<span class="owl-prev"></span>',
        nextArrow: '<span class="owl-next"></span>',
        rtl: jQuery(this).parent(".woocommerce-product-gallery").data("rtl") === "yes" && jQuery(this).parent(".woocommerce-product-gallery").data("layout") !== "vertical",
        responsive: [{
          breakpoint: 1200,
          settings: {
            vertical: false,
            slidesToShow: jQuery(this).parent(".woocommerce-product-gallery").data("tabletcolumns")
          }
        }]
      };
      jQuery(this).slick(_config);
    });
  }

}

jQuery(document).ready(function () {
  const carousel = new Carousel();
  carousel.CarouselSlick();
  carousel.getSlickTabs();

  carousel._carouselBlurAddClass();

  jQuery(document.body).on("tbay_carousel_slick", () => {
    carousel.CarouselSlick();
  });
  jQuery(document.body).on("tbay_quick_view", () => {
    carousel.CarouselSlickQuickView();
  });
});
jQuery(document.body).on('wc-product-gallery-after-init', () => {
  var slider = new Slider();
  slider.tbaySlickSlider();
});
jQuery(window).on("elementor/frontend/init", function () {
  if (elementorFrontend.isEditMode() && typeof themename_settings !== "undefined" && Array.isArray(themename_settings.elements_ready.slick)) {
    jQuery.each(themename_settings.elements_ready.slick, function (index, value) {
      elementorFrontend.hooks.addAction("frontend/element_ready/tbay-" + value + ".default", () => {
        const carousel = new Carousel();
        carousel.CarouselSlick();
      });
    });
  }
});
