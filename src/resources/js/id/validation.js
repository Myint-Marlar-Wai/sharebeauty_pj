$(document).ready(function () {
	//---------------double transmission-----------

	function transmission() {
		//alert('submitted!');
		$(".err_alt_msg").remove();
		$('#submit').prop('disabled', true).css({ "background-color": "#8f8d8d", "cursor": "not-allowed" });
	}

	function IsEmail(email) {
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regex.test(email)) {
			return false;
		} else {
			return true;
		}
	}
	//---------------account-change.html-----------
	$('#acc-change').submit(function (e) {
		// e.preventDefault();
		var email = $('#acc_change_email').val();
		if (email != '' && email.length < 200 && (IsEmail(email) == true)) {
			transmission();
		} else {
            e.preventDefault();
			$(".err_alt_msg").remove();
			if (email == '') {
				$('#acc_change_email').after('<span class="err_alt_msg">ONCE IDはメールアドレスの形式で必ず入力してください。</span>');
			} else if (email.length > 200) {
				$('#acc_change_email').after('<span class="err_alt_msg">半角200文字以内で入力して下さい</span>');
			} else if (IsEmail(email) == false) {
				$('#acc_change_email').after('<span class="err_alt_msg">無効な形式のONCE-ID（メールアドレス）です</span>');
			}
		}
	});

	//---------------change-account-info.html-----------
	$('#change').submit(function (e) {
		// e.preventDefault();
		var bankaccno = $('#bankaccno').val();
		var fname = $('#fname').val();
		var branchcode = $('#branchcode').val();
		var branchname = $('#branchname').val();
		var accno = $('#accno').val();
		var accholder = $('#accholder').val();
		var accname = $('#accname').val();
		var remark = $('#remark').val();

		if (bankaccno != '' && bankaccno.length < 15 && fname != '' && fname.length < 30 && branchcode != '' && branchcode.length < 7 && branchname != '' && branchname.length < 30 && ($("#usual").is(":checked") || $("#current").is(":checked")) && accno != '' && accno.length < 15 && accholder != '' && accholder.length < 15 && accname != '' && accname.length < 30 && remark != '' && remark.length < 255) {
			transmission();
		} else {
            e.preventDefault();
			$(".err_alt_msg").remove();
			if (bankaccno == '') {
				$('#bankaccno').after('<span class="err_alt_msg">金融機関コードを入力して下さい</span>');
			} else if (bankaccno.length > 15) {
				$('#bankaccno').after('<span class="err_alt_msg">半角15文字以内で入力して下さい</span>');
			}

			if (fname == '') {
				$('#fname').after('<span class="err_alt_msg">金融機関名を入力して下さい</span>');
			} else if (fname.length > 30) {
				$('#fname').after('<span class="err_alt_msg">半角30文字以内で入力して下さい</span>');
			}

			if (branchcode == '') {
				$('#branchcode').after('<span class="err_alt_msg">支店コードを入力して下さい</span>');
			} else if (branchcode.length > 7) {
				$('#branchcode').after('<span class="err_alt_msg">半角7文字以内で入力して下さい</span>');
			}

			if (branchname == '') {
				$('#branchname').after('<span class="err_alt_msg">支店名を入力して下さい</span>');
			} else if (branchname.length > 30) {
				$('#branchname').after('<span class="err_alt_msg">半角30文字以内で入力して下さい</span>');
			}

			if (!($("#usual").is(":checked") || $("#current").is(":checked"))) {
				$('#check').after('<span class="err_alt_msg">口座種別が未入力</span>');
			}

			if (accno == '') {
				$('#accno').after('<span class="err_alt_msg">口座番号を入力して下さい</span>');
			} else if (accno.length > 15) {
				$('#accno').after('<span class="err_alt_msg">半角15文字以内で入力して下さい</span>');
			}

			if (accholder == '') {
				$('#accholder').after('<span class="err_alt_msg">口座名義を入力して下さい</span>');
			} else if (accholder.length > 15) {
				$('#accholder').after('<span class="err_alt_msg">半角15文字以内で入力して下さい</span>');
			}

			if (accname == '') {
				$('#accname').after('<span class="err_alt_msg">口座名義かなを入力して下さい</span>');
			} else if (accname.length > 30) {
				$('#accname').after('<span class="err_alt_msg">半角30文字以内で入力して下さい</span>');
			}

			if (remark == '') {
				$('#remark').after('<span class="err_alt_msg">備考を入力して下さい</span>');
			} else if (remark.length > 255) {
				$('#remark').after('<span class="err_alt_msg">半角255文字以内で入力して下さい</span>');
			}
		}
	});

	//---------------contact.html-----------
	$('#contact-form').submit(function (e) {
		// e.preventDefault();
		var type = $('#inquirytype').val();
		var inquiry = $('#contents_of_inquiry').val();
		var name = $('#name').val();
		var email = $('#email').val();

		if (type != '' && inquiry != '' && inquiry.length < 60 && name != '' && name.length < 30 && email != '' && email.length < 200 && (IsEmail(email) == true)) {
			transmission();
		} else {
            e.preventDefault();
			//---------------required-----------
			$(".err_alt_msg").remove();
			if (type == '') {
				$('#inquirytype').after('<span class="err_alt_msg">お問合せ種別を入力して下さい</span>');
			}

			if (inquiry == '') {
				$('#contents_of_inquiry').after('<span class="err_alt_msg">お問い合わせ内容を入力して下さい</span>');
			} else if (inquiry.length > 60) {
				$('#contents_of_inquiry').after('<span class="err_alt_msg">全角半角60文字以内で入力して下さい</span>');
			}

			if (name == '') {
				$('#name').after('<span class="err_alt_msg">お名前を入力して下さい</span>');
			} else if (name.length > 30) {
				$('#name').after('<span class="err_alt_msg">全角半角30文字以内で入力して下さい</span>');
			}

			if (email == '') {
				$('#email').after('<span class="err_alt_msg">ONCE IDはメールアドレスの形式で必ず入力してください。</span>');
			} else if (email.length > 200) {
				$('#email').after('<span class="err_alt_msg">半角200文字以内で入力して下さい</span>');
			} else if (IsEmail(email) == false) {
				$('#email').after('<span class="err_alt_msg">無効な形式のONCE-ID（メールアドレス）です</span>');
			}
		}
	});

	//---------------login-contact.html-----------
	$('#login-contact').submit(function (e) {
		// e.preventDefault();
		var type = $('#inquirytype').val();
		var inquiry = $('#contents_of_inquiry').val();

		if (type != '' && inquiry != '' && inquiry.length < 60) {
			transmission();
		} else {
            e.preventDefault();
			//---------------required-----------
			$(".err_alt_msg").remove();
			if (type == '') {
				$('#inquirytype').after('<span class="err_alt_msg">お問合せ種別を入力して下さい</span>');
			}

			if (inquiry == '') {
				$('#contents_of_inquiry').after('<span class="err_alt_msg">お問い合わせ内容を入力して下さい</span>');
			} else if (inquiry.length > 60) {
				$('#contents_of_inquiry').after('<span class="err_alt_msg">全角半角60文字以内で入力して下さい</span>');
			}
		}
	});

	//---------------login.html-----------
	$('#login').submit(function (e) {
        // e.preventDefault();
		var email = $('#email').val();
		var password = $('#password').val();

		if (email != '' && email.length < 200 && (IsEmail(email) == true) && password != '') {
			transmission();
		} else {
            e.preventDefault();
			//---------------required-----------
			$(".err_alt_msg").remove();
			if (email == '') {
				$('#email').after('<span class="err_alt_msg">ONCE IDはメールアドレスの形式で必ず入力してください。</span>');
			} else if (email.length > 200) {
				$('#email').after('<span class="err_alt_msg">半角200文字以内で入力して下さい</span>');
			} else if (IsEmail(email) == false) {
				$('#email').after('<span class="err_alt_msg">無効な形式のONCE-ID（メールアドレス）です</span>');
			}

			if (password == '') {
				$('#pwd').after('<span class="err_alt_msg">パスワードが未入力</span>');
			}
		}
	});

	//---------------password-change.html-----------
	$('#password-change').submit(function (e) {
        // e.preventDefault();
		var current = $('#current-password').val();
		var news = $('#new-password').val();

		if (current != '' && news != '') {
			transmission();
		} else {
            e.preventDefault();
			//---------------required-----------
			$(".err_alt_msg").remove();
			if (current == '') {
				$('#current_pwd').after('<span class="err_alt_msg">現在のパスワードを入力して下さい</span>');
			}

			if (news == '') {
				$('#new_pwd').after('<span class="err_alt_msg">新しいパスワードを入力して下さい</span>');
			}
		}
	});

	//---------------password-reset.html-----------
	$('#password-reset').submit(function (e) {
		// e.preventDefault();
		var email = $('#reset__email').val();
		if (email != '' && email.length < 200 && (IsEmail(email) == true)) {
			transmission();
		} else {
            e.preventDefault();
			$(".err_alt_msg").remove();
			if (email == '') {
				$('#reset__email').after('<span class="err_alt_msg">ONCE IDはメールアドレスの形式で必ず入力してください。</span>');
			} else if (email.length > 200) {
				$('#reset__email').after('<span class="err_alt_msg">半角200文字以内で入力して下さい</span>');
			} else if (IsEmail(email) == false) {
				$('#reset__email').after('<span class="err_alt_msg">無効な形式のONCE-ID（メールアドレス）です</span>');
			}
		}
	});

	//---------------password-setting.html-----------
	$('#setting').submit(function (e) {
		// e.preventDefault();
		var email = $('#setting__email').val();
		var password = $('#new_pwd').val();

		if (email != '' && email.length < 200 && (IsEmail(email) == true) && password != '') {
			transmission();
		} else {
            e.preventDefault();
			//---------------required-----------
			$(".err_alt_msg").remove();
			if (email == '') {
				$('#setting__email').after('<span class="err_alt_msg">ONCE IDはメールアドレスの形式で必ず入力してください。</span>');
			} else if (email.length > 200) {
				$('#setting__email').after('<span class="err_alt_msg">半角200文字以内で入力して下さい</span>');
			} else if (IsEmail(email) == false) {
				$('#setting__email').after('<span class="err_alt_msg">無効な形式のONCE-ID（メールアドレス）です</span>');
			}

			if (password == '') {
				$('.pwd').after('<span class="err_alt_msg">新しいパスワードを入力して下さい</span>');
			}
		}
	});

	//---------------profile-change.html-----------
	$('#profile-change').submit(function (e) {
		// e.preventDefault();
		var profile = $('#profile_name_1').val();
		var pname = $('#profile-name').val();
		var dname = $('#display-name').val();
		var year = $('#year').val();
		var month = $('#month').val();
		var day = $('#day').val();
		var code = $('#code').val();
		var prefectures = $('#prefectures').val();
		var municipality = $('#municipality').val();
		var number = $('#number').val();
		var phonenumber = $('#phonenumber').val();
		var txt = $('#txt').val();
		var industry = $('#industry').val();
		var storename = $('#storename').val();

		if (profile != '' && pname != '' && pname.length < 30 && dname != '' && dname.length < 30 && ($("#male").is(":checked") || $("#female").is(":checked") || $("#unselect").is(":checked")) && year != '' && month != '' && day != '' && code != '' && code.length < 7 && prefectures != '' && municipality != '' && municipality.length < 255 && number != '' && number.length < 255 && phonenumber != '' && phonenumber.length < 255 && txt != '' && txt.length < 400 && industry != '' && storename != '' && storename.length < 60 && $("#privacy").prop("checked")) {
			transmission();
		} else {
            e.preventDefault();
			$(".err_alt_msg").remove();
			if (profile == '') {
				$('#profile-upload').after('<span class="err_alt_msg">プロフィール画像を設定して下さい</span>');
			} else if ($('#profile_name_1')[0].files[0].size > 1048576) {
				/*1048576-1MB(You can change the size as you want)*/
				$('#profile-upload').after('<span class="err_alt_msg">File size too large! Please upload less than 1MB</span>');
			} else {
				var ext = profile.split('.').pop().toLowerCase();
				if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
					$('#profile-upload').after('<span class="err_alt_msg">invalid extension!</span>');
				}
			}

			if (pname == '') {
				$('#profile-name').after('<span class="err_alt_msg">名前（非公開）を入力して下さい</span>');
			} else if (pname.length > 30) {
				$('#profile-name').after('<span class="err_alt_msg">全角半角30文字以内で入力して下さい</span>');
			}

			if (dname == '') {
				$('#display-name').after('<span class="err_alt_msg">表示名を入力して下さい</span>');
			} else if (dname.length > 30) {
				$('#display-name').after('<span class="err_alt_msg">全角半角20文字以内で入力して下さい</span>');
			}

			if (!($("#male").is(":checked") || $("#female").is(":checked") || $("#unselect").is(":checked"))) {
				$('#gender').after('<span class="err_alt_msg">性別が未入力</span>');
			}

			if (year == '' || month == '' || day == '') {
				$('#date').after('<span class="err_alt_msg">生年月日が未入力</span>');
			}

			if (code == '') {
				$('#code').after('<span class="err_alt_msg">郵便番号を入力して下さい</span>');
			} else if (code.length > 7) {
				$('#code').after('<span class="err_alt_msg">半角7文字以内で入力して下さい</span>');
			}

			if (prefectures == '') {
				$('#prefectures').after('<span class="err_alt_msg">都道府県を選択して下さい</span>');
			}

			if (municipality == '') {
				$('#municipality').after('<span class="err_alt_msg">住所を入力して下さい</span>');
			} else if (municipality.length > 255) {
				$('#municipality').after('<span class="err_alt_msg">全角半角255文字以内で入力して下さい</span>');
			}

			if (number == '') {
				$('#number').after('<span class="err_alt_msg">住所その他を入力して下さい</span>');
			} else if (number.length > 255) {
				$('#number').after('<span class="err_alt_msg">全角半角255文字以内で入力して下さい</span>');
			}

			if (phonenumber == '') {
				$('#phonenumber').after('<span class="err_alt_msg">電話番号を入力して下さい</span>');
			} else if (phonenumber.length > 12) {
				$('#phonenumber').after('<span class="err_alt_msg">半角12文字以内で入力して下さい</span>');
			}

			if (txt == '') {
				$('#txt').after('<span class="err_alt_msg">紹介文を入力して下さい</span>');
			} else if (txt.length > 400) {
				$('#txt').after('<span class="err_alt_msg">全角半角400文字以内で入力して下さい</span>');
			}

			if (industry == '') {
				$('#industry').after('<span class="err_alt_msg">業種を選択して下さい</span>');
			}

			if (storename == '') {
				$('#storename').after('<span class="err_alt_msg">店舗名を入力して下さい</span>');
			} else if (storename.length > 60) {
				$('#storename').after('<span class="err_alt_msg">全角半角60文字以内で入力して下さい</span>');
			}

			if (!$("#privacy").prop("checked")) {
				$("#check-error").after('<span class="err_alt_msg">利用規約・プライバシーポリシーに同意して下さい</span>');
			}
		}
	});

	//---------------registration.html-----------
	$('#registration').submit(function (e) {
        // e.preventDefault();
		var email = $('#email').val();
		var password = $('#password').val();

		if (email != '' && email.length < 200 && (IsEmail(email) == true) && password != '') {
			transmission();
		} else {
            e.preventDefault();
			//---------------required-----------
			$(".err_alt_msg").remove();
			if (email == '') {
				$('#email').after('<span class="err_alt_msg">ONCE IDはメールアドレスの形式で必ず入力してください。</span>');
			} else if (email.length > 200) {
				$('#email').after('<span class="err_alt_msg">半角200文字以内で入力して下さい</span>');
			} else if (IsEmail(email) == false) {
				$('#email').after('<span class="err_alt_msg">無効な形式のONCE-ID（メールアドレス）です</span>');
			}

			if (password == '') {
				$('.pwd').after('<span class="err_alt_msg">新しいパスワードを入力して下さい</span>');
			}
		}
	});

});
