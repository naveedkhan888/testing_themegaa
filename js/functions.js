'use strict';

class StickyHeader {
  constructor() {
    let _this = this;

    this.$tbayHeader = jQuery(".tbay_header-template");
    this.$tbayHeaderMain = jQuery(".tbay_header-template .header-main");

    if (this.$tbayHeader.hasClass("main-sticky-header") && this.$tbayHeaderMain.length > 0) {
      this._initStickyHeader();
    }

    this._intSearchOffcanvas;
    let sticky_header = jQuery(".element-sticky-header");

    if (sticky_header.length > 0) {
      _this._initELementStickyheader(sticky_header);
    }
  }

  _initStickyHeader() {
    var _this = this;

    var tbay_width = jQuery(window).width();

    var header_height = _this.$tbayHeader.outerHeight();

    var headerMain_height = _this.$tbayHeaderMain.outerHeight();

    var admin_height = jQuery("#wpadminbar").length > 0 ? jQuery("#wpadminbar").outerHeight() : 0;

    var sticky = _this.$tbayHeaderMain.offset().top;

    if (tbay_width >= 1024) {
      if (sticky == 0 || sticky == admin_height) {
        if (_this.$tbayHeader.hasClass("sticky-header")) return;

        _this._stickyHeaderOnDesktop(headerMain_height, sticky, admin_height);

        _this.$tbayHeaderMain.addClass("sticky-1");

        jQuery(window).scroll(function () {
          if (jQuery(this).scrollTop() > header_height) {
            _this.$tbayHeaderMain.addClass("sticky-box");
          } else {
            _this.$tbayHeaderMain.removeClass("sticky-box");
          }
        });
      } else {
        jQuery(window).scroll(function () {
          if (!_this.$tbayHeader.hasClass("main-sticky-header")) return;

          if (jQuery(this).scrollTop() > sticky - admin_height) {
            if (_this.$tbayHeader.hasClass("sticky-header")) return;

            _this._stickyHeaderOnDesktop(headerMain_height, sticky, admin_height);
          } else {
            _this.$tbayHeaderMain.css("top", 0).css("position", "relative").removeClass("sticky-header").parent().css("padding-top", 0);

            _this.$tbayHeaderMain.prev().css("margin-bottom", 0);
          }
        });
      }
    }
  }

  _stickyHeaderOnDesktop(headerMain_height, sticky, admin_height) {
    this.$tbayHeaderMain.addClass("sticky-header").css("top", admin_height).css("position", "fixed");

    if (sticky == 0 || sticky == admin_height) {
      this.$tbayHeaderMain.parent().css("padding-top", headerMain_height);
    } else {
      this.$tbayHeaderMain.prev().css("margin-bottom", headerMain_height);
    }
  }

  _intSearchOffcanvas() {
    if (jQuery("#tbay-offcanvas-main").length === 0) return;
    jQuery('[data-toggle="offcanvas-main-search"]').off().on("click", function () {
      jQuery("#wrapper-container").toggleClass("show");
      jQuery("#tbay-offcanvas-main").toggleClass("show");
    });
    var $box_totop = jQuery("#tbay-offcanvas-main, .search");
    jQuery(window).on("click.Bst", function (event) {
      if ($box_totop.has(event.target).length == 0 && !$box_totop.is(event.target)) {
        jQuery("#wrapper-container").removeClass("show");
        jQuery("#tbay-offcanvas-main").removeClass("show");
      }
    });
  }

  _initELementStickyheader(elements) {
    var el = elements.first();

    let _this = this;

    var scroll = false,
        sum = 0,
        prev_sum = 0;
    if (el.parents(".tbay_header-template").length === 0) return;
    var adminbar = jQuery("#wpadminbar").length > 0 ? jQuery("#wpadminbar").outerHeight() : 0,
        sticky_load = el.offset().top - jQuery(window).scrollTop() - adminbar,
        sticky = sticky_load;
    el.prevAll().each(function () {
      prev_sum += jQuery(this).outerHeight();
    });
    elements.each(function () {
      if (jQuery(this).parents(".element-sticky-header").length > 0) return;
      sum += jQuery(this).outerHeight();
    });

    _this._initELementStickyheaderContent(sticky_load, sticky, sum, prev_sum, elements, el, adminbar, scroll);

    jQuery(window).scroll(function () {
      scroll = true;
      if (jQuery(window).scrollTop() === 0) sticky = 0;

      _this._initELementStickyheaderContent(sticky_load, sticky, sum, prev_sum, elements, el, adminbar, scroll);
    });
  }

  _initELementStickyheaderContent(sticky_load, sticky, sum, prev_sum, elements, el, adminbar, scroll) {
    if (jQuery(window).scrollTop() < prev_sum && scroll || jQuery(window).scrollTop() === 0 && scroll) {
      if (el.parent().children().first().hasClass("element-sticky-header")) return;
      el.css("top", "");

      if (sticky === sticky_load || sticky === 0) {
        elements.last().next().css("padding-top", "");
      } else {
        el.prev().css("margin-bottom", "");
      }

      el.parent().css("padding-top", "");
      elements.each(function () {
        jQuery(this).removeClass("sticky");

        if (jQuery(this).prev(".element-sticky-header").length > 0) {
          jQuery(this).css("top", "");
        }
      });
    } else {
      if (jQuery(window).scrollTop() < prev_sum && !scroll) return;
      elements.each(function () {
        if (jQuery(this).parents(".element-sticky-header").length > 0) return;
        jQuery(this).addClass("sticky");

        if (jQuery(this).prevAll(".element-sticky-header").length > 0) {
          let total = 0;
          jQuery(this).prevAll(".element-sticky-header").each(function () {
            total += jQuery(this).outerHeight();
          });
          jQuery(this).css("top", total + adminbar);
        }
      });
      el.css("top", adminbar);

      if (sticky === sticky_load || sticky === 0) {
        el.addClass("sticky");
        el.parent().css("padding-top", sum);
      } else {
        el.prev().css("margin-bottom", sum);
      }
    }
  }

}

const TREE_VIEW_OPTION_MEGA_MENU = {
  animated: 300,
  collapsed: true,
  unique: true,
  persist: "location"
};
const TREE_VIEW_OPTION_MOBILE_MENU = {
  animated: 300,
  collapsed: true,
  unique: true,
  hover: false
};

class Mobile {
  constructor() {
    this._mobileMenu();

    this._Select_change_form();

    this._topBarDevice();

    jQuery(window).scroll(() => {
      this._topBarDevice();
    });
  }

  _topBarDevice() {
    const windowObj = jQuery(window);
    const scroll = windowObj.scrollTop();
    const objectSelect = jQuery("#wpadminbar").length > 0 ? jQuery("#wpadminbar").outerHeight() : 0;
    const scrollmobile = windowObj.scrollTop();
    const topbarDeviceMobile = jQuery(".topbar-device-mobile");
    topbarDeviceMobile.toggleClass("active", scroll <= objectSelect);
    jQuery("#tbay-mobile-menu").toggleClass("offsetop", scrollmobile == 0);
  }

