

// Modal box
$('.action_btn,.change-btn,.product_btn').on('click', function () {
	$('#' + $(this).data('modal')).fadeIn('slow');
});

$('.alert_modal__form__close,#one_col_theme,#two_col_theme,#three_col_theme').on('click', function () {
	$('.alert_modal').fadeOut('slow');
});

$(".alert_modal").on('click', function (event) {
	if (jQuery.inArray(event.target, $('.alert_modal')) != "-1") {
		$('.alert_modal').hide();
	}
});

//theme_switch
function clearThemes() {
	$(".template_management__theme_switch").removeClass("one_col two_col three_col");
	$(".template_management__theme_switch div").removeClass("one_col two_col three_col");
}


$(function () {
	$("#reflect_theme").click(function () {
		clearThemes();
		$(".template_management__select_template_txt").find('p').text("テンプレートA");
		$(".template_management__theme_switch").addClass("one_col");
		$(".template_management__theme_switch div").addClass("one_col");
	});
	$("#one_col_theme").click(function () {
		clearThemes();
		$(".template_management__select_template_txt").find('p').text("テンプレートA");
		$(".template_management__theme_switch").addClass("one_col");
		$(".template_management__theme_switch div").addClass("one_col");
	});

	$("#two_col_theme").click(function () {
		clearThemes();
		$(".template_management__select_template_txt").find('p').text("テンプレートB");
		$(".template_management__theme_switch").addClass("two_col");
		$(".template_management__theme_switch div").addClass("two_col");
	});

	$("#three_col_theme").click(function () {
		clearThemes();
		$(".template_management__select_template_txt").find('p').text("テンプレートC");
		$(".template_management__theme_switch").addClass("three_col");
		$(".template_management__theme_switch div").addClass("three_col");
	});
});

// Status Button
$('.open_close_status').on('click', function () {
	$('.open_close_status').removeClass('active');
	$(this).addClass('active');
});

//Tab
var $tabButtonItem = $('.calendar_type li'),
	$tabContents = $('.calendar_data__content'),
	activeClass = 'active';

$tabButtonItem.first().addClass(activeClass);

$tabButtonItem.find('a').on('click', function (e) {
	var target = $(this).attr('href');
	$tabButtonItem.removeClass(activeClass);
	$(this).parent().addClass(activeClass);
	$tabContents.hide();
	$(target).show();
	e.preventDefault();
});
$tabButtonItem.find('a').on('click', function (e) {
	$tabButtonItem.removeClass(activeClass);
	$(this).parent().addClass(activeClass);
	e.preventDefault();
});

// Header Height
$(document).ready(function () {
	function setHeight() {
		$headerHeight = $('.sub_nav').outerHeight();
		$content = $('.content');
		$content.css('margin-top', $headerHeight);

	}
	setHeight();
	$(window).resize(function () {
		setHeight();
	});


	$('.publishing-settings__btn__list li button').click(function () {
		$('.action_btn').removeClass('toogleclass');
		$(this).toggleClass("toogleclass");
	});
});
