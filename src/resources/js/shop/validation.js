$(document).ready(function () {
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


	function validate(firstname, lastname, yamada, hanako, code, prefectures, municipalities, address, phonenumber) {
		$(".err_alt_msg").remove();
		if (firstname == '') {
			$('#first_name').after('<span class="err_alt_msg">お名前（姓）が未入力</span>');
		} else if (firstname.length > 30) {
			$('#first_name').after('<span class="err_alt_msg">全角半角30文字以内で入力して下さい</span>');
		}

		if (lastname == '') {
			$('#last_name').after('<span class="err_alt_msg">お名前（名）が未入力</span>');
		} else if (lastname.length > 30) {
			$('#last_name').after('<span class="err_alt_msg">全角半角30文字以内で入力して下さい</span>');
		}

		if (yamada == '') {
			$('#furigana_sei').after('<span class="err_alt_msg">フリガナ（セイ）が未入力</span>');
		} else if (yamada.length > 30) {
			$('#furigana_sei').after('<span class="err_alt_msg">全角半角30文字以内で入力して下さい</span>');
		}

		if (hanako == '') {
			$('#furigana_may').after('<span class="err_alt_msg">フリガナ（メイ）が未入力</span>');
		} else if (hanako.length > 30) {
			$('#furigana_may').after('<span class="err_alt_msg">全角半角30文字以内で入力して下さい</span>');
		}

		if (code == '') {
			$('#post_code').after('<span class="err_alt_msg">郵便番号が未入力</span>');
		} else if (code.length > 7) {
			$('#post_code').after('<span class="err_alt_msg">半角7文字以内で入力して下さい</span>');
		}

		if (prefectures == '') {
			$('#prefectures').after('<span class="err_alt_msg">都道府県が未入力</span>');
		}

		if (municipalities == '') {
			$('#municipalities').after('<span class="err_alt_msg">市区町村が未入力</span>');
		} else if (municipalities.length > 255) {
			$('#municipalities').after('<span class="err_alt_msg">全角半角255文字以内で入力して下さい</span>');
		}

		if (address == '') {
			$('#address').after('<span class="err_alt_msg">番地・建物名・部屋番号が未入力</span>');
		} else if (address.length > 255) {
			$('#address').after('<span class="err_alt_msg">全角半角255文字以内で入力して下さい</span>');
		}

		if (phonenumber == '') {
			$('#ph_no').after('<span class="err_alt_msg">電話番号が未入力</span>');
		} else if (phonenumber.length > 12) {
			$('#ph_no').after('<span class="err_alt_msg">半角12文字以内で入力して下さい</span>');
		}

	}

	//---------------contact-form.html-----------
	$('#contact-form').submit(function (e) {
		e.preventDefault();
		var type = $('#inquirytype').val();
		var inquiry = $('#contents_of_inquiry').val();
		var name = $('#name').val();
		var email = $('#email').val();
		if (type != '' && inquiry != '' && name != '' && email != '' && email.length < 200 && (IsEmail(email) == true)) {
			transmission();
		} else {
			//---------------required-----------
			$(".err_alt_msg").remove();
			if (type == '') {
				$('#inquirytype').after('<span class="err_alt_msg">お問合せ種別を入力して下さい</span>');
			}

			if (inquiry == '') {
				$('#contents_of_inquiry').after('<span class="err_alt_msg">お問合せ内容を入力して下さい</span>');
			} else if (inquiry.length > 60) {
				$('#contents_of_inquiry').after('<span class="err_alt_msg">全角半角60文字以内で入力して下さい</span>');
			}

			if (name == '') {
				$('#name').after('<span class="err_alt_msg">名前を入力して下さい</span>');
			}

			if (email == '') {
				$('#email').after('<span class="err_alt_msg">メールアドレスを入力して下さい</span>');
			} else if (email.length > 200) {
				$('#email').after('<span class="err_alt_msg">半角200文字以内で入力して下さい</span>');
			} else if (IsEmail(email) == false) {
				$('#email').after('<span class="err_alt_msg">無効な形式のONCE-ID（メールアドレス）です</span>');
			}
		}
	});

	//---------------shipping-information.html-----------
	$('#shipping-info').submit(function (e) {
		e.preventDefault();
		var firstname = $('#first_name').val();
		var lastname = $('#last_name').val();
		var yamada = $('#furigana_sei').val();
		var hanako = $('#furigana_may').val();
		var code = $('#post_code').val();
		var prefectures = $('#prefectures').val();
		var municipalities = $('#municipalities').val();
		var address = $('#address').val();
		var phonenumber = $('#ph_no').val();

		if (firstname != '' && firstname.length < 30 && lastname != '' && lastname.length < 30 && yamada != '' && yamada.length < 30 && hanako != '' && yamada.length < 30 && code != '' && code.length < 7 && prefectures != '' && municipalities != '' && municipalities.length < 255 && address != '' && address.length < 255 && phonenumber != '' && phonenumber.length < 12 && $("#privacy").prop("checked")) {
			transmission();
		} else {
			validate(firstname, lastname, yamada, hanako, code, prefectures, municipalities, address, phonenumber);
			if (!$("#privacy").prop("checked")) {
				$("#check").after('<span class="err_alt_msg">利用規約・プライバシーポリシーに同意して下さい</span>');
			}
		}
	});

	//---------------shop-login.html-----------
	$('#login').submit(function (e) {
		// e.preventDefault();
		var email = $('#email').val();
		var pwd = $('#password').val();
		if (email != '' && email.length < 200 && (IsEmail(email) == true) && pwd != '') {
			transmission();
		} else {
            e.preventDefault();
			//---------------required-----------
			$(".err_alt_msg").remove();
			if (email == '') {
				$('#email').after('<span class="err_alt_msg">メールアドレスを入力して下さい</span>');
			} else if (email.length > 200) {
				$('#email').after('<span class="err_alt_msg">半角200文字以内で入力して下さい</span>');
			} else if (IsEmail(email) == false) {
				$('#email').after('<span class="err_alt_msg">無効な形式のONCE-ID（メールアドレス）です</span>');
			}
			if (pwd == '') {
				$('#pwd').after('<span class="err_alt_msg">パスワードを入力して下さい</span>');
			}
		}
	});

	//---------------shop-cart.html-----------
	$('#shop-cart').submit(function (e) {
		e.preventDefault();
		var id = $('#buy_id').val();
		var password = $('#password').val();
		if (id != '' && password != '') {
			transmission();
		} else {
			//---------------required-----------
			$(".err_alt_msg").remove();
			if (id == '') {
				$('#buy_id').after('<span class="err_alt_msg">IDを入力して下さい</span>');
			}

			if (password == '') {
				$('#pwd').after('<span class="err_alt_msg">パスワードを入力して下さい</span>');
			}
		}
	});

	//---------------member-information.html-----------
	$('#member-info').submit(function (e) {
		e.preventDefault();
		var firstname = $('#first_name').val();
		var lastname = $('#last_name').val();
		var yamada = $('#furigana_sei').val();
		var hanako = $('#furigana_may').val();
		var code = $('#post_code').val();
		var prefectures = $('#prefectures').val();
		var municipalities = $('#municipalities').val();
		var address = $('#address').val();
		var phonenumber = $('#ph_no').val();
		var email = $('#email').val();
		var year = $('#year').val();
		var month = $('#month').val();
		var day = $('#day').val();

		if (firstname != '' && firstname.length < 30 && lastname != '' && lastname.length < 30 && yamada != '' && yamada.length < 30 && hanako != '' && yamada.length < 30 && code != '' && code.length < 7 && prefectures != '' && municipalities != '' && municipalities.length < 255 && address != '' && address.length < 255 && phonenumber != '' && phonenumber.length < 12 && email != '' && email.length < 200 && (IsEmail(email) == true) && $("#privacy").prop("checked")) {
			transmission();
		} else {
			validate(firstname, lastname, yamada, hanako, code, prefectures, municipalities, address, phonenumber);
			if (email == '') {
				$('#email').after('<span class="err_alt_msg">メールアドレスを入力して下さい</span>');
			} else if (email.length > 200) {
				$('#email').after('<span class="err_alt_msg">半角200文字以内で入力して下さい</span>');
			} else if (IsEmail(email) == false) {
				$('#email').after('<span class="err_alt_msg">無効な形式のONCE-ID（メールアドレス）です</span>');
			}

			if (!$("#privacy").prop("checked")) {
				$("#check").after('<span class="err_alt_msg">利用規約・プライバシーポリシーに同意して下さい</span>');
			}
		}
	});

	//---------------enter-purchase-info.html-----------
	//---------------enter-purchase-info-default.html-----------
	$('#enter-info').submit(function (e) {
		e.preventDefault();
		var firstname = $('#first_name').val();
		var lastname = $('#last_name').val();
		var yamada = $('#furigana_sei').val();
		var hanako = $('#furigana_may').val();
		var code = $('#post_code').val();
		var prefectures = $('#prefectures').val();
		var municipalities = $('#municipalities').val();
		var address = $('#address').val();
		var phonenumber = $('#ph_no').val();
		var email = $('#email').val();
		var changeaddress = $('#change_address').val();
		var newfirstname = $('#new_first_name').val();
		var newlastname = $('#new_last_name').val();
		var newyamada = $('#new_furigana_sei').val();
		var newhanako = $('#new_furigana_may').val();
		var newcode = $('#new_post_code').val();
		var newprefectures = $('#new_prefectures').val();
		var newmunicipalities = $('#new_municipalities').val();
		var newaddress = $('#new_address').val();
		var newphonenumber = $('#new_ph_no').val();
		//var remarkname = $('#remark_name').val();

		if (changeaddress == 1) {
			if (firstname != '' && firstname.length < 30 && lastname != '' && lastname.length < 30 && yamada != '' && yamada.length < 30 && hanako != '' && yamada.length < 30 && code != '' && code.length < 7 && prefectures != '' && municipalities != '' && municipalities.length < 255 && address != '' && address.length < 255 && phonenumber != '' && phonenumber.length < 12 && email != '' && email.length < 200 && (IsEmail(email) == true)) {
				transmission();
			} else {
				validate(firstname, lastname, yamada, hanako, code, prefectures, municipalities, address, phonenumber);
				if (email == '') {
					$('#email').after('<span class="err_alt_msg">メールアドレスを入力して下さい</span>');
				} else if (email.length > 200) {
					$('#email').after('<span class="err_alt_msg">半角200文字以内で入力して下さい</span>');
				} else if (IsEmail(email) == false) {
					$('#email').after('<span class="err_alt_msg">無効な形式のONCE-ID（メールアドレス）です</span>');
				}
			}
		} else {
			if (firstname != '' && firstname.length < 30 && lastname != '' && lastname.length < 30 && yamada != '' && yamada.length < 30 && hanako != '' && yamada.length < 30 && code != '' && code.length < 7 && prefectures != '' && municipalities != '' && municipalities.length < 255 && address != '' && address.length < 255 && phonenumber != '' && phonenumber.length < 12 && email != '' && email.length < 200 && (IsEmail(email) == true) && newfirstname != '' && newfirstname.length < 30 && newlastname != '' && newlastname.length < 30 && newyamada != '' && newyamada.length < 30 && newhanako != '' && newyamada.length < 30 && newcode != '' && newcode.length < 7 && newprefectures != '' && newmunicipalities != '' && newmunicipalities.length < 255 && newaddress != '' && newaddress.length < 255 && newphonenumber != '' && phonenumber.length < 12) {
				transmission();
			} else {
				validate(firstname, lastname, yamada, hanako, code, prefectures, municipalities, address, phonenumber);
				if (email == '') {
					$('#email').after('<span class="err_alt_msg">メールアドレスを入力して下さい</span>');
				} else if (email.length > 200) {
					$('#email').after('<span class="err_alt_msg">半角200文字以内で入力して下さい</span>');
				} else if (IsEmail(email) == false) {
					$('#email').after('<span class="err_alt_msg">無効な形式のONCE-ID（メールアドレス）です</span>');
				}
				if (newfirstname == '') {
					$('#new_first_name').after('<span class="err_alt_msg">お名前（姓）を入力して下さい</span>');
				} else if (newfirstname.length > 30) {
					$('#new_first_name').after('<span class="err_alt_msg">全角半角30文字以内で入力して下さい</span>');
				}

				if (newlastname == '') {
					$('#new_last_name').after('<span class="err_alt_msg">お名前（名）を入力して下さい</span>');
				} else if (lastname.length > 30) {
					$('#new_last_name').after('<span class="err_alt_msg">全角半角30文字以内で入力して下さい</span>');
				}

				if (newyamada == '') {
					$('#new_furigana_sei').after('<span class="err_alt_msg">フリガナ（セイ）を入力して下さい</span>');
				} else if (newyamada.length > 30) {
					$('#new_furigana_sei').after('<span class="err_alt_msg">全角半角30文字以内で入力して下さい</span>');
				}

				if (newhanako == '') {
					$('#new_furigana_may').after('<span class="err_alt_msg">フリガナ（メイ）を入力して下さい</span>');
				} else if (newhanako.length > 30) {
					$('#new_furigana_may').after('<span class="err_alt_msg">全角半角30文字以内で入力して下さい</span>');
				}

				if (newcode == '') {
					$('#new_post_code').after('<span class="err_alt_msg">郵便番号を入力して下さい</span>');
				} else if (code.length > 7) {
					$('#new_post_code').after('<span class="err_alt_msg">半角7文字以内で入力して下さい</span>');
				}

				if (newprefectures == '') {
					$('#new_prefectures').after('<span class="err_alt_msg">都道府県を選択して下さい</span>');
				}

				if (newmunicipalities == '') {
					$('#new_municipalities').after('<span class="err_alt_msg">住所を入力して下さい</span>');
				} else if (newmunicipalities.length > 255) {
					$('#new_municipalities').after('<span class="err_alt_msg">全角半角255文字以内で入力して下さい</span>');
				}

				if (newaddress == '') {
					$('#new_address').after('<span class="err_alt_msg">住所その他を入力して下さい</span>');
				} else if (newaddress.length > 255) {
					$('#new_address').after('<span class="err_alt_msg">全角半角255文字以内で入力して下さい</span>');
				}

				if (newphonenumber == '') {
					$('#new_ph_no').after('<span class="err_alt_msg">電話番号を入力して下さい</span>');
				} else if (newphonenumber.length > 12) {
					$('#new_ph_no').after('<span class="err_alt_msg">半角12文字以内で入力して下さい</span>');
				}
			}
		}
	});
});