  _mobileMenu() {
    const wrapperContainer = jQuery("#wrapper-container");
    const tbayMobileMenu = jQuery("#tbay-mobile-menu");
    jQuery('[data-toggle="offcanvas"], .btn-offcanvas').on("click", function () {
      wrapperContainer.toggleClass("active");
      tbayMobileMenu.toggleClass("active");
    });
    jQuery("#main-mobile-menu .caret").on("click", function () {
      jQuery("#main-mobile-menu .dropdown").removeClass("open");
      jQuery(event.target).parent().addClass("open");
    });
  }

  _Select_change_form() {
    jQuery(".topbar-device-mobile > form select").on("change", function () {
      this.form.submit();
    });
  }

}

class AccountMenu {
  constructor() {
    this._slideToggleAccountMenu(".tbay-login");

    this._slideToggleAccountMenu(".topbar-mobile");

    this._tbayClickNotMyAccountMenu();
  }

  _tbayClickNotMyAccountMenu() {
    const $win_my_account = jQuery(window);
    const $box_my_account = jQuery(".tbay-login .dropdown .account-menu,.topbar-mobile .dropdown .account-menu,.tbay-login .dropdown .account-button,.topbar-mobile .dropdown .account-button");
    $win_my_account.on("click.Bst", function (event) {
      if ($box_my_account.has(event.target).length === 0 && !$box_my_account.is(event.target)) {
        jQuery(".tbay-login .dropdown .account-menu, .topbar-mobile .dropdown .account-menu").slideUp(500);
      }
    });
  }

  _slideToggleAccountMenu(parentSelector) {
    jQuery(parentSelector).find(".dropdown .account-button").on("click", function () {
      jQuery(parentSelector).find(".dropdown .account-menu").slideToggle(500);
    });
  }

}

class BackToTop {
  constructor() {
    this._init();
  }

  _init() {
    const $window = jQuery(window);
    const $backToTopMobile = jQuery("#back-to-top-mobile");
    const $backToTop = jQuery("#back-to-top");
    const $categoryFixed = jQuery(".tbay-category-fixed");
    const $toTop = jQuery(".tbay-to-top");
    $window.scroll(function () {
      const isActive = $window.scrollTop() > 400;
      $toTop.toggleClass("active", isActive);
      $categoryFixed.toggleClass("active", isActive);
    });
    $backToTopMobile.add($backToTop).on("click", function () {
      jQuery("html, body").animate({
        scrollTop: "0px"
      }, 0);
    });
  }

}

class FuncCommon {
  constructor() {
    this._progressAnimation();

    this._createWrapStart();

    jQuery(".mod-heading .widget-title > span").wrapStart();

    this._tbayActiveAdminBar();

    this._tbayResizeMegamenu();

    this._initHeaderCoverBG();

    this._initCanvasSearch();

    this._initTreeviewMenu();

    this._categoryMenu();

    jQuery(window).scroll(() => {
      this._tbayActiveAdminBar();
    });
    jQuery(window).on("resize", () => {
      this._tbayResizeMegamenu();
    });

    this._moveFormLogin();

    this._moveFormCoupon();

    this._moveNoticesLogin();

    this._tbayMainContentMinHeight();

    this._tbayCompareOpenAddClassBody();

    this._tbayImageColorTab();
  }

  _tbayActiveAdminBar() {
    const objectSelect = jQuery("#wpadminbar");

    if (objectSelect.length > 0) {
      jQuery("body").addClass("active-admin-bar");
    }
  }

  _createWrapStart() {
    jQuery.fn.wrapStart = function () {
      return this.each(function () {
        const $this = jQuery(this);
        const node = $this.contents().filter(function () {
          return this.nodeType == 3;
        }).first();
        const text = node.text().trim();
        const first = text.split(" ", 1).join(" ");
        if (!node.length) return;
        node[0].nodeValue = text.slice(first.length);
        node.before("<b>" + first + "</b>");
      });
    };
  }

  _progressAnimation() {
    jQuery("[data-progress-animation]").each(function () {
      const $this = jQuery(this);
      $this.appear(function () {
        const delay = $this.attr("data-appear-animation-delay") ? $this.attr("data-appear-animation-delay") : 1;
        if (delay > 1) $this.css("animation-delay", delay + "ms");
        setTimeout(function () {
          $this.animate({
            width: $this.attr("data-progress-animation")
          }, 800);
        }, delay);
      }, {
        accX: 0,
        accY: -50
      });
    });
  }

  _tbayResizeMegamenu() {
    const window_size = jQuery("body").innerWidth();

    if (jQuery(".tbay_custom_menu").length > 0 && jQuery(".tbay_custom_menu").hasClass("tbay-vertical-menu")) {
      if (window_size > 767) {
        this._resizeMegaMenuOnDesktop();
      } else {
        this._initTreeViewForMegaMenuOnMobile();
      }
    }

    if (jQuery(".tbay-megamenu").length > 0 && jQuery(".tbay-megamenu,.tbay-offcanvas-main").hasClass("verticle-menu") && window_size > 767) {
      this._resizeMegaMenuVertical();
    }
  }

  _resizeMegaMenuVertical() {
    const full_width = parseInt(jQuery("#main-container.container").innerWidth());
    const menu_width = parseInt(jQuery(".verticle-menu").innerWidth());
    const w = full_width - menu_width;
    jQuery(".verticle-menu").find(".aligned-fullwidth").children(".dropdown-menu").css({
      "max-width": w,
      width: full_width - 30
    });
  }

  _resizeMegaMenuOnDesktop() {
    const maxWidth = jQuery("#main-container.container").innerWidth() - jQuery(".tbay-vertical-menu").innerWidth();
    const width = jQuery("#main-container.container").innerWidth() - 30;
    jQuery(".tbay-vertical-menu").find(".aligned-fullwidth").children(".dropdown-menu").css({
      "max-width": maxWidth,
      width: width
    });
  }

  _initTreeViewForMegaMenuOnMobile() {
    if (typeof jQuery.fn.treeview === "undefined") return;
    jQuery(".tbay-vertical-menu > .widget_nav_menu >.nav > ul").each(function () {
      if (jQuery(this).hasClass("treeview")) return;
      jQuery(this).treeview(TREE_VIEW_OPTION_MEGA_MENU);
    });
  }

  _moveFormLogin() {
    if (jQuery(".woocommerce-form-login-toggle").length === 0) return;
    jQuery(".woocommerce-form-login-toggle").parent().find(".woocommerce-form-login").insertAfter(jQuery(".woocommerce-form-login-toggle .woocommerce-info"));
  }

  _moveNoticesLogin() {
    if (jQuery(".woocommerce-form-login-toggle").length === 0) return;
    jQuery(".woocommerce > .woocommerce-notices-wrapper").insertAfter(jQuery(".woocommerce-form-login-toggle .woocommerce-form-login "));
  }

  _moveFormCoupon() {
    if (jQuery(".woocommerce-form-coupon-toggle").length === 0) return;
    jQuery(".woocommerce-form-coupon-toggle").parent().find(".woocommerce-form-coupon").insertAfter(jQuery(".woocommerce-form-coupon-toggle .woocommerce-info"));
  }

