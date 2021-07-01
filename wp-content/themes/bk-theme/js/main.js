"use strict";
jQuery.noConflict();

const elementAddOnMobile = document.getElementById("mobile-menu");
const body = document.getElementsByClassName("main-body");
const blurBackground = document.getElementById("site-overlay");

function openMenu() {
  elementAddOnMobile.classList.add("open");
  body[0].classList.add("mobile-view");
  blurBackground.classList.add("active");
}

function closeMenu() {
  elementAddOnMobile.classList.remove("open");
  body[0].classList.remove("mobile-view");
  blurBackground.classList.remove("active");
}

const placeToAddYoutubeVideo = jQuery(".video-container");

function openAndplayVideo(id) {
  if (id != null) {
    let iframeVideo =
      '<span class="menu-btn-close-js"><i class="fas fa-times text-danger fa-2x"></i></span>';
    iframeVideo =
      iframeVideo +
      `<iframe src="https://www.youtube.com/embed/` +
      id +
      `?rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write;
        encrypted-media; gyroscope; picture-in-picture" allowfullscreen="true"></iframe>`;
    blurBackground.classList.add("active");
    placeToAddYoutubeVideo.html(iframeVideo);
  }
}

function closeVideo() {
  placeToAddYoutubeVideo.html("");
}

// if (window.IntersectionObserver) {
//     let observer = new IntersectionObserver((entries, observer) => {
//         entries.forEach(entry => {
//             if (entry.isIntersecting) {
//                 entry.target.classList.add('active');
//                 observer.unobserve(entry.target);
//             }
//         });
//     }, {
//         rootMargin: "0px 0px -75px 0px"
//     });
//     document.querySelectorAll('.animation').forEach(animation => {
//         observer.observe(animation);
//     });
// }

jQuery(document).ready(function () {
  const btnBackToTop = jQuery(".btn-top");
  const btnOpenMobileMenu = jQuery(".menu-btn-js");
  const btnCloseMobileMenu = jQuery(".menu-btn-close-js");
  const btnSearch = jQuery(".menu-btn-search-js");
  const sectionMobileNav = jQuery(".nav");
  const sectionSearch = jQuery(".search");

  jQuery(window).scroll(function () {
    const scrollHeight = jQuery(document).height();
    const windowheight =
      jQuery(window).height() + jQuery(window).scrollTop() - 200;

    if (scrollHeight - windowheight <= scrollHeight / 2) {
      btnBackToTop.addClass("show");
    } else {
      btnBackToTop.removeClass("show");
    }
  });

  btnBackToTop.on("click", function (e) {
    e.preventDefault();
    jQuery("html, body").animate(
      {
        scrollTop: 0,
      },
      "300"
    );
  });
  btnOpenMobileMenu.on("click", function () {
    sectionMobileNav.show();
    // sectionSearch.hide();
    openMenu();
  });

  const transparentLayer = jQuery(".site-overlay");

  transparentLayer.on("click", function () {
    closeMenu();
    closeVideo();
  });

  btnSearch.on("click", function () {
    sectionMobileNav.hide();
    sectionSearch.show();
    openMenu();
  });

  btnCloseMobileMenu.on("click", function () {
    closeVideo();
    closeMenu();
  });

  //  SLIDER
  const sliderHome = jQuery(".slider-homepage");

  sliderHome.slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: true,
    arrows: true,
    // autoplay: true,
    // autoplaySpeed: 2000,
    responsive: [
      {
        breakpoint: 767,
        settings: {
          arrows: false,
        },
      },
    ],
  });
  //  end----------------- SLIDER

  // VIDEO YOUTUBE
  const youtubeVideo = jQuery(".patients-testimonial .video-wrapper");

  youtubeVideo.on("click", function () {
    let idVideo = jQuery(this).find("img").data("id");
    openAndplayVideo(idVideo);
  });
  // END-----------VIDEO YOUTUBE

  // BUTTON TOP
  const btnTop = jQuery(".btn-top");

  jQuery(window).scroll(function () {
    let scrollHeight = jQuery(document).height();
    let windowheight =
      jQuery(window).height() + jQuery(window).scrollTop() - 200;
    if (scrollHeight - windowheight <= scrollHeight / 2) {
      btnTop.addClass("show");
    } else {
      btnTop.removeClass("show");
    }
  });

  btnTop.on("click", function (e) {
    e.preventDefault();
    jQuery("html, body").animate({ scrollTop: 0 }, "300");
  });
  // END-----------BUTTON TOP

  const contactInput = jQuery(".wpcf7-form-control.wpcf7-text");
  contactInput.on("click", function () {
    jQuery(".wpcf7-form").find(".active").toggleClass("active");
    jQuery(this).parent(".wpcf7-form-control-wrap").toggleClass("active");
  });

  let offset = parseInt(jQuery(".default-post-load").val()); // khái báo số lượng bài viết đã hiển thị; // khái báo số lượng bài viết đã hiển thị
  const placeToAddNews = jQuery("#content");
  const currentPageCate = jQuery(".cat").val();

  const query = jQuery(".search-query").val();

  jQuery(window).scroll(function () {
    let scrollHeight = jQuery(document).height();
    let windowheight =
      jQuery(window).height() + jQuery(window).scrollTop() - 200;
    let loadingData = false;

    if (scrollHeight - windowheight <= scrollHeight / 5 && !loadingData) {
      if (currentPageCate) {
        loadingData = true;
        jQuery.ajax({
          // Hàm ajax
          type: "post", //Phương thức truyền post hoặc get
          dataType: "html", //Dạng dữ liệu trả về xml, json, script, or html
          async: false,
          url: jQuery(".url-admin").val(), // Nơi xử lý dữ liệu
          data: {
            action: "loadmore", //Tên action, dữ liệu gởi lên cho server
            offset: offset, // gởi số lượng bài viết đã hiển thị cho server
            cat: currentPageCate,
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(
              "The following error occured: " + textStatus,
              errorThrown
            );
          },
          success: function (response) {
            if (response && response !== "") {
              placeToAddNews.append(response);
              offset = offset + 3; // tăng bài viết đã hiển thị
              loadingData = false;
            }
          },
        });
      } else if (query) {
        loadingData = true;
        jQuery.ajax({
          // Hàm ajax
          type: "post", //Phương thức truyền post hoặc get
          dataType: "html", //Dạng dữ liệu trả về xml, json, script, or html
          async: false,
          url: jQuery(".url-admin").val(), // Nơi xử lý dữ liệu
          data: {
            action: "loadmore", //Tên action, dữ liệu gởi lên cho server
            offset: offset, // gởi số lượng bài viết đã hiển thị cho server
            query: query,
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(
              "The following error occured: " + textStatus,
              errorThrown
            );
          },
          success: function (response) {
            console.log(response);
            if (response && response !== "") {
              placeToAddNews.append(response);
              offset = offset + 3; // tăng bài viết đã hiển thị
              loadingData = false;
            }
          },
        });
      }
    }
  });

  // ACTIVE POPUP FORM

  $(".btn-contact-us").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(".popup-booking-form").toggleClass("popup-booking-open");
  });

  $(".closer-popup").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    $(".popup-booking-form").removeClass("popup-booking-open");
  });
});
