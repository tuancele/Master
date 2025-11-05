(function ($) {

    // Kiểu thanh toán lãi:
    // 1 - Số tiền trả theo dự nợ giảm dần
    // 2 - Số tiền trả đều hàng tháng
    var interest_type = 2;

    $('.currency').inputmask("numeric", {
        radixPoint: ".",
        groupSeparator: ",",
        digits: 2,
        autoGroup: true,
        prefix: '', //No Space, this will truncate the first character
        rightAlign: false,
        oncleared: function () { }
    });

    // Số tiền vay
    $('.amount').on('input', function () {
        var value = this.value.replace(/[,]+/g, "");
        calculator_interest_rate();
    });

    // Thời gian vay
    $('.time').on('input', function () {
        
        var value = this.value.replace(/[,]+/g, "");
        calculator_interest_rate();
    });

    // Thời gian vay
    $('.interest').on('input', function () {
        
        var value = this.value.replace(/[,]+/g, "");
        calculator_interest_rate();
    });
    

    //function calcultor_amount() {
    //    var _price_total = $('.product-price').val().replace(/[.]+/g, "");
    //    var _percent_price = $('.percent-price').val();
    //    var _amount = Math.round(Number(_price_total) * (Number(_percent_price) / 100));
    //    var _rst = _price_total - _amount;
    //    var _rs_retainer = formatNumber(_rst * 1000000, ',', '.');
    //    var _rs_payment = formatNumber(_amount * 1000000, ',', '.');
    //    $('.amount').val(_amount);
    //    $('.rs-retainer').html(_rs_retainer);
    //    $('.rs-payment').html(_rs_payment);
    //}

    ///
    this.interest_changed = function (e) {
        console.log(e.value);
        interest_type = e.value;
        calculator_interest_rate();
    }

    function calculator_interest_rate() {
        //var _price_total = $('.product-price').val().replace(/[.]+/g, ""); // Tổng giá trị BĐS - triệu VND
        var _amount = $('.amount').val().replace(/[,]+/g, ""); // Số tiền vay (Gốc phải trả) - triệu VND
        var _percent = $('.interest').val(); // Phần trăm lãi suất
        var _time = $('.time').val(); // Thời gian vay (Năm)
        
        //Thời gian vay (Tháng)
        _time = _time * 12;

        // Số tiền phải trả trước
        //var _retainer = (_price_total - _amount) * 1000000;
        
        // Tổng tiền gốc phải trả
        _amount = _amount * 1000000;

        // Phần trăm lãi suất 1 tháng
        var _percent_month = Number(_percent / 100) / 12;

        // Tiền lãi trong 1 tháng
        var _interest_month = _amount * _percent_month;

        // Tiền gốc phải trả trong 1 tháng
        var _payment_month = _amount / _time;

        // Tổng gốc và lãi trong 1 tháng đầu
        var _amount_month = Math.round(_payment_month + _interest_month);

        var _interest_total = 0;

        interest_type = Number(interest_type);
        if (_amount > 0) {
            if (interest_type === 2) {
                // Tổng tiền lãi phải trả (Thanh toán đều hàng tháng )
                var _html = '';
                var _css = '';
                var _du_no_dau_ky = _amount;
                for (var i = 0; i < _time; i++) {
                    if (i % 2 === 0) {
                        _css = 'white';
                    } else {
                        _css = '';
                    }
                    _interest_total = _interest_total + _interest_month;
                    _html += '<tr class="' + _css +'">'
                    _html += '<td>' + (i + 1) + '</td>'
                    _html += '<td>' + formatNumber(_du_no_dau_ky, '.', ',') + ' </td>'
                    _html += '<td>' + formatNumber(Math.round(_payment_month), '.', ',') + '</td>'
                    _html += '<td>' + formatNumber(Math.round(_interest_month), '.', ',') + '</td>'
                    _html += '<td>' + formatNumber(Math.round(_amount_month), '.', ',') + '</td>'
                    _html += '</tr>'
                    _du_no_dau_ky = Math.round(_du_no_dau_ky - _payment_month);
                }
                $('#body_result').html(_html);
                //_interest_total = _interest_month * _time;
            }
            else if (interest_type === 1) {
                // Tiền lãi phải trả từng tháng (Thanh toán theo dư nợ giảm dần)
                var _html = '';
                var _css = '';
                var _du_no_dau_ky = _amount;
                var _lai_theo_tung_thang = 0;
                for (var i = 0; i < _time; i++) {
                    if (i % 2 === 0) {
                        _css = 'white';
                    } else {
                        _css = '';
                    }
                    _lai_theo_tung_thang = _du_no_dau_ky * _percent_month;
                    _interest_total = _interest_total + _lai_theo_tung_thang;
                    _html += '<tr class="' + _css +'">'
                    _html += '<td>' + (i + 1) + '</td>'
                    _html += '<td>' + formatNumber(Math.round(_du_no_dau_ky), '.', ',') + ' </td>'
                    _html += '<td>' + formatNumber(Math.round(_payment_month), '.', ',') + '</td>'
                    _html += '<td>' + formatNumber(Math.round(_lai_theo_tung_thang), '.', ',') + '</td>'
                    _html += '<td>' + formatNumber(Math.round(_payment_month + _lai_theo_tung_thang), '.', ',') + '</td>'
                    _html += '</tr>'
                    _du_no_dau_ky = _du_no_dau_ky - _payment_month;
                }
                $('#body_result').html(_html);
            }
        } else {
            $('#body_result').html("");
        }
        
        _interest_total = Math.round(_interest_total);

        // Tổng tất cả tiền lãi phải trả.
        var _rs_interest_total = formatNumber(_interest_total, '.', ',');

        // Tổng cả gốc và lãi phải trả trong toàn kì
        var _rs_total = formatNumber((Number(_interest_total) + Number(_amount)), '.', ',');
        
        $('#rs_interest_total').html(_rs_interest_total);
        $('#rs_total').html(_rs_total);
    }

    this.calculator = function () {
        calculator_interest_rate();
    }

    function formatNumber(nStr, decSeperate, groupSeperate) {
        nStr += '';
        x = nStr.split(decSeperate);
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + groupSeperate + '$2');
        }
        return x1 + x2;
    }

    function init() {
        var str = localStorage.getItem("InterestRate_Data");
        if (str !== null && str !== "" && str !== undefined) {
            var data = JSON.parse(str);
            $('.amount').val(data.amount);
            $('.interest').val(data.interest); 
            $('.time').val(data.time);
            $('.interest-type').val(data.type);
            interest_type = data.type;
            calculator_interest_rate();
        }

        $(".table").mCustomScrollbar({
            //theme: "rounded-dots-dark"
            theme: "minimal-dark"
        });

       

        window.localStorage.removeItem("InterestRate_Data");
    }

    init();

})(jQuery);