  _initHeaderCoverBG() {
    const menu = jQuery(".tbay-horizontal .navbar-nav > li,.tbay-horizontal-default .navbar-nav > li, .tbay_header-template .product-recently-viewed-header"),
          search = jQuery(".tbay-search-form .tbay-search"),
          btn_category = jQuery(".category-inside .category-inside-title"),
          cart_click = jQuery(".cart-popup");
    menu.mouseenter(function () {
      if (jQuery(this).parents("#tbay-header").length === 0) return;
      if (jQuery(this).children(".dropdown-menu, ul, .sub-menu-wrap, .content-view").length == 0) return;
      jQuery(".tbay_header-template").addClass("nav-cover-active-1");
    }).mouseleave(function () {
      if (jQuery(this).closest(".dropdown-menu").length) return;
      jQuery(".tbay_header-template").removeClass("nav-cover-active-1");
    });
    search.focusin(function () {
      if (jQuery(this).closest(".dropdown-menu").length) return;
      if (search.parents(".sidebar-canvas-search").length > 0 || jQuery(this).closest(".tbay_header-template").length === 0) return;
      jQuery(".tbay_header-template").addClass("nav-cover-active-2");
    }).focusout(function () {
      jQuery(".tbay_header-template").removeClass("nav-cover-active-2");
    });
    cart_click.on("shown.bs.dropdown", function (event) {
      jQuery(event.target).closest(".tbay_header-template").addClass("nav-cover-active-3");
    }).on("hidden.bs.dropdown", function (event) {
      jQuery(event.target).closest(".tbay_header-template").removeClass("nav-cover-active-3");
    });

    if (btn_category.parents(".tbay_header-template")) {
      jQuery(document.body).on("tbay_category_inside_open", () => {
        jQuery(".tbay_header-template").addClass("nav-cover-active-4");
      });
      jQuery(document.body).on("tbay_category_inside_close", () => {
        jQuery(".tbay_header-template").removeClass("nav-cover-active-4");
      });
    }
  }

  _initCanvasSearch() {
    const input_search = jQuery("#tbay-search-form-canvas .sidebar-canvas-search .sidebar-content .tbay-search");
    input_search.focusin(function () {
      input_search.parent().addClass("search_cv_active");
    }).focusout(function () {
      input_search.parent().removeClass("search_cv_active");
    });
  }

  _initTreeviewMenu() {
    if (typeof jQuery.fn.treeview === "undefined") return;
    jQuery("#category-menu").addClass("treeview");
    jQuery(".treeview-menu .menu, #category-menu").treeview(TREE_VIEW_OPTION_MEGA_MENU);
    jQuery("#main-mobile-menu, #main-mobile-menu-xlg").treeview(TREE_VIEW_OPTION_MOBILE_MENU);
  }

  _categoryMenu() {
    jQuery(".category-inside .category-inside-title").on("click", function () {
      jQuery(event.target).parents(".category-inside").toggleClass("open");
      if (jQuery(event.target).parents(".category-inside").hasClass("setting-open")) return;

      if (jQuery(event.target).parents(".category-inside").hasClass("open")) {
        jQuery(document.body).trigger("tbay_category_inside_open");
      } else {
        jQuery(document.body).trigger("tbay_category_inside_close");
      }
    });
    const $win = jQuery(window);
    $win.on("click.Bst,click touchstart tap", function (event) {
      const $box = jQuery(".category-inside .category-inside-title, .category-inside-content");
      if (!jQuery(".category-inside").hasClass("open") && !jQuery(".tbay_header-template").hasClass("nav-cover-active-4")) return;

      if ($box.has(event.target).length == 0 && !$box.is(event.target)) {
        const insides = jQuery(".category-inside");
        jQuery.each(insides, function (key, inside) {
          if (!jQuery(inside).hasClass("setting-open")) {
            jQuery(inside).removeClass("open");
            jQuery(".tbay_header-template").removeClass("nav-cover-active-4");
          }
        });
      }
    });
  }

  _tbayMainContentMinHeight() {
    if (jQuery("#tbay-header").length === 0) return;
    const headerH = jQuery("#tbay-header").length > 0 ? jQuery("#tbay-header").outerHeight() : 0,
          footerH = jQuery("#tbay-footer").length > 0 ? jQuery("#tbay-footer").outerHeight() : 0,
          wpadminbarH = jQuery('#wpadminbar').length > 0 ? jQuery('#wpadminbar').outerHeight() : 0,
          copyrightH = jQuery('.tbay-footer .tbay-copyright').length > 0 ? jQuery('.tbay-footer .tbay-copyright').css('margin-top').replace("px", "") : 0,
          winH = jQuery(window).outerHeight();
    jQuery("#tbay-main-content").css('min-height', winH - headerH - footerH - wpadminbarH - copyrightH);
  }

  _tbayCompareOpenAddClassBody() {
    jQuery(document.body).on("yith_woocompare_open_popup", () => {
      jQuery("body").addClass("overflow-hidden");
    });
    jQuery(document).bind('cbox_closed', () => {
      jQuery("body").removeClass("overflow-hidden");
    });
  }

  _tbayImageColorTab() {
    if (jQuery(".tbay-element-image-color-tab").length === 0) return;
    jQuery(".tab-list-color .gallery-color-picker").on('click', function (event) {
      if (jQuery(event.target).hasClass('active')) return;
      jQuery(event.target).parent().find('.active').removeClass('active');
      jQuery(event.target).addClass('active');
      jQuery(event.target).parents('.content-wrapper').removeAttr('class').addClass('content-wrapper active-' + jQuery(event.target).data('color'));
    });
  }

}

class NewsLetter {
  constructor() {
    if (typeof jQuery.fn.modal === "undefined") return;

    this._init();
  }

  _init() {
    let btnRemove = jQuery("#popupNewsletterModal .popupnewsletter-close, #popupNewsletterModal .btn-text-close");
    setTimeout(function () {
      if (Cookies.get("newsletter_remove") == "" || typeof Cookies.get("newsletter_remove") === "undefined") {
        jQuery("#popupNewsletterModal").modal("show");
      }
    }, 3000);
    btnRemove.off().on("click", function (event) {
      jQuery(this).parents("#newsletter-popup").slideUp("slow");
      Cookies.set("newsletter_remove", "hidden", {
        expires: 0.1,
        path: "/"
      });
      event.preventDefault();
    });
  }

}

class Search {
  constructor() {
    this._init();
  }

  _init() {
    this._tbaySearchMobile();

    this._searchToTop();

    this._searchCanvasForm();

    jQuery(".button-show-search").on("click", function () {
      jQuery(".tbay-search-form").addClass("active");
    });
    jQuery(".button-hidden-search").on("click", function () {
      jQuery(".tbay-search-form").removeClass("active");
    });
  }

  _tbaySearchMobile() {
    jQuery("#search-mobile-nav-cover").on("click", function () {
      jQuery(this).parent().find("form").removeClass("open");
    });
  }

  _searchToTop() {
    jQuery(".search-totop-wrapper .btn-search-totop").on("click", function () {
      jQuery(".search-totop-content").toggleClass("active");
      jQuery(this).toggleClass("active");
    });
    var $box_totop = jQuery(".search-totop-wrapper .btn-search-totop, .search-totop-content");
    jQuery(window).on("click.Bst", function (event) {
      if ($box_totop.has(event.target).length == 0 && !$box_totop.is(event.target)) {
        jQuery(".search-totop-wrapper .btn-search-totop").removeClass("active");
        jQuery(".search-totop-content").removeClass("active");
      }
    });
  }

