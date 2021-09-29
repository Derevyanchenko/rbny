function close_popup()
{
    $(".rbny-overlay-form").fadeOut(200);
    $('.rbny-overlay').fadeOut(200);
    $("body, html").css("overflow-y", "");

    $('.slick-slider').slick('unslick');
}


function show_rbny_popup(num)
{
    $(".rbny-popup__content").hide();
    $(".rbny-popup__content-" + num).show();
    $(".rbny-overlay").fadeIn(200);
    $("body, html").css("overflow-y", "hidden");
}

function show_rbny_form(order_name)
{
    // close_popup();
    $('.order_name').val(order_name);
    $('.rbny-popup__info-content').hide();
    $(".rbny-popup__form-wrapper").show();
    // $(".rbny-overlay-form").fadeIn(200);
    // $("body, html").css("overflow-y", "hidden");
}

function rbny_popup_slider_init(num) {
    $('.rbny-popup__slider-' + num).not('.slick-initialized').slick({
        dots: true,
        arrows: false,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 500,
        fade: true,
        autoplay: true,
        autoplaySpeed: 5000,
        cssEase: 'linear',
    }); 
}

// add input type hidden in cf7 form for bind order name
function add_order_name_in_cf7_form() {
    const form = $('.wpcf7-form');
    const order_name_input = '<input class="order_name" type="hidden" name="order_name" value="">';

    form.append(order_name_input);
}

// ######################################################################


$(document).ready(function() {

    $(".rbny-popup__close").on("click", function() {
        close_popup();
    });

    // show works image in single portfolio
    $(".rbny-item").on("click", function() {
        let data_index = $(this).data("rbny");

        show_rbny_popup( data_index );
        rbny_popup_slider_init( data_index );
    });

    add_order_name_in_cf7_form();

    // ajax form 
    // $(".rbny-popup__form").on("submit", function(e) {
    //     e.preventDefault();

    //     $.ajax({
    //         url: dd_ajax_object.ajax_url,
    //         type: 'POST',
    //         data: $(this).serialize(),
    //         success: function( data ) {
    //             console.log(data);
    //             $(".rbny-popup__form-wrapper form").hide();
    //             $(".rbny-popup__form-wrapper .form-success").css("display", "flex");
    //             $(this).trigger("reset");

    //             setTimeout(function(){
    //               close_popup();
    //               $(".rbny-popup__form-wrapper .form-success").hide();
    //               $(".rbny-popup__form-wrapper").hide();
    //               $(".rbny-popup__form-wrapper form").show();
    //               $('.rbny-popup__info-content').show();
    //             }, 3000);

    //         },
    //         error: function( error ) {
    //             console/log( error );
    //             alert('Error :(');
    //         }

    //     });
    //   });

    // show form in popup

    $('.rbny-popup__info-btn').on("click", "button", function() {
        var order_name = $(this).parent().siblings('.rbny-popup__info-title').text();
        show_rbny_form(order_name);
    });

});

$(document).mouseup(function (event) {

    if (!$(".rbny-overlay").is(":visible")) {
      if ($(".popup").is(":visible")) {
        var popup = $(".popup");
        if (!popup.is(event.target) && !$("#lightbox").is(event.target)
        && !$(".rbny-overlay").is(event.target) && popup.has(event.target).length === 0) {
          console.log(event.target)
            close_popup();
        }
    }
    }
});