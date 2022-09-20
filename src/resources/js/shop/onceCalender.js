  $(document).ready(function () {
    // Date Picker
    $(".datepicker").datepicker({
        dateFormat: 'yy年mm月dd日',
        dayNames: ['土曜日', '日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日'],
        dayNamesShort: ['土', '日', '月', '火', '水', '木', '金'],
        dayNamesMin: ['土', '日', '月', '火', '水', '木', '金'],
        monthNames: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        beforeShow: function () {
            $('.alert_bg').addClass('show');
        }
    });
    $(".datepicker").val($.datepicker.formatDate('yy年mm月dd日', new Date()));
    var today = $('.datepicker').datepicker('getDate');
    today = $.datepicker.formatDate("yy-mm-dd", today);
    var url_param = location.pathname;
    var url_split = url_param.split('/');
    var once_id = url_split[2];

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },            
        url: '/once-sale-check',
        type: 'post',
        cache: false,
        dataType:'json',
        data:{ 'today' : today , 'once_id' : once_id },
    })
    .done(function(response) { 
        //通信成功時の処理
        if(response) {
            // 成功の処理
            $('#day #once_amount').html(response.amount);
            $('#day #once_dayBeforeRatio .yen').html('¥' + response.dayBeforeRatio);
            $('#day #once_quantity').html(response.quantity);
            $('#day #once_sellers_reward').html('¥' + response.sellers_reward);
    } else {
            // エラーの処理
        }
    })
    .fail(function(xhr) {  
        //通信失敗時の処理
    })
    .always(function(xhr, msg) { 
        //通信完了時の処理
        //結果に関わらず実行したいスクリプトを記載
    })

    $('.hasDatepicker').change(function () {
        var selectDay = $('.datepicker').datepicker('getDate');
        selectDay = $.datepicker.formatDate("yy-mm-dd", selectDay);
        var url_param = location.pathname;
        var url_split = url_param.split('/');
        var once_id = url_split[2];
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },            
            url: '/once-sale-check',
            type: 'post',
            cache: false,
            dataType:'json',
            data:{ 'selectDay' : selectDay , 'once_id' : once_id },
        })
        .done(function(response) { 
            //通信成功時の処理
            if(response) {
                // 成功の処理
                $('#day #once_amount').html(response.amount);
                $('#day #once_dayBeforeRatio .yen').html('¥' + response.dayBeforeRatio);
                $('#day #once_quantity').html(response.quantity);
                $('#day #once_sellers_reward').html('¥' + response.sellers_reward);
            } else {
                // エラーの処理
            }
        })
        .fail(function(xhr) {  
            //通信失敗時の処理
        })
        .always(function(xhr, msg) { 
            //通信完了時の処理
            //結果に関わらず実行したいスクリプトを記載
        })
    });

    $('.prev_day').on('click', function () {
        var beforeDay = $('.datepicker').datepicker('getDate');
        beforeDay.setDate(beforeDay.getDate() - 1)
        $('.datepicker').datepicker('setDate', beforeDay);
        beforeDay = $.datepicker.formatDate("yy-mm-dd", beforeDay);
        var url_param = location.pathname;
        var url_split = url_param.split('/');
        var once_id = url_split[2];

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },            
            url: '/once-sale-check',
            type: 'post',
            cache: false,
            dataType:'json',
            data:{ 'beforeDay' : beforeDay , 'once_id' : once_id },
        })
        .done(function(response) { 
            //通信成功時の処理
            if(response) {
                // 成功の処理
                $('#day #once_amount').html(response.amount);
                $('#day #once_dayBeforeRatio .yen').html('¥' + response.dayBeforeRatio);
                $('#day #once_quantity').html(response.quantity);
                $('#day #once_sellers_reward').html('¥' + response.sellers_reward);
            } else {
                // エラーの処理
            }
        })
        .fail(function(xhr) {  
            //通信失敗時の処理
        })
        .always(function(xhr, msg) { 
            //通信完了時の処理
            //結果に関わらず実行したいスクリプトを記載
        })
    });

    $('.next_day').on('click', function () {
        var afterDay = $('.datepicker').datepicker('getDate');
        afterDay.setDate(afterDay.getDate() + 1)
        $('.datepicker').datepicker('setDate', afterDay);
        afterDay = $.datepicker.formatDate("yy-mm-dd", afterDay);
        var url_param = location.pathname;
        var url_split = url_param.split('/');
        var once_id = url_split[2];

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },            
            url: '/once-sale-check',
            type: 'post',
            cache: false,
            dataType:'json',
            data:{ 'afterDay' : afterDay , 'once_id' : once_id },
        })
        .done(function(response) { 
            //通信成功時の処理
            if(response) {
                // 成功の処理
                $('#day #once_amount').html(response.amount);
                $('#day #once_dayBeforeRatio .yen').html('¥' + response.dayBeforeRatio);
                $('#day #once_quantity').html(response.quantity);
                $('#day #once_sellers_reward').html('¥' + response.sellers_reward);
            } else {
                // エラーの処理
            }
        })
        .fail(function(xhr) {  
            //通信失敗時の処理
        })
        .always(function(xhr, msg) { 
            //通信完了時の処理
            //結果に関わらず実行したいスクリプトを記載
        })
    });


    // Month Picker
    $('.monthpicker').monthpicker({
        monthNames: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        monthNamesShort: ["1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"],
        dateFormat: 'yy年mm月',
        yearSuffix: '年',
        beforeShow: function () {
            $('.alert_bg').addClass('show');
        }
    });
    $(".monthpicker").val($.monthpicker.formatDate('yy年mm月', new Date()));
    var month = $('.datepicker').datepicker('getDate');
    month.setDate(month.getDate())
    $('.datepicker').datepicker('setDate', month);
    month = $.datepicker.formatDate("yy-mm", month);
    var url_param = location.pathname;
    var url_split = url_param.split('/');
    var once_id = url_split[2];

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },            
        url: '/once-sale-check',
        type: 'post',
        cache: false,
        dataType:'json',
        data:{ 'month' : month , 'once_id' : once_id },
    })
    .done(function(response) { 
        //通信成功時の処理
        if(response) {
            // 成功の処理
            $('#month #once_amount').html(response.amount);
            $('#month #once_dayBeforeRatio .yen').html('¥' + response.dayBeforeRatio);
            $('#month #once_quantity').html(response.quantity);
            $('#month #once_sellers_reward').html('¥' + response.sellers_reward);
        } else {
            // エラーの処理
        }
    })
    .fail(function(xhr) {  
        //通信失敗時の処理
    })
    .always(function(xhr, msg) { 
        //通信完了時の処理
        //結果に関わらず実行したいスクリプトを記載
    })

    $('.hasMonthpicker').change(function () {
        var selectMonth = $('.monthpicker').monthpicker('getDate');
        selectMonth = $.datepicker.formatDate("yy-mm", selectMonth);
        var url_param = location.pathname;
        var url_split = url_param.split('/');
        var once_id = url_split[2];

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },            
            url: '/once-sale-check',
            type: 'post',
            cache: false,
            dataType:'json',
            data:{ 'selectMonth' : selectMonth , 'once_id' : once_id },
        })
        .done(function(response) { 
            //通信成功時の処理
            if(response) {
                // 成功の処理
                $('#month #once_amount').html(response.amount);
                $('#month #once_dayBeforeRatio .yen').html('¥' + response.dayBeforeRatio);
                $('#month #once_quantity').html(response.quantity);
                $('#month #once_sellers_reward').html('¥' + response.sellers_reward);
            } else {
                // エラーの処理
            }
        })
        .fail(function(xhr) {  
            //通信失敗時の処理
        })
        .always(function(xhr, msg) { 
            //通信完了時の処理
            //結果に関わらず実行したいスクリプトを記載
        })
    });

    $('.prev_month').on('click', function () {
        var beforeMonth = $('.monthpicker').monthpicker('getDate');
        beforeMonth.setMonth(beforeMonth.getMonth() - 1)
        $('.monthpicker').monthpicker('setDate', beforeMonth);
        beforeMonth = $.datepicker.formatDate("yy-mm", beforeMonth);
        var url_param = location.pathname;
        var url_split = url_param.split('/');
        var once_id = url_split[2];
        console.log('once_id = ' + once_id);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },            
            url: '/once-sale-check',
            type: 'post',
            cache: false,
            dataType:'json',
            data:{ 'beforeMonth' : beforeMonth , 'once_id' : once_id },
        })
        .done(function(response) { 
            //通信成功時の処理
            if(response) {
                // 成功の処理
                $('#month #once_amount').html(response.amount);
                $('#month #once_dayBeforeRatio .yen').html('¥' + response.dayBeforeRatio);
                $('#month #once_quantity').html(response.quantity);
                $('#month #once_sellers_reward').html('¥' + response.sellers_reward);
            } else {
                // エラーの処理
            }
        })
        .fail(function(xhr) {  
            //通信失敗時の処理
        })
        .always(function(xhr, msg) { 
            //通信完了時の処理
            //結果に関わらず実行したいスクリプトを記載
        })
    });

    $('.next_month').on('click', function () {
        var afterMonth = $('.monthpicker').monthpicker('getDate');
        afterMonth.setMonth(afterMonth.getMonth() + 1)
        $('.monthpicker').monthpicker('setDate', afterMonth);
        afterMonth = $.datepicker.formatDate("yy-mm", afterMonth);
        var url_param = location.pathname;
        var url_split = url_param.split('/');
        var once_id = url_split[2];

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },            
            url: '/once-sale-check',
            type: 'post',
            cache: false,
            dataType:'json',
            data:{ 'afterMonth' : afterMonth , 'once_id' : once_id },
        })
        .done(function(response) { 
            //通信成功時の処理
            if(response) {
                // 成功の処理
                $('#month #once_amount').html(response.amount);
                $('#month #once_dayBeforeRatio .yen').html('¥' + response.dayBeforeRatio);
                $('#month #once_quantity').html(response.quantity);
                $('#month #once_sellers_reward').html('¥' + response.sellers_reward);
            } else {
                // エラーの処理
            }
        })
        .fail(function(xhr) {  
            //通信失敗時の処理
        })
        .always(function(xhr, msg) { 
            //通信完了時の処理
            //結果に関わらず実行したいスクリプトを記載
        })
    });

    $('.shop_sale__datetime_picker').on('change', function () {
        $('.alert_bg').removeClass('show');
    });
    $('.alert_bg').on('click', function () {
        $(this).removeClass('show');
    });
});
  