  _searchCanvasForm() {
    let searchform = jQuery("#tbay-search-form-canvas");
    if (searchform.length === 0) return;
    searchform.find("button.search-open").on('click', function () {
      jQuery(event.target).parents("#tbay-search-form-canvas").addClass("open").find('.tbay-search').focus();
      jQuery("body").toggleClass("active-search-canvas");
    });
    let window_searchcanvas = jQuery(window);
    let forcussidebar = jQuery("#tbay-search-form-canvas .search-open, #tbay-search-form-canvas .sidebar-content");
    window_searchcanvas.on("click.Bst", function (event) {
      if (!searchform.hasClass("open")) return;

      if (forcussidebar.has(event.target).length == 0 && !forcussidebar.is(event.target)) {
        searchform.removeClass("open");
        jQuery("body").removeClass("active-search-canvas");
      }
    });
    searchform.find("button.btn-search-close").on("click", function () {
      if (!searchform.hasClass("open")) return;
      searchform.removeClass("open");
      jQuery("body").removeClass("active-search-canvas");
    });
  }

}

class TreeView {
  constructor() {
    this._tbayTreeViewMenu();
  }

  _tbayTreeViewMenu() {
    const treeview = jQuery.fn.treeview;
    const tbayTreeview = jQuery(".tbay-treeview");
    if (typeof treeview === "undefined" || typeof tbayTreeview === "undefined") return;
    tbayTreeview.each(function () {
      const ul = jQuery(this).find("> ul");
      if (ul.hasClass("treeview")) return;
      ul.treeview({
        animated: 400,
        collapsed: ul.parents('nav').data('expand') == '1',
        unique: true,
        persist: "location"
      });
    });
  }

}

class Section {
  constructor() {
    this._tbayMegaMenu();

    this._tbayRecentlyView();
  }

  _tbayMegaMenu() {
    const menu = jQuery(".elementor-widget-tbay-nav-menu");
    if (menu.length === 0) return;
    menu.each(function () {
      const column = jQuery(this).closest(".elementor-column, .e-child");
      const section = jQuery(this).closest(".elementor-top-section, .e-parent");

      if (jQuery(this).find(".tbay-element-nav-menu").data("wrapper").layout === "horizontal") {
        if (!column.hasClass("tbay-column-static")) {
          column.addClass("tbay-column-static");
        }

        if (!section.hasClass("tbay-section-static")) {
          section.addClass("tbay-section-static");
        }
      }
    });
  }

  _tbayRecentlyView() {
    const recently = jQuery(".product-recently-viewed-header");
    if (recently.length === 0) return;
    recently.each(function () {
      const column = jQuery(this).closest(".elementor-column, .e-child");
      const section = jQuery(this).closest(".elementor-top-section, .e-parent");

      if (jQuery(this).data("wrapper").layout === "header") {
        if (!column.hasClass("tbay-column-static")) {
          column.addClass("tbay-column-static");
        }

        if (!column.hasClass("tbay-column-recentlyviewed")) {
          column.addClass("tbay-column-recentlyviewed");
        }

        if (!section.hasClass("tbay-section-recentlyviewed")) {
          section.addClass("tbay-section-recentlyviewed");
        }

        if (!section.hasClass("tbay-section-static")) {
          section.addClass("tbay-section-static");
        }
      }
    });
  }

}

class Preload {
  constructor() {
    this._init();
  }

  _init() {
    const $preloader = jQuery(".js-preloader");

    if ($preloader.length) {
      $preloader.jpreLoader({}, function () {
        $preloader.addClass("preloader-done");
        jQuery("body").trigger("preloader-done");
        jQuery(window).trigger("resize");
      });
    }

    jQuery(".item-loader").delay(100).fadeOut(400, function () {
      jQuery("body").removeClass("tbay-body-loading");
      jQuery(this).remove();
    });

    if (jQuery(document.body).hasClass("tb-loader")) {
      setTimeout(function () {
        jQuery(document.body).removeClass("tb-loader");
        jQuery(".item-loader").fadeOut(250);
      }, 300);
    }
  }

}

class Accordion {
  constructor() {
    this._init();
  }

  _init() {
    const singleProduct = jQuery(".single-product");
    if (!singleProduct.length) return;
    const woocommerceAccordion = jQuery("#woocommerce-accordion");
    woocommerceAccordion.on("shown.bs.collapse", function (e) {
      const offset = woocommerceAccordion.find(".collapse.show").prev(".tabs-title");

      if (offset) {
        jQuery("html,body").animate({
          scrollTop: offset.offset().top - 150
        }, 500);
      }
    });
  }

}

class CustomFonts {
  constructor() {
    this._init();
  }

  _init() {
    if (jQuery('.list-tbay-custom-fonts-body').length === 0) return;
    jQuery('.code-preview').hide();
    jQuery('.show-code').off().on('click', function (e) {
      var temp = jQuery("<input>");
      jQuery("body").append(temp);
      temp.val(jQuery(this).find('.code-preview').text()).select();
      document.execCommand("copy");
      temp.remove();
      jQuery(this).children('.name').toggle();
      jQuery(this).children('.code-preview').toggleClass('show');
      e.stopPropagation();
      return false;
    });
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    jQuery("#quick-search").keyup(function () {
      var srch = jQuery(this).val().trim().toLowerCase();
      jQuery(".icon-preview-box").hide().filter(function () {
        return jQuery(this).html().trim().toLowerCase().indexOf(srch) != -1;
      }).show();
    });
    jQuery(".font-size-changer a").on("click", function (e) {
      e.preventDefault();
      jQuery(".font-size-changer .active").removeClass("active");
      jQuery(".icon-preview-box").removeClass("small-icons medium-icons large-icons").addClass(jQuery(this).attr("class"));
      jQuery(this).addClass("active");
    });
  }

}

class MenuDropdownsAJAX {
  constructor() {
    this._initmenuDropdownsAJAX(jQuery);
  }

  _initmenuDropdownsAJAX($) {
    var _this = this;

    jQuery("body").on("mousemove", function () {
      jQuery(".menu").has(".dropdown-load-ajax").each(function () {
        var $menu = jQuery(this);

        if ($menu.hasClass("dropdowns-loading") || $menu.hasClass("dropdowns-loaded")) {
          return;
        }

        if (!_this.isNear($menu, 50, event)) {
          return;
        }

        _this.loadDropdowns($menu);
      });
    });
  }

