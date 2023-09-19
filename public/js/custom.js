
  //*!--Back To Top START--!*//  
  //Get the button
  let mybutton = document.getElementById("btn-back-to-top");

  // When the user scrolls down 20px from the top of the document, show the button
  window.onscroll = function () {
    scrollFunction();
  };

  function scrollFunction() {
    if (
      document.body.scrollTop > 20 ||
      document.documentElement.scrollTop > 20
    ) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  };
  // When the user clicks on the button, scroll to the top of the document
  mybutton.addEventListener("click", backToTop);

  function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  };
  //*!--Back To Top END--!*//

  //*!--Productlist Card Start--!*//

  $('.NEWProListIcon').mouseover(function() {
  $('#name').html($(this).data('name'));
  $('#title').html($(this).data('title'));
  $('#code').html($(this).data('code'));
  $('#picsrc').attr('src', $(this).data('img'));

  var num = $(this).data('num');
    if (num == 1) {
  $('.product_new_icon').removeClass('hide');
  $('.product_upcoming_icon').addClass('hide');
  } else if (num == 2) {
  $('.product_upcoming_icon').removeClass('hide');
  $('.product_new_icon').addClass('hide');
  } else {
  $('.product_new_icon').addClass('hide');
  $('.product_upcoming_icon').addClass('hide');
  }

  // 連結
  $('.pro-link').attr('href', $(this).data('url'));
  });

  //*!--Productlist Card END--!*//

  
  //*!---Gallery START--!*//
    $('.slider-single').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: false,
    adaptiveHeight: false,
    infinite: false,
    useTransform: true,
    speed: 400,
    cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
    });

    $('.slider-nav')
    .on('init', function(event, slick) {
      $('.slider-nav .slick-slide.slick-current').addClass('is-active');
    })
    .slick({
      slidesToShow: 5,
      slidesToScroll: 5,
      dots: false,
      focusOnSelect: false,
      infinite: false,
      vertical:true,
      responsive: [{
        breakpoint: 1024,
        settings: {
          slidesToShow: 5,
          slidesToScroll: 5,
        }
      }, {
        breakpoint: 640,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 4,
        }
      }, {
        breakpoint: 420,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
      }
      }]
    });

    $('.slider-single').on('afterChange', function(event, slick, currentSlide) {
    $('.slider-nav').slick('slickGoTo', currentSlide);
    var currrentNavSlideElem = '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
    $('.slider-nav .slick-slide.is-active').removeClass('is-active');
    $(currrentNavSlideElem).addClass('is-active');
    });

    $('.slider-nav').on('click', '.slick-slide', function(event) {
    event.preventDefault();
    var goToSingleSlide = $(this).data('slick-index');

    $('.slider-single').slick('slickGoTo', goToSingleSlide);
    });
  //*!--Gallery END--!*//


  //*!--哪裡買-地圖開始--!*//
    
    //
    function MM_preloadImages() { //v3.0
      var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
        var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
        if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
    }

    function MM_swapImgRestore() { //v3.0
      var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
    }

    function MM_findObj(n, d) { //v4.01
      var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
        d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
      if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
      for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
      if(!x && d.getElementById) x=d.getElementById(n); return x;
    }

    function MM_swapImage() { //v3.0
      var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
       if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
    }
    //
    
  //*!--哪裡買-地圖結束--!*//

    
  //*!--rwdImageMaps-START--!*//

    jQuery(function($) {
        $('img[usemap]').rwdImageMaps();
    });
  //*!--rwdImageMaps-END--!*//


  //*!--HomeBody:NEW PRODUCTS-03style--!*//
        $('.HomeNewproduct').slick({
          dots: true,
          arrows: true,
          infinite: false,
          slidesToShow: 5,
          slidesToScroll: 5,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 5,
                slidesToScroll: 5,
                infinite: true,
                dots: true,
                arrows: true,
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
                arrows: false,
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                arrows: false,
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        });
  //*!--HomeBody:NEW PRODUCTS-03style-END--!*//


  //*!--HomeBody:FEATURED BLOG--!*//
        $('.HomeFeatureBlog').slick({
          dots: true,
          arrows: true,
          infinite: false,
          slidesToShow: 3,
          slidesToScroll: 3,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true,
                arrows: true,
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                arrows: false,
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        });
  //*!--HomeBody:FEATURED BLOG-END--!*//