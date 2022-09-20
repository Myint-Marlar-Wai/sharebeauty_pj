$(document).ready(function () {
	function transmission() {
		alert('submitted!');
		$(".err_alt_msg").remove();
		$('#submit').prop('disabled', true).css({ "background-color": "#8f8d8d", "cursor": "not-allowed" });
	}
	
	//-------------url copy--------------------
	function mobile(id) {
		//alert(id);
		var share = document.getElementById(id);
		if (share) {
			share.addEventListener('click', async () => {
				try {
					await navigator.share({ title: document.title, url: "" });
				} catch (error) {
					console.error(error);
				}
			});
		}
	}

	function pc(id) {
		//alert(id);
		$(id).click(function (e) {
			e.preventDefault();
			var url = location.href;
			if (url) {
				document.addEventListener('copy', function (e) {
					e.clipboardData.setData('text/plain', url);
					e.preventDefault();
				}, true);
				document.execCommand('copy');
				alert("URLをコピーしました");
			} else {
				alert("URLをコピーする事が出来ませんでした");
			}

		});
	}

	//---------------order-list.html-----------
	//--------------calender validation----------
	function DateCheck() {
		var StartDate = $('#start').val();
		var EndDate = $('#end').val();
		var sDate = new Date(StartDate);
		var eDate = new Date(EndDate);
		//alert(sDate);

		if (StartDate != '' && EndDate != '' && sDate > eDate) {
			$('#dateerror').after('<span class="err_alt_msg">End date should be greater than Start date.</span>');
			return false;
		} else if (StartDate == '' && EndDate == '') {
			$('#dateerror').after('<span class="err_alt_msg">dateを入力して下さい</span>');
		}
	}
	$('#calendar').click(function (e) {
		e.preventDefault();
		$(".err_alt_msg").remove();
		DateCheck();
	});

	//---------------product-sale-list.html-----------
	//---------------shop-detail.html-----------
	//---------------shop-list.html-----------
	if ($(window).width() < 767) {
		mobile('copy1');
		mobile('copy2');
		mobile('copy3');
		mobile('copy4');
		mobile('copy');
		mobile('listcopy1');
		mobile('listcopy2');
	} else {
		pc('#copy1');
		pc('#copy2');
		pc('#copy3');
		pc('#copy4');
		pc('#copy');
		pc('#listcopy1');
		pc('#listcopy2');
	}

	//---------------shop-create.html-----------
	//---------------shop-info-change.html-----------
	$('#shop-form').submit(function (e) {
		e.preventDefault();
		var name = $('#shop_create_name').val();
		var result = $('#shop_create_result').val();
		var area = $('#acc_change_area').val();
		var img1 = $('#shop_name_1').val();
		var img2 = $('#shop_name_2').val();

		if (name != '' && name.length < 60 && result != '' && result.length < 20 && area != '' && area.length < 400 && img1 != '' && img2 != '') {
			transmission();
		} else {
			$(".err_alt_msg").remove();
			if (name == '') {
				$('#shop_create_name').after('<span class="err_alt_msg">表示ショップ名を入力して下さい</span>');
			} else if (name.length > 60) {
				$('#shop_create_name').after('<span class="err_alt_msg">全角半角60文字以内で入力して下さい</span>');
			}

			if (result == '') {
				$('#result').after('<span class="err_alt_msg">URLショップ名を入力して下さい</span>');
			} else if (result.length > 20) {
				$('#result').after('<span class="err_alt_msg">半角英数20文字以内で入力して下さい</span>');
			}

			if (area == '') {
				$('#acc_change_area').after('<span class="err_alt_msg">ショップ紹介文を入力して下さい</span>');
			} else if (area.length > 400) {
				$('#acc_change_area').after('<span class="err_alt_msg">全角半角400文字以内で入力して下さい</span>');
			}

			if (img1 == '') {
				$('#upload1').after('<span class="err_alt_msg">ショップイメージ1を設定して下さい</span>');
			} else if ($('#shop_name_1')[0].files[0].size > 1048576) {
				/*1048576-1MB(You can change the size as you want)*/
				$('#upload1').after('<span class="err_alt_msg">File size too large! Please upload less than 1MB</span>');
			} else {
				var ext = img1.split('.').pop().toLowerCase();
				if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
					$('#upload1').after('<span class="err_alt_msg">invalid extension!</span>');
				}
			}

			if (img2 == '') {
				$('#upload2').after('<span class="err_alt_msg">ショップイメージ2を設定して下さい</span>');
			} else if ($('#shop_name_2')[0].files[0].size > 1048576) {
				$('#upload2').after('<span class="err_alt_msg">File size too large! Please upload less than 1MB</span>');
			} else {
				var ext = img2.split('.').pop().toLowerCase();
				if ($.inArray(ext, ['gif', 'jpg', 'jpeg']) == -1) {
					$('#upload2').after('<span class="err_alt_msg">invalid extension!</span>');
				}
			}
		}
	});

	//---------------product-sale-detail.html-----------
	$('#sale_detail').click(function (e) {
		e.preventDefault();
		alert('submitted!');
		$('#sale_detail').prop('disabled', true).css({ "background-color": "#8f8d8d", "cursor": "not-allowed" });
	});


});