  loadDropdowns($menu) {
    var _this = this;

    $menu.addClass("dropdowns-loading");
    var storageKey = "",
        unparsedData = "",
        menu_mobile_id = "";

    if ($menu.closest("nav").attr("id") === "tbay-mobile-menu-navbar") {
      if (jQuery("#main-mobile-menu-mmenu-wrapper").length > 0) {
        menu_mobile_id += "_" + jQuery("#main-mobile-menu-mmenu-wrapper").data("id");
      }

      storageKey = themename_settings.storage_key + "_megamenu_" + menu_mobile_id;
    } else {
      storageKey = themename_settings.storage_key + "_megamenu_" + $menu.closest("nav").data("id");
    }

    unparsedData = localStorage.getItem(storageKey);
    var storedData = false;
    var $items = $menu.find(".dropdown-load-ajax"),
        ids = [];
    $items.each(function () {
      ids.push(jQuery(this).find(".dropdown-html-placeholder").data("id"));
    });
    var unparsedData = localStorage.getItem(storageKey);

    try {
      storedData = JSON.parse(unparsedData);
    } catch (e) {
      console.log("cant parse Json", e);
    }

    if (storedData) {
      _this.renderResults(storedData, $menu);

      if ($menu.attr("id") !== "tbay-mobile-menu-navbar") {
        $menu.removeClass("dropdowns-loading").addClass("dropdowns-loaded");
      }
    } else {
      jQuery.ajax({
        url: themename_settings.ajaxurl,
        data: {
          action: "themename_load_html_dropdowns",
          ids: ids,
          security: themename_settings.wp_megamenunonce
        },
        dataType: "json",
        method: "POST",
        success: function (response) {
          if (response.status === "success") {
            _this.renderResults(response.data, $menu);

            localStorage.setItem(storageKey, JSON.stringify(response.data));
          } else {
            console.log("loading html dropdowns returns wrong data - ", response.message);
          }
        },
        error: function () {
          console.log("loading html dropdowns ajax error");
        }
      });
    }
  }

  renderResults(data, $menu) {
    var _this = this;

    Object.keys(data).forEach(function (id) {
      _this.removeDuplicatedStylesFromHTML(data[id], function (html) {
        let html2 = html;
        const regex1 = '<li[^>]*><a[^>]*href=["]' + window.location.href + '["]>.*?</a></li>';
        let content = html.match(regex1);

        if (content !== null) {
          let $url = content[0];
          let $class = $url.match(/(?:class)=(?:["']\W+\s*(?:\w+)\()?["']([^'"]+)['"]/g)[0].split('"')[1];
          let $class_new = $class + " active";
          let $url_new = $url.replace($class, $class_new);
          html2 = html2.replace($url, $url_new);
        }

        $menu.find('[data-id="' + id + '"]').replaceWith(html2);

        if ($menu.attr("id") !== "tbay-mobile-menu-navbar") {
          $menu.addClass("dropdowns-loaded");
          setTimeout(function () {
            $menu.removeClass("dropdowns-loading");
          }, 1000);
        }
      });
    });
  }

  isNear($element, distance, event) {
    var left = $element.offset().left - distance,
        top = $element.offset().top - distance,
        right = left + $element.width() + 2 * distance,
        bottom = top + $element.height() + 2 * distance,
        x = event.pageX,
        y = event.pageY;
    return x > left && x < right && y > top && y < bottom;
  }

  removeDuplicatedStylesFromHTML(html, callback) {
    if (themename_settings.combined_css) {
      callback(html);
      return;
    } else {
      const regex = /<style>.*?<\/style>/gm;
      let output = html.replace(regex, "");
      callback(output);
      return;
    }
  }

}

class MenuClickAJAX {
  constructor() {
    if (typeof themename_settings === "undefined") return;

    this._initmenuClickAJAX();
  }

  _initmenuClickAJAX() {
    jQuery(".element-menu-ajax.ajax-active").each(function () {
      var $menu = jQuery(this);
      $menu.find(".menu-click").off("click").on("click", function (e) {
        e.preventDefault();
        var $this = jQuery(this);
        if (!$this.closest(".element-menu-ajax").hasClass("ajax-active")) return;
        var element = $this.closest(".tbay-element"),
            type_menu = element.data("wrapper")["type_menu"],
            layout = element.data("wrapper")["layout"];
        var nav = type_menu === "toggle" ? element.find(".category-inside-content > nav") : element.find(".menu-canvas-content > nav");
        var slug = nav.data("id");
        var storageKey = themename_settings.storage_key + "_" + slug + "_" + layout;
        var storedData = false;
        var unparsedData = localStorage.getItem(storageKey);

        try {
          storedData = JSON.parse(unparsedData);
        } catch (e) {
          console.log("cant parse Json", e);
        }

        if (storedData) {
          nav.html(storedData);
          element.removeClass("load-ajax");
          $this.closest(".element-menu-ajax").removeClass("ajax-active");

          if (layout === "treeview") {
            jQuery(document.body).trigger("tbay_load_html_click_treeview");
          } else {
            jQuery(document.body).trigger("tbay_load_html_click");
          }
        } else {
          jQuery.ajax({
            url: themename_settings.ajaxurl,
            data: {
              action: "themename_load_html_click",
              slug: slug,
              type_menu: type_menu,
              layout: layout,
              security: themename_settings.wp_menuclicknonce
            },
            dataType: "json",
            method: "POST",
            beforeSend: function (xhr) {
              element.addClass("load-ajax");
            },
            success: function (response) {
              if (response.status === "success") {
                nav.html(response.data);
                localStorage.setItem(storageKey, JSON.stringify(response.data));

                if (layout === "treeview") {
                  jQuery(document.body).trigger("tbay_load_html_click_treeview");
                } else {
                  jQuery(document.body).trigger("tbay_load_html_click");
                }
              } else {
                console.log("loading html dropdowns returns wrong data - ", response.message);
              }

              element.removeClass("load-ajax");
              $this.closest(".element-menu-ajax").removeClass("ajax-active");
            },
            error: function () {
              console.log("loading html dropdowns ajax error");
            }
          });
        }
      });
    });
  }

}

class CanvastemplateAJAX {
  constructor() {
    this._initcanvastemplateAJAX();
  }

  _initcanvastemplateAJAX() {
    jQuery(".canvas-template-ajax.ajax-active").each(function () {
      const $menu = jQuery(this);
      $menu.find(".menu-click").off("click").on("click", function (e) {
        e.preventDefault();
        const $this = jQuery(this);
        if (!$this.closest(".canvas-template-ajax").hasClass("ajax-active")) return;
        const element = $this.parent().find(".canvas-menu-content");
        const nav = element.find(".canvas-content-ajax");
        const id = $this.data("id");
        const storageKey = themename_settings.storage_key + "_canvas_template_" + id;
        let storedData = false;
        const unparsedData = localStorage.getItem(storageKey);

        try {
          storedData = JSON.parse(unparsedData);
        } catch (e) {
          console.log("cant parse Json", e);
        }

        if (storedData) {
          nav.html(storedData);
          element.removeClass("load-ajax");
          $this.closest(".canvas-template-ajax").removeClass("ajax-active");
          jQuery(document.body).trigger("tbay_load_canvas_template_html_click");
        } else {
          jQuery.ajax({
            url: themename_settings.ajaxurl,
            data: {
              action: "themename_load_html_canvas_template_click",
              id: id,
              security: themename_settings.wp_templateclicknonce
            },
            dataType: "json",
            method: "POST",
            beforeSend: function (xhr) {
              element.addClass("load-ajax");
            },
            success: function (response) {
              if (response.status === "success") {
                nav.html(response.data);
                localStorage.setItem(storageKey, JSON.stringify(response.data));
                jQuery(document.body).trigger("tbay_load_canvas_template_html_click");
              } else {
                console.log("loading html dropdowns returns wrong data - ", response.message);
              }

              element.removeClass("load-ajax");
              $this.closest(".canvas-template-ajax").removeClass("ajax-active");
            },
            error: function () {
              console.log("loading html dropdowns ajax error");
            }
          });
        }
      });
    });
  }

}

class CndkBeforeAfter {
  constructor() {
    if (typeof jQuery.fn.cndkbeforeafter === "undefined") return;

    this._beforeAfterImage();
  }

