$(function () {
	/* Hide Show Password */
	$('.toggle_pwd').click(function () {
		$(this).toggleClass("fa-eye fa-eye-slash");
		input = $(this).parent().find("input");
		if (input.attr("type") == "password") {
			input.attr("type", "text");
		} else {
			input.attr("type", "password");
		}
	});
});