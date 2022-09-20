var user = {};
window.startApp = function () {
	gapi.load('auth2', function () {
		auth2 = gapi.auth2.init({
			client_id: 'YOUR_CLIENT_ID.apps.googleusercontent.com',
			cookiepolicy: 'single_host_origin',
		});
		attachSignin(document.getElementById('google_btn'));
	});
};

function attachSignin(element) {
	console.log(element.id);
	auth2.attachClickHandler(element, {},
		function (user) {
			//document.getElementById('name').innerText = "Signed in: " +
			user.getBasicProfile().getName();
		}, function (error) {
			alert(JSON.stringify(error, undefined, 2));
		});
}

$(document).ready(function () {
	$('input:checkbox').click(function () {
		$('input:checkbox').not(this).prop('checked', false);
	});

	$(".season").change(function () {
		if ($(this).val() == "") $(this).addClass("empty");
		else $(this).removeClass("empty")
	});
	$(".season").change();
});