  _beforeAfterImage() {
    let element = jQuery(".tbay-before-after-image-slider");
    if (element.length === 0) return;
    let settings = element.parents('.tbay-element-before-after-image-slider').data('settings');
    element.cndkbeforeafter({
      mode: settings.mode,
      showText: settings.showText,
      beforeText: settings.beforeText,
      beforeTextPosition: settings.beforeTextPosition,
      afterText: settings.afterText,
      afterTextPosition: settings.afterTextPosition,
      seperatorWidth: settings.seperatorWidth.size + 'px',
      seperatorOpacity: settings.seperatorOpacity.size,
      theme: settings.theme,
      autoSliding: settings.autoSliding,
      autoSlidingStopOnHover: settings.autoSlidingStopOnHover,
      hoverEffect: settings.hoverEffect,
      enterAnimation: settings.enterAnimation
    });
  }

}

class Isotope {
  constructor() {
    if (typeof jQuery.fn.isotope === "undefined") return;

    this._IsotopeRun();
  }

  _IsotopeRun() {
    var portfolios = jQuery('.pf-isotope').isotope({
      itemSelector: '.element-item',
      layoutMode: 'masonry'
    });
    jQuery('#pf-filters').on('click', 'button', function () {
      var filterValue = jQuery(this).attr('data-filter');
      portfolios.isotope({
        filter: filterValue
      });
    });
    jQuery('.pf-button-group').each(function (i, buttonGroup) {
      var $buttonGroup = jQuery(buttonGroup);
      $buttonGroup.on('click', 'button', function () {
        $buttonGroup.find('.is-checked').removeClass('is-checked');
        jQuery(this).addClass('is-checked');
      });
    });
  }

}

class TimeTo {
  constructor() {
    if (typeof jQuery.fn.timeTo === "undefined") return;

    this._init();
  }

  _init() {
    const elements = jQuery('[data-time="timmer"], [data-countdown="countdown"]');
    elements.each(function (index, el) {
      let id = jQuery(this).data("id");
      let date = jQuery(this).data("date").split("-");
      var futureDate = new Date("" + date[2] + "-" + date[0] + "-" + date[1] + "T" + date[3] + ":" + date[4] + ":" + date[5] + "");
      jQuery("#countdown-" + id + "").timeTo({
        timeTo: new Date(futureDate)
      });
    });
  }

}

class AutoComplete {
  constructor() {
    if (typeof jQuery.Autocomplete === "undefined" || typeof themename_settings === "undefined") return;

    this._callAjaxSearch();
  }

  _callAjaxSearch() {
    const _this = this;

    const url = `${themename_settings.ajaxurl}?action=themename_autocomplete_search&security=${themename_settings.wp_searchnonce}`;
    const form = jQuery("form.searchform.themename-ajax-search");

    const RegEx = value => value.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");

    form.each(function () {
      const _this2 = jQuery(this);

      const autosearch = _this2.find("input[name=s]");

      const post_type = _this2.data("post-type");

      const enable_image = Boolean(_this2.data("thumbnail"));
      const enable_subtitle = post_type === "product" ? Boolean(_this2.data("subtitle")) : false;
      const enable_price = post_type === "product" ? Boolean(_this2.data("price")) : false;
      autosearch.devbridgeAutocomplete({
        serviceUrl: _this._AutoServiceUrl(autosearch, url),
        minChars: _this._AutoMinChars(autosearch),
        appendTo: _this._AutoAppendTo(autosearch),
        width: "100%",
        maxHeight: "initial",
        onSelect: suggestion => {
          if (suggestion.link.length > 0) window.location.href = suggestion.link;
        },
        onSearchStart: () => autosearch.parents("form").addClass("tbay-loading"),
        beforeRender: (container, suggestion) => {
          if (typeof suggestion[0].result !== "undefined") {
            jQuery(container).prepend(`<div class="list-header"><span>${suggestion[0].result}</span></div>`);
          }

          if (suggestion[0].view_all) {
            jQuery(container).append(`<div class="view-all-products"><span>${themename_settings.show_all_text}</span></div>`);
          }
        },
        onSearchComplete: (query, suggestions) => {
          form.removeClass("tbay-loading");
          jQuery(this).parents("form").addClass("open");
          jQuery(document.body).trigger("tbay_searchcomplete");
        },
        formatResult: (suggestion, currentValue) => {
          let returnValue = _this._initformatResult(suggestion, currentValue, RegEx, enable_image, enable_price, enable_subtitle);

          return returnValue;
        },
        onHide: function (container) {
          if (jQuery(this).parents("form").hasClass("open")) jQuery(this).parents("form").removeClass("open");
        }
      });
      jQuery("body").on("click", function () {
        if (autosearch.is(":focus")) {
          return;
        }

        autosearch.each(function () {
          jQuery(this).devbridgeAutocomplete("hide");
        });
      });
      jQuery(".tbay-search-clear").on("click", function () {
        jQuery(this).parents(".tbay-search-form").removeClass("open");
        jQuery(this).parents(".tbay-search-form").find("input[name=s]").val("");
      });
    });
    const cat_change = form.find('[name="product_cat"], [name="category"]');

    if (cat_change.length) {
      cat_change.change(function (e) {
        const se_input = jQuery(e.target).parents("form").find("input[name=s]");
        const ac = se_input.devbridgeAutocomplete();
        ac.hide();
        ac.setOptions({
          serviceUrl: _this._AutoServiceUrl(se_input, url)
        });
        ac.onValueChange();
      });
    }

    jQuery(document.body).on("tbay_searchcomplete", function () {
      jQuery(".view-all-products").on("click", function () {
        jQuery(this).parents("form").submit();
        e.stopPropagation();
      });
    });
  }

  _AutoServiceUrl(autosearch, url) {
    const form = autosearch.parents("form");
    const number = parseInt(form.data("count"));
    const postType = form.data("post-type");
    const product_cat = form.find('[name="product_cat"], [name="category"]').val();

    if (number > 0) {
      url += `&number=${number}`;
    }

    url += `&post_type=${postType}`;

    if (product_cat) {
      url += `&product_cat=${product_cat}`;
    }

    return url;
  }

  _AutoAppendTo(autosearch) {
    const form = autosearch.parents("form");
    const appendTo = typeof form.data("appendto") !== "undefined" ? form.data("appendto") : form.find(".themename-search-results");
    return appendTo;
  }

  _AutoMinChars(autosearch) {
    const form = autosearch.parents("form");
    const minChars = parseInt(form.data("minchars"));
    return minChars;
  }

  _initformatResult(suggestion, currentValue, RegEx, enable_image, enable_price, enable_subtitle) {
    if (suggestion.no_found) return '<div class="suggestion-title no-found-msg">' + suggestion.value + "</div>";
    if (currentValue == "&") currentValue = "&#038;";
    const pattern = "(" + RegEx(currentValue) + ")";
    let returnValue = "";

    if (enable_image && suggestion.image && suggestion.image.length > 0) {
      returnValue += ' <div class="suggestion-thumb">' + suggestion.image + "</div>";
    }

    returnValue += '<div class="suggestion-group">';
    returnValue += '<div class="suggestion-title product-title"><span>' + suggestion.value.replace(new RegExp(pattern, "gi"), "<strong>$1</strong>").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/&lt;(\/?strong)&gt;/g, "<$1>") + "</span></div>";

    if (enable_subtitle && suggestion.subtitle && suggestion.subtitle.length > 0) {
      returnValue += '<div class="suggestion-subtitle product-subtitle"><span>' + suggestion.subtitle.replace(new RegExp(pattern, "gi"), "<strong>$1</strong>").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/&lt;(\/?strong)&gt;/g, "<$1>") + "</span></div>";
    }

    if (suggestion.sku && suggestion.sku.length > 0) {
      returnValue += '<div class="suggestion-sku product-sku"><span>' + suggestion.sku.replace(new RegExp(pattern, "gi"), "<strong>$1</strong>").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/&lt;(\/?strong)&gt;/g, "<$1>") + "</span></div>";
    }

    if (enable_price && suggestion.price && suggestion.price.length > 0) {
      returnValue += ' <div class="suggestion-price price">' + suggestion.price + "</div>";
    }

    returnValue += "</div>";
    return returnValue;
  }

}

class TBMmenu {
  constructor() {
    if (typeof Mmenu === "undefined") return;

    this._initMmenu();
  }

  _initMmenu() {
    const body = jQuery("body");

    if (body.hasClass("admin-bar")) {
      jQuery("html").addClass("html-mmenu");
    }

    const text_cancel = typeof themename_settings !== "undefined" ? themename_settings.cancel : "";
    Mmenu.i18n({
      cancel: text_cancel
    });
    const mmenu = jQuery("#tbay-mobile-smartmenu");
    if (mmenu.length === 0) return;
    const themes = mmenu.data("themes");
    const menu_title = mmenu.data("title");
    const searchcounters = Boolean(mmenu.data("counters"));
    const enableeffects = Boolean(mmenu.data("enableeffects"));
    const effectspanels = enableeffects ? mmenu.data("effectspanels") : "";
    const effectslistitems = enableeffects ? mmenu.data("effectslistitems") : "";
    let mmenuOptions = {
      offCanvas: true,
      navbar: {
        title: menu_title
      },
      counters: searchcounters,
      extensions: [themes, effectspanels, effectslistitems]
    };
    const mmenuOptionsAddition = {
      navbars: [],
      searchfield: {}
    };
    const mm_tbay_bottom = jQuery("#mm-tbay-bottom");

    if (mm_tbay_bottom.length > 0) {
      mmenuOptionsAddition.navbars.push({
        position: "bottom",
        content: ""
      });
    }

    mmenuOptions = _.extend(mmenuOptionsAddition, mmenuOptions);
    const mmenuConfigurations = {
      offCanvas: {
        page: {
          selector: "#tbay-main-content"
        }
      },
      searchfield: {
        clear: true
      }
    };
    const menu = new Mmenu("#tbay-mobile-menu-navbar", mmenuOptions, mmenuConfigurations);

    if (mm_tbay_bottom.length > 0) {
      mm_tbay_bottom.prependTo(jQuery("#tbay-mobile-menu-navbar .mm-navbars--bottom"));
    }

    const mmenu_close = jQuery("#mmenu-close");

    if (mmenu_close.length > 0) {
      mmenu_close.prependTo(jQuery("#main-mobile-menu-mmenu"));
    }

    jQuery(".mm-panels").css("top", jQuery(".mm-navbars_top").outerHeight());
    jQuery(".mmenu-open").each(function () {
      jQuery(this).on("click", function () {
        menu.API.open();
      });
    });
    jQuery("#mmenu-close").on("click", function () {
      menu.API.close();
    });
  }

}

class SumoSelect {
  constructor() {
    if (typeof jQuery.fn.SumoSelect === "undefined") return;

    this._init();
  }

  _init() {
    jQuery(document).ready(function () {
      let sumo_class = ".woocommerce-currency-switcher, .woocommerce-fillter >.select, .woocommerce-ordering > .orderby, .tbay-filter select";
      jQuery(sumo_class).SumoSelect({
        csvDispCount: 3,
        captionFormatAllSelected: "Yeah, OK, so everything."
      });
      let search_form = jQuery(".tbay-search-form");
      search_form.each(function () {
        if (jQuery(this).hasClass("tbay-search-mobile")) return;
        jQuery(this).find("select").SumoSelect({
          forceCustomRendering: true
        });
      });
    });
  }

}

class Gallery {
  constructor() {
    if (typeof PhotoSwipe === "undefined") return;

    this._intGallery();
  }

  _intGallery() {
    const gallery = jQuery(".tbay-element-custom-gallery");
    if (gallery.length === 0) return;
    const container = gallery.find(".gallery-item").map(function () {
      const $link = jQuery(this).find(".gallery-link");
      return {
        src: $link.attr("href"),
        w: $link.find("img").attr("width"),
        h: $link.find("img").attr("height"),
        title: $link.data("lightbox-title")
      };
    }).get();
    gallery.find(".gallery-link").off("click").on("click", function (event) {
      event.preventDefault();
      const $pswp = jQuery(".pswp")[0];
      const options = {
        index: jQuery(this).parents(".gallery-item").index(),
        showHideOpacity: true,
        closeOnVerticalDrag: false,
        mainClass: "pswp-gallery-images"
      };
      const gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
      gallery.init();
      event.stopPropagation();
    });
  }

}

class CountDownTimer {
  constructor() {
    if (typeof jQuery.fn.tbayCountDown === "undefined" || typeof themename_settings === "undefined") return;

    this._CountDownTimer();
  }

  _CountDownTimer() {
    var _this = this;

    var timerElements = jQuery('[data-time="timmer"]:not(.scroll-init), [data-countdown="countdown"]:not(.scroll-init)');
    if (timerElements.length === 0) return;
    timerElements.each(function () {
      _this._initCountDownTimer(jQuery(this));
    });
    jQuery('[data-time="timmer"].scroll-init, [data-countdown="countdown"].scroll-init').waypoint(function () {
      var el = jQuery(jQuery(this)[0].element);

      _this._initCountDownTimer(el);
    }, {
      offset: "100%"
    });
  }

  _initCountDownTimer(el) {
    let date = jQuery(el).data("date").split("-"),
        days = jQuery(el).data("days"),
        hours = jQuery(el).data("hours"),
        mins = jQuery(el).data("mins"),
        secs = jQuery(el).data("secs");
    var display = '';
    var show_days = show_hours = show_minutes = show_seconds = true;
    var custom_separator = ":";

    if (jQuery(el).parents('.tbay-element-countdown').length > 0) {
      var settings = jQuery(el).parents('.tbay-element-countdown').data('settings'),
          show_days = settings.show_days,
          show_hours = settings.show_hours,
          show_minutes = settings.show_minutes,
          custom_separator = settings.custom_separator,
          show_seconds = settings.show_seconds;
    }

    if (show_days) {
      display += '<div class="day">%%D%%' + days + '</div><span>' + custom_separator + '</span>';
    }

    if (show_hours) {
      display += '<div class="hours">%%H%%' + hours + '</div><span>' + custom_separator + '</span>';
    }

    if (show_minutes) {
      display += '<div class="minutes">%%M%%' + mins + '</div><span>' + custom_separator + '</span>';
    }

    if (show_seconds) {
      display += '<div class="seconds">%%S%%' + secs + '</div>';
    }

    jQuery(el).tbayCountDown({
      TargetDate: date[0] + "/" + date[1] + "/" + date[2] + " " + date[3] + ":" + date[4] + ":" + date[5],
      DisplayFormat: '<div class="times">' + display + '</div>',
      FinishMessage: ""
    });
  }

}

