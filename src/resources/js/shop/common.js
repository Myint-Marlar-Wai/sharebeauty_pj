$(document).ready(function () {
    //Header Height
    function setHeight() {
        $headerHeight = $('.user_header').outerHeight();
        $content = $('.user_content');
        $content.css('margin-top', $headerHeight);
    }
    setHeight();
    $(window).resize(function () {
        setHeight();
    });

    // Quantity
    $(function () {
        $('.increase_btn').on('click', function () {
            var $qty = $(this).closest('.quantity').find('.qty_num');
            var currentVal = parseInt($qty.val());
            if (!isNaN(currentVal)) {
                $qty.val(currentVal + 1);
            }
        });
        $('.decrease_btn').on('click', function () {
            var $qty = $(this).closest('.quantity').find('.qty_num');
            var currentVal = parseInt($qty.val());
            if (!isNaN(currentVal) && currentVal > 1) {
                $qty.val(currentVal - 1);
            }
        });
    });

    //accordion
    $(".accordion__ttl:first").toggleClass('open');
    $('.accordion_blk .accordion:not(:first-of-type) .accordion__body').css('display', 'none');
    $('.accordion__ttl').click(function (e) {
        $('.accordion__ttl').removeClass('open');
        $(this).toggleClass('open');
        e.preventDefault();

        let $this = $(this);

        if ($this.next().hasClass('accordion_body')) {
            $this.next().removeClass('accordion_body');
            $this.next().slideUp(350);
        } else {
            $this.parent().parent().find('li .accordion__body').removeClass('accordion_body');
            $this.parent().parent().find('li .accordion__body').slideUp(350);
            $this.next().toggleClass('accordion_body');
            $this.next().slideToggle(350);
        }
    });

    //hide /show toggle

    $('.ship_info_block__new,.new_card').hide();
    $('select[id=change_address],select[id=card_selection]').change(function () {

        if ($('select[id=change_address] option:selected').val() == "1") {
            $('.ship_info_block__new').hide();
        }
        else if ($('select[id=change_address] option:selected').val() == "2") {
            $('.ship_info_block__new').show();
        }
        if ($('select[id=card_selection] option:selected').val() == "1") {
            $('.new_card').hide();
        }
        else if ($('select[id=card_selection] option:selected').val() == "2") {
            $('.new_card').show();
        }
    });


    $(".season").change(function () {
        if ($(this).val() == "") $(this).addClass("empty");
        else $(this).removeClass("empty")
    });
    $(".season").change();

    $(".delete_link").click(function () {
        $(this).closest('.cart_product').hide();
    });


});