class Sticky {
  constructor() {
    if (typeof themename_settings === "undefined" || typeof jQuery.fn.hcSticky === "undefined") return;
    let sticky_menu_bar = jQuery("#sticky-menu-bar").outerHeight() || 0;

    this._tbayProductSingleStick(sticky_menu_bar);
  }

  _tbayProductSingleStick(sticky_menu_bar) {
    if (jQuery(window).width() < 992 || jQuery("#tbay-header").length === 0 && jQuery("#tbay-customize-header").length === 0) return;

    if (jQuery(".active-stick .summary-left, .active-stick .summary-right").length > 0) {
      jQuery(".active-stick .summary-left, .active-stick .summary-right").hcSticky({
        stickTo: ".active-stick .image-mains",
        top: (jQuery(".element-sticky-header").length ? jQuery(".element-sticky-header").outerHeight() + 50 : 50) + sticky_menu_bar
      });
    }

    if (jQuery(".active-stick .information").length > 0) {
      jQuery(".active-stick .information").hcSticky({
        stickTo: ".active-stick .image-mains",
        top: (jQuery(".element-sticky-header").length ? jQuery(".element-sticky-header").outerHeight() + 100 : 100) + sticky_menu_bar
      });
    }
  }

}

class Magnific {
  constructor() {
    if (typeof jQuery.magnificPopup === "undefined" || typeof themename_settings === "undefined") return;

    this._list_search_form_popup();

    this._list_button_popup();

    jQuery(document.body).on("tbay_quick_view", () => {
      this._list_button_popup();
    });
  }

  _list_search_form_popup() {
    if (jQuery("#tbay-search-form-popup").length === 0) return;
    jQuery("#tbay-search-form-popup .search-open").magnificPopup({
      type: "inline",
      fixedContentPos: "hidden",
      fixedBgPos: true,
      closeBtnInside: true,
      preloader: false,
      showCloseBtn: false,
      midClick: true,
      focus: '.tbay-search',
      mainClass: "popup-mfp-search-form",
      callbacks: {
        open: function () {
          this.content.find('.btn-search-close').on("click", function () {
            jQuery.magnificPopup.close();
          });
        },
        close: function () {}
      }
    });
  }

  _list_button_popup() {
    if (jQuery(".popup-button-open").length === 0) return;
    jQuery(".popup-button-open").magnificPopup({
      type: "inline",
      fixedContentPos: "hidden",
      fixedBgPos: true,
      closeBtnInside: true,
      preloader: false,
      midClick: true,
      removalDelay: 300,
      mainClass: "popup-button-mfp-zoom-in tbay-mfp-max-width"
    });
  }

}

jQuery(document).ready(jQuery => {
  new CustomFonts(), new CanvastemplateAJAX(), new MenuDropdownsAJAX(), new MenuClickAJAX(), new StickyHeader(), new AccountMenu(), new BackToTop(), new FuncCommon(), new NewsLetter(), new Preload(), new Search(), new TreeView(), new Accordion(), new Section(), new TimeTo(), new CndkBeforeAfter(), new Isotope(), new AutoComplete(), new CountDownTimer(), new Gallery(), new Sticky(), new Magnific(), new TBMmenu();

  if (jQuery(window).width() < 1200) {
    var mobile = new Mobile();

    mobile._topBarDevice();

    jQuery(window).scroll(() => {
      mobile._topBarDevice();
    });
  }

  new SumoSelect();

  function woof_ajax_done_handler2(e) {
    new SumoSelect();
  }

  jQuery(document).on("woof_ajax_done", woof_ajax_done_handler2);
});
setTimeout(function () {
  jQuery(document.body).on("tbay_load_html_click_treeview", () => {
    new TreeView();
  });
}, 2000);
jQuery(window).on("resize", () => {
  if (jQuery(window).width() < 1200) {
    var mobile = new Mobile();

    mobile._topBarDevice();

    jQuery(window).scroll(() => {
      mobile._topBarDevice();
    });
  }

  jQuery(".mm-panels").css("bottom", jQuery(".mm-navbars_bottom").outerHeight());
});

var CustomFontsHandler = function ($scope, $) {
  new CustomFonts();
};

jQuery(window).on("elementor/frontend/init", function () {
  if (elementorFrontend.isEditMode() && typeof themename_settings !== "undefined" && Array.isArray(themename_settings.elements_ready.customfonts)) {
    jQuery.each(themename_settings.elements_ready.customfonts, function (index, value) {
      elementorFrontend.hooks.addAction("frontend/element_ready/tbay-" + value + ".default", CustomFontsHandler);
    });
  }
});

var AutoCompleteHandler = function ($scope, $) {
  new AutoComplete();
};

jQuery(window).on("elementor/frontend/init", function () {
  if (elementorFrontend.isEditMode() && typeof themename_settings !== "undefined" && Array.isArray(themename_settings.elements_ready.autocomplete)) {
    jQuery.each(themename_settings.elements_ready.autocomplete, function (index, value) {
      elementorFrontend.hooks.addAction("frontend/element_ready/tbay-" + value + ".default", AutoCompleteHandler);
    });
  }
});

var CndkBeforeAfterHandler = function ($scope, $) {
  new CndkBeforeAfter();
};

jQuery(window).on("elementor/frontend/init", function () {
  if (elementorFrontend.isEditMode() && typeof themename_settings !== "undefined") {
    elementorFrontend.hooks.addAction("frontend/element_ready/tbay-before-after-image-slider.default", CndkBeforeAfterHandler);
  }
});

var CountDownTimerHandler = function ($scope, $) {
  new CountDownTimer();
};

jQuery(document.body).on("tbay_quick_view", () => {
  new CountDownTimer();
});
jQuery(window).on("elementor/frontend/init", function () {
  if (elementorFrontend.isEditMode() && typeof themename_settings !== "undefined" && Array.isArray(themename_settings.elements_ready.countdowntimer)) {
    jQuery.each(themename_settings.elements_ready.countdowntimer, function (index, value) {
      elementorFrontend.hooks.addAction("frontend/element_ready/tbay-" + value + ".default", CountDownTimerHandler);
    });
  }
});

var IsotopeHandler = function ($scope, $) {
  new Isotope();
};

jQuery(window).on("elementor/frontend/init", function () {
  if (elementorFrontend.isEditMode() && typeof themename_settings !== "undefined" && Array.isArray(themename_settings.elements_ready.isotope)) {
    jQuery.each(themename_settings.elements_ready.isotope, function (index, value) {
      elementorFrontend.hooks.addAction("frontend/element_ready/tbay-" + value + ".default", IsotopeHandler);
    });
  }
});
