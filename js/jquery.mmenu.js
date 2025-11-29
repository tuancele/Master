(function ($) {



    // Kiểu thanh toán lãi:

    // 1 - Số tiền trả theo dự nợ giảm dần

    // 2 - Số tiền trả đều hàng tháng

    var interest_type = 2;



    var textContent = ('textContent' in document) ? 'textContent' : 'innerText';

    var $document = $(document);

    var selector = '[data-rangeslider]';

    var $element = $(selector);



    var touch = true;

    var total_inside = 0;



    //$('input[type="range"]').rangeslider();

    $element.rangeslider({



        // Feature detection the default is `true`.

        // Set this to `false` if you want to use

        // the polyfill also in Browsers which support

        // the native <input type="range"> element.

        polyfill: false,



        // Default CSS classes

        rangeClass: 'rangeslider',

        disabledClass: 'rangeslider--disabled',

        horizontalClass: 'rangeslider--horizontal',

        verticalClass: 'rangeslider--vertical',

        fillClass: 'rangeslider__fill',

        handleClass: 'rangeslider__handle',



        // Callback function

        onInit: function () {

            //valueOutput(this.$element[0]);

            //debugger

        },



        // Callback function

        onSlide: function (position, value) { },



        // Callback function

        onSlideEnd: function (position, value) { }

    });



    //$('input[type="range"]').rangeslider('update', true);



    //$('input[type="range"]').rangeslider('update', true);



    $document.on('input', 'input[type="range"], ' + selector, function (e) {

        if (touch) {

            valueOutput(e.target);

        }

    });



    function valueOutput(element) {

        //console.log(element.className);

        var value = element.value;

        //$('.product-price').val(value);

        //var output = element.parentNode.getElementsByTagName('input')[0] || element.parentNode.parentNode.getElementsByTagName('input')[0];

        //if (element.className)

        if (element.className === "range-product-price") {

            $('.product-price').val(value);

            calcultor_amount();

            calculator_interest_rate();

        }



        if (element.className === "range-percent-price") {

            $('.percent-price').val(value);

            calcultor_amount();

            calculator_interest_rate();

        }



        if (element.className === "range-time") {

            $('.time').val(value);

            calculator_interest_rate();

        }



        if (element.className === "range-interest") {

            $('.interest').val(value);

            calculator_interest_rate();

        }

    }



    /// Update chart

    function update_date_chart(interest, retainer, payment) {

        var index = 0;

        config.data.datasets.forEach(function (dataset) {

            dataset.data = dataset.data.map(function () {

                index++;

                if (index === 1) {

                    return interest;

                }

                if (index === 2) {

                    return retainer;

                }

                if (index === 3) {

                    return payment;

                }

            });

        });

        myChart.update();

    }

    



    $('.currency').inputmask("numeric", {

        radixPoint: ".",

        groupSeparator: ",",

        digits: 2,

        autoGroup: true,

        prefix: '', //No Space, this will truncate the first character

        rightAlign: false,

        oncleared: function () { }

    });



    //$('').change(function () {

    //    //console.log($('.product-price').val());

    //    var text = $('.product-price').val();



    //    var value = text.replace(/[,]+/g, "");

    //    console.log(value);

    //    $('.range-product-price').val(value);

    //});



    // Giá trị nhà đất

    $('.product-price').on('input', function () {

        touch = false;

        if (this.value === "") {

            this.value = 0;

        }

        var value = this.value.replace(/[,]+/g, "");

        $('.range-product-price').val(value).change();

        calcultor_amount();

        calculator_interest_rate();

    });



    // Số tiền vay

    $('.amount').on('input', function () {

        var value = this.value.replace(/[,]+/g, "");

        calcultor_percent();

    });



    // Phần trăm tiền vay

    $('.percent-price').on('input', function () {

        touch = false;

        //if (this.value === "") {

        //    this.value = 0;

        //}

        var value = this.value.replace(/[,]+/g, "");

        $('.range-percent-price').val(value).change();

        calcultor_amount();

        calculator_interest_rate();

    });



    // Thời gian vay

    $('.time').on('input', function () {

        touch = false;

        //if (this.value === "") {

        //    this.value = 0;

        //}

        var value = this.value.replace(/[,]+/g, "");

        $('.range-time').val(value).change();

        calculator_interest_rate();

    });



    // Thời gian vay

    $('.interest').on('input', function () {

        touch = false;

        //if (this.value === "") {

        //    this.value = 0;

        //}

        var value = this.value.replace(/[,]+/g, "");

        $('.range-interest').val(value).change();

        calculator_interest_rate();

    });



    $('.rangeslider__handle').mouseover(function () {

        touch = true;

    });



    $('.rangeslider__handle').on('touchstart', function (e) {

        touch = true;

    });



    function calcultor_percent() {

        var _price_total = $('.product-price').val().replace(/[,]+/g, "");

        var _amount = $('.amount').val().replace(/[,]+/g, "");

        var _percent = Math.round(Number(_amount) * 100 / Number(_price_total));

        $('.percent-price').val(_percent);



        touch = false;

        $('.range-percent-price').val(_percent).change();

        var _rs_retainer = formatNumber((_price_total - _amount) * 1000000, '.', ',');

        var _rs_payment = formatNumber(_amount * 1000000, '.', ',');

        $('.rs-retainer').html(_rs_retainer);

        $('.rs-payment').html(_rs_payment);

        calculator_interest_rate();

    }



    function calcultor_amount() {

        var _price_total = $('.product-price').val().replace(/[,]+/g, "");

        var _percent_price = $('.percent-price').val().replace(/[,]+/g, "");

        var _amount = Math.round(Number(_price_total) * (Number(_percent_price) / 100));

      

        var _rs_retainer = formatNumber((_price_total - _amount) * 1000000, '.', ',');

        var _rs_payment = formatNumber(_amount * 1000000, '.', ',');

        $('.amount').val(_amount);

        $('.rs-retainer').html(_rs_retainer);

        $('.rs-payment').html(_rs_payment);

    }



    ///

    this.interest_changed = function (e) {

        //console.log(e.value);

        interest_type = e.value;

        calculator_interest_rate();

    }



    function calculator_interest_rate() {

        var _price_total = $('.product-price').val().replace(/[,]+/g, ""); // Tổng giá trị BĐS - triệu VND

        var _amount = $('.amount').val().replace(/[,]+/g, ""); // Số tiền vay (Gốc phải trả) - triệu VND

        var _percent = $('.interest').val(); // Phần trăm lãi suất

        var _time = $('.time').val(); // Thời gian vay (Năm)





        //Thời gian vay (Tháng)

        _time = _time * 12;



        // Số tiền phải trả trước

        var _retainer = (_price_total - _amount) * 1000000;

        

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

        if (interest_type === 2) {

            // Tổng tiền lãi phải trả (Thanh toán đều hàng tháng )

            _interest_total = _interest_month * _time;

        }

        else if (interest_type === 1) {

            var _du_no_dau_ky = _amount;

            // Tổng tiền lãi phải trả (Thanh toán theo dư nợ giảm dần)

            for (var i = 0; i < _time; i++) {

                _interest_total += _du_no_dau_ky * _percent_month;

                _du_no_dau_ky = _du_no_dau_ky - _payment_month;

            }

        }

        _interest_total = Math.round(_interest_total);



        // Tổng cả gốc và lãi phải trả trong toàn kì (Đợn vị: Tỷ VND)

        var _total = ((Number(_price_total) + (_interest_total / 1000000)) / 1000).toFixed(2);

        

        var _rs_interest = formatNumber(_interest_total, '.', ',');



        var _rs_amount_first_month = formatNumber(_amount_month, '.', ',');

        $('.rs-interest').html(_rs_interest);

        $('.amount-first-month').html(_rs_amount_first_month);

        total_inside = _total;

        myChart.config.options.elements.center.text = total_inside + "\ntỷ";

        //$('.rs-total').html(_total);

        update_date_chart(_interest_total, _retainer, Number(_amount));

    }



    this.to_detail = function () {

        var _amount = $('.amount').val().replace(/[,]+/g, ""); // Số tiền vay (Gốc phải trả) - triệu VND

        var _percent = $('.interest').val(); // Phần trăm lãi suất

        var _time = $('.time').val(); // Thời gian vay (Năm)



        var data = {

            amount: _amount,

            interest: _percent,

            time: _time,

            type: interest_type

        }

        localStorage.setItem("InterestRate_Data", JSON.stringify(data));

        $("<a>").attr("href", "/tinh-lai-suat-vay").attr("target", "_blank")[0].click();

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



    var config = {

        type: 'doughnut',

        data: {

            labels: ["Lãi cần trả", "Cần trả trước", "Gốc cần trả"],

            datasets: [{

                label: '# of Votes',

                fill: true,

                data: [10, 10, 10],

                backgroundColor: [

                    '#e95155',

                    '#1397d4',

                    '#3d4d64'

                ],

                borderWidth: 5,

                borderColor: "#fff"

            }]

        },

        options: {

            elements: {

                center: {

                    text: total_inside

                }

            },

            cutoutPercentage: 75,

            legend: {

                display: false

            },

            animation: {

                animateScale: true,

                animateRotate: true

            },

            responsive: true,

            tooltips: {

                enabled: true,

                mode: 'label',

                callbacks: {

                    title: function (tooltipItem, data) {

                        return data['labels'][tooltipItem[0]['index']];

                    },

                    label: function (tooltipItem, data) {

                        return formatNumber(data['datasets'][0]['data'][tooltipItem['index']], ",", ".") + " VND";

                    },

                    afterLabel: function (tooltipItem, data) {

                        var dataset = data['datasets'][0];

                        var percent = Math.round((dataset['data'][tooltipItem['index']] / dataset["_meta"][0]['total']) * 100)

                        return '(' + percent + '%)';

                    }

                },

                backgroundColor: '#FFF',

                titleFontSize: 14,

                titleFontColor: '#1397d4',

                bodyFontColor: '#000',

                bodyFontSize: 14,

                displayColors: false

            }

        }

    };



    Chart.pluginService.register({

        beforeDraw: function (chart) {

            var width = chart.chart.width,

                height = chart.chart.height,

                ctx = chart.chart.ctx;

            ctx.restore();

            var fontSize = (height / 114).toFixed(2);

            ctx.font = fontSize + "em sans-serif";

            ctx.textBaseline = "middle";

            var text = chart.config.options.elements.center.text,

                textX = Math.round((width - ctx.measureText(text).width) / 2),

                textY = height / 2;

            ctx.fillText(text, textX, textY);

            ctx.save();

        }

    });



// Bọc Chart.js trong document.ready
$(document).ready(function() {
    try {
        var chartElement = document.getElementById("chart");
        // Chỉ chạy nếu phần tử <canvas id="chart"> tồn tại trên trang này
        if (chartElement) { 
            var ctx = chartElement.getContext('2d');
            var myChart = new Chart(ctx, config);
        }
    } catch (err) {
        console.log(err);
    }
});



    this.InitInterestRate = function (price) {

        //console.log(price);

        touch = false;

        $('.product-price').val(Math.round(price));

        $('.range-product-price').val(price).change();

        calcultor_amount();

        calculator_interest_rate();

    };



})(jQuery);



(function(e,h,l,c){e.fn.sonar=function(o,n){if(typeof o==="boolean"){n=o;o=c}return e.sonar(this[0],o,n)};var f=l.body,a="scrollin",m="scrollout",b=function(r,n,t){if(r){f||(f=l.body);var s=r,u=0,v=f.offsetHeight,o=h.innerHeight||l.documentElement.clientHeight||f.clientHeight||0,q=l.documentElement.scrollTop||h.pageYOffset||f.scrollTop||0,p=r.offsetHeight||0;if(!r.sonarElemTop||r.sonarBodyHeight!==v){if(s.offsetParent){do{u+=s.offsetTop}while(s=s.offsetParent)}r.sonarElemTop=u;r.sonarBodyHeight=v}n=n===c?0:n;return(!(r.sonarElemTop+(t?0:p)<q-n)&&!(r.sonarElemTop+(t?p:0)>q+o+n))}},d={},j=0,i=function(){setTimeout(function(){var s,o,t,q,p,r,n;for(t in d){o=d[t];for(r=0,n=o.length;r<n;r++){q=o[r];s=q.elem;p=b(s,q.px,q.full);if(t===m?!p:p){if(!q.tr){if(s[t]){e(s).trigger(t);q.tr=1}else{o.splice(r,1);r--;n--}}}else{q.tr=0}}}},25)},k=function(n,o){n[o]=0},g=function(r,p){var t=p.px,q=p.full,s=p.evt,o=b(r,t,q),n=0;r[s]=1;if(s===m?!o:o){setTimeout(function(){e(r).trigger(s===m?m:a)},0);n=1}d[s].push({elem:r,px:t,full:q,tr:n});if(!j){e(h).bind("scroll",i);j=1}};e.sonar=b;d[a]=[];e.event.special[a]={add:function(n){var p=n.data||{},o=this;if(!o[a]){g(this,{px:p.distance,full:p.full,evt:a})}},remove:function(n){k(this,a)}};d[m]=[];e.event.special[m]={add:function(n){var p=n.data||{},o=this;if(!o[m]){g(o,{px:p.distance,full:p.full,evt:m})}},remove:function(n){k(this,m)}}})(jQuery,window,document);



(function($) {

	lazy_load_init();

	$( 'body' ).bind( 'post-load', lazy_load_init ); // Work with WP.com infinite scroll



	function lazy_load_init() {

		$( 'img[data-lazy-src]' ).bind( 'scrollin', { distance: 200 }, function() {

			lazy_load_image( this );

		});



		// We need to force load gallery images in Jetpack Carousel and give up lazy-loading otherwise images don't show up correctly

		$( '[data-carousel-extra]' ).each( function() {

			$( this ).find( 'img[data-lazy-src]' ).each( function() {

				lazy_load_image( this );

			} );		

		} );

	}



	function lazy_load_image( img ) {

		var $img = jQuery( img ),

			src = $img.attr( 'data-lazy-src' );



		if ( ! src || 'undefined' === typeof( src ) )

			return;



		$img.unbind( 'scrollin' ) // remove event binding

			.hide()

			.removeAttr( 'data-lazy-src' )

			.attr( 'data-lazy-loaded', 'true' );



		img.src = src;

		$img.fadeIn();

	}

})(jQuery);


/*!

 * VERSION: 1.18.0

 * DATE: 2015-09-05

 * UPDATES AND DOCS AT: http://greensock.com

 * 

 * Includes all of the following: TweenLite, TweenMax, TimelineLite, TimelineMax, EasePack, CSSPlugin, RoundPropsPlugin, BezierPlugin, AttrPlugin, DirectionalRotationPlugin

 *

 * @license Copyright (c) 2008-2015, GreenSock. All rights reserved.

 * This work is subject to the terms at http://greensock.com/standard-license or for

 * Club GreenSock members, the software agreement that was issued with your membership.

 * 

 * @author: Jack Doyle, jack@greensock.com

 **/

var _gsScope="undefined"!=typeof module&&module.exports&&"undefined"!=typeof global?global:this||window;(_gsScope._gsQueue||(_gsScope._gsQueue=[])).push(function(){"use strict";_gsScope._gsDefine("TweenMax",["core.Animation","core.SimpleTimeline","TweenLite"],function(t,e,i){var s=function(t){var e,i=[],s=t.length;for(e=0;e!==s;i.push(t[e++]));return i},r=function(t,e,i){var s,r,n=t.cycle;for(s in n)r=n[s],t[s]="function"==typeof r?r.call(e[i],i):r[i%r.length];delete t.cycle},n=function(t,e,s){i.call(this,t,e,s),this._cycle=0,this._yoyo=this.vars.yoyo===!0,this._repeat=this.vars.repeat||0,this._repeatDelay=this.vars.repeatDelay||0,this._dirty=!0,this.render=n.prototype.render},a=1e-10,o=i._internals,l=o.isSelector,h=o.isArray,_=n.prototype=i.to({},.1,{}),u=[];n.version="1.18.0",_.constructor=n,_.kill()._gc=!1,n.killTweensOf=n.killDelayedCallsTo=i.killTweensOf,n.getTweensOf=i.getTweensOf,n.lagSmoothing=i.lagSmoothing,n.ticker=i.ticker,n.render=i.render,_.invalidate=function(){return this._yoyo=this.vars.yoyo===!0,this._repeat=this.vars.repeat||0,this._repeatDelay=this.vars.repeatDelay||0,this._uncache(!0),i.prototype.invalidate.call(this)},_.updateTo=function(t,e){var s,r=this.ratio,n=this.vars.immediateRender||t.immediateRender;e&&this._startTime<this._timeline._time&&(this._startTime=this._timeline._time,this._uncache(!1),this._gc?this._enabled(!0,!1):this._timeline.insert(this,this._startTime-this._delay));for(s in t)this.vars[s]=t[s];if(this._initted||n)if(e)this._initted=!1,n&&this.render(0,!0,!0);else if(this._gc&&this._enabled(!0,!1),this._notifyPluginsOfEnabled&&this._firstPT&&i._onPluginEvent("_onDisable",this),this._time/this._duration>.998){var a=this._time;this.render(0,!0,!1),this._initted=!1,this.render(a,!0,!1)}else if(this._time>0||n){this._initted=!1,this._init();for(var o,l=1/(1-r),h=this._firstPT;h;)o=h.s+h.c,h.c*=l,h.s=o-h.c,h=h._next}return this},_.render=function(t,e,i){this._initted||0===this._duration&&this.vars.repeat&&this.invalidate();var s,r,n,l,h,_,u,c,f=this._dirty?this.totalDuration():this._totalDuration,p=this._time,m=this._totalTime,d=this._cycle,g=this._duration,v=this._rawPrevTime;if(t>=f?(this._totalTime=f,this._cycle=this._repeat,this._yoyo&&0!==(1&this._cycle)?(this._time=0,this.ratio=this._ease._calcEnd?this._ease.getRatio(0):0):(this._time=g,this.ratio=this._ease._calcEnd?this._ease.getRatio(1):1),this._reversed||(s=!0,r="onComplete",i=i||this._timeline.autoRemoveChildren),0===g&&(this._initted||!this.vars.lazy||i)&&(this._startTime===this._timeline._duration&&(t=0),(0===t||0>v||v===a)&&v!==t&&(i=!0,v>a&&(r="onReverseComplete")),this._rawPrevTime=c=!e||t||v===t?t:a)):1e-7>t?(this._totalTime=this._time=this._cycle=0,this.ratio=this._ease._calcEnd?this._ease.getRatio(0):0,(0!==m||0===g&&v>0)&&(r="onReverseComplete",s=this._reversed),0>t&&(this._active=!1,0===g&&(this._initted||!this.vars.lazy||i)&&(v>=0&&(i=!0),this._rawPrevTime=c=!e||t||v===t?t:a)),this._initted||(i=!0)):(this._totalTime=this._time=t,0!==this._repeat&&(l=g+this._repeatDelay,this._cycle=this._totalTime/l>>0,0!==this._cycle&&this._cycle===this._totalTime/l&&this._cycle--,this._time=this._totalTime-this._cycle*l,this._yoyo&&0!==(1&this._cycle)&&(this._time=g-this._time),this._time>g?this._time=g:0>this._time&&(this._time=0)),this._easeType?(h=this._time/g,_=this._easeType,u=this._easePower,(1===_||3===_&&h>=.5)&&(h=1-h),3===_&&(h*=2),1===u?h*=h:2===u?h*=h*h:3===u?h*=h*h*h:4===u&&(h*=h*h*h*h),this.ratio=1===_?1-h:2===_?h:.5>this._time/g?h/2:1-h/2):this.ratio=this._ease.getRatio(this._time/g)),p===this._time&&!i&&d===this._cycle)return m!==this._totalTime&&this._onUpdate&&(e||this._callback("onUpdate")),void 0;if(!this._initted){if(this._init(),!this._initted||this._gc)return;if(!i&&this._firstPT&&(this.vars.lazy!==!1&&this._duration||this.vars.lazy&&!this._duration))return this._time=p,this._totalTime=m,this._rawPrevTime=v,this._cycle=d,o.lazyTweens.push(this),this._lazy=[t,e],void 0;this._time&&!s?this.ratio=this._ease.getRatio(this._time/g):s&&this._ease._calcEnd&&(this.ratio=this._ease.getRatio(0===this._time?0:1))}for(this._lazy!==!1&&(this._lazy=!1),this._active||!this._paused&&this._time!==p&&t>=0&&(this._active=!0),0===m&&(2===this._initted&&t>0&&this._init(),this._startAt&&(t>=0?this._startAt.render(t,e,i):r||(r="_dummyGS")),this.vars.onStart&&(0!==this._totalTime||0===g)&&(e||this._callback("onStart"))),n=this._firstPT;n;)n.f?n.t[n.p](n.c*this.ratio+n.s):n.t[n.p]=n.c*this.ratio+n.s,n=n._next;this._onUpdate&&(0>t&&this._startAt&&this._startTime&&this._startAt.render(t,e,i),e||(this._totalTime!==m||s)&&this._callback("onUpdate")),this._cycle!==d&&(e||this._gc||this.vars.onRepeat&&this._callback("onRepeat")),r&&(!this._gc||i)&&(0>t&&this._startAt&&!this._onUpdate&&this._startTime&&this._startAt.render(t,e,i),s&&(this._timeline.autoRemoveChildren&&this._enabled(!1,!1),this._active=!1),!e&&this.vars[r]&&this._callback(r),0===g&&this._rawPrevTime===a&&c!==a&&(this._rawPrevTime=0))},n.to=function(t,e,i){return new n(t,e,i)},n.from=function(t,e,i){return i.runBackwards=!0,i.immediateRender=0!=i.immediateRender,new n(t,e,i)},n.fromTo=function(t,e,i,s){return s.startAt=i,s.immediateRender=0!=s.immediateRender&&0!=i.immediateRender,new n(t,e,s)},n.staggerTo=n.allTo=function(t,e,a,o,_,c,f){o=o||0;var p,m,d,g,v=a.delay||0,y=[],T=function(){a.onComplete&&a.onComplete.apply(a.onCompleteScope||this,arguments),_.apply(f||a.callbackScope||this,c||u)},x=a.cycle,w=a.startAt&&a.startAt.cycle;for(h(t)||("string"==typeof t&&(t=i.selector(t)||t),l(t)&&(t=s(t))),t=t||[],0>o&&(t=s(t),t.reverse(),o*=-1),p=t.length-1,d=0;p>=d;d++){m={};for(g in a)m[g]=a[g];if(x&&r(m,t,d),w){w=m.startAt={};for(g in a.startAt)w[g]=a.startAt[g];r(m.startAt,t,d)}m.delay=v,d===p&&_&&(m.onComplete=T),y[d]=new n(t[d],e,m),v+=o}return y},n.staggerFrom=n.allFrom=function(t,e,i,s,r,a,o){return i.runBackwards=!0,i.immediateRender=0!=i.immediateRender,n.staggerTo(t,e,i,s,r,a,o)},n.staggerFromTo=n.allFromTo=function(t,e,i,s,r,a,o,l){return s.startAt=i,s.immediateRender=0!=s.immediateRender&&0!=i.immediateRender,n.staggerTo(t,e,s,r,a,o,l)},n.delayedCall=function(t,e,i,s,r){return new n(e,0,{delay:t,onComplete:e,onCompleteParams:i,callbackScope:s,onReverseComplete:e,onReverseCompleteParams:i,immediateRender:!1,useFrames:r,overwrite:0})},n.set=function(t,e){return new n(t,0,e)},n.isTweening=function(t){return i.getTweensOf(t,!0).length>0};var c=function(t,e){for(var s=[],r=0,n=t._first;n;)n instanceof i?s[r++]=n:(e&&(s[r++]=n),s=s.concat(c(n,e)),r=s.length),n=n._next;return s},f=n.getAllTweens=function(e){return c(t._rootTimeline,e).concat(c(t._rootFramesTimeline,e))};n.killAll=function(t,i,s,r){null==i&&(i=!0),null==s&&(s=!0);var n,a,o,l=f(0!=r),h=l.length,_=i&&s&&r;for(o=0;h>o;o++)a=l[o],(_||a instanceof e||(n=a.target===a.vars.onComplete)&&s||i&&!n)&&(t?a.totalTime(a._reversed?0:a.totalDuration()):a._enabled(!1,!1))},n.killChildTweensOf=function(t,e){if(null!=t){var r,a,_,u,c,f=o.tweenLookup;if("string"==typeof t&&(t=i.selector(t)||t),l(t)&&(t=s(t)),h(t))for(u=t.length;--u>-1;)n.killChildTweensOf(t[u],e);else{r=[];for(_ in f)for(a=f[_].target.parentNode;a;)a===t&&(r=r.concat(f[_].tweens)),a=a.parentNode;for(c=r.length,u=0;c>u;u++)e&&r[u].totalTime(r[u].totalDuration()),r[u]._enabled(!1,!1)}}};var p=function(t,i,s,r){i=i!==!1,s=s!==!1,r=r!==!1;for(var n,a,o=f(r),l=i&&s&&r,h=o.length;--h>-1;)a=o[h],(l||a instanceof e||(n=a.target===a.vars.onComplete)&&s||i&&!n)&&a.paused(t)};return n.pauseAll=function(t,e,i){p(!0,t,e,i)},n.resumeAll=function(t,e,i){p(!1,t,e,i)},n.globalTimeScale=function(e){var s=t._rootTimeline,r=i.ticker.time;return arguments.length?(e=e||a,s._startTime=r-(r-s._startTime)*s._timeScale/e,s=t._rootFramesTimeline,r=i.ticker.frame,s._startTime=r-(r-s._startTime)*s._timeScale/e,s._timeScale=t._rootTimeline._timeScale=e,e):s._timeScale},_.progress=function(t){return arguments.length?this.totalTime(this.duration()*(this._yoyo&&0!==(1&this._cycle)?1-t:t)+this._cycle*(this._duration+this._repeatDelay),!1):this._time/this.duration()},_.totalProgress=function(t){return arguments.length?this.totalTime(this.totalDuration()*t,!1):this._totalTime/this.totalDuration()},_.time=function(t,e){return arguments.length?(this._dirty&&this.totalDuration(),t>this._duration&&(t=this._duration),this._yoyo&&0!==(1&this._cycle)?t=this._duration-t+this._cycle*(this._duration+this._repeatDelay):0!==this._repeat&&(t+=this._cycle*(this._duration+this._repeatDelay)),this.totalTime(t,e)):this._time},_.duration=function(e){return arguments.length?t.prototype.duration.call(this,e):this._duration},_.totalDuration=function(t){return arguments.length?-1===this._repeat?this:this.duration((t-this._repeat*this._repeatDelay)/(this._repeat+1)):(this._dirty&&(this._totalDuration=-1===this._repeat?999999999999:this._duration*(this._repeat+1)+this._repeatDelay*this._repeat,this._dirty=!1),this._totalDuration)},_.repeat=function(t){return arguments.length?(this._repeat=t,this._uncache(!0)):this._repeat},_.repeatDelay=function(t){return arguments.length?(this._repeatDelay=t,this._uncache(!0)):this._repeatDelay},_.yoyo=function(t){return arguments.length?(this._yoyo=t,this):this._yoyo},n},!0),_gsScope._gsDefine("TimelineLite",["core.Animation","core.SimpleTimeline","TweenLite"],function(t,e,i){var s=function(t){e.call(this,t),this._labels={},this.autoRemoveChildren=this.vars.autoRemoveChildren===!0,this.smoothChildTiming=this.vars.smoothChildTiming===!0,this._sortChildren=!0,this._onUpdate=this.vars.onUpdate;var i,s,r=this.vars;for(s in r)i=r[s],l(i)&&-1!==i.join("").indexOf("{self}")&&(r[s]=this._swapSelfInParams(i));l(r.tweens)&&this.add(r.tweens,0,r.align,r.stagger)},r=1e-10,n=i._internals,a=s._internals={},o=n.isSelector,l=n.isArray,h=n.lazyTweens,_=n.lazyRender,u=_gsScope._gsDefine.globals,c=function(t){var e,i={};for(e in t)i[e]=t[e];return i},f=function(t,e,i){var s,r,n=t.cycle;for(s in n)r=n[s],t[s]="function"==typeof r?r.call(e[i],i):r[i%r.length];delete t.cycle},p=a.pauseCallback=function(){},m=function(t){var e,i=[],s=t.length;for(e=0;e!==s;i.push(t[e++]));return i},d=s.prototype=new e;return s.version="1.18.0",d.constructor=s,d.kill()._gc=d._forcingPlayhead=d._hasPause=!1,d.to=function(t,e,s,r){var n=s.repeat&&u.TweenMax||i;return e?this.add(new n(t,e,s),r):this.set(t,s,r)},d.from=function(t,e,s,r){return this.add((s.repeat&&u.TweenMax||i).from(t,e,s),r)},d.fromTo=function(t,e,s,r,n){var a=r.repeat&&u.TweenMax||i;return e?this.add(a.fromTo(t,e,s,r),n):this.set(t,r,n)},d.staggerTo=function(t,e,r,n,a,l,h,_){var u,p,d=new s({onComplete:l,onCompleteParams:h,callbackScope:_,smoothChildTiming:this.smoothChildTiming}),g=r.cycle;for("string"==typeof t&&(t=i.selector(t)||t),t=t||[],o(t)&&(t=m(t)),n=n||0,0>n&&(t=m(t),t.reverse(),n*=-1),p=0;t.length>p;p++)u=c(r),u.startAt&&(u.startAt=c(u.startAt),u.startAt.cycle&&f(u.startAt,t,p)),g&&f(u,t,p),d.to(t[p],e,u,p*n);return this.add(d,a)},d.staggerFrom=function(t,e,i,s,r,n,a,o){return i.immediateRender=0!=i.immediateRender,i.runBackwards=!0,this.staggerTo(t,e,i,s,r,n,a,o)},d.staggerFromTo=function(t,e,i,s,r,n,a,o,l){return s.startAt=i,s.immediateRender=0!=s.immediateRender&&0!=i.immediateRender,this.staggerTo(t,e,s,r,n,a,o,l)},d.call=function(t,e,s,r){return this.add(i.delayedCall(0,t,e,s),r)},d.set=function(t,e,s){return s=this._parseTimeOrLabel(s,0,!0),null==e.immediateRender&&(e.immediateRender=s===this._time&&!this._paused),this.add(new i(t,0,e),s)},s.exportRoot=function(t,e){t=t||{},null==t.smoothChildTiming&&(t.smoothChildTiming=!0);var r,n,a=new s(t),o=a._timeline;for(null==e&&(e=!0),o._remove(a,!0),a._startTime=0,a._rawPrevTime=a._time=a._totalTime=o._time,r=o._first;r;)n=r._next,e&&r instanceof i&&r.target===r.vars.onComplete||a.add(r,r._startTime-r._delay),r=n;return o.add(a,0),a},d.add=function(r,n,a,o){var h,_,u,c,f,p;if("number"!=typeof n&&(n=this._parseTimeOrLabel(n,0,!0,r)),!(r instanceof t)){if(r instanceof Array||r&&r.push&&l(r)){for(a=a||"normal",o=o||0,h=n,_=r.length,u=0;_>u;u++)l(c=r[u])&&(c=new s({tweens:c})),this.add(c,h),"string"!=typeof c&&"function"!=typeof c&&("sequence"===a?h=c._startTime+c.totalDuration()/c._timeScale:"start"===a&&(c._startTime-=c.delay())),h+=o;return this._uncache(!0)}if("string"==typeof r)return this.addLabel(r,n);if("function"!=typeof r)throw"Cannot add "+r+" into the timeline; it is not a tween, timeline, function, or string.";r=i.delayedCall(0,r)}if(e.prototype.add.call(this,r,n),(this._gc||this._time===this._duration)&&!this._paused&&this._duration<this.duration())for(f=this,p=f.rawTime()>r._startTime;f._timeline;)p&&f._timeline.smoothChildTiming?f.totalTime(f._totalTime,!0):f._gc&&f._enabled(!0,!1),f=f._timeline;return this},d.remove=function(e){if(e instanceof t){this._remove(e,!1);var i=e._timeline=e.vars.useFrames?t._rootFramesTimeline:t._rootTimeline;return e._startTime=(e._paused?e._pauseTime:i._time)-(e._reversed?e.totalDuration()-e._totalTime:e._totalTime)/e._timeScale,this}if(e instanceof Array||e&&e.push&&l(e)){for(var s=e.length;--s>-1;)this.remove(e[s]);return this}return"string"==typeof e?this.removeLabel(e):this.kill(null,e)},d._remove=function(t,i){e.prototype._remove.call(this,t,i);var s=this._last;return s?this._time>s._startTime+s._totalDuration/s._timeScale&&(this._time=this.duration(),this._totalTime=this._totalDuration):this._time=this._totalTime=this._duration=this._totalDuration=0,this},d.append=function(t,e){return this.add(t,this._parseTimeOrLabel(null,e,!0,t))},d.insert=d.insertMultiple=function(t,e,i,s){return this.add(t,e||0,i,s)},d.appendMultiple=function(t,e,i,s){return this.add(t,this._parseTimeOrLabel(null,e,!0,t),i,s)},d.addLabel=function(t,e){return this._labels[t]=this._parseTimeOrLabel(e),this},d.addPause=function(t,e,s,r){var n=i.delayedCall(0,p,s,r||this);return n.vars.onComplete=n.vars.onReverseComplete=e,n.data="isPause",this._hasPause=!0,this.add(n,t)},d.removeLabel=function(t){return delete this._labels[t],this},d.getLabelTime=function(t){return null!=this._labels[t]?this._labels[t]:-1},d._parseTimeOrLabel=function(e,i,s,r){var n;if(r instanceof t&&r.timeline===this)this.remove(r);else if(r&&(r instanceof Array||r.push&&l(r)))for(n=r.length;--n>-1;)r[n]instanceof t&&r[n].timeline===this&&this.remove(r[n]);if("string"==typeof i)return this._parseTimeOrLabel(i,s&&"number"==typeof e&&null==this._labels[i]?e-this.duration():0,s);if(i=i||0,"string"!=typeof e||!isNaN(e)&&null==this._labels[e])null==e&&(e=this.duration());else{if(n=e.indexOf("="),-1===n)return null==this._labels[e]?s?this._labels[e]=this.duration()+i:i:this._labels[e]+i;i=parseInt(e.charAt(n-1)+"1",10)*Number(e.substr(n+1)),e=n>1?this._parseTimeOrLabel(e.substr(0,n-1),0,s):this.duration()}return Number(e)+i},d.seek=function(t,e){return this.totalTime("number"==typeof t?t:this._parseTimeOrLabel(t),e!==!1)},d.stop=function(){return this.paused(!0)},d.gotoAndPlay=function(t,e){return this.play(t,e)},d.gotoAndStop=function(t,e){return this.pause(t,e)},d.render=function(t,e,i){this._gc&&this._enabled(!0,!1);var s,n,a,o,l,u,c=this._dirty?this.totalDuration():this._totalDuration,f=this._time,p=this._startTime,m=this._timeScale,d=this._paused;if(t>=c)this._totalTime=this._time=c,this._reversed||this._hasPausedChild()||(n=!0,o="onComplete",l=!!this._timeline.autoRemoveChildren,0===this._duration&&(0===t||0>this._rawPrevTime||this._rawPrevTime===r)&&this._rawPrevTime!==t&&this._first&&(l=!0,this._rawPrevTime>r&&(o="onReverseComplete"))),this._rawPrevTime=this._duration||!e||t||this._rawPrevTime===t?t:r,t=c+1e-4;else if(1e-7>t)if(this._totalTime=this._time=0,(0!==f||0===this._duration&&this._rawPrevTime!==r&&(this._rawPrevTime>0||0>t&&this._rawPrevTime>=0))&&(o="onReverseComplete",n=this._reversed),0>t)this._active=!1,this._timeline.autoRemoveChildren&&this._reversed?(l=n=!0,o="onReverseComplete"):this._rawPrevTime>=0&&this._first&&(l=!0),this._rawPrevTime=t;else{if(this._rawPrevTime=this._duration||!e||t||this._rawPrevTime===t?t:r,0===t&&n)for(s=this._first;s&&0===s._startTime;)s._duration||(n=!1),s=s._next;t=0,this._initted||(l=!0)}else{if(this._hasPause&&!this._forcingPlayhead&&!e){if(t>=f)for(s=this._first;s&&t>=s._startTime&&!u;)s._duration||"isPause"!==s.data||s.ratio||0===s._startTime&&0===this._rawPrevTime||(u=s),s=s._next;else for(s=this._last;s&&s._startTime>=t&&!u;)s._duration||"isPause"===s.data&&s._rawPrevTime>0&&(u=s),s=s._prev;u&&(this._time=t=u._startTime,this._totalTime=t+this._cycle*(this._totalDuration+this._repeatDelay))}this._totalTime=this._time=this._rawPrevTime=t}if(this._time!==f&&this._first||i||l||u){if(this._initted||(this._initted=!0),this._active||!this._paused&&this._time!==f&&t>0&&(this._active=!0),0===f&&this.vars.onStart&&0!==this._time&&(e||this._callback("onStart")),this._time>=f)for(s=this._first;s&&(a=s._next,!this._paused||d);)(s._active||s._startTime<=this._time&&!s._paused&&!s._gc)&&(u===s&&this.pause(),s._reversed?s.render((s._dirty?s.totalDuration():s._totalDuration)-(t-s._startTime)*s._timeScale,e,i):s.render((t-s._startTime)*s._timeScale,e,i)),s=a;else for(s=this._last;s&&(a=s._prev,!this._paused||d);){if(s._active||f>=s._startTime&&!s._paused&&!s._gc){if(u===s){for(u=s._prev;u&&u.endTime()>this._time;)u.render(u._reversed?u.totalDuration()-(t-u._startTime)*u._timeScale:(t-u._startTime)*u._timeScale,e,i),u=u._prev;u=null,this.pause()}s._reversed?s.render((s._dirty?s.totalDuration():s._totalDuration)-(t-s._startTime)*s._timeScale,e,i):s.render((t-s._startTime)*s._timeScale,e,i)}s=a}this._onUpdate&&(e||(h.length&&_(),this._callback("onUpdate"))),o&&(this._gc||(p===this._startTime||m!==this._timeScale)&&(0===this._time||c>=this.totalDuration())&&(n&&(h.length&&_(),this._timeline.autoRemoveChildren&&this._enabled(!1,!1),this._active=!1),!e&&this.vars[o]&&this._callback(o)))}},d._hasPausedChild=function(){for(var t=this._first;t;){if(t._paused||t instanceof s&&t._hasPausedChild())return!0;t=t._next}return!1},d.getChildren=function(t,e,s,r){r=r||-9999999999;for(var n=[],a=this._first,o=0;a;)r>a._startTime||(a instanceof i?e!==!1&&(n[o++]=a):(s!==!1&&(n[o++]=a),t!==!1&&(n=n.concat(a.getChildren(!0,e,s)),o=n.length))),a=a._next;return n},d.getTweensOf=function(t,e){var s,r,n=this._gc,a=[],o=0;for(n&&this._enabled(!0,!0),s=i.getTweensOf(t),r=s.length;--r>-1;)(s[r].timeline===this||e&&this._contains(s[r]))&&(a[o++]=s[r]);return n&&this._enabled(!1,!0),a},d.recent=function(){return this._recent},d._contains=function(t){for(var e=t.timeline;e;){if(e===this)return!0;e=e.timeline}return!1},d.shiftChildren=function(t,e,i){i=i||0;for(var s,r=this._first,n=this._labels;r;)r._startTime>=i&&(r._startTime+=t),r=r._next;if(e)for(s in n)n[s]>=i&&(n[s]+=t);return this._uncache(!0)},d._kill=function(t,e){if(!t&&!e)return this._enabled(!1,!1);for(var i=e?this.getTweensOf(e):this.getChildren(!0,!0,!1),s=i.length,r=!1;--s>-1;)i[s]._kill(t,e)&&(r=!0);return r},d.clear=function(t){var e=this.getChildren(!1,!0,!0),i=e.length;for(this._time=this._totalTime=0;--i>-1;)e[i]._enabled(!1,!1);return t!==!1&&(this._labels={}),this._uncache(!0)},d.invalidate=function(){for(var e=this._first;e;)e.invalidate(),e=e._next;return t.prototype.invalidate.call(this)},d._enabled=function(t,i){if(t===this._gc)for(var s=this._first;s;)s._enabled(t,!0),s=s._next;return e.prototype._enabled.call(this,t,i)},d.totalTime=function(){this._forcingPlayhead=!0;var e=t.prototype.totalTime.apply(this,arguments);return this._forcingPlayhead=!1,e},d.duration=function(t){return arguments.length?(0!==this.duration()&&0!==t&&this.timeScale(this._duration/t),this):(this._dirty&&this.totalDuration(),this._duration)},d.totalDuration=function(t){if(!arguments.length){if(this._dirty){for(var e,i,s=0,r=this._last,n=999999999999;r;)e=r._prev,r._dirty&&r.totalDuration(),r._startTime>n&&this._sortChildren&&!r._paused?this.add(r,r._startTime-r._delay):n=r._startTime,0>r._startTime&&!r._paused&&(s-=r._startTime,this._timeline.smoothChildTiming&&(this._startTime+=r._startTime/this._timeScale),this.shiftChildren(-r._startTime,!1,-9999999999),n=0),i=r._startTime+r._totalDuration/r._timeScale,i>s&&(s=i),r=e;this._duration=this._totalDuration=s,this._dirty=!1}return this._totalDuration}return 0!==this.totalDuration()&&0!==t&&this.timeScale(this._totalDuration/t),this},d.paused=function(e){if(!e)for(var i=this._first,s=this._time;i;)i._startTime===s&&"isPause"===i.data&&(i._rawPrevTime=0),i=i._next;return t.prototype.paused.apply(this,arguments)},d.usesFrames=function(){for(var e=this._timeline;e._timeline;)e=e._timeline;return e===t._rootFramesTimeline},d.rawTime=function(){return this._paused?this._totalTime:(this._timeline.rawTime()-this._startTime)*this._timeScale},s},!0),_gsScope._gsDefine("TimelineMax",["TimelineLite","TweenLite","easing.Ease"],function(t,e,i){var s=function(e){t.call(this,e),this._repeat=this.vars.repeat||0,this._repeatDelay=this.vars.repeatDelay||0,this._cycle=0,this._yoyo=this.vars.yoyo===!0,this._dirty=!0},r=1e-10,n=e._internals,a=n.lazyTweens,o=n.lazyRender,l=new i(null,null,1,0),h=s.prototype=new t;return h.constructor=s,h.kill()._gc=!1,s.version="1.18.0",h.invalidate=function(){return this._yoyo=this.vars.yoyo===!0,this._repeat=this.vars.repeat||0,this._repeatDelay=this.vars.repeatDelay||0,this._uncache(!0),t.prototype.invalidate.call(this)},h.addCallback=function(t,i,s,r){return this.add(e.delayedCall(0,t,s,r),i)},h.removeCallback=function(t,e){if(t)if(null==e)this._kill(null,t);else for(var i=this.getTweensOf(t,!1),s=i.length,r=this._parseTimeOrLabel(e);--s>-1;)i[s]._startTime===r&&i[s]._enabled(!1,!1);return this},h.removePause=function(e){return this.removeCallback(t._internals.pauseCallback,e)},h.tweenTo=function(t,i){i=i||{};var s,r,n,a={ease:l,useFrames:this.usesFrames(),immediateRender:!1};for(r in i)a[r]=i[r];return a.time=this._parseTimeOrLabel(t),s=Math.abs(Number(a.time)-this._time)/this._timeScale||.001,n=new e(this,s,a),a.onStart=function(){n.target.paused(!0),n.vars.time!==n.target.time()&&s===n.duration()&&n.duration(Math.abs(n.vars.time-n.target.time())/n.target._timeScale),i.onStart&&n._callback("onStart")},n},h.tweenFromTo=function(t,e,i){i=i||{},t=this._parseTimeOrLabel(t),i.startAt={onComplete:this.seek,onCompleteParams:[t],callbackScope:this},i.immediateRender=i.immediateRender!==!1;var s=this.tweenTo(e,i);return s.duration(Math.abs(s.vars.time-t)/this._timeScale||.001)},h.render=function(t,e,i){this._gc&&this._enabled(!0,!1);var s,n,l,h,_,u,c,f=this._dirty?this.totalDuration():this._totalDuration,p=this._duration,m=this._time,d=this._totalTime,g=this._startTime,v=this._timeScale,y=this._rawPrevTime,T=this._paused,x=this._cycle;if(t>=f)this._locked||(this._totalTime=f,this._cycle=this._repeat),this._reversed||this._hasPausedChild()||(n=!0,h="onComplete",_=!!this._timeline.autoRemoveChildren,0===this._duration&&(0===t||0>y||y===r)&&y!==t&&this._first&&(_=!0,y>r&&(h="onReverseComplete"))),this._rawPrevTime=this._duration||!e||t||this._rawPrevTime===t?t:r,this._yoyo&&0!==(1&this._cycle)?this._time=t=0:(this._time=p,t=p+1e-4);else if(1e-7>t)if(this._locked||(this._totalTime=this._cycle=0),this._time=0,(0!==m||0===p&&y!==r&&(y>0||0>t&&y>=0)&&!this._locked)&&(h="onReverseComplete",n=this._reversed),0>t)this._active=!1,this._timeline.autoRemoveChildren&&this._reversed?(_=n=!0,h="onReverseComplete"):y>=0&&this._first&&(_=!0),this._rawPrevTime=t;else{if(this._rawPrevTime=p||!e||t||this._rawPrevTime===t?t:r,0===t&&n)for(s=this._first;s&&0===s._startTime;)s._duration||(n=!1),s=s._next;t=0,this._initted||(_=!0)}else if(0===p&&0>y&&(_=!0),this._time=this._rawPrevTime=t,this._locked||(this._totalTime=t,0!==this._repeat&&(u=p+this._repeatDelay,this._cycle=this._totalTime/u>>0,0!==this._cycle&&this._cycle===this._totalTime/u&&this._cycle--,this._time=this._totalTime-this._cycle*u,this._yoyo&&0!==(1&this._cycle)&&(this._time=p-this._time),this._time>p?(this._time=p,t=p+1e-4):0>this._time?this._time=t=0:t=this._time)),this._hasPause&&!this._forcingPlayhead&&!e){if(t=this._time,t>=m)for(s=this._first;s&&t>=s._startTime&&!c;)s._duration||"isPause"!==s.data||s.ratio||0===s._startTime&&0===this._rawPrevTime||(c=s),s=s._next;else for(s=this._last;s&&s._startTime>=t&&!c;)s._duration||"isPause"===s.data&&s._rawPrevTime>0&&(c=s),s=s._prev;c&&(this._time=t=c._startTime,this._totalTime=t+this._cycle*(this._totalDuration+this._repeatDelay))}if(this._cycle!==x&&!this._locked){var w=this._yoyo&&0!==(1&x),b=w===(this._yoyo&&0!==(1&this._cycle)),P=this._totalTime,k=this._cycle,S=this._rawPrevTime,R=this._time;if(this._totalTime=x*p,x>this._cycle?w=!w:this._totalTime+=p,this._time=m,this._rawPrevTime=0===p?y-1e-4:y,this._cycle=x,this._locked=!0,m=w?0:p,this.render(m,e,0===p),e||this._gc||this.vars.onRepeat&&this._callback("onRepeat"),b&&(m=w?p+1e-4:-1e-4,this.render(m,!0,!1)),this._locked=!1,this._paused&&!T)return;this._time=R,this._totalTime=P,this._cycle=k,this._rawPrevTime=S}if(!(this._time!==m&&this._first||i||_||c))return d!==this._totalTime&&this._onUpdate&&(e||this._callback("onUpdate")),void 0;if(this._initted||(this._initted=!0),this._active||!this._paused&&this._totalTime!==d&&t>0&&(this._active=!0),0===d&&this.vars.onStart&&0!==this._totalTime&&(e||this._callback("onStart")),this._time>=m)for(s=this._first;s&&(l=s._next,!this._paused||T);)(s._active||s._startTime<=this._time&&!s._paused&&!s._gc)&&(c===s&&this.pause(),s._reversed?s.render((s._dirty?s.totalDuration():s._totalDuration)-(t-s._startTime)*s._timeScale,e,i):s.render((t-s._startTime)*s._timeScale,e,i)),s=l;else for(s=this._last;s&&(l=s._prev,!this._paused||T);){if(s._active||m>=s._startTime&&!s._paused&&!s._gc){if(c===s){for(c=s._prev;c&&c.endTime()>this._time;)c.render(c._reversed?c.totalDuration()-(t-c._startTime)*c._timeScale:(t-c._startTime)*c._timeScale,e,i),c=c._prev;c=null,this.pause()}s._reversed?s.render((s._dirty?s.totalDuration():s._totalDuration)-(t-s._startTime)*s._timeScale,e,i):s.render((t-s._startTime)*s._timeScale,e,i)}s=l}this._onUpdate&&(e||(a.length&&o(),this._callback("onUpdate"))),h&&(this._locked||this._gc||(g===this._startTime||v!==this._timeScale)&&(0===this._time||f>=this.totalDuration())&&(n&&(a.length&&o(),this._timeline.autoRemoveChildren&&this._enabled(!1,!1),this._active=!1),!e&&this.vars[h]&&this._callback(h)))},h.getActive=function(t,e,i){null==t&&(t=!0),null==e&&(e=!0),null==i&&(i=!1);var s,r,n=[],a=this.getChildren(t,e,i),o=0,l=a.length;for(s=0;l>s;s++)r=a[s],r.isActive()&&(n[o++]=r);return n},h.getLabelAfter=function(t){t||0!==t&&(t=this._time);var e,i=this.getLabelsArray(),s=i.length;for(e=0;s>e;e++)if(i[e].time>t)return i[e].name;return null},h.getLabelBefore=function(t){null==t&&(t=this._time);for(var e=this.getLabelsArray(),i=e.length;--i>-1;)if(t>e[i].time)return e[i].name;return null},h.getLabelsArray=function(){var t,e=[],i=0;for(t in this._labels)e[i++]={time:this._labels[t],name:t};return e.sort(function(t,e){return t.time-e.time}),e},h.progress=function(t,e){return arguments.length?this.totalTime(this.duration()*(this._yoyo&&0!==(1&this._cycle)?1-t:t)+this._cycle*(this._duration+this._repeatDelay),e):this._time/this.duration()},h.totalProgress=function(t,e){return arguments.length?this.totalTime(this.totalDuration()*t,e):this._totalTime/this.totalDuration()},h.totalDuration=function(e){return arguments.length?-1===this._repeat?this:this.duration((e-this._repeat*this._repeatDelay)/(this._repeat+1)):(this._dirty&&(t.prototype.totalDuration.call(this),this._totalDuration=-1===this._repeat?999999999999:this._duration*(this._repeat+1)+this._repeatDelay*this._repeat),this._totalDuration)},h.time=function(t,e){return arguments.length?(this._dirty&&this.totalDuration(),t>this._duration&&(t=this._duration),this._yoyo&&0!==(1&this._cycle)?t=this._duration-t+this._cycle*(this._duration+this._repeatDelay):0!==this._repeat&&(t+=this._cycle*(this._duration+this._repeatDelay)),this.totalTime(t,e)):this._time},h.repeat=function(t){return arguments.length?(this._repeat=t,this._uncache(!0)):this._repeat},h.repeatDelay=function(t){return arguments.length?(this._repeatDelay=t,this._uncache(!0)):this._repeatDelay},h.yoyo=function(t){return arguments.length?(this._yoyo=t,this):this._yoyo},h.currentLabel=function(t){return arguments.length?this.seek(t,!0):this.getLabelBefore(this._time+1e-8)},s},!0),function(){var t=180/Math.PI,e=[],i=[],s=[],r={},n=_gsScope._gsDefine.globals,a=function(t,e,i,s){this.a=t,this.b=e,this.c=i,this.d=s,this.da=s-t,this.ca=i-t,this.ba=e-t},o=",x,y,z,left,top,right,bottom,marginTop,marginLeft,marginRight,marginBottom,paddingLeft,paddingTop,paddingRight,paddingBottom,backgroundPosition,backgroundPosition_y,",l=function(t,e,i,s){var r={a:t},n={},a={},o={c:s},l=(t+e)/2,h=(e+i)/2,_=(i+s)/2,u=(l+h)/2,c=(h+_)/2,f=(c-u)/8;return r.b=l+(t-l)/4,n.b=u+f,r.c=n.a=(r.b+n.b)/2,n.c=a.a=(u+c)/2,a.b=c-f,o.b=_+(s-_)/4,a.c=o.a=(a.b+o.b)/2,[r,n,a,o]},h=function(t,r,n,a,o){var h,_,u,c,f,p,m,d,g,v,y,T,x,w=t.length-1,b=0,P=t[0].a;for(h=0;w>h;h++)f=t[b],_=f.a,u=f.d,c=t[b+1].d,o?(y=e[h],T=i[h],x=.25*(T+y)*r/(a?.5:s[h]||.5),p=u-(u-_)*(a?.5*r:0!==y?x/y:0),m=u+(c-u)*(a?.5*r:0!==T?x/T:0),d=u-(p+((m-p)*(3*y/(y+T)+.5)/4||0))):(p=u-.5*(u-_)*r,m=u+.5*(c-u)*r,d=u-(p+m)/2),p+=d,m+=d,f.c=g=p,f.b=0!==h?P:P=f.a+.6*(f.c-f.a),f.da=u-_,f.ca=g-_,f.ba=P-_,n?(v=l(_,P,g,u),t.splice(b,1,v[0],v[1],v[2],v[3]),b+=4):b++,P=m;f=t[b],f.b=P,f.c=P+.4*(f.d-P),f.da=f.d-f.a,f.ca=f.c-f.a,f.ba=P-f.a,n&&(v=l(f.a,P,f.c,f.d),t.splice(b,1,v[0],v[1],v[2],v[3]))},_=function(t,s,r,n){var o,l,h,_,u,c,f=[];if(n)for(t=[n].concat(t),l=t.length;--l>-1;)"string"==typeof(c=t[l][s])&&"="===c.charAt(1)&&(t[l][s]=n[s]+Number(c.charAt(0)+c.substr(2)));if(o=t.length-2,0>o)return f[0]=new a(t[0][s],0,0,t[-1>o?0:1][s]),f;for(l=0;o>l;l++)h=t[l][s],_=t[l+1][s],f[l]=new a(h,0,0,_),r&&(u=t[l+2][s],e[l]=(e[l]||0)+(_-h)*(_-h),i[l]=(i[l]||0)+(u-_)*(u-_));return f[l]=new a(t[l][s],0,0,t[l+1][s]),f},u=function(t,n,a,l,u,c){var f,p,m,d,g,v,y,T,x={},w=[],b=c||t[0];u="string"==typeof u?","+u+",":o,null==n&&(n=1);for(p in t[0])w.push(p);if(t.length>1){for(T=t[t.length-1],y=!0,f=w.length;--f>-1;)if(p=w[f],Math.abs(b[p]-T[p])>.05){y=!1;break}y&&(t=t.concat(),c&&t.unshift(c),t.push(t[1]),c=t[t.length-3])}for(e.length=i.length=s.length=0,f=w.length;--f>-1;)p=w[f],r[p]=-1!==u.indexOf(","+p+","),x[p]=_(t,p,r[p],c);for(f=e.length;--f>-1;)e[f]=Math.sqrt(e[f]),i[f]=Math.sqrt(i[f]);if(!l){for(f=w.length;--f>-1;)if(r[p])for(m=x[w[f]],v=m.length-1,d=0;v>d;d++)g=m[d+1].da/i[d]+m[d].da/e[d],s[d]=(s[d]||0)+g*g;for(f=s.length;--f>-1;)s[f]=Math.sqrt(s[f])}for(f=w.length,d=a?4:1;--f>-1;)p=w[f],m=x[p],h(m,n,a,l,r[p]),y&&(m.splice(0,d),m.splice(m.length-d,d));return x},c=function(t,e,i){e=e||"soft";var s,r,n,o,l,h,_,u,c,f,p,m={},d="cubic"===e?3:2,g="soft"===e,v=[];if(g&&i&&(t=[i].concat(t)),null==t||d+1>t.length)throw"invalid Bezier data";for(c in t[0])v.push(c);for(h=v.length;--h>-1;){for(c=v[h],m[c]=l=[],f=0,u=t.length,_=0;u>_;_++)s=null==i?t[_][c]:"string"==typeof(p=t[_][c])&&"="===p.charAt(1)?i[c]+Number(p.charAt(0)+p.substr(2)):Number(p),g&&_>1&&u-1>_&&(l[f++]=(s+l[f-2])/2),l[f++]=s;for(u=f-d+1,f=0,_=0;u>_;_+=d)s=l[_],r=l[_+1],n=l[_+2],o=2===d?0:l[_+3],l[f++]=p=3===d?new a(s,r,n,o):new a(s,(2*r+s)/3,(2*r+n)/3,n);l.length=f}return m},f=function(t,e,i){for(var s,r,n,a,o,l,h,_,u,c,f,p=1/i,m=t.length;--m>-1;)for(c=t[m],n=c.a,a=c.d-n,o=c.c-n,l=c.b-n,s=r=0,_=1;i>=_;_++)h=p*_,u=1-h,s=r-(r=(h*h*a+3*u*(h*o+u*l))*h),f=m*i+_-1,e[f]=(e[f]||0)+s*s},p=function(t,e){e=e>>0||6;var i,s,r,n,a=[],o=[],l=0,h=0,_=e-1,u=[],c=[];for(i in t)f(t[i],a,e);for(r=a.length,s=0;r>s;s++)l+=Math.sqrt(a[s]),n=s%e,c[n]=l,n===_&&(h+=l,n=s/e>>0,u[n]=c,o[n]=h,l=0,c=[]);return{length:h,lengths:o,segments:u}},m=_gsScope._gsDefine.plugin({propName:"bezier",priority:-1,version:"1.3.4",API:2,global:!0,init:function(t,e,i){this._target=t,e instanceof Array&&(e={values:e}),this._func={},this._round={},this._props=[],this._timeRes=null==e.timeResolution?6:parseInt(e.timeResolution,10);var s,r,n,a,o,l=e.values||[],h={},_=l[0],f=e.autoRotate||i.vars.orientToBezier;this._autoRotate=f?f instanceof Array?f:[["x","y","rotation",f===!0?0:Number(f)||0]]:null;

for(s in _)this._props.push(s);for(n=this._props.length;--n>-1;)s=this._props[n],this._overwriteProps.push(s),r=this._func[s]="function"==typeof t[s],h[s]=r?t[s.indexOf("set")||"function"!=typeof t["get"+s.substr(3)]?s:"get"+s.substr(3)]():parseFloat(t[s]),o||h[s]!==l[0][s]&&(o=h);if(this._beziers="cubic"!==e.type&&"quadratic"!==e.type&&"soft"!==e.type?u(l,isNaN(e.curviness)?1:e.curviness,!1,"thruBasic"===e.type,e.correlate,o):c(l,e.type,h),this._segCount=this._beziers[s].length,this._timeRes){var m=p(this._beziers,this._timeRes);this._length=m.length,this._lengths=m.lengths,this._segments=m.segments,this._l1=this._li=this._s1=this._si=0,this._l2=this._lengths[0],this._curSeg=this._segments[0],this._s2=this._curSeg[0],this._prec=1/this._curSeg.length}if(f=this._autoRotate)for(this._initialRotations=[],f[0]instanceof Array||(this._autoRotate=f=[f]),n=f.length;--n>-1;){for(a=0;3>a;a++)s=f[n][a],this._func[s]="function"==typeof t[s]?t[s.indexOf("set")||"function"!=typeof t["get"+s.substr(3)]?s:"get"+s.substr(3)]:!1;s=f[n][2],this._initialRotations[n]=this._func[s]?this._func[s].call(this._target):this._target[s]}return this._startRatio=i.vars.runBackwards?1:0,!0},set:function(e){var i,s,r,n,a,o,l,h,_,u,c=this._segCount,f=this._func,p=this._target,m=e!==this._startRatio;if(this._timeRes){if(_=this._lengths,u=this._curSeg,e*=this._length,r=this._li,e>this._l2&&c-1>r){for(h=c-1;h>r&&e>=(this._l2=_[++r]););this._l1=_[r-1],this._li=r,this._curSeg=u=this._segments[r],this._s2=u[this._s1=this._si=0]}else if(this._l1>e&&r>0){for(;r>0&&(this._l1=_[--r])>=e;);0===r&&this._l1>e?this._l1=0:r++,this._l2=_[r],this._li=r,this._curSeg=u=this._segments[r],this._s1=u[(this._si=u.length-1)-1]||0,this._s2=u[this._si]}if(i=r,e-=this._l1,r=this._si,e>this._s2&&u.length-1>r){for(h=u.length-1;h>r&&e>=(this._s2=u[++r]););this._s1=u[r-1],this._si=r}else if(this._s1>e&&r>0){for(;r>0&&(this._s1=u[--r])>=e;);0===r&&this._s1>e?this._s1=0:r++,this._s2=u[r],this._si=r}o=(r+(e-this._s1)/(this._s2-this._s1))*this._prec}else i=0>e?0:e>=1?c-1:c*e>>0,o=(e-i*(1/c))*c;for(s=1-o,r=this._props.length;--r>-1;)n=this._props[r],a=this._beziers[n][i],l=(o*o*a.da+3*s*(o*a.ca+s*a.ba))*o+a.a,this._round[n]&&(l=Math.round(l)),f[n]?p[n](l):p[n]=l;if(this._autoRotate){var d,g,v,y,T,x,w,b=this._autoRotate;for(r=b.length;--r>-1;)n=b[r][2],x=b[r][3]||0,w=b[r][4]===!0?1:t,a=this._beziers[b[r][0]],d=this._beziers[b[r][1]],a&&d&&(a=a[i],d=d[i],g=a.a+(a.b-a.a)*o,y=a.b+(a.c-a.b)*o,g+=(y-g)*o,y+=(a.c+(a.d-a.c)*o-y)*o,v=d.a+(d.b-d.a)*o,T=d.b+(d.c-d.b)*o,v+=(T-v)*o,T+=(d.c+(d.d-d.c)*o-T)*o,l=m?Math.atan2(T-v,y-g)*w+x:this._initialRotations[r],f[n]?p[n](l):p[n]=l)}}}),d=m.prototype;m.bezierThrough=u,m.cubicToQuadratic=l,m._autoCSS=!0,m.quadraticToCubic=function(t,e,i){return new a(t,(2*e+t)/3,(2*e+i)/3,i)},m._cssRegister=function(){var t=n.CSSPlugin;if(t){var e=t._internals,i=e._parseToProxy,s=e._setPluginRatio,r=e.CSSPropTween;e._registerComplexSpecialProp("bezier",{parser:function(t,e,n,a,o,l){e instanceof Array&&(e={values:e}),l=new m;var h,_,u,c=e.values,f=c.length-1,p=[],d={};if(0>f)return o;for(h=0;f>=h;h++)u=i(t,c[h],a,o,l,f!==h),p[h]=u.end;for(_ in e)d[_]=e[_];return d.values=p,o=new r(t,"bezier",0,0,u.pt,2),o.data=u,o.plugin=l,o.setRatio=s,0===d.autoRotate&&(d.autoRotate=!0),!d.autoRotate||d.autoRotate instanceof Array||(h=d.autoRotate===!0?0:Number(d.autoRotate),d.autoRotate=null!=u.end.left?[["left","top","rotation",h,!1]]:null!=u.end.x?[["x","y","rotation",h,!1]]:!1),d.autoRotate&&(a._transform||a._enableTransforms(!1),u.autoRotate=a._target._gsTransform),l._onInitTween(u.proxy,d,a._tween),o}})}},d._roundProps=function(t,e){for(var i=this._overwriteProps,s=i.length;--s>-1;)(t[i[s]]||t.bezier||t.bezierThrough)&&(this._round[i[s]]=e)},d._kill=function(t){var e,i,s=this._props;for(e in this._beziers)if(e in t)for(delete this._beziers[e],delete this._func[e],i=s.length;--i>-1;)s[i]===e&&s.splice(i,1);return this._super._kill.call(this,t)}}(),_gsScope._gsDefine("plugins.CSSPlugin",["plugins.TweenPlugin","TweenLite"],function(t,e){var i,s,r,n,a=function(){t.call(this,"css"),this._overwriteProps.length=0,this.setRatio=a.prototype.setRatio},o=_gsScope._gsDefine.globals,l={},h=a.prototype=new t("css");h.constructor=a,a.version="1.18.0",a.API=2,a.defaultTransformPerspective=0,a.defaultSkewType="compensated",a.defaultSmoothOrigin=!0,h="px",a.suffixMap={top:h,right:h,bottom:h,left:h,width:h,height:h,fontSize:h,padding:h,margin:h,perspective:h,lineHeight:""};var _,u,c,f,p,m,d=/(?:\d|\-\d|\.\d|\-\.\d)+/g,g=/(?:\d|\-\d|\.\d|\-\.\d|\+=\d|\-=\d|\+=.\d|\-=\.\d)+/g,v=/(?:\+=|\-=|\-|\b)[\d\-\.]+[a-zA-Z0-9]*(?:%|\b)/gi,y=/(?![+-]?\d*\.?\d+|[+-]|e[+-]\d+)[^0-9]/g,T=/(?:\d|\-|\+|=|#|\.)*/g,x=/opacity *= *([^)]*)/i,w=/opacity:([^;]*)/i,b=/alpha\(opacity *=.+?\)/i,P=/^(rgb|hsl)/,k=/([A-Z])/g,S=/-([a-z])/gi,R=/(^(?:url\(\"|url\())|(?:(\"\))$|\)$)/gi,O=function(t,e){return e.toUpperCase()},A=/(?:Left|Right|Width)/i,C=/(M11|M12|M21|M22)=[\d\-\.e]+/gi,D=/progid\:DXImageTransform\.Microsoft\.Matrix\(.+?\)/i,M=/,(?=[^\)]*(?:\(|$))/gi,z=Math.PI/180,F=180/Math.PI,I={},E=document,N=function(t){return E.createElementNS?E.createElementNS("http://www.w3.org/1999/xhtml",t):E.createElement(t)},L=N("div"),X=N("img"),B=a._internals={_specialProps:l},j=navigator.userAgent,Y=function(){var t=j.indexOf("Android"),e=N("a");return c=-1!==j.indexOf("Safari")&&-1===j.indexOf("Chrome")&&(-1===t||Number(j.substr(t+8,1))>3),p=c&&6>Number(j.substr(j.indexOf("Version/")+8,1)),f=-1!==j.indexOf("Firefox"),(/MSIE ([0-9]{1,}[\.0-9]{0,})/.exec(j)||/Trident\/.*rv:([0-9]{1,}[\.0-9]{0,})/.exec(j))&&(m=parseFloat(RegExp.$1)),e?(e.style.cssText="top:1px;opacity:.55;",/^0.55/.test(e.style.opacity)):!1}(),U=function(t){return x.test("string"==typeof t?t:(t.currentStyle?t.currentStyle.filter:t.style.filter)||"")?parseFloat(RegExp.$1)/100:1},q=function(t){window.console&&console.log(t)},V="",G="",W=function(t,e){e=e||L;var i,s,r=e.style;if(void 0!==r[t])return t;for(t=t.charAt(0).toUpperCase()+t.substr(1),i=["O","Moz","ms","Ms","Webkit"],s=5;--s>-1&&void 0===r[i[s]+t];);return s>=0?(G=3===s?"ms":i[s],V="-"+G.toLowerCase()+"-",G+t):null},Z=E.defaultView?E.defaultView.getComputedStyle:function(){},Q=a.getStyle=function(t,e,i,s,r){var n;return Y||"opacity"!==e?(!s&&t.style[e]?n=t.style[e]:(i=i||Z(t))?n=i[e]||i.getPropertyValue(e)||i.getPropertyValue(e.replace(k,"-$1").toLowerCase()):t.currentStyle&&(n=t.currentStyle[e]),null==r||n&&"none"!==n&&"auto"!==n&&"auto auto"!==n?n:r):U(t)},$=B.convertToPixels=function(t,i,s,r,n){if("px"===r||!r)return s;if("auto"===r||!s)return 0;var o,l,h,_=A.test(i),u=t,c=L.style,f=0>s;if(f&&(s=-s),"%"===r&&-1!==i.indexOf("border"))o=s/100*(_?t.clientWidth:t.clientHeight);else{if(c.cssText="border:0 solid red;position:"+Q(t,"position")+";line-height:0;","%"!==r&&u.appendChild&&"v"!==r.charAt(0)&&"rem"!==r)c[_?"borderLeftWidth":"borderTopWidth"]=s+r;else{if(u=t.parentNode||E.body,l=u._gsCache,h=e.ticker.frame,l&&_&&l.time===h)return l.width*s/100;c[_?"width":"height"]=s+r}u.appendChild(L),o=parseFloat(L[_?"offsetWidth":"offsetHeight"]),u.removeChild(L),_&&"%"===r&&a.cacheWidths!==!1&&(l=u._gsCache=u._gsCache||{},l.time=h,l.width=100*(o/s)),0!==o||n||(o=$(t,i,s,r,!0))}return f?-o:o},H=B.calculateOffset=function(t,e,i){if("absolute"!==Q(t,"position",i))return 0;var s="left"===e?"Left":"Top",r=Q(t,"margin"+s,i);return t["offset"+s]-($(t,e,parseFloat(r),r.replace(T,""))||0)},K=function(t,e){var i,s,r,n={};if(e=e||Z(t,null))if(i=e.length)for(;--i>-1;)r=e[i],(-1===r.indexOf("-transform")||ke===r)&&(n[r.replace(S,O)]=e.getPropertyValue(r));else for(i in e)(-1===i.indexOf("Transform")||Pe===i)&&(n[i]=e[i]);else if(e=t.currentStyle||t.style)for(i in e)"string"==typeof i&&void 0===n[i]&&(n[i.replace(S,O)]=e[i]);return Y||(n.opacity=U(t)),s=Ne(t,e,!1),n.rotation=s.rotation,n.skewX=s.skewX,n.scaleX=s.scaleX,n.scaleY=s.scaleY,n.x=s.x,n.y=s.y,Re&&(n.z=s.z,n.rotationX=s.rotationX,n.rotationY=s.rotationY,n.scaleZ=s.scaleZ),n.filters&&delete n.filters,n},J=function(t,e,i,s,r){var n,a,o,l={},h=t.style;for(a in i)"cssText"!==a&&"length"!==a&&isNaN(a)&&(e[a]!==(n=i[a])||r&&r[a])&&-1===a.indexOf("Origin")&&("number"==typeof n||"string"==typeof n)&&(l[a]="auto"!==n||"left"!==a&&"top"!==a?""!==n&&"auto"!==n&&"none"!==n||"string"!=typeof e[a]||""===e[a].replace(y,"")?n:0:H(t,a),void 0!==h[a]&&(o=new pe(h,a,h[a],o)));if(s)for(a in s)"className"!==a&&(l[a]=s[a]);return{difs:l,firstMPT:o}},te={width:["Left","Right"],height:["Top","Bottom"]},ee=["marginLeft","marginRight","marginTop","marginBottom"],ie=function(t,e,i){var s=parseFloat("width"===e?t.offsetWidth:t.offsetHeight),r=te[e],n=r.length;for(i=i||Z(t,null);--n>-1;)s-=parseFloat(Q(t,"padding"+r[n],i,!0))||0,s-=parseFloat(Q(t,"border"+r[n]+"Width",i,!0))||0;return s},se=function(t,e){if("contain"===t||"auto"===t||"auto auto"===t)return t+" ";(null==t||""===t)&&(t="0 0");var i=t.split(" "),s=-1!==t.indexOf("left")?"0%":-1!==t.indexOf("right")?"100%":i[0],r=-1!==t.indexOf("top")?"0%":-1!==t.indexOf("bottom")?"100%":i[1];return null==r?r="center"===s?"50%":"0":"center"===r&&(r="50%"),("center"===s||isNaN(parseFloat(s))&&-1===(s+"").indexOf("="))&&(s="50%"),t=s+" "+r+(i.length>2?" "+i[2]:""),e&&(e.oxp=-1!==s.indexOf("%"),e.oyp=-1!==r.indexOf("%"),e.oxr="="===s.charAt(1),e.oyr="="===r.charAt(1),e.ox=parseFloat(s.replace(y,"")),e.oy=parseFloat(r.replace(y,"")),e.v=t),e||t},re=function(t,e){return"string"==typeof t&&"="===t.charAt(1)?parseInt(t.charAt(0)+"1",10)*parseFloat(t.substr(2)):parseFloat(t)-parseFloat(e)},ne=function(t,e){return null==t?e:"string"==typeof t&&"="===t.charAt(1)?parseInt(t.charAt(0)+"1",10)*parseFloat(t.substr(2))+e:parseFloat(t)},ae=function(t,e,i,s){var r,n,a,o,l,h=1e-6;return null==t?o=e:"number"==typeof t?o=t:(r=360,n=t.split("_"),l="="===t.charAt(1),a=(l?parseInt(t.charAt(0)+"1",10)*parseFloat(n[0].substr(2)):parseFloat(n[0]))*(-1===t.indexOf("rad")?1:F)-(l?0:e),n.length&&(s&&(s[i]=e+a),-1!==t.indexOf("short")&&(a%=r,a!==a%(r/2)&&(a=0>a?a+r:a-r)),-1!==t.indexOf("_cw")&&0>a?a=(a+9999999999*r)%r-(0|a/r)*r:-1!==t.indexOf("ccw")&&a>0&&(a=(a-9999999999*r)%r-(0|a/r)*r)),o=e+a),h>o&&o>-h&&(o=0),o},oe={aqua:[0,255,255],lime:[0,255,0],silver:[192,192,192],black:[0,0,0],maroon:[128,0,0],teal:[0,128,128],blue:[0,0,255],navy:[0,0,128],white:[255,255,255],fuchsia:[255,0,255],olive:[128,128,0],yellow:[255,255,0],orange:[255,165,0],gray:[128,128,128],purple:[128,0,128],green:[0,128,0],red:[255,0,0],pink:[255,192,203],cyan:[0,255,255],transparent:[255,255,255,0]},le=function(t,e,i){return t=0>t?t+1:t>1?t-1:t,0|255*(1>6*t?e+6*(i-e)*t:.5>t?i:2>3*t?e+6*(i-e)*(2/3-t):e)+.5},he=a.parseColor=function(t,e){var i,s,r,n,a,o,l,h,_,u,c;if(t)if("number"==typeof t)i=[t>>16,255&t>>8,255&t];else{if(","===t.charAt(t.length-1)&&(t=t.substr(0,t.length-1)),oe[t])i=oe[t];else if("#"===t.charAt(0))4===t.length&&(s=t.charAt(1),r=t.charAt(2),n=t.charAt(3),t="#"+s+s+r+r+n+n),t=parseInt(t.substr(1),16),i=[t>>16,255&t>>8,255&t];else if("hsl"===t.substr(0,3))if(i=c=t.match(d),e){if(-1!==t.indexOf("="))return t.match(g)}else a=Number(i[0])%360/360,o=Number(i[1])/100,l=Number(i[2])/100,r=.5>=l?l*(o+1):l+o-l*o,s=2*l-r,i.length>3&&(i[3]=Number(t[3])),i[0]=le(a+1/3,s,r),i[1]=le(a,s,r),i[2]=le(a-1/3,s,r);else i=t.match(d)||oe.transparent;i[0]=Number(i[0]),i[1]=Number(i[1]),i[2]=Number(i[2]),i.length>3&&(i[3]=Number(i[3]))}else i=oe.black;return e&&!c&&(s=i[0]/255,r=i[1]/255,n=i[2]/255,h=Math.max(s,r,n),_=Math.min(s,r,n),l=(h+_)/2,h===_?a=o=0:(u=h-_,o=l>.5?u/(2-h-_):u/(h+_),a=h===s?(r-n)/u+(n>r?6:0):h===r?(n-s)/u+2:(s-r)/u+4,a*=60),i[0]=0|a+.5,i[1]=0|100*o+.5,i[2]=0|100*l+.5),i},_e=function(t,e){var i,s,r,n=t.match(ue)||[],a=0,o=n.length?"":t;for(i=0;n.length>i;i++)s=n[i],r=t.substr(a,t.indexOf(s,a)-a),a+=r.length+s.length,s=he(s,e),3===s.length&&s.push(1),o+=r+(e?"hsla("+s[0]+","+s[1]+"%,"+s[2]+"%,"+s[3]:"rgba("+s.join(","))+")";return o},ue="(?:\\b(?:(?:rgb|rgba|hsl|hsla)\\(.+?\\))|\\B#.+?\\b";for(h in oe)ue+="|"+h+"\\b";ue=RegExp(ue+")","gi"),a.colorStringFilter=function(t){var e,i=t[0]+t[1];ue.lastIndex=0,ue.test(i)&&(e=-1!==i.indexOf("hsl(")||-1!==i.indexOf("hsla("),t[0]=_e(t[0],e),t[1]=_e(t[1],e))},e.defaultStringFilter||(e.defaultStringFilter=a.colorStringFilter);var ce=function(t,e,i,s){if(null==t)return function(t){return t};var r,n=e?(t.match(ue)||[""])[0]:"",a=t.split(n).join("").match(v)||[],o=t.substr(0,t.indexOf(a[0])),l=")"===t.charAt(t.length-1)?")":"",h=-1!==t.indexOf(" ")?" ":",",_=a.length,u=_>0?a[0].replace(d,""):"";return _?r=e?function(t){var e,c,f,p;if("number"==typeof t)t+=u;else if(s&&M.test(t)){for(p=t.replace(M,"|").split("|"),f=0;p.length>f;f++)p[f]=r(p[f]);return p.join(",")}if(e=(t.match(ue)||[n])[0],c=t.split(e).join("").match(v)||[],f=c.length,_>f--)for(;_>++f;)c[f]=i?c[0|(f-1)/2]:a[f];return o+c.join(h)+h+e+l+(-1!==t.indexOf("inset")?" inset":"")}:function(t){var e,n,c;if("number"==typeof t)t+=u;else if(s&&M.test(t)){for(n=t.replace(M,"|").split("|"),c=0;n.length>c;c++)n[c]=r(n[c]);return n.join(",")}if(e=t.match(v)||[],c=e.length,_>c--)for(;_>++c;)e[c]=i?e[0|(c-1)/2]:a[c];return o+e.join(h)+l}:function(t){return t}},fe=function(t){return t=t.split(","),function(e,i,s,r,n,a,o){var l,h=(i+"").split(" ");for(o={},l=0;4>l;l++)o[t[l]]=h[l]=h[l]||h[(l-1)/2>>0];return r.parse(e,o,n,a)}},pe=(B._setPluginRatio=function(t){this.plugin.setRatio(t);for(var e,i,s,r,n=this.data,a=n.proxy,o=n.firstMPT,l=1e-6;o;)e=a[o.v],o.r?e=Math.round(e):l>e&&e>-l&&(e=0),o.t[o.p]=e,o=o._next;if(n.autoRotate&&(n.autoRotate.rotation=a.rotation),1===t)for(o=n.firstMPT;o;){if(i=o.t,i.type){if(1===i.type){for(r=i.xs0+i.s+i.xs1,s=1;i.l>s;s++)r+=i["xn"+s]+i["xs"+(s+1)];i.e=r}}else i.e=i.s+i.xs0;o=o._next}},function(t,e,i,s,r){this.t=t,this.p=e,this.v=i,this.r=r,s&&(s._prev=this,this._next=s)}),me=(B._parseToProxy=function(t,e,i,s,r,n){var a,o,l,h,_,u=s,c={},f={},p=i._transform,m=I;for(i._transform=null,I=e,s=_=i.parse(t,e,s,r),I=m,n&&(i._transform=p,u&&(u._prev=null,u._prev&&(u._prev._next=null)));s&&s!==u;){if(1>=s.type&&(o=s.p,f[o]=s.s+s.c,c[o]=s.s,n||(h=new pe(s,"s",o,h,s.r),s.c=0),1===s.type))for(a=s.l;--a>0;)l="xn"+a,o=s.p+"_"+l,f[o]=s.data[l],c[o]=s[l],n||(h=new pe(s,l,o,h,s.rxp[l]));s=s._next}return{proxy:c,end:f,firstMPT:h,pt:_}},B.CSSPropTween=function(t,e,s,r,a,o,l,h,_,u,c){this.t=t,this.p=e,this.s=s,this.c=r,this.n=l||e,t instanceof me||n.push(this.n),this.r=h,this.type=o||0,_&&(this.pr=_,i=!0),this.b=void 0===u?s:u,this.e=void 0===c?s+r:c,a&&(this._next=a,a._prev=this)}),de=function(t,e,i,s,r,n){var a=new me(t,e,i,s-i,r,-1,n);return a.b=i,a.e=a.xs0=s,a},ge=a.parseComplex=function(t,e,i,s,r,n,a,o,l,h){i=i||n||"",a=new me(t,e,0,0,a,h?2:1,null,!1,o,i,s),s+="";var u,c,f,p,m,v,y,T,x,w,b,P,k,S=i.split(", ").join(",").split(" "),R=s.split(", ").join(",").split(" "),O=S.length,A=_!==!1;for((-1!==s.indexOf(",")||-1!==i.indexOf(","))&&(S=S.join(" ").replace(M,", ").split(" "),R=R.join(" ").replace(M,", ").split(" "),O=S.length),O!==R.length&&(S=(n||"").split(" "),O=S.length),a.plugin=l,a.setRatio=h,ue.lastIndex=0,u=0;O>u;u++)if(p=S[u],m=R[u],T=parseFloat(p),T||0===T)a.appendXtra("",T,re(m,T),m.replace(g,""),A&&-1!==m.indexOf("px"),!0);else if(r&&ue.test(p))P=","===m.charAt(m.length-1)?"),":")",k=-1!==m.indexOf("hsl")&&Y,p=he(p,k),m=he(m,k),x=p.length+m.length>6,x&&!Y&&0===m[3]?(a["xs"+a.l]+=a.l?" transparent":"transparent",a.e=a.e.split(R[u]).join("transparent")):(Y||(x=!1),k?a.appendXtra(x?"hsla(":"hsl(",p[0],re(m[0],p[0]),",",!1,!0).appendXtra("",p[1],re(m[1],p[1]),"%,",!1).appendXtra("",p[2],re(m[2],p[2]),x?"%,":"%"+P,!1):a.appendXtra(x?"rgba(":"rgb(",p[0],m[0]-p[0],",",!0,!0).appendXtra("",p[1],m[1]-p[1],",",!0).appendXtra("",p[2],m[2]-p[2],x?",":P,!0),x&&(p=4>p.length?1:p[3],a.appendXtra("",p,(4>m.length?1:m[3])-p,P,!1))),ue.lastIndex=0;else if(v=p.match(d)){if(y=m.match(g),!y||y.length!==v.length)return a;for(f=0,c=0;v.length>c;c++)b=v[c],w=p.indexOf(b,f),a.appendXtra(p.substr(f,w-f),Number(b),re(y[c],b),"",A&&"px"===p.substr(w+b.length,2),0===c),f=w+b.length;a["xs"+a.l]+=p.substr(f)}else a["xs"+a.l]+=a.l?" "+p:p;if(-1!==s.indexOf("=")&&a.data){for(P=a.xs0+a.data.s,u=1;a.l>u;u++)P+=a["xs"+u]+a.data["xn"+u];a.e=P+a["xs"+u]}return a.l||(a.type=-1,a.xs0=a.e),a.xfirst||a},ve=9;for(h=me.prototype,h.l=h.pr=0;--ve>0;)h["xn"+ve]=0,h["xs"+ve]="";h.xs0="",h._next=h._prev=h.xfirst=h.data=h.plugin=h.setRatio=h.rxp=null,h.appendXtra=function(t,e,i,s,r,n){var a=this,o=a.l;return a["xs"+o]+=n&&o?" "+t:t||"",i||0===o||a.plugin?(a.l++,a.type=a.setRatio?2:1,a["xs"+a.l]=s||"",o>0?(a.data["xn"+o]=e+i,a.rxp["xn"+o]=r,a["xn"+o]=e,a.plugin||(a.xfirst=new me(a,"xn"+o,e,i,a.xfirst||a,0,a.n,r,a.pr),a.xfirst.xs0=0),a):(a.data={s:e+i},a.rxp={},a.s=e,a.c=i,a.r=r,a)):(a["xs"+o]+=e+(s||""),a)};var ye=function(t,e){e=e||{},this.p=e.prefix?W(t)||t:t,l[t]=l[this.p]=this,this.format=e.formatter||ce(e.defaultValue,e.color,e.collapsible,e.multi),e.parser&&(this.parse=e.parser),this.clrs=e.color,this.multi=e.multi,this.keyword=e.keyword,this.dflt=e.defaultValue,this.pr=e.priority||0},Te=B._registerComplexSpecialProp=function(t,e,i){"object"!=typeof e&&(e={parser:i});var s,r,n=t.split(","),a=e.defaultValue;for(i=i||[a],s=0;n.length>s;s++)e.prefix=0===s&&e.prefix,e.defaultValue=i[s]||a,r=new ye(n[s],e)},xe=function(t){if(!l[t]){var e=t.charAt(0).toUpperCase()+t.substr(1)+"Plugin";Te(t,{parser:function(t,i,s,r,n,a,h){var _=o.com.greensock.plugins[e];return _?(_._cssRegister(),l[s].parse(t,i,s,r,n,a,h)):(q("Error: "+e+" js file not loaded."),n)}})}};h=ye.prototype,h.parseComplex=function(t,e,i,s,r,n){var a,o,l,h,_,u,c=this.keyword;if(this.multi&&(M.test(i)||M.test(e)?(o=e.replace(M,"|").split("|"),l=i.replace(M,"|").split("|")):c&&(o=[e],l=[i])),l){for(h=l.length>o.length?l.length:o.length,a=0;h>a;a++)e=o[a]=o[a]||this.dflt,i=l[a]=l[a]||this.dflt,c&&(_=e.indexOf(c),u=i.indexOf(c),_!==u&&(-1===u?o[a]=o[a].split(c).join(""):-1===_&&(o[a]+=" "+c)));e=o.join(", "),i=l.join(", ")}return ge(t,this.p,e,i,this.clrs,this.dflt,s,this.pr,r,n)},h.parse=function(t,e,i,s,n,a){return this.parseComplex(t.style,this.format(Q(t,this.p,r,!1,this.dflt)),this.format(e),n,a)},a.registerSpecialProp=function(t,e,i){Te(t,{parser:function(t,s,r,n,a,o){var l=new me(t,r,0,0,a,2,r,!1,i);return l.plugin=o,l.setRatio=e(t,s,n._tween,r),l},priority:i})},a.useSVGTransformAttr=c||f;var we,be="scaleX,scaleY,scaleZ,x,y,z,skewX,skewY,rotation,rotationX,rotationY,perspective,xPercent,yPercent".split(","),Pe=W("transform"),ke=V+"transform",Se=W("transformOrigin"),Re=null!==W("perspective"),Oe=B.Transform=function(){this.perspective=parseFloat(a.defaultTransformPerspective)||0,this.force3D=a.defaultForce3D!==!1&&Re?a.defaultForce3D||"auto":!1},Ae=window.SVGElement,Ce=function(t,e,i){var s,r=E.createElementNS("http://www.w3.org/2000/svg",t),n=/([a-z])([A-Z])/g;for(s in i)r.setAttributeNS(null,s.replace(n,"$1-$2").toLowerCase(),i[s]);return e.appendChild(r),r},De=E.documentElement,Me=function(){var t,e,i,s=m||/Android/i.test(j)&&!window.chrome;return E.createElementNS&&!s&&(t=Ce("svg",De),e=Ce("rect",t,{width:100,height:50,x:100}),i=e.getBoundingClientRect().width,e.style[Se]="50% 50%",e.style[Pe]="scaleX(0.5)",s=i===e.getBoundingClientRect().width&&!(f&&Re),De.removeChild(t)),s}(),ze=function(t,e,i,s,r){var n,o,l,h,_,u,c,f,p,m,d,g,v,y,T=t._gsTransform,x=Ee(t,!0);T&&(v=T.xOrigin,y=T.yOrigin),(!s||2>(n=s.split(" ")).length)&&(c=t.getBBox(),e=se(e).split(" "),n=[(-1!==e[0].indexOf("%")?parseFloat(e[0])/100*c.width:parseFloat(e[0]))+c.x,(-1!==e[1].indexOf("%")?parseFloat(e[1])/100*c.height:parseFloat(e[1]))+c.y]),i.xOrigin=h=parseFloat(n[0]),i.yOrigin=_=parseFloat(n[1]),s&&x!==Ie&&(u=x[0],c=x[1],f=x[2],p=x[3],m=x[4],d=x[5],g=u*p-c*f,o=h*(p/g)+_*(-f/g)+(f*d-p*m)/g,l=h*(-c/g)+_*(u/g)-(u*d-c*m)/g,h=i.xOrigin=n[0]=o,_=i.yOrigin=n[1]=l),T&&(r||r!==!1&&a.defaultSmoothOrigin!==!1?(o=h-v,l=_-y,T.xOffset+=o*x[0]+l*x[2]-o,T.yOffset+=o*x[1]+l*x[3]-l):T.xOffset=T.yOffset=0),t.setAttribute("data-svg-origin",n.join(" "))},Fe=function(t){return!!(Ae&&"function"==typeof t.getBBox&&t.getCTM&&(!t.parentNode||t.parentNode.getBBox&&t.parentNode.getCTM))},Ie=[1,0,0,1,0,0],Ee=function(t,e){var i,s,r,n,a,o=t._gsTransform||new Oe,l=1e5;if(Pe?s=Q(t,ke,null,!0):t.currentStyle&&(s=t.currentStyle.filter.match(C),s=s&&4===s.length?[s[0].substr(4),Number(s[2].substr(4)),Number(s[1].substr(4)),s[3].substr(4),o.x||0,o.y||0].join(","):""),i=!s||"none"===s||"matrix(1, 0, 0, 1, 0, 0)"===s,(o.svg||t.getBBox&&Fe(t))&&(i&&-1!==(t.style[Pe]+"").indexOf("matrix")&&(s=t.style[Pe],i=0),r=t.getAttribute("transform"),i&&r&&(-1!==r.indexOf("matrix")?(s=r,i=0):-1!==r.indexOf("translate")&&(s="matrix(1,0,0,1,"+r.match(/(?:\-|\b)[\d\-\.e]+\b/gi).join(",")+")",i=0))),i)return Ie;for(r=(s||"").match(/(?:\-|\b)[\d\-\.e]+\b/gi)||[],ve=r.length;--ve>-1;)n=Number(r[ve]),r[ve]=(a=n-(n|=0))?(0|a*l+(0>a?-.5:.5))/l+n:n;return e&&r.length>6?[r[0],r[1],r[4],r[5],r[12],r[13]]:r},Ne=B.getTransform=function(t,i,s,n){if(t._gsTransform&&s&&!n)return t._gsTransform;var o,l,h,_,u,c,f=s?t._gsTransform||new Oe:new Oe,p=0>f.scaleX,m=2e-5,d=1e5,g=Re?parseFloat(Q(t,Se,i,!1,"0 0 0").split(" ")[2])||f.zOrigin||0:0,v=parseFloat(a.defaultTransformPerspective)||0;if(f.svg=!(!t.getBBox||!Fe(t)),f.svg&&(ze(t,Q(t,Se,r,!1,"50% 50%")+"",f,t.getAttribute("data-svg-origin")),we=a.useSVGTransformAttr||Me),o=Ee(t),o!==Ie){if(16===o.length){var y,T,x,w,b,P=o[0],k=o[1],S=o[2],R=o[3],O=o[4],A=o[5],C=o[6],D=o[7],M=o[8],z=o[9],I=o[10],E=o[12],N=o[13],L=o[14],X=o[11],B=Math.atan2(C,I);f.zOrigin&&(L=-f.zOrigin,E=M*L-o[12],N=z*L-o[13],L=I*L+f.zOrigin-o[14]),f.rotationX=B*F,B&&(w=Math.cos(-B),b=Math.sin(-B),y=O*w+M*b,T=A*w+z*b,x=C*w+I*b,M=O*-b+M*w,z=A*-b+z*w,I=C*-b+I*w,X=D*-b+X*w,O=y,A=T,C=x),B=Math.atan2(M,I),f.rotationY=B*F,B&&(w=Math.cos(-B),b=Math.sin(-B),y=P*w-M*b,T=k*w-z*b,x=S*w-I*b,z=k*b+z*w,I=S*b+I*w,X=R*b+X*w,P=y,k=T,S=x),B=Math.atan2(k,P),f.rotation=B*F,B&&(w=Math.cos(-B),b=Math.sin(-B),P=P*w+O*b,T=k*w+A*b,A=k*-b+A*w,C=S*-b+C*w,k=T),f.rotationX&&Math.abs(f.rotationX)+Math.abs(f.rotation)>359.9&&(f.rotationX=f.rotation=0,f.rotationY+=180),f.scaleX=(0|Math.sqrt(P*P+k*k)*d+.5)/d,f.scaleY=(0|Math.sqrt(A*A+z*z)*d+.5)/d,f.scaleZ=(0|Math.sqrt(C*C+I*I)*d+.5)/d,f.skewX=0,f.perspective=X?1/(0>X?-X:X):0,f.x=E,f.y=N,f.z=L,f.svg&&(f.x-=f.xOrigin-(f.xOrigin*P-f.yOrigin*O),f.y-=f.yOrigin-(f.yOrigin*k-f.xOrigin*A))}else if(!(Re&&!n&&o.length&&f.x===o[4]&&f.y===o[5]&&(f.rotationX||f.rotationY)||void 0!==f.x&&"none"===Q(t,"display",i))){var j=o.length>=6,Y=j?o[0]:1,U=o[1]||0,q=o[2]||0,V=j?o[3]:1;f.x=o[4]||0,f.y=o[5]||0,h=Math.sqrt(Y*Y+U*U),_=Math.sqrt(V*V+q*q),u=Y||U?Math.atan2(U,Y)*F:f.rotation||0,c=q||V?Math.atan2(q,V)*F+u:f.skewX||0,Math.abs(c)>90&&270>Math.abs(c)&&(p?(h*=-1,c+=0>=u?180:-180,u+=0>=u?180:-180):(_*=-1,c+=0>=c?180:-180)),f.scaleX=h,f.scaleY=_,f.rotation=u,f.skewX=c,Re&&(f.rotationX=f.rotationY=f.z=0,f.perspective=v,f.scaleZ=1),f.svg&&(f.x-=f.xOrigin-(f.xOrigin*Y+f.yOrigin*q),f.y-=f.yOrigin-(f.xOrigin*U+f.yOrigin*V))}f.zOrigin=g;for(l in f)m>f[l]&&f[l]>-m&&(f[l]=0)}return s&&(t._gsTransform=f,f.svg&&(we&&t.style[Pe]?e.delayedCall(.001,function(){je(t.style,Pe)}):!we&&t.getAttribute("transform")&&e.delayedCall(.001,function(){t.removeAttribute("transform")}))),f},Le=function(t){var e,i,s=this.data,r=-s.rotation*z,n=r+s.skewX*z,a=1e5,o=(0|Math.cos(r)*s.scaleX*a)/a,l=(0|Math.sin(r)*s.scaleX*a)/a,h=(0|Math.sin(n)*-s.scaleY*a)/a,_=(0|Math.cos(n)*s.scaleY*a)/a,u=this.t.style,c=this.t.currentStyle;if(c){i=l,l=-h,h=-i,e=c.filter,u.filter="";var f,p,d=this.t.offsetWidth,g=this.t.offsetHeight,v="absolute"!==c.position,y="progid:DXImageTransform.Microsoft.Matrix(M11="+o+", M12="+l+", M21="+h+", M22="+_,w=s.x+d*s.xPercent/100,b=s.y+g*s.yPercent/100;if(null!=s.ox&&(f=(s.oxp?.01*d*s.ox:s.ox)-d/2,p=(s.oyp?.01*g*s.oy:s.oy)-g/2,w+=f-(f*o+p*l),b+=p-(f*h+p*_)),v?(f=d/2,p=g/2,y+=", Dx="+(f-(f*o+p*l)+w)+", Dy="+(p-(f*h+p*_)+b)+")"):y+=", sizingMethod='auto expand')",u.filter=-1!==e.indexOf("DXImageTransform.Microsoft.Matrix(")?e.replace(D,y):y+" "+e,(0===t||1===t)&&1===o&&0===l&&0===h&&1===_&&(v&&-1===y.indexOf("Dx=0, Dy=0")||x.test(e)&&100!==parseFloat(RegExp.$1)||-1===e.indexOf("gradient("&&e.indexOf("Alpha"))&&u.removeAttribute("filter")),!v){var P,k,S,R=8>m?1:-1;for(f=s.ieOffsetX||0,p=s.ieOffsetY||0,s.ieOffsetX=Math.round((d-((0>o?-o:o)*d+(0>l?-l:l)*g))/2+w),s.ieOffsetY=Math.round((g-((0>_?-_:_)*g+(0>h?-h:h)*d))/2+b),ve=0;4>ve;ve++)k=ee[ve],P=c[k],i=-1!==P.indexOf("px")?parseFloat(P):$(this.t,k,parseFloat(P),P.replace(T,""))||0,S=i!==s[k]?2>ve?-s.ieOffsetX:-s.ieOffsetY:2>ve?f-s.ieOffsetX:p-s.ieOffsetY,u[k]=(s[k]=Math.round(i-S*(0===ve||2===ve?1:R)))+"px"}}},Xe=B.set3DTransformRatio=B.setTransformRatio=function(t){var e,i,s,r,n,a,o,l,h,_,u,c,p,m,d,g,v,y,T,x,w,b,P,k=this.data,S=this.t.style,R=k.rotation,O=k.rotationX,A=k.rotationY,C=k.scaleX,D=k.scaleY,M=k.scaleZ,F=k.x,I=k.y,E=k.z,N=k.svg,L=k.perspective,X=k.force3D;if(!(((1!==t&&0!==t||"auto"!==X||this.tween._totalTime!==this.tween._totalDuration&&this.tween._totalTime)&&X||E||L||A||O)&&(!we||!N)&&Re))return R||k.skewX||N?(R*=z,b=k.skewX*z,P=1e5,e=Math.cos(R)*C,r=Math.sin(R)*C,i=Math.sin(R-b)*-D,n=Math.cos(R-b)*D,b&&"simple"===k.skewType&&(v=Math.tan(b),v=Math.sqrt(1+v*v),i*=v,n*=v,k.skewY&&(e*=v,r*=v)),N&&(F+=k.xOrigin-(k.xOrigin*e+k.yOrigin*i)+k.xOffset,I+=k.yOrigin-(k.xOrigin*r+k.yOrigin*n)+k.yOffset,we&&(k.xPercent||k.yPercent)&&(m=this.t.getBBox(),F+=.01*k.xPercent*m.width,I+=.01*k.yPercent*m.height),m=1e-6,m>F&&F>-m&&(F=0),m>I&&I>-m&&(I=0)),T=(0|e*P)/P+","+(0|r*P)/P+","+(0|i*P)/P+","+(0|n*P)/P+","+F+","+I+")",N&&we?this.t.setAttribute("transform","matrix("+T):S[Pe]=(k.xPercent||k.yPercent?"translate("+k.xPercent+"%,"+k.yPercent+"%) matrix(":"matrix(")+T):S[Pe]=(k.xPercent||k.yPercent?"translate("+k.xPercent+"%,"+k.yPercent+"%) matrix(":"matrix(")+C+",0,0,"+D+","+F+","+I+")",void 0;if(f&&(m=1e-4,m>C&&C>-m&&(C=M=2e-5),m>D&&D>-m&&(D=M=2e-5),!L||k.z||k.rotationX||k.rotationY||(L=0)),R||k.skewX)R*=z,d=e=Math.cos(R),g=r=Math.sin(R),k.skewX&&(R-=k.skewX*z,d=Math.cos(R),g=Math.sin(R),"simple"===k.skewType&&(v=Math.tan(k.skewX*z),v=Math.sqrt(1+v*v),d*=v,g*=v,k.skewY&&(e*=v,r*=v))),i=-g,n=d;else{if(!(A||O||1!==M||L||N))return S[Pe]=(k.xPercent||k.yPercent?"translate("+k.xPercent+"%,"+k.yPercent+"%) translate3d(":"translate3d(")+F+"px,"+I+"px,"+E+"px)"+(1!==C||1!==D?" scale("+C+","+D+")":""),void 0;e=n=1,i=r=0}h=1,s=a=o=l=_=u=0,c=L?-1/L:0,p=k.zOrigin,m=1e-6,x=",",w="0",R=A*z,R&&(d=Math.cos(R),g=Math.sin(R),o=-g,_=c*-g,s=e*g,a=r*g,h=d,c*=d,e*=d,r*=d),R=O*z,R&&(d=Math.cos(R),g=Math.sin(R),v=i*d+s*g,y=n*d+a*g,l=h*g,u=c*g,s=i*-g+s*d,a=n*-g+a*d,h*=d,c*=d,i=v,n=y),1!==M&&(s*=M,a*=M,h*=M,c*=M),1!==D&&(i*=D,n*=D,l*=D,u*=D),1!==C&&(e*=C,r*=C,o*=C,_*=C),(p||N)&&(p&&(F+=s*-p,I+=a*-p,E+=h*-p+p),N&&(F+=k.xOrigin-(k.xOrigin*e+k.yOrigin*i)+k.xOffset,I+=k.yOrigin-(k.xOrigin*r+k.yOrigin*n)+k.yOffset),m>F&&F>-m&&(F=w),m>I&&I>-m&&(I=w),m>E&&E>-m&&(E=0)),T=k.xPercent||k.yPercent?"translate("+k.xPercent+"%,"+k.yPercent+"%) matrix3d(":"matrix3d(",T+=(m>e&&e>-m?w:e)+x+(m>r&&r>-m?w:r)+x+(m>o&&o>-m?w:o),T+=x+(m>_&&_>-m?w:_)+x+(m>i&&i>-m?w:i)+x+(m>n&&n>-m?w:n),O||A?(T+=x+(m>l&&l>-m?w:l)+x+(m>u&&u>-m?w:u)+x+(m>s&&s>-m?w:s),T+=x+(m>a&&a>-m?w:a)+x+(m>h&&h>-m?w:h)+x+(m>c&&c>-m?w:c)+x):T+=",0,0,0,0,1,0,",T+=F+x+I+x+E+x+(L?1+-E/L:1)+")",S[Pe]=T};h=Oe.prototype,h.x=h.y=h.z=h.skewX=h.skewY=h.rotation=h.rotationX=h.rotationY=h.zOrigin=h.xPercent=h.yPercent=h.xOffset=h.yOffset=0,h.scaleX=h.scaleY=h.scaleZ=1,Te("transform,scale,scaleX,scaleY,scaleZ,x,y,z,rotation,rotationX,rotationY,rotationZ,skewX,skewY,shortRotation,shortRotationX,shortRotationY,shortRotationZ,transformOrigin,svgOrigin,transformPerspective,directionalRotation,parseTransform,force3D,skewType,xPercent,yPercent,smoothOrigin",{parser:function(t,e,i,s,n,o,l){if(s._lastParsedTransform===l)return n;s._lastParsedTransform=l;var h,_,u,c,f,p,m,d,g,v,y=t._gsTransform,T=t.style,x=1e-6,w=be.length,b=l,P={},k="transformOrigin";if(l.display?(c=Q(t,"display"),T.display="block",h=Ne(t,r,!0,l.parseTransform),T.display=c):h=Ne(t,r,!0,l.parseTransform),s._transform=h,"string"==typeof b.transform&&Pe)c=L.style,c[Pe]=b.transform,c.display="block",c.position="absolute",E.body.appendChild(L),_=Ne(L,null,!1),E.body.removeChild(L),_.perspective||(_.perspective=h.perspective),null!=b.xPercent&&(_.xPercent=ne(b.xPercent,h.xPercent)),null!=b.yPercent&&(_.yPercent=ne(b.yPercent,h.yPercent));else if("object"==typeof b){if(_={scaleX:ne(null!=b.scaleX?b.scaleX:b.scale,h.scaleX),scaleY:ne(null!=b.scaleY?b.scaleY:b.scale,h.scaleY),scaleZ:ne(b.scaleZ,h.scaleZ),x:ne(b.x,h.x),y:ne(b.y,h.y),z:ne(b.z,h.z),xPercent:ne(b.xPercent,h.xPercent),yPercent:ne(b.yPercent,h.yPercent),perspective:ne(b.transformPerspective,h.perspective)},d=b.directionalRotation,null!=d)if("object"==typeof d)for(c in d)b[c]=d[c];else b.rotation=d;"string"==typeof b.x&&-1!==b.x.indexOf("%")&&(_.x=0,_.xPercent=ne(b.x,h.xPercent)),"string"==typeof b.y&&-1!==b.y.indexOf("%")&&(_.y=0,_.yPercent=ne(b.y,h.yPercent)),_.rotation=ae("rotation"in b?b.rotation:"shortRotation"in b?b.shortRotation+"_short":"rotationZ"in b?b.rotationZ:h.rotation,h.rotation,"rotation",P),Re&&(_.rotationX=ae("rotationX"in b?b.rotationX:"shortRotationX"in b?b.shortRotationX+"_short":h.rotationX||0,h.rotationX,"rotationX",P),_.rotationY=ae("rotationY"in b?b.rotationY:"shortRotationY"in b?b.shortRotationY+"_short":h.rotationY||0,h.rotationY,"rotationY",P)),_.skewX=null==b.skewX?h.skewX:ae(b.skewX,h.skewX),_.skewY=null==b.skewY?h.skewY:ae(b.skewY,h.skewY),(u=_.skewY-h.skewY)&&(_.skewX+=u,_.rotation+=u)}for(Re&&null!=b.force3D&&(h.force3D=b.force3D,m=!0),h.skewType=b.skewType||h.skewType||a.defaultSkewType,p=h.force3D||h.z||h.rotationX||h.rotationY||_.z||_.rotationX||_.rotationY||_.perspective,p||null==b.scale||(_.scaleZ=1);--w>-1;)i=be[w],f=_[i]-h[i],(f>x||-x>f||null!=b[i]||null!=I[i])&&(m=!0,n=new me(h,i,h[i],f,n),i in P&&(n.e=P[i]),n.xs0=0,n.plugin=o,s._overwriteProps.push(n.n));return f=b.transformOrigin,h.svg&&(f||b.svgOrigin)&&(g=h.xOffset,v=h.yOffset,ze(t,se(f),_,b.svgOrigin,b.smoothOrigin),n=de(h,"xOrigin",(y?h:_).xOrigin,_.xOrigin,n,k),n=de(h,"yOrigin",(y?h:_).yOrigin,_.yOrigin,n,k),(g!==h.xOffset||v!==h.yOffset)&&(n=de(h,"xOffset",y?g:h.xOffset,h.xOffset,n,k),n=de(h,"yOffset",y?v:h.yOffset,h.yOffset,n,k)),f=we?null:"0px 0px"),(f||Re&&p&&h.zOrigin)&&(Pe?(m=!0,i=Se,f=(f||Q(t,i,r,!1,"50% 50%"))+"",n=new me(T,i,0,0,n,-1,k),n.b=T[i],n.plugin=o,Re?(c=h.zOrigin,f=f.split(" "),h.zOrigin=(f.length>2&&(0===c||"0px"!==f[2])?parseFloat(f[2]):c)||0,n.xs0=n.e=f[0]+" "+(f[1]||"50%")+" 0px",n=new me(h,"zOrigin",0,0,n,-1,n.n),n.b=c,n.xs0=n.e=h.zOrigin):n.xs0=n.e=f):se(f+"",h)),m&&(s._transformType=h.svg&&we||!p&&3!==this._transformType?2:3),n},prefix:!0}),Te("boxShadow",{defaultValue:"0px 0px 0px 0px #999",prefix:!0,color:!0,multi:!0,keyword:"inset"}),Te("borderRadius",{defaultValue:"0px",parser:function(t,e,i,n,a){e=this.format(e);var o,l,h,_,u,c,f,p,m,d,g,v,y,T,x,w,b=["borderTopLeftRadius","borderTopRightRadius","borderBottomRightRadius","borderBottomLeftRadius"],P=t.style;for(m=parseFloat(t.offsetWidth),d=parseFloat(t.offsetHeight),o=e.split(" "),l=0;b.length>l;l++)this.p.indexOf("border")&&(b[l]=W(b[l])),u=_=Q(t,b[l],r,!1,"0px"),-1!==u.indexOf(" ")&&(_=u.split(" "),u=_[0],_=_[1]),c=h=o[l],f=parseFloat(u),v=u.substr((f+"").length),y="="===c.charAt(1),y?(p=parseInt(c.charAt(0)+"1",10),c=c.substr(2),p*=parseFloat(c),g=c.substr((p+"").length-(0>p?1:0))||""):(p=parseFloat(c),g=c.substr((p+"").length)),""===g&&(g=s[i]||v),g!==v&&(T=$(t,"borderLeft",f,v),x=$(t,"borderTop",f,v),"%"===g?(u=100*(T/m)+"%",_=100*(x/d)+"%"):"em"===g?(w=$(t,"borderLeft",1,"em"),u=T/w+"em",_=x/w+"em"):(u=T+"px",_=x+"px"),y&&(c=parseFloat(u)+p+g,h=parseFloat(_)+p+g)),a=ge(P,b[l],u+" "+_,c+" "+h,!1,"0px",a);return a},prefix:!0,formatter:ce("0px 0px 0px 0px",!1,!0)}),Te("backgroundPosition",{defaultValue:"0 0",parser:function(t,e,i,s,n,a){var o,l,h,_,u,c,f="background-position",p=r||Z(t,null),d=this.format((p?m?p.getPropertyValue(f+"-x")+" "+p.getPropertyValue(f+"-y"):p.getPropertyValue(f):t.currentStyle.backgroundPositionX+" "+t.currentStyle.backgroundPositionY)||"0 0"),g=this.format(e);

if(-1!==d.indexOf("%")!=(-1!==g.indexOf("%"))&&(c=Q(t,"backgroundImage").replace(R,""),c&&"none"!==c)){for(o=d.split(" "),l=g.split(" "),X.setAttribute("src",c),h=2;--h>-1;)d=o[h],_=-1!==d.indexOf("%"),_!==(-1!==l[h].indexOf("%"))&&(u=0===h?t.offsetWidth-X.width:t.offsetHeight-X.height,o[h]=_?parseFloat(d)/100*u+"px":100*(parseFloat(d)/u)+"%");d=o.join(" ")}return this.parseComplex(t.style,d,g,n,a)},formatter:se}),Te("backgroundSize",{defaultValue:"0 0",formatter:se}),Te("perspective",{defaultValue:"0px",prefix:!0}),Te("perspectiveOrigin",{defaultValue:"50% 50%",prefix:!0}),Te("transformStyle",{prefix:!0}),Te("backfaceVisibility",{prefix:!0}),Te("userSelect",{prefix:!0}),Te("margin",{parser:fe("marginTop,marginRight,marginBottom,marginLeft")}),Te("padding",{parser:fe("paddingTop,paddingRight,paddingBottom,paddingLeft")}),Te("clip",{defaultValue:"rect(0px,0px,0px,0px)",parser:function(t,e,i,s,n,a){var o,l,h;return 9>m?(l=t.currentStyle,h=8>m?" ":",",o="rect("+l.clipTop+h+l.clipRight+h+l.clipBottom+h+l.clipLeft+")",e=this.format(e).split(",").join(h)):(o=this.format(Q(t,this.p,r,!1,this.dflt)),e=this.format(e)),this.parseComplex(t.style,o,e,n,a)}}),Te("textShadow",{defaultValue:"0px 0px 0px #999",color:!0,multi:!0}),Te("autoRound,strictUnits",{parser:function(t,e,i,s,r){return r}}),Te("border",{defaultValue:"0px solid #000",parser:function(t,e,i,s,n,a){return this.parseComplex(t.style,this.format(Q(t,"borderTopWidth",r,!1,"0px")+" "+Q(t,"borderTopStyle",r,!1,"solid")+" "+Q(t,"borderTopColor",r,!1,"#000")),this.format(e),n,a)},color:!0,formatter:function(t){var e=t.split(" ");return e[0]+" "+(e[1]||"solid")+" "+(t.match(ue)||["#000"])[0]}}),Te("borderWidth",{parser:fe("borderTopWidth,borderRightWidth,borderBottomWidth,borderLeftWidth")}),Te("float,cssFloat,styleFloat",{parser:function(t,e,i,s,r){var n=t.style,a="cssFloat"in n?"cssFloat":"styleFloat";return new me(n,a,0,0,r,-1,i,!1,0,n[a],e)}});var Be=function(t){var e,i=this.t,s=i.filter||Q(this.data,"filter")||"",r=0|this.s+this.c*t;100===r&&(-1===s.indexOf("atrix(")&&-1===s.indexOf("radient(")&&-1===s.indexOf("oader(")?(i.removeAttribute("filter"),e=!Q(this.data,"filter")):(i.filter=s.replace(b,""),e=!0)),e||(this.xn1&&(i.filter=s=s||"alpha(opacity="+r+")"),-1===s.indexOf("pacity")?0===r&&this.xn1||(i.filter=s+" alpha(opacity="+r+")"):i.filter=s.replace(x,"opacity="+r))};Te("opacity,alpha,autoAlpha",{defaultValue:"1",parser:function(t,e,i,s,n,a){var o=parseFloat(Q(t,"opacity",r,!1,"1")),l=t.style,h="autoAlpha"===i;return"string"==typeof e&&"="===e.charAt(1)&&(e=("-"===e.charAt(0)?-1:1)*parseFloat(e.substr(2))+o),h&&1===o&&"hidden"===Q(t,"visibility",r)&&0!==e&&(o=0),Y?n=new me(l,"opacity",o,e-o,n):(n=new me(l,"opacity",100*o,100*(e-o),n),n.xn1=h?1:0,l.zoom=1,n.type=2,n.b="alpha(opacity="+n.s+")",n.e="alpha(opacity="+(n.s+n.c)+")",n.data=t,n.plugin=a,n.setRatio=Be),h&&(n=new me(l,"visibility",0,0,n,-1,null,!1,0,0!==o?"inherit":"hidden",0===e?"hidden":"inherit"),n.xs0="inherit",s._overwriteProps.push(n.n),s._overwriteProps.push(i)),n}});var je=function(t,e){e&&(t.removeProperty?(("ms"===e.substr(0,2)||"webkit"===e.substr(0,6))&&(e="-"+e),t.removeProperty(e.replace(k,"-$1").toLowerCase())):t.removeAttribute(e))},Ye=function(t){if(this.t._gsClassPT=this,1===t||0===t){this.t.setAttribute("class",0===t?this.b:this.e);for(var e=this.data,i=this.t.style;e;)e.v?i[e.p]=e.v:je(i,e.p),e=e._next;1===t&&this.t._gsClassPT===this&&(this.t._gsClassPT=null)}else this.t.getAttribute("class")!==this.e&&this.t.setAttribute("class",this.e)};Te("className",{parser:function(t,e,s,n,a,o,l){var h,_,u,c,f,p=t.getAttribute("class")||"",m=t.style.cssText;if(a=n._classNamePT=new me(t,s,0,0,a,2),a.setRatio=Ye,a.pr=-11,i=!0,a.b=p,_=K(t,r),u=t._gsClassPT){for(c={},f=u.data;f;)c[f.p]=1,f=f._next;u.setRatio(1)}return t._gsClassPT=a,a.e="="!==e.charAt(1)?e:p.replace(RegExp("\\s*\\b"+e.substr(2)+"\\b"),"")+("+"===e.charAt(0)?" "+e.substr(2):""),t.setAttribute("class",a.e),h=J(t,_,K(t),l,c),t.setAttribute("class",p),a.data=h.firstMPT,t.style.cssText=m,a=a.xfirst=n.parse(t,h.difs,a,o)}});var Ue=function(t){if((1===t||0===t)&&this.data._totalTime===this.data._totalDuration&&"isFromStart"!==this.data.data){var e,i,s,r,n,a=this.t.style,o=l.transform.parse;if("all"===this.e)a.cssText="",r=!0;else for(e=this.e.split(" ").join("").split(","),s=e.length;--s>-1;)i=e[s],l[i]&&(l[i].parse===o?r=!0:i="transformOrigin"===i?Se:l[i].p),je(a,i);r&&(je(a,Pe),n=this.t._gsTransform,n&&(n.svg&&this.t.removeAttribute("data-svg-origin"),delete this.t._gsTransform))}};for(Te("clearProps",{parser:function(t,e,s,r,n){return n=new me(t,s,0,0,n,2),n.setRatio=Ue,n.e=e,n.pr=-10,n.data=r._tween,i=!0,n}}),h="bezier,throwProps,physicsProps,physics2D".split(","),ve=h.length;ve--;)xe(h[ve]);h=a.prototype,h._firstPT=h._lastParsedTransform=h._transform=null,h._onInitTween=function(t,e,o){if(!t.nodeType)return!1;this._target=t,this._tween=o,this._vars=e,_=e.autoRound,i=!1,s=e.suffixMap||a.suffixMap,r=Z(t,""),n=this._overwriteProps;var h,f,m,d,g,v,y,T,x,b=t.style;if(u&&""===b.zIndex&&(h=Q(t,"zIndex",r),("auto"===h||""===h)&&this._addLazySet(b,"zIndex",0)),"string"==typeof e&&(d=b.cssText,h=K(t,r),b.cssText=d+";"+e,h=J(t,h,K(t)).difs,!Y&&w.test(e)&&(h.opacity=parseFloat(RegExp.$1)),e=h,b.cssText=d),this._firstPT=f=e.className?l.className.parse(t,e.className,"className",this,null,null,e):this.parse(t,e,null),this._transformType){for(x=3===this._transformType,Pe?c&&(u=!0,""===b.zIndex&&(y=Q(t,"zIndex",r),("auto"===y||""===y)&&this._addLazySet(b,"zIndex",0)),p&&this._addLazySet(b,"WebkitBackfaceVisibility",this._vars.WebkitBackfaceVisibility||(x?"visible":"hidden"))):b.zoom=1,m=f;m&&m._next;)m=m._next;T=new me(t,"transform",0,0,null,2),this._linkCSSP(T,null,m),T.setRatio=Pe?Xe:Le,T.data=this._transform||Ne(t,r,!0),T.tween=o,T.pr=-1,n.pop()}if(i){for(;f;){for(v=f._next,m=d;m&&m.pr>f.pr;)m=m._next;(f._prev=m?m._prev:g)?f._prev._next=f:d=f,(f._next=m)?m._prev=f:g=f,f=v}this._firstPT=d}return!0},h.parse=function(t,e,i,n){var a,o,h,u,c,f,p,m,d,g,v=t.style;for(a in e)f=e[a],o=l[a],o?i=o.parse(t,f,a,this,i,n,e):(c=Q(t,a,r)+"",d="string"==typeof f,"color"===a||"fill"===a||"stroke"===a||-1!==a.indexOf("Color")||d&&P.test(f)?(d||(f=he(f),f=(f.length>3?"rgba(":"rgb(")+f.join(",")+")"),i=ge(v,a,c,f,!0,"transparent",i,0,n)):!d||-1===f.indexOf(" ")&&-1===f.indexOf(",")?(h=parseFloat(c),p=h||0===h?c.substr((h+"").length):"",(""===c||"auto"===c)&&("width"===a||"height"===a?(h=ie(t,a,r),p="px"):"left"===a||"top"===a?(h=H(t,a,r),p="px"):(h="opacity"!==a?0:1,p="")),g=d&&"="===f.charAt(1),g?(u=parseInt(f.charAt(0)+"1",10),f=f.substr(2),u*=parseFloat(f),m=f.replace(T,"")):(u=parseFloat(f),m=d?f.replace(T,""):""),""===m&&(m=a in s?s[a]:p),f=u||0===u?(g?u+h:u)+m:e[a],p!==m&&""!==m&&(u||0===u)&&h&&(h=$(t,a,h,p),"%"===m?(h/=$(t,a,100,"%")/100,e.strictUnits!==!0&&(c=h+"%")):"em"===m||"rem"===m?h/=$(t,a,1,m):"px"!==m&&(u=$(t,a,u,m),m="px"),g&&(u||0===u)&&(f=u+h+m)),g&&(u+=h),!h&&0!==h||!u&&0!==u?void 0!==v[a]&&(f||"NaN"!=f+""&&null!=f)?(i=new me(v,a,u||h||0,0,i,-1,a,!1,0,c,f),i.xs0="none"!==f||"display"!==a&&-1===a.indexOf("Style")?f:c):q("invalid "+a+" tween value: "+e[a]):(i=new me(v,a,h,u-h,i,0,a,_!==!1&&("px"===m||"zIndex"===a),0,c,f),i.xs0=m)):i=ge(v,a,c,f,!0,null,i,0,n)),n&&i&&!i.plugin&&(i.plugin=n);return i},h.setRatio=function(t){var e,i,s,r=this._firstPT,n=1e-6;if(1!==t||this._tween._time!==this._tween._duration&&0!==this._tween._time)if(t||this._tween._time!==this._tween._duration&&0!==this._tween._time||this._tween._rawPrevTime===-1e-6)for(;r;){if(e=r.c*t+r.s,r.r?e=Math.round(e):n>e&&e>-n&&(e=0),r.type)if(1===r.type)if(s=r.l,2===s)r.t[r.p]=r.xs0+e+r.xs1+r.xn1+r.xs2;else if(3===s)r.t[r.p]=r.xs0+e+r.xs1+r.xn1+r.xs2+r.xn2+r.xs3;else if(4===s)r.t[r.p]=r.xs0+e+r.xs1+r.xn1+r.xs2+r.xn2+r.xs3+r.xn3+r.xs4;else if(5===s)r.t[r.p]=r.xs0+e+r.xs1+r.xn1+r.xs2+r.xn2+r.xs3+r.xn3+r.xs4+r.xn4+r.xs5;else{for(i=r.xs0+e+r.xs1,s=1;r.l>s;s++)i+=r["xn"+s]+r["xs"+(s+1)];r.t[r.p]=i}else-1===r.type?r.t[r.p]=r.xs0:r.setRatio&&r.setRatio(t);else r.t[r.p]=e+r.xs0;r=r._next}else for(;r;)2!==r.type?r.t[r.p]=r.b:r.setRatio(t),r=r._next;else for(;r;){if(2!==r.type)if(r.r&&-1!==r.type)if(e=Math.round(r.s+r.c),r.type){if(1===r.type){for(s=r.l,i=r.xs0+e+r.xs1,s=1;r.l>s;s++)i+=r["xn"+s]+r["xs"+(s+1)];r.t[r.p]=i}}else r.t[r.p]=e+r.xs0;else r.t[r.p]=r.e;else r.setRatio(t);r=r._next}},h._enableTransforms=function(t){this._transform=this._transform||Ne(this._target,r,!0),this._transformType=this._transform.svg&&we||!t&&3!==this._transformType?2:3};var qe=function(){this.t[this.p]=this.e,this.data._linkCSSP(this,this._next,null,!0)};h._addLazySet=function(t,e,i){var s=this._firstPT=new me(t,e,0,0,this._firstPT,2);s.e=i,s.setRatio=qe,s.data=this},h._linkCSSP=function(t,e,i,s){return t&&(e&&(e._prev=t),t._next&&(t._next._prev=t._prev),t._prev?t._prev._next=t._next:this._firstPT===t&&(this._firstPT=t._next,s=!0),i?i._next=t:s||null!==this._firstPT||(this._firstPT=t),t._next=e,t._prev=i),t},h._kill=function(e){var i,s,r,n=e;if(e.autoAlpha||e.alpha){n={};for(s in e)n[s]=e[s];n.opacity=1,n.autoAlpha&&(n.visibility=1)}return e.className&&(i=this._classNamePT)&&(r=i.xfirst,r&&r._prev?this._linkCSSP(r._prev,i._next,r._prev._prev):r===this._firstPT&&(this._firstPT=i._next),i._next&&this._linkCSSP(i._next,i._next._next,r._prev),this._classNamePT=null),t.prototype._kill.call(this,n)};var Ve=function(t,e,i){var s,r,n,a;if(t.slice)for(r=t.length;--r>-1;)Ve(t[r],e,i);else for(s=t.childNodes,r=s.length;--r>-1;)n=s[r],a=n.type,n.style&&(e.push(K(n)),i&&i.push(n)),1!==a&&9!==a&&11!==a||!n.childNodes.length||Ve(n,e,i)};return a.cascadeTo=function(t,i,s){var r,n,a,o,l=e.to(t,i,s),h=[l],_=[],u=[],c=[],f=e._internals.reservedProps;for(t=l._targets||l.target,Ve(t,_,c),l.render(i,!0,!0),Ve(t,u),l.render(0,!0,!0),l._enabled(!0),r=c.length;--r>-1;)if(n=J(c[r],_[r],u[r]),n.firstMPT){n=n.difs;for(a in s)f[a]&&(n[a]=s[a]);o={};for(a in n)o[a]=_[r][a];h.push(e.fromTo(c[r],i,o,n))}return h},t.activate([a]),a},!0),function(){var t=_gsScope._gsDefine.plugin({propName:"roundProps",version:"1.5",priority:-1,API:2,init:function(t,e,i){return this._tween=i,!0}}),e=function(t){for(;t;)t.f||t.blob||(t.r=1),t=t._next},i=t.prototype;i._onInitAllProps=function(){for(var t,i,s,r=this._tween,n=r.vars.roundProps.join?r.vars.roundProps:r.vars.roundProps.split(","),a=n.length,o={},l=r._propLookup.roundProps;--a>-1;)o[n[a]]=1;for(a=n.length;--a>-1;)for(t=n[a],i=r._firstPT;i;)s=i._next,i.pg?i.t._roundProps(o,!0):i.n===t&&(2===i.f&&i.t?e(i.t._firstPT):(this._add(i.t,t,i.s,i.c),s&&(s._prev=i._prev),i._prev?i._prev._next=s:r._firstPT===i&&(r._firstPT=s),i._next=i._prev=null,r._propLookup[t]=l)),i=s;return!1},i._add=function(t,e,i,s){this._addTween(t,e,i,i+s,e,!0),this._overwriteProps.push(e)}}(),function(){_gsScope._gsDefine.plugin({propName:"attr",API:2,version:"0.5.0",init:function(t,e){var i;if("function"!=typeof t.setAttribute)return!1;for(i in e)this._addTween(t,"setAttribute",t.getAttribute(i)+"",e[i]+"",i,!1,i),this._overwriteProps.push(i);return!0}})}(),_gsScope._gsDefine.plugin({propName:"directionalRotation",version:"0.2.1",API:2,init:function(t,e){"object"!=typeof e&&(e={rotation:e}),this.finals={};var i,s,r,n,a,o,l=e.useRadians===!0?2*Math.PI:360,h=1e-6;for(i in e)"useRadians"!==i&&(o=(e[i]+"").split("_"),s=o[0],r=parseFloat("function"!=typeof t[i]?t[i]:t[i.indexOf("set")||"function"!=typeof t["get"+i.substr(3)]?i:"get"+i.substr(3)]()),n=this.finals[i]="string"==typeof s&&"="===s.charAt(1)?r+parseInt(s.charAt(0)+"1",10)*Number(s.substr(2)):Number(s)||0,a=n-r,o.length&&(s=o.join("_"),-1!==s.indexOf("short")&&(a%=l,a!==a%(l/2)&&(a=0>a?a+l:a-l)),-1!==s.indexOf("_cw")&&0>a?a=(a+9999999999*l)%l-(0|a/l)*l:-1!==s.indexOf("ccw")&&a>0&&(a=(a-9999999999*l)%l-(0|a/l)*l)),(a>h||-h>a)&&(this._addTween(t,i,r,r+a,i),this._overwriteProps.push(i)));return!0},set:function(t){var e;if(1!==t)this._super.setRatio.call(this,t);else for(e=this._firstPT;e;)e.f?e.t[e.p](this.finals[e.p]):e.t[e.p]=this.finals[e.p],e=e._next}})._autoCSS=!0,_gsScope._gsDefine("easing.Back",["easing.Ease"],function(t){var e,i,s,r=_gsScope.GreenSockGlobals||_gsScope,n=r.com.greensock,a=2*Math.PI,o=Math.PI/2,l=n._class,h=function(e,i){var s=l("easing."+e,function(){},!0),r=s.prototype=new t;return r.constructor=s,r.getRatio=i,s},_=t.register||function(){},u=function(t,e,i,s){var r=l("easing."+t,{easeOut:new e,easeIn:new i,easeInOut:new s},!0);return _(r,t),r},c=function(t,e,i){this.t=t,this.v=e,i&&(this.next=i,i.prev=this,this.c=i.v-e,this.gap=i.t-t)},f=function(e,i){var s=l("easing."+e,function(t){this._p1=t||0===t?t:1.70158,this._p2=1.525*this._p1},!0),r=s.prototype=new t;return r.constructor=s,r.getRatio=i,r.config=function(t){return new s(t)},s},p=u("Back",f("BackOut",function(t){return(t-=1)*t*((this._p1+1)*t+this._p1)+1}),f("BackIn",function(t){return t*t*((this._p1+1)*t-this._p1)}),f("BackInOut",function(t){return 1>(t*=2)?.5*t*t*((this._p2+1)*t-this._p2):.5*((t-=2)*t*((this._p2+1)*t+this._p2)+2)})),m=l("easing.SlowMo",function(t,e,i){e=e||0===e?e:.7,null==t?t=.7:t>1&&(t=1),this._p=1!==t?e:0,this._p1=(1-t)/2,this._p2=t,this._p3=this._p1+this._p2,this._calcEnd=i===!0},!0),d=m.prototype=new t;return d.constructor=m,d.getRatio=function(t){var e=t+(.5-t)*this._p;return this._p1>t?this._calcEnd?1-(t=1-t/this._p1)*t:e-(t=1-t/this._p1)*t*t*t*e:t>this._p3?this._calcEnd?1-(t=(t-this._p3)/this._p1)*t:e+(t-e)*(t=(t-this._p3)/this._p1)*t*t*t:this._calcEnd?1:e},m.ease=new m(.7,.7),d.config=m.config=function(t,e,i){return new m(t,e,i)},e=l("easing.SteppedEase",function(t){t=t||1,this._p1=1/t,this._p2=t+1},!0),d=e.prototype=new t,d.constructor=e,d.getRatio=function(t){return 0>t?t=0:t>=1&&(t=.999999999),(this._p2*t>>0)*this._p1},d.config=e.config=function(t){return new e(t)},i=l("easing.RoughEase",function(e){e=e||{};for(var i,s,r,n,a,o,l=e.taper||"none",h=[],_=0,u=0|(e.points||20),f=u,p=e.randomize!==!1,m=e.clamp===!0,d=e.template instanceof t?e.template:null,g="number"==typeof e.strength?.4*e.strength:.4;--f>-1;)i=p?Math.random():1/u*f,s=d?d.getRatio(i):i,"none"===l?r=g:"out"===l?(n=1-i,r=n*n*g):"in"===l?r=i*i*g:.5>i?(n=2*i,r=.5*n*n*g):(n=2*(1-i),r=.5*n*n*g),p?s+=Math.random()*r-.5*r:f%2?s+=.5*r:s-=.5*r,m&&(s>1?s=1:0>s&&(s=0)),h[_++]={x:i,y:s};for(h.sort(function(t,e){return t.x-e.x}),o=new c(1,1,null),f=u;--f>-1;)a=h[f],o=new c(a.x,a.y,o);this._prev=new c(0,0,0!==o.t?o:o.next)},!0),d=i.prototype=new t,d.constructor=i,d.getRatio=function(t){var e=this._prev;if(t>e.t){for(;e.next&&t>=e.t;)e=e.next;e=e.prev}else for(;e.prev&&e.t>=t;)e=e.prev;return this._prev=e,e.v+(t-e.t)/e.gap*e.c},d.config=function(t){return new i(t)},i.ease=new i,u("Bounce",h("BounceOut",function(t){return 1/2.75>t?7.5625*t*t:2/2.75>t?7.5625*(t-=1.5/2.75)*t+.75:2.5/2.75>t?7.5625*(t-=2.25/2.75)*t+.9375:7.5625*(t-=2.625/2.75)*t+.984375}),h("BounceIn",function(t){return 1/2.75>(t=1-t)?1-7.5625*t*t:2/2.75>t?1-(7.5625*(t-=1.5/2.75)*t+.75):2.5/2.75>t?1-(7.5625*(t-=2.25/2.75)*t+.9375):1-(7.5625*(t-=2.625/2.75)*t+.984375)}),h("BounceInOut",function(t){var e=.5>t;return t=e?1-2*t:2*t-1,t=1/2.75>t?7.5625*t*t:2/2.75>t?7.5625*(t-=1.5/2.75)*t+.75:2.5/2.75>t?7.5625*(t-=2.25/2.75)*t+.9375:7.5625*(t-=2.625/2.75)*t+.984375,e?.5*(1-t):.5*t+.5})),u("Circ",h("CircOut",function(t){return Math.sqrt(1-(t-=1)*t)}),h("CircIn",function(t){return-(Math.sqrt(1-t*t)-1)}),h("CircInOut",function(t){return 1>(t*=2)?-.5*(Math.sqrt(1-t*t)-1):.5*(Math.sqrt(1-(t-=2)*t)+1)})),s=function(e,i,s){var r=l("easing."+e,function(t,e){this._p1=t>=1?t:1,this._p2=(e||s)/(1>t?t:1),this._p3=this._p2/a*(Math.asin(1/this._p1)||0),this._p2=a/this._p2},!0),n=r.prototype=new t;return n.constructor=r,n.getRatio=i,n.config=function(t,e){return new r(t,e)},r},u("Elastic",s("ElasticOut",function(t){return this._p1*Math.pow(2,-10*t)*Math.sin((t-this._p3)*this._p2)+1},.3),s("ElasticIn",function(t){return-(this._p1*Math.pow(2,10*(t-=1))*Math.sin((t-this._p3)*this._p2))},.3),s("ElasticInOut",function(t){return 1>(t*=2)?-.5*this._p1*Math.pow(2,10*(t-=1))*Math.sin((t-this._p3)*this._p2):.5*this._p1*Math.pow(2,-10*(t-=1))*Math.sin((t-this._p3)*this._p2)+1},.45)),u("Expo",h("ExpoOut",function(t){return 1-Math.pow(2,-10*t)}),h("ExpoIn",function(t){return Math.pow(2,10*(t-1))-.001}),h("ExpoInOut",function(t){return 1>(t*=2)?.5*Math.pow(2,10*(t-1)):.5*(2-Math.pow(2,-10*(t-1)))})),u("Sine",h("SineOut",function(t){return Math.sin(t*o)}),h("SineIn",function(t){return-Math.cos(t*o)+1}),h("SineInOut",function(t){return-.5*(Math.cos(Math.PI*t)-1)})),l("easing.EaseLookup",{find:function(e){return t.map[e]}},!0),_(r.SlowMo,"SlowMo","ease,"),_(i,"RoughEase","ease,"),_(e,"SteppedEase","ease,"),p},!0)}),_gsScope._gsDefine&&_gsScope._gsQueue.pop()(),function(t,e){"use strict";var i=t.GreenSockGlobals=t.GreenSockGlobals||t;if(!i.TweenLite){var s,r,n,a,o,l=function(t){var e,s=t.split("."),r=i;for(e=0;s.length>e;e++)r[s[e]]=r=r[s[e]]||{};return r},h=l("com.greensock"),_=1e-10,u=function(t){var e,i=[],s=t.length;for(e=0;e!==s;i.push(t[e++]));return i},c=function(){},f=function(){var t=Object.prototype.toString,e=t.call([]);return function(i){return null!=i&&(i instanceof Array||"object"==typeof i&&!!i.push&&t.call(i)===e)}}(),p={},m=function(s,r,n,a){this.sc=p[s]?p[s].sc:[],p[s]=this,this.gsClass=null,this.func=n;var o=[];this.check=function(h){for(var _,u,c,f,d,g=r.length,v=g;--g>-1;)(_=p[r[g]]||new m(r[g],[])).gsClass?(o[g]=_.gsClass,v--):h&&_.sc.push(this);if(0===v&&n)for(u=("com.greensock."+s).split("."),c=u.pop(),f=l(u.join("."))[c]=this.gsClass=n.apply(n,o),a&&(i[c]=f,d="undefined"!=typeof module&&module.exports,!d&&"function"==typeof define&&define.amd?define((t.GreenSockAMDPath?t.GreenSockAMDPath+"/":"")+s.split(".").pop(),[],function(){return f}):s===e&&d&&(module.exports=f)),g=0;this.sc.length>g;g++)this.sc[g].check()},this.check(!0)},d=t._gsDefine=function(t,e,i,s){return new m(t,e,i,s)},g=h._class=function(t,e,i){return e=e||function(){},d(t,[],function(){return e},i),e};d.globals=i;var v=[0,0,1,1],y=[],T=g("easing.Ease",function(t,e,i,s){this._func=t,this._type=i||0,this._power=s||0,this._params=e?v.concat(e):v},!0),x=T.map={},w=T.register=function(t,e,i,s){for(var r,n,a,o,l=e.split(","),_=l.length,u=(i||"easeIn,easeOut,easeInOut").split(",");--_>-1;)for(n=l[_],r=s?g("easing."+n,null,!0):h.easing[n]||{},a=u.length;--a>-1;)o=u[a],x[n+"."+o]=x[o+n]=r[o]=t.getRatio?t:t[o]||new t};for(n=T.prototype,n._calcEnd=!1,n.getRatio=function(t){if(this._func)return this._params[0]=t,this._func.apply(null,this._params);var e=this._type,i=this._power,s=1===e?1-t:2===e?t:.5>t?2*t:2*(1-t);return 1===i?s*=s:2===i?s*=s*s:3===i?s*=s*s*s:4===i&&(s*=s*s*s*s),1===e?1-s:2===e?s:.5>t?s/2:1-s/2},s=["Linear","Quad","Cubic","Quart","Quint,Strong"],r=s.length;--r>-1;)n=s[r]+",Power"+r,w(new T(null,null,1,r),n,"easeOut",!0),w(new T(null,null,2,r),n,"easeIn"+(0===r?",easeNone":"")),w(new T(null,null,3,r),n,"easeInOut");x.linear=h.easing.Linear.easeIn,x.swing=h.easing.Quad.easeInOut;var b=g("events.EventDispatcher",function(t){this._listeners={},this._eventTarget=t||this});n=b.prototype,n.addEventListener=function(t,e,i,s,r){r=r||0;var n,l,h=this._listeners[t],_=0;for(null==h&&(this._listeners[t]=h=[]),l=h.length;--l>-1;)n=h[l],n.c===e&&n.s===i?h.splice(l,1):0===_&&r>n.pr&&(_=l+1);h.splice(_,0,{c:e,s:i,up:s,pr:r}),this!==a||o||a.wake()},n.removeEventListener=function(t,e){var i,s=this._listeners[t];if(s)for(i=s.length;--i>-1;)if(s[i].c===e)return s.splice(i,1),void 0},n.dispatchEvent=function(t){var e,i,s,r=this._listeners[t];if(r)for(e=r.length,i=this._eventTarget;--e>-1;)s=r[e],s&&(s.up?s.c.call(s.s||i,{type:t,target:i}):s.c.call(s.s||i))};var P=t.requestAnimationFrame,k=t.cancelAnimationFrame,S=Date.now||function(){return(new Date).getTime()},R=S();for(s=["ms","moz","webkit","o"],r=s.length;--r>-1&&!P;)P=t[s[r]+"RequestAnimationFrame"],k=t[s[r]+"CancelAnimationFrame"]||t[s[r]+"CancelRequestAnimationFrame"];g("Ticker",function(t,e){var i,s,r,n,l,h=this,u=S(),f=e!==!1&&P,p=500,m=33,d="tick",g=function(t){var e,a,o=S()-R;o>p&&(u+=o-m),R+=o,h.time=(R-u)/1e3,e=h.time-l,(!i||e>0||t===!0)&&(h.frame++,l+=e+(e>=n?.004:n-e),a=!0),t!==!0&&(r=s(g)),a&&h.dispatchEvent(d)};b.call(h),h.time=h.frame=0,h.tick=function(){g(!0)},h.lagSmoothing=function(t,e){p=t||1/_,m=Math.min(e,p,0)},h.sleep=function(){null!=r&&(f&&k?k(r):clearTimeout(r),s=c,r=null,h===a&&(o=!1))},h.wake=function(){null!==r?h.sleep():h.frame>10&&(R=S()-p+5),s=0===i?c:f&&P?P:function(t){return setTimeout(t,0|1e3*(l-h.time)+1)},h===a&&(o=!0),g(2)},h.fps=function(t){return arguments.length?(i=t,n=1/(i||60),l=this.time+n,h.wake(),void 0):i},h.useRAF=function(t){return arguments.length?(h.sleep(),f=t,h.fps(i),void 0):f},h.fps(t),setTimeout(function(){f&&5>h.frame&&h.useRAF(!1)},1500)}),n=h.Ticker.prototype=new h.events.EventDispatcher,n.constructor=h.Ticker;var O=g("core.Animation",function(t,e){if(this.vars=e=e||{},this._duration=this._totalDuration=t||0,this._delay=Number(e.delay)||0,this._timeScale=1,this._active=e.immediateRender===!0,this.data=e.data,this._reversed=e.reversed===!0,W){o||a.wake();var i=this.vars.useFrames?G:W;i.add(this,i._time),this.vars.paused&&this.paused(!0)}});a=O.ticker=new h.Ticker,n=O.prototype,n._dirty=n._gc=n._initted=n._paused=!1,n._totalTime=n._time=0,n._rawPrevTime=-1,n._next=n._last=n._onUpdate=n._timeline=n.timeline=null,n._paused=!1;var A=function(){o&&S()-R>2e3&&a.wake(),setTimeout(A,2e3)};A(),n.play=function(t,e){return null!=t&&this.seek(t,e),this.reversed(!1).paused(!1)},n.pause=function(t,e){return null!=t&&this.seek(t,e),this.paused(!0)},n.resume=function(t,e){return null!=t&&this.seek(t,e),this.paused(!1)},n.seek=function(t,e){return this.totalTime(Number(t),e!==!1)},n.restart=function(t,e){return this.reversed(!1).paused(!1).totalTime(t?-this._delay:0,e!==!1,!0)},n.reverse=function(t,e){return null!=t&&this.seek(t||this.totalDuration(),e),this.reversed(!0).paused(!1)},n.render=function(){},n.invalidate=function(){return this._time=this._totalTime=0,this._initted=this._gc=!1,this._rawPrevTime=-1,(this._gc||!this.timeline)&&this._enabled(!0),this},n.isActive=function(){var t,e=this._timeline,i=this._startTime;return!e||!this._gc&&!this._paused&&e.isActive()&&(t=e.rawTime())>=i&&i+this.totalDuration()/this._timeScale>t},n._enabled=function(t,e){return o||a.wake(),this._gc=!t,this._active=this.isActive(),e!==!0&&(t&&!this.timeline?this._timeline.add(this,this._startTime-this._delay):!t&&this.timeline&&this._timeline._remove(this,!0)),!1},n._kill=function(){return this._enabled(!1,!1)},n.kill=function(t,e){return this._kill(t,e),this},n._uncache=function(t){for(var e=t?this:this.timeline;e;)e._dirty=!0,e=e.timeline;return this},n._swapSelfInParams=function(t){for(var e=t.length,i=t.concat();--e>-1;)"{self}"===t[e]&&(i[e]=this);return i},n._callback=function(t){var e=this.vars;e[t].apply(e[t+"Scope"]||e.callbackScope||this,e[t+"Params"]||y)},n.eventCallback=function(t,e,i,s){if("on"===(t||"").substr(0,2)){var r=this.vars;if(1===arguments.length)return r[t];null==e?delete r[t]:(r[t]=e,r[t+"Params"]=f(i)&&-1!==i.join("").indexOf("{self}")?this._swapSelfInParams(i):i,r[t+"Scope"]=s),"onUpdate"===t&&(this._onUpdate=e)}return this},n.delay=function(t){return arguments.length?(this._timeline.smoothChildTiming&&this.startTime(this._startTime+t-this._delay),this._delay=t,this):this._delay},n.duration=function(t){return arguments.length?(this._duration=this._totalDuration=t,this._uncache(!0),this._timeline.smoothChildTiming&&this._time>0&&this._time<this._duration&&0!==t&&this.totalTime(this._totalTime*(t/this._duration),!0),this):(this._dirty=!1,this._duration)},n.totalDuration=function(t){return this._dirty=!1,arguments.length?this.duration(t):this._totalDuration},n.time=function(t,e){return arguments.length?(this._dirty&&this.totalDuration(),this.totalTime(t>this._duration?this._duration:t,e)):this._time},n.totalTime=function(t,e,i){if(o||a.wake(),!arguments.length)return this._totalTime;if(this._timeline){if(0>t&&!i&&(t+=this.totalDuration()),this._timeline.smoothChildTiming){this._dirty&&this.totalDuration();var s=this._totalDuration,r=this._timeline;if(t>s&&!i&&(t=s),this._startTime=(this._paused?this._pauseTime:r._time)-(this._reversed?s-t:t)/this._timeScale,r._dirty||this._uncache(!1),r._timeline)for(;r._timeline;)r._timeline._time!==(r._startTime+r._totalTime)/r._timeScale&&r.totalTime(r._totalTime,!0),r=r._timeline}this._gc&&this._enabled(!0,!1),(this._totalTime!==t||0===this._duration)&&(F.length&&Q(),this.render(t,e,!1),F.length&&Q())}return this},n.progress=n.totalProgress=function(t,e){var i=this.duration();return arguments.length?this.totalTime(i*t,e):i?this._time/i:this.ratio},n.startTime=function(t){return arguments.length?(t!==this._startTime&&(this._startTime=t,this.timeline&&this.timeline._sortChildren&&this.timeline.add(this,t-this._delay)),this):this._startTime},n.endTime=function(t){return this._startTime+(0!=t?this.totalDuration():this.duration())/this._timeScale},n.timeScale=function(t){if(!arguments.length)return this._timeScale;if(t=t||_,this._timeline&&this._timeline.smoothChildTiming){var e=this._pauseTime,i=e||0===e?e:this._timeline.totalTime();this._startTime=i-(i-this._startTime)*this._timeScale/t}return this._timeScale=t,this._uncache(!1)},n.reversed=function(t){return arguments.length?(t!=this._reversed&&(this._reversed=t,this.totalTime(this._timeline&&!this._timeline.smoothChildTiming?this.totalDuration()-this._totalTime:this._totalTime,!0)),this):this._reversed},n.paused=function(t){if(!arguments.length)return this._paused;var e,i,s=this._timeline;return t!=this._paused&&s&&(o||t||a.wake(),e=s.rawTime(),i=e-this._pauseTime,!t&&s.smoothChildTiming&&(this._startTime+=i,this._uncache(!1)),this._pauseTime=t?e:null,this._paused=t,this._active=this.isActive(),!t&&0!==i&&this._initted&&this.duration()&&(e=s.smoothChildTiming?this._totalTime:(e-this._startTime)/this._timeScale,this.render(e,e===this._totalTime,!0))),this._gc&&!t&&this._enabled(!0,!1),this};var C=g("core.SimpleTimeline",function(t){O.call(this,0,t),this.autoRemoveChildren=this.smoothChildTiming=!0});n=C.prototype=new O,n.constructor=C,n.kill()._gc=!1,n._first=n._last=n._recent=null,n._sortChildren=!1,n.add=n.insert=function(t,e){var i,s;if(t._startTime=Number(e||0)+t._delay,t._paused&&this!==t._timeline&&(t._pauseTime=t._startTime+(this.rawTime()-t._startTime)/t._timeScale),t.timeline&&t.timeline._remove(t,!0),t.timeline=t._timeline=this,t._gc&&t._enabled(!0,!0),i=this._last,this._sortChildren)for(s=t._startTime;i&&i._startTime>s;)i=i._prev;return i?(t._next=i._next,i._next=t):(t._next=this._first,this._first=t),t._next?t._next._prev=t:this._last=t,t._prev=i,this._recent=t,this._timeline&&this._uncache(!0),this},n._remove=function(t,e){return t.timeline===this&&(e||t._enabled(!1,!0),t._prev?t._prev._next=t._next:this._first===t&&(this._first=t._next),t._next?t._next._prev=t._prev:this._last===t&&(this._last=t._prev),t._next=t._prev=t.timeline=null,t===this._recent&&(this._recent=this._last),this._timeline&&this._uncache(!0)),this},n.render=function(t,e,i){var s,r=this._first;for(this._totalTime=this._time=this._rawPrevTime=t;r;)s=r._next,(r._active||t>=r._startTime&&!r._paused)&&(r._reversed?r.render((r._dirty?r.totalDuration():r._totalDuration)-(t-r._startTime)*r._timeScale,e,i):r.render((t-r._startTime)*r._timeScale,e,i)),r=s},n.rawTime=function(){return o||a.wake(),this._totalTime};var D=g("TweenLite",function(e,i,s){if(O.call(this,i,s),this.render=D.prototype.render,null==e)throw"Cannot tween a null target.";this.target=e="string"!=typeof e?e:D.selector(e)||e;var r,n,a,o=e.jquery||e.length&&e!==t&&e[0]&&(e[0]===t||e[0].nodeType&&e[0].style&&!e.nodeType),l=this.vars.overwrite;if(this._overwrite=l=null==l?V[D.defaultOverwrite]:"number"==typeof l?l>>0:V[l],(o||e instanceof Array||e.push&&f(e))&&"number"!=typeof e[0])for(this._targets=a=u(e),this._propLookup=[],this._siblings=[],r=0;a.length>r;r++)n=a[r],n?"string"!=typeof n?n.length&&n!==t&&n[0]&&(n[0]===t||n[0].nodeType&&n[0].style&&!n.nodeType)?(a.splice(r--,1),this._targets=a=a.concat(u(n))):(this._siblings[r]=$(n,this,!1),1===l&&this._siblings[r].length>1&&K(n,this,null,1,this._siblings[r])):(n=a[r--]=D.selector(n),"string"==typeof n&&a.splice(r+1,1)):a.splice(r--,1);else this._propLookup={},this._siblings=$(e,this,!1),1===l&&this._siblings.length>1&&K(e,this,null,1,this._siblings);(this.vars.immediateRender||0===i&&0===this._delay&&this.vars.immediateRender!==!1)&&(this._time=-_,this.render(-this._delay))},!0),M=function(e){return e&&e.length&&e!==t&&e[0]&&(e[0]===t||e[0].nodeType&&e[0].style&&!e.nodeType)},z=function(t,e){var i,s={};for(i in t)q[i]||i in e&&"transform"!==i&&"x"!==i&&"y"!==i&&"width"!==i&&"height"!==i&&"className"!==i&&"border"!==i||!(!j[i]||j[i]&&j[i]._autoCSS)||(s[i]=t[i],delete t[i]);t.css=s};n=D.prototype=new O,n.constructor=D,n.kill()._gc=!1,n.ratio=0,n._firstPT=n._targets=n._overwrittenProps=n._startAt=null,n._notifyPluginsOfEnabled=n._lazy=!1,D.version="1.18.0",D.defaultEase=n._ease=new T(null,null,1,1),D.defaultOverwrite="auto",D.ticker=a,D.autoSleep=120,D.lagSmoothing=function(t,e){a.lagSmoothing(t,e)},D.selector=t.$||t.jQuery||function(e){var i=t.$||t.jQuery;return i?(D.selector=i,i(e)):"undefined"==typeof document?e:document.querySelectorAll?document.querySelectorAll(e):document.getElementById("#"===e.charAt(0)?e.substr(1):e)};var F=[],I={},E=/(?:(-|-=|\+=)?\d*\.?\d*(?:e[\-+]?\d+)?)[0-9]/gi,N=function(t){for(var e,i=this._firstPT,s=1e-6;i;)e=i.blob?t?this.join(""):this.start:i.c*t+i.s,i.r?e=Math.round(e):s>e&&e>-s&&(e=0),i.f?i.fp?i.t[i.p](i.fp,e):i.t[i.p](e):i.t[i.p]=e,i=i._next},L=function(t,e,i,s){var r,n,a,o,l,h,_,u=[t,e],c=0,f="",p=0;for(u.start=t,i&&(i(u),t=u[0],e=u[1]),u.length=0,r=t.match(E)||[],n=e.match(E)||[],s&&(s._next=null,s.blob=1,u._firstPT=s),l=n.length,o=0;l>o;o++)_=n[o],h=e.substr(c,e.indexOf(_,c)-c),f+=h||!o?h:",",c+=h.length,p?p=(p+1)%5:"rgba("===h.substr(-5)&&(p=1),_===r[o]||o>=r.length?f+=_:(f&&(u.push(f),f=""),a=parseFloat(r[o]),u.push(a),u._firstPT={_next:u._firstPT,t:u,p:u.length-1,s:a,c:("="===_.charAt(1)?parseInt(_.charAt(0)+"1",10)*parseFloat(_.substr(2)):parseFloat(_)-a)||0,f:0,r:p&&4>p}),c+=_.length;return f+=e.substr(c),f&&u.push(f),u.setRatio=N,u},X=function(t,e,i,s,r,n,a,o){var l,h,_="get"===i?t[e]:i,u=typeof t[e],c="string"==typeof s&&"="===s.charAt(1),f={t:t,p:e,s:_,f:"function"===u,pg:0,n:r||e,r:n,pr:0,c:c?parseInt(s.charAt(0)+"1",10)*parseFloat(s.substr(2)):parseFloat(s)-_||0};return"number"!==u&&("function"===u&&"get"===i&&(h=e.indexOf("set")||"function"!=typeof t["get"+e.substr(3)]?e:"get"+e.substr(3),f.s=_=a?t[h](a):t[h]()),"string"==typeof _&&(a||isNaN(_))?(f.fp=a,l=L(_,s,o||D.defaultStringFilter,f),f={t:l,p:"setRatio",s:0,c:1,f:2,pg:0,n:r||e,pr:0}):c||(f.c=parseFloat(s)-parseFloat(_)||0)),f.c?((f._next=this._firstPT)&&(f._next._prev=f),this._firstPT=f,f):void 0},B=D._internals={isArray:f,isSelector:M,lazyTweens:F,blobDif:L},j=D._plugins={},Y=B.tweenLookup={},U=0,q=B.reservedProps={ease:1,delay:1,overwrite:1,onComplete:1,onCompleteParams:1,onCompleteScope:1,useFrames:1,runBackwards:1,startAt:1,onUpdate:1,onUpdateParams:1,onUpdateScope:1,onStart:1,onStartParams:1,onStartScope:1,onReverseComplete:1,onReverseCompleteParams:1,onReverseCompleteScope:1,onRepeat:1,onRepeatParams:1,onRepeatScope:1,easeParams:1,yoyo:1,immediateRender:1,repeat:1,repeatDelay:1,data:1,paused:1,reversed:1,autoCSS:1,lazy:1,onOverwrite:1,callbackScope:1,stringFilter:1},V={none:0,all:1,auto:2,concurrent:3,allOnStart:4,preexisting:5,"true":1,"false":0},G=O._rootFramesTimeline=new C,W=O._rootTimeline=new C,Z=30,Q=B.lazyRender=function(){var t,e=F.length;for(I={};--e>-1;)t=F[e],t&&t._lazy!==!1&&(t.render(t._lazy[0],t._lazy[1],!0),t._lazy=!1);F.length=0};W._startTime=a.time,G._startTime=a.frame,W._active=G._active=!0,setTimeout(Q,1),O._updateRoot=D.render=function(){var t,e,i;if(F.length&&Q(),W.render((a.time-W._startTime)*W._timeScale,!1,!1),G.render((a.frame-G._startTime)*G._timeScale,!1,!1),F.length&&Q(),a.frame>=Z){Z=a.frame+(parseInt(D.autoSleep,10)||120);

for(i in Y){for(e=Y[i].tweens,t=e.length;--t>-1;)e[t]._gc&&e.splice(t,1);0===e.length&&delete Y[i]}if(i=W._first,(!i||i._paused)&&D.autoSleep&&!G._first&&1===a._listeners.tick.length){for(;i&&i._paused;)i=i._next;i||a.sleep()}}},a.addEventListener("tick",O._updateRoot);var $=function(t,e,i){var s,r,n=t._gsTweenID;if(Y[n||(t._gsTweenID=n="t"+U++)]||(Y[n]={target:t,tweens:[]}),e&&(s=Y[n].tweens,s[r=s.length]=e,i))for(;--r>-1;)s[r]===e&&s.splice(r,1);return Y[n].tweens},H=function(t,e,i,s){var r,n,a=t.vars.onOverwrite;return a&&(r=a(t,e,i,s)),a=D.onOverwrite,a&&(n=a(t,e,i,s)),r!==!1&&n!==!1},K=function(t,e,i,s,r){var n,a,o,l;if(1===s||s>=4){for(l=r.length,n=0;l>n;n++)if((o=r[n])!==e)o._gc||o._kill(null,t,e)&&(a=!0);else if(5===s)break;return a}var h,u=e._startTime+_,c=[],f=0,p=0===e._duration;for(n=r.length;--n>-1;)(o=r[n])===e||o._gc||o._paused||(o._timeline!==e._timeline?(h=h||J(e,0,p),0===J(o,h,p)&&(c[f++]=o)):u>=o._startTime&&o._startTime+o.totalDuration()/o._timeScale>u&&((p||!o._initted)&&2e-10>=u-o._startTime||(c[f++]=o)));for(n=f;--n>-1;)if(o=c[n],2===s&&o._kill(i,t,e)&&(a=!0),2!==s||!o._firstPT&&o._initted){if(2!==s&&!H(o,e))continue;o._enabled(!1,!1)&&(a=!0)}return a},J=function(t,e,i){for(var s=t._timeline,r=s._timeScale,n=t._startTime;s._timeline;){if(n+=s._startTime,r*=s._timeScale,s._paused)return-100;s=s._timeline}return n/=r,n>e?n-e:i&&n===e||!t._initted&&2*_>n-e?_:(n+=t.totalDuration()/t._timeScale/r)>e+_?0:n-e-_};n._init=function(){var t,e,i,s,r,n=this.vars,a=this._overwrittenProps,o=this._duration,l=!!n.immediateRender,h=n.ease;if(n.startAt){this._startAt&&(this._startAt.render(-1,!0),this._startAt.kill()),r={};for(s in n.startAt)r[s]=n.startAt[s];if(r.overwrite=!1,r.immediateRender=!0,r.lazy=l&&n.lazy!==!1,r.startAt=r.delay=null,this._startAt=D.to(this.target,0,r),l)if(this._time>0)this._startAt=null;else if(0!==o)return}else if(n.runBackwards&&0!==o)if(this._startAt)this._startAt.render(-1,!0),this._startAt.kill(),this._startAt=null;else{0!==this._time&&(l=!1),i={};for(s in n)q[s]&&"autoCSS"!==s||(i[s]=n[s]);if(i.overwrite=0,i.data="isFromStart",i.lazy=l&&n.lazy!==!1,i.immediateRender=l,this._startAt=D.to(this.target,0,i),l){if(0===this._time)return}else this._startAt._init(),this._startAt._enabled(!1),this.vars.immediateRender&&(this._startAt=null)}if(this._ease=h=h?h instanceof T?h:"function"==typeof h?new T(h,n.easeParams):x[h]||D.defaultEase:D.defaultEase,n.easeParams instanceof Array&&h.config&&(this._ease=h.config.apply(h,n.easeParams)),this._easeType=this._ease._type,this._easePower=this._ease._power,this._firstPT=null,this._targets)for(t=this._targets.length;--t>-1;)this._initProps(this._targets[t],this._propLookup[t]={},this._siblings[t],a?a[t]:null)&&(e=!0);else e=this._initProps(this.target,this._propLookup,this._siblings,a);if(e&&D._onPluginEvent("_onInitAllProps",this),a&&(this._firstPT||"function"!=typeof this.target&&this._enabled(!1,!1)),n.runBackwards)for(i=this._firstPT;i;)i.s+=i.c,i.c=-i.c,i=i._next;this._onUpdate=n.onUpdate,this._initted=!0},n._initProps=function(e,i,s,r){var n,a,o,l,h,_;if(null==e)return!1;I[e._gsTweenID]&&Q(),this.vars.css||e.style&&e!==t&&e.nodeType&&j.css&&this.vars.autoCSS!==!1&&z(this.vars,e);for(n in this.vars)if(_=this.vars[n],q[n])_&&(_ instanceof Array||_.push&&f(_))&&-1!==_.join("").indexOf("{self}")&&(this.vars[n]=_=this._swapSelfInParams(_,this));else if(j[n]&&(l=new j[n])._onInitTween(e,this.vars[n],this)){for(this._firstPT=h={_next:this._firstPT,t:l,p:"setRatio",s:0,c:1,f:1,n:n,pg:1,pr:l._priority},a=l._overwriteProps.length;--a>-1;)i[l._overwriteProps[a]]=this._firstPT;(l._priority||l._onInitAllProps)&&(o=!0),(l._onDisable||l._onEnable)&&(this._notifyPluginsOfEnabled=!0),h._next&&(h._next._prev=h)}else i[n]=X.call(this,e,n,"get",_,n,0,null,this.vars.stringFilter);return r&&this._kill(r,e)?this._initProps(e,i,s,r):this._overwrite>1&&this._firstPT&&s.length>1&&K(e,this,i,this._overwrite,s)?(this._kill(i,e),this._initProps(e,i,s,r)):(this._firstPT&&(this.vars.lazy!==!1&&this._duration||this.vars.lazy&&!this._duration)&&(I[e._gsTweenID]=!0),o)},n.render=function(t,e,i){var s,r,n,a,o=this._time,l=this._duration,h=this._rawPrevTime;if(t>=l)this._totalTime=this._time=l,this.ratio=this._ease._calcEnd?this._ease.getRatio(1):1,this._reversed||(s=!0,r="onComplete",i=i||this._timeline.autoRemoveChildren),0===l&&(this._initted||!this.vars.lazy||i)&&(this._startTime===this._timeline._duration&&(t=0),(0===t||0>h||h===_&&"isPause"!==this.data)&&h!==t&&(i=!0,h>_&&(r="onReverseComplete")),this._rawPrevTime=a=!e||t||h===t?t:_);else if(1e-7>t)this._totalTime=this._time=0,this.ratio=this._ease._calcEnd?this._ease.getRatio(0):0,(0!==o||0===l&&h>0)&&(r="onReverseComplete",s=this._reversed),0>t&&(this._active=!1,0===l&&(this._initted||!this.vars.lazy||i)&&(h>=0&&(h!==_||"isPause"!==this.data)&&(i=!0),this._rawPrevTime=a=!e||t||h===t?t:_)),this._initted||(i=!0);else if(this._totalTime=this._time=t,this._easeType){var u=t/l,c=this._easeType,f=this._easePower;(1===c||3===c&&u>=.5)&&(u=1-u),3===c&&(u*=2),1===f?u*=u:2===f?u*=u*u:3===f?u*=u*u*u:4===f&&(u*=u*u*u*u),this.ratio=1===c?1-u:2===c?u:.5>t/l?u/2:1-u/2}else this.ratio=this._ease.getRatio(t/l);if(this._time!==o||i){if(!this._initted){if(this._init(),!this._initted||this._gc)return;if(!i&&this._firstPT&&(this.vars.lazy!==!1&&this._duration||this.vars.lazy&&!this._duration))return this._time=this._totalTime=o,this._rawPrevTime=h,F.push(this),this._lazy=[t,e],void 0;this._time&&!s?this.ratio=this._ease.getRatio(this._time/l):s&&this._ease._calcEnd&&(this.ratio=this._ease.getRatio(0===this._time?0:1))}for(this._lazy!==!1&&(this._lazy=!1),this._active||!this._paused&&this._time!==o&&t>=0&&(this._active=!0),0===o&&(this._startAt&&(t>=0?this._startAt.render(t,e,i):r||(r="_dummyGS")),this.vars.onStart&&(0!==this._time||0===l)&&(e||this._callback("onStart"))),n=this._firstPT;n;)n.f?n.t[n.p](n.c*this.ratio+n.s):n.t[n.p]=n.c*this.ratio+n.s,n=n._next;this._onUpdate&&(0>t&&this._startAt&&t!==-1e-4&&this._startAt.render(t,e,i),e||(this._time!==o||s)&&this._callback("onUpdate")),r&&(!this._gc||i)&&(0>t&&this._startAt&&!this._onUpdate&&t!==-1e-4&&this._startAt.render(t,e,i),s&&(this._timeline.autoRemoveChildren&&this._enabled(!1,!1),this._active=!1),!e&&this.vars[r]&&this._callback(r),0===l&&this._rawPrevTime===_&&a!==_&&(this._rawPrevTime=0))}},n._kill=function(t,e,i){if("all"===t&&(t=null),null==t&&(null==e||e===this.target))return this._lazy=!1,this._enabled(!1,!1);e="string"!=typeof e?e||this._targets||this.target:D.selector(e)||e;var s,r,n,a,o,l,h,_,u,c=i&&this._time&&i._startTime===this._startTime&&this._timeline===i._timeline;if((f(e)||M(e))&&"number"!=typeof e[0])for(s=e.length;--s>-1;)this._kill(t,e[s],i)&&(l=!0);else{if(this._targets){for(s=this._targets.length;--s>-1;)if(e===this._targets[s]){o=this._propLookup[s]||{},this._overwrittenProps=this._overwrittenProps||[],r=this._overwrittenProps[s]=t?this._overwrittenProps[s]||{}:"all";break}}else{if(e!==this.target)return!1;o=this._propLookup,r=this._overwrittenProps=t?this._overwrittenProps||{}:"all"}if(o){if(h=t||o,_=t!==r&&"all"!==r&&t!==o&&("object"!=typeof t||!t._tempKill),i&&(D.onOverwrite||this.vars.onOverwrite)){for(n in h)o[n]&&(u||(u=[]),u.push(n));if((u||!t)&&!H(this,i,e,u))return!1}for(n in h)(a=o[n])&&(c&&(a.f?a.t[a.p](a.s):a.t[a.p]=a.s,l=!0),a.pg&&a.t._kill(h)&&(l=!0),a.pg&&0!==a.t._overwriteProps.length||(a._prev?a._prev._next=a._next:a===this._firstPT&&(this._firstPT=a._next),a._next&&(a._next._prev=a._prev),a._next=a._prev=null),delete o[n]),_&&(r[n]=1);!this._firstPT&&this._initted&&this._enabled(!1,!1)}}return l},n.invalidate=function(){return this._notifyPluginsOfEnabled&&D._onPluginEvent("_onDisable",this),this._firstPT=this._overwrittenProps=this._startAt=this._onUpdate=null,this._notifyPluginsOfEnabled=this._active=this._lazy=!1,this._propLookup=this._targets?{}:[],O.prototype.invalidate.call(this),this.vars.immediateRender&&(this._time=-_,this.render(-this._delay)),this},n._enabled=function(t,e){if(o||a.wake(),t&&this._gc){var i,s=this._targets;if(s)for(i=s.length;--i>-1;)this._siblings[i]=$(s[i],this,!0);else this._siblings=$(this.target,this,!0)}return O.prototype._enabled.call(this,t,e),this._notifyPluginsOfEnabled&&this._firstPT?D._onPluginEvent(t?"_onEnable":"_onDisable",this):!1},D.to=function(t,e,i){return new D(t,e,i)},D.from=function(t,e,i){return i.runBackwards=!0,i.immediateRender=0!=i.immediateRender,new D(t,e,i)},D.fromTo=function(t,e,i,s){return s.startAt=i,s.immediateRender=0!=s.immediateRender&&0!=i.immediateRender,new D(t,e,s)},D.delayedCall=function(t,e,i,s,r){return new D(e,0,{delay:t,onComplete:e,onCompleteParams:i,callbackScope:s,onReverseComplete:e,onReverseCompleteParams:i,immediateRender:!1,lazy:!1,useFrames:r,overwrite:0})},D.set=function(t,e){return new D(t,0,e)},D.getTweensOf=function(t,e){if(null==t)return[];t="string"!=typeof t?t:D.selector(t)||t;var i,s,r,n;if((f(t)||M(t))&&"number"!=typeof t[0]){for(i=t.length,s=[];--i>-1;)s=s.concat(D.getTweensOf(t[i],e));for(i=s.length;--i>-1;)for(n=s[i],r=i;--r>-1;)n===s[r]&&s.splice(i,1)}else for(s=$(t).concat(),i=s.length;--i>-1;)(s[i]._gc||e&&!s[i].isActive())&&s.splice(i,1);return s},D.killTweensOf=D.killDelayedCallsTo=function(t,e,i){"object"==typeof e&&(i=e,e=!1);for(var s=D.getTweensOf(t,e),r=s.length;--r>-1;)s[r]._kill(i,t)};var te=g("plugins.TweenPlugin",function(t,e){this._overwriteProps=(t||"").split(","),this._propName=this._overwriteProps[0],this._priority=e||0,this._super=te.prototype},!0);if(n=te.prototype,te.version="1.18.0",te.API=2,n._firstPT=null,n._addTween=X,n.setRatio=N,n._kill=function(t){var e,i=this._overwriteProps,s=this._firstPT;if(null!=t[this._propName])this._overwriteProps=[];else for(e=i.length;--e>-1;)null!=t[i[e]]&&i.splice(e,1);for(;s;)null!=t[s.n]&&(s._next&&(s._next._prev=s._prev),s._prev?(s._prev._next=s._next,s._prev=null):this._firstPT===s&&(this._firstPT=s._next)),s=s._next;return!1},n._roundProps=function(t,e){for(var i=this._firstPT;i;)(t[this._propName]||null!=i.n&&t[i.n.split(this._propName+"_").join("")])&&(i.r=e),i=i._next},D._onPluginEvent=function(t,e){var i,s,r,n,a,o=e._firstPT;if("_onInitAllProps"===t){for(;o;){for(a=o._next,s=r;s&&s.pr>o.pr;)s=s._next;(o._prev=s?s._prev:n)?o._prev._next=o:r=o,(o._next=s)?s._prev=o:n=o,o=a}o=e._firstPT=r}for(;o;)o.pg&&"function"==typeof o.t[t]&&o.t[t]()&&(i=!0),o=o._next;return i},te.activate=function(t){for(var e=t.length;--e>-1;)t[e].API===te.API&&(j[(new t[e])._propName]=t[e]);return!0},d.plugin=function(t){if(!(t&&t.propName&&t.init&&t.API))throw"illegal plugin definition.";var e,i=t.propName,s=t.priority||0,r=t.overwriteProps,n={init:"_onInitTween",set:"setRatio",kill:"_kill",round:"_roundProps",initAll:"_onInitAllProps"},a=g("plugins."+i.charAt(0).toUpperCase()+i.substr(1)+"Plugin",function(){te.call(this,i,s),this._overwriteProps=r||[]},t.global===!0),o=a.prototype=new te(i);o.constructor=a,a.API=t.API;for(e in n)"function"==typeof t[e]&&(o[n[e]]=t[e]);return a.version=t.version,te.activate([a]),a},s=t._gsQueue){for(r=0;s.length>r;r++)s[r]();for(n in p)p[n].func||t.console.log("GSAP encountered missing dependency: com.greensock."+n)}o=!1}}("undefined"!=typeof module&&module.exports&&"undefined"!=typeof global?global:this||window,"TweenMax");



if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");+function(a){"use strict";var b=a.fn.jquery.split(" ")[0].split(".");if(b[0]<2&&b[1]<9||1==b[0]&&9==b[1]&&b[2]<1||b[0]>3)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher, but lower than version 4")}(jQuery),+function(a){"use strict";function b(){var a=document.createElement("bootstrap"),b={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var c in b)if(void 0!==a.style[c])return{end:b[c]};return!1}a.fn.emulateTransitionEnd=function(b){var c=!1,d=this;a(this).one("bsTransitionEnd",function(){c=!0});var e=function(){c||a(d).trigger(a.support.transition.end)};return setTimeout(e,b),this},a(function(){a.support.transition=b(),a.support.transition&&(a.event.special.bsTransitionEnd={bindType:a.support.transition.end,delegateType:a.support.transition.end,handle:function(b){if(a(b.target).is(this))return b.handleObj.handler.apply(this,arguments)}})})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var c=a(this),e=c.data("bs.alert");e||c.data("bs.alert",e=new d(this)),"string"==typeof b&&e[b].call(c)})}var c='[data-dismiss="alert"]',d=function(b){a(b).on("click",c,this.close)};d.VERSION="3.3.7",d.TRANSITION_DURATION=150,d.prototype.close=function(b){function c(){g.detach().trigger("closed.bs.alert").remove()}var e=a(this),f=e.attr("data-target");f||(f=e.attr("href"),f=f&&f.replace(/.*(?=#[^\s]*$)/,""));var g=a("#"===f?[]:f);b&&b.preventDefault(),g.length||(g=e.closest(".alert")),g.trigger(b=a.Event("close.bs.alert")),b.isDefaultPrevented()||(g.removeClass("in"),a.support.transition&&g.hasClass("fade")?g.one("bsTransitionEnd",c).emulateTransitionEnd(d.TRANSITION_DURATION):c())};var e=a.fn.alert;a.fn.alert=b,a.fn.alert.Constructor=d,a.fn.alert.noConflict=function(){return a.fn.alert=e,this},a(document).on("click.bs.alert.data-api",c,d.prototype.close)}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.button"),f="object"==typeof b&&b;e||d.data("bs.button",e=new c(this,f)),"toggle"==b?e.toggle():b&&e.setState(b)})}var c=function(b,d){this.$element=a(b),this.options=a.extend({},c.DEFAULTS,d),this.isLoading=!1};c.VERSION="3.3.7",c.DEFAULTS={loadingText:"loading..."},c.prototype.setState=function(b){var c="disabled",d=this.$element,e=d.is("input")?"val":"html",f=d.data();b+="Text",null==f.resetText&&d.data("resetText",d[e]()),setTimeout(a.proxy(function(){d[e](null==f[b]?this.options[b]:f[b]),"loadingText"==b?(this.isLoading=!0,d.addClass(c).attr(c,c).prop(c,!0)):this.isLoading&&(this.isLoading=!1,d.removeClass(c).removeAttr(c).prop(c,!1))},this),0)},c.prototype.toggle=function(){var a=!0,b=this.$element.closest('[data-toggle="buttons"]');if(b.length){var c=this.$element.find("input");"radio"==c.prop("type")?(c.prop("checked")&&(a=!1),b.find(".active").removeClass("active"),this.$element.addClass("active")):"checkbox"==c.prop("type")&&(c.prop("checked")!==this.$element.hasClass("active")&&(a=!1),this.$element.toggleClass("active")),c.prop("checked",this.$element.hasClass("active")),a&&c.trigger("change")}else this.$element.attr("aria-pressed",!this.$element.hasClass("active")),this.$element.toggleClass("active")};var d=a.fn.button;a.fn.button=b,a.fn.button.Constructor=c,a.fn.button.noConflict=function(){return a.fn.button=d,this},a(document).on("click.bs.button.data-api",'[data-toggle^="button"]',function(c){var d=a(c.target).closest(".btn");b.call(d,"toggle"),a(c.target).is('input[type="radio"], input[type="checkbox"]')||(c.preventDefault(),d.is("input,button")?d.trigger("focus"):d.find("input:visible,button:visible").first().trigger("focus"))}).on("focus.bs.button.data-api blur.bs.button.data-api",'[data-toggle^="button"]',function(b){a(b.target).closest(".btn").toggleClass("focus",/^focus(in)?$/.test(b.type))})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.carousel"),f=a.extend({},c.DEFAULTS,d.data(),"object"==typeof b&&b),g="string"==typeof b?b:f.slide;e||d.data("bs.carousel",e=new c(this,f)),"number"==typeof b?e.to(b):g?e[g]():f.interval&&e.pause().cycle()})}var c=function(b,c){this.$element=a(b),this.$indicators=this.$element.find(".carousel-indicators"),this.options=c,this.paused=null,this.sliding=null,this.interval=null,this.$active=null,this.$items=null,this.options.keyboard&&this.$element.on("keydown.bs.carousel",a.proxy(this.keydown,this)),"hover"==this.options.pause&&!("ontouchstart"in document.documentElement)&&this.$element.on("mouseenter.bs.carousel",a.proxy(this.pause,this)).on("mouseleave.bs.carousel",a.proxy(this.cycle,this))};c.VERSION="3.3.7",c.TRANSITION_DURATION=600,c.DEFAULTS={interval:5e3,pause:"hover",wrap:!0,keyboard:!0},c.prototype.keydown=function(a){if(!/input|textarea/i.test(a.target.tagName)){switch(a.which){case 37:this.prev();break;case 39:this.next();break;default:return}a.preventDefault()}},c.prototype.cycle=function(b){return b||(this.paused=!1),this.interval&&clearInterval(this.interval),this.options.interval&&!this.paused&&(this.interval=setInterval(a.proxy(this.next,this),this.options.interval)),this},c.prototype.getItemIndex=function(a){return this.$items=a.parent().children(".item"),this.$items.index(a||this.$active)},c.prototype.getItemForDirection=function(a,b){var c=this.getItemIndex(b),d="prev"==a&&0===c||"next"==a&&c==this.$items.length-1;if(d&&!this.options.wrap)return b;var e="prev"==a?-1:1,f=(c+e)%this.$items.length;return this.$items.eq(f)},c.prototype.to=function(a){var b=this,c=this.getItemIndex(this.$active=this.$element.find(".item.active"));if(!(a>this.$items.length-1||a<0))return this.sliding?this.$element.one("slid.bs.carousel",function(){b.to(a)}):c==a?this.pause().cycle():this.slide(a>c?"next":"prev",this.$items.eq(a))},c.prototype.pause=function(b){return b||(this.paused=!0),this.$element.find(".next, .prev").length&&a.support.transition&&(this.$element.trigger(a.support.transition.end),this.cycle(!0)),this.interval=clearInterval(this.interval),this},c.prototype.next=function(){if(!this.sliding)return this.slide("next")},c.prototype.prev=function(){if(!this.sliding)return this.slide("prev")},c.prototype.slide=function(b,d){var e=this.$element.find(".item.active"),f=d||this.getItemForDirection(b,e),g=this.interval,h="next"==b?"left":"right",i=this;if(f.hasClass("active"))return this.sliding=!1;var j=f[0],k=a.Event("slide.bs.carousel",{relatedTarget:j,direction:h});if(this.$element.trigger(k),!k.isDefaultPrevented()){if(this.sliding=!0,g&&this.pause(),this.$indicators.length){this.$indicators.find(".active").removeClass("active");var l=a(this.$indicators.children()[this.getItemIndex(f)]);l&&l.addClass("active")}var m=a.Event("slid.bs.carousel",{relatedTarget:j,direction:h});return a.support.transition&&this.$element.hasClass("slide")?(f.addClass(b),f[0].offsetWidth,e.addClass(h),f.addClass(h),e.one("bsTransitionEnd",function(){f.removeClass([b,h].join(" ")).addClass("active"),e.removeClass(["active",h].join(" ")),i.sliding=!1,setTimeout(function(){i.$element.trigger(m)},0)}).emulateTransitionEnd(c.TRANSITION_DURATION)):(e.removeClass("active"),f.addClass("active"),this.sliding=!1,this.$element.trigger(m)),g&&this.cycle(),this}};var d=a.fn.carousel;a.fn.carousel=b,a.fn.carousel.Constructor=c,a.fn.carousel.noConflict=function(){return a.fn.carousel=d,this};var e=function(c){var d,e=a(this),f=a(e.attr("data-target")||(d=e.attr("href"))&&d.replace(/.*(?=#[^\s]+$)/,""));if(f.hasClass("carousel")){var g=a.extend({},f.data(),e.data()),h=e.attr("data-slide-to");h&&(g.interval=!1),b.call(f,g),h&&f.data("bs.carousel").to(h),c.preventDefault()}};a(document).on("click.bs.carousel.data-api","[data-slide]",e).on("click.bs.carousel.data-api","[data-slide-to]",e),a(window).on("load",function(){a('[data-ride="carousel"]').each(function(){var c=a(this);b.call(c,c.data())})})}(jQuery),+function(a){"use strict";function b(b){var c,d=b.attr("data-target")||(c=b.attr("href"))&&c.replace(/.*(?=#[^\s]+$)/,"");return a(d)}function c(b){return this.each(function(){var c=a(this),e=c.data("bs.collapse"),f=a.extend({},d.DEFAULTS,c.data(),"object"==typeof b&&b);!e&&f.toggle&&/show|hide/.test(b)&&(f.toggle=!1),e||c.data("bs.collapse",e=new d(this,f)),"string"==typeof b&&e[b]()})}var d=function(b,c){this.$element=a(b),this.options=a.extend({},d.DEFAULTS,c),this.$trigger=a('[data-toggle="collapse"][href="#'+b.id+'"],[data-toggle="collapse"][data-target="#'+b.id+'"]'),this.transitioning=null,this.options.parent?this.$parent=this.getParent():this.addAriaAndCollapsedClass(this.$element,this.$trigger),this.options.toggle&&this.toggle()};d.VERSION="3.3.7",d.TRANSITION_DURATION=350,d.DEFAULTS={toggle:!0},d.prototype.dimension=function(){var a=this.$element.hasClass("width");return a?"width":"height"},d.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var b,e=this.$parent&&this.$parent.children(".panel").children(".in, .collapsing");if(!(e&&e.length&&(b=e.data("bs.collapse"),b&&b.transitioning))){var f=a.Event("show.bs.collapse");if(this.$element.trigger(f),!f.isDefaultPrevented()){e&&e.length&&(c.call(e,"hide"),b||e.data("bs.collapse",null));var g=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[g](0).attr("aria-expanded",!0),this.$trigger.removeClass("collapsed").attr("aria-expanded",!0),this.transitioning=1;var h=function(){this.$element.removeClass("collapsing").addClass("collapse in")[g](""),this.transitioning=0,this.$element.trigger("shown.bs.collapse")};if(!a.support.transition)return h.call(this);var i=a.camelCase(["scroll",g].join("-"));this.$element.one("bsTransitionEnd",a.proxy(h,this)).emulateTransitionEnd(d.TRANSITION_DURATION)[g](this.$element[0][i])}}}},d.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var b=a.Event("hide.bs.collapse");if(this.$element.trigger(b),!b.isDefaultPrevented()){var c=this.dimension();this.$element[c](this.$element[c]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded",!1),this.$trigger.addClass("collapsed").attr("aria-expanded",!1),this.transitioning=1;var e=function(){this.transitioning=0,this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")};return a.support.transition?void this.$element[c](0).one("bsTransitionEnd",a.proxy(e,this)).emulateTransitionEnd(d.TRANSITION_DURATION):e.call(this)}}},d.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()},d.prototype.getParent=function(){return a(this.options.parent).find('[data-toggle="collapse"][data-parent="'+this.options.parent+'"]').each(a.proxy(function(c,d){var e=a(d);this.addAriaAndCollapsedClass(b(e),e)},this)).end()},d.prototype.addAriaAndCollapsedClass=function(a,b){var c=a.hasClass("in");a.attr("aria-expanded",c),b.toggleClass("collapsed",!c).attr("aria-expanded",c)};var e=a.fn.collapse;a.fn.collapse=c,a.fn.collapse.Constructor=d,a.fn.collapse.noConflict=function(){return a.fn.collapse=e,this},a(document).on("click.bs.collapse.data-api",'[data-toggle="collapse"]',function(d){var e=a(this);e.attr("data-target")||d.preventDefault();var f=b(e),g=f.data("bs.collapse"),h=g?"toggle":e.data();c.call(f,h)})}(jQuery),+function(a){"use strict";function b(b){var c=b.attr("data-target");c||(c=b.attr("href"),c=c&&/#[A-Za-z]/.test(c)&&c.replace(/.*(?=#[^\s]*$)/,""));var d=c&&a(c);return d&&d.length?d:b.parent()}function c(c){c&&3===c.which||(a(e).remove(),a(f).each(function(){var d=a(this),e=b(d),f={relatedTarget:this};e.hasClass("open")&&(c&&"click"==c.type&&/input|textarea/i.test(c.target.tagName)&&a.contains(e[0],c.target)||(e.trigger(c=a.Event("hide.bs.dropdown",f)),c.isDefaultPrevented()||(d.attr("aria-expanded","false"),e.removeClass("open").trigger(a.Event("hidden.bs.dropdown",f)))))}))}function d(b){return this.each(function(){var c=a(this),d=c.data("bs.dropdown");d||c.data("bs.dropdown",d=new g(this)),"string"==typeof b&&d[b].call(c)})}var e=".dropdown-backdrop",f='[data-toggle="dropdown"]',g=function(b){a(b).on("click.bs.dropdown",this.toggle)};g.VERSION="3.3.7",g.prototype.toggle=function(d){var e=a(this);if(!e.is(".disabled, :disabled")){var f=b(e),g=f.hasClass("open");if(c(),!g){"ontouchstart"in document.documentElement&&!f.closest(".navbar-nav").length&&a(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(a(this)).on("click",c);var h={relatedTarget:this};if(f.trigger(d=a.Event("show.bs.dropdown",h)),d.isDefaultPrevented())return;e.trigger("focus").attr("aria-expanded","true"),f.toggleClass("open").trigger(a.Event("shown.bs.dropdown",h))}return!1}},g.prototype.keydown=function(c){if(/(38|40|27|32)/.test(c.which)&&!/input|textarea/i.test(c.target.tagName)){var d=a(this);if(c.preventDefault(),c.stopPropagation(),!d.is(".disabled, :disabled")){var e=b(d),g=e.hasClass("open");if(!g&&27!=c.which||g&&27==c.which)return 27==c.which&&e.find(f).trigger("focus"),d.trigger("click");var h=" li:not(.disabled):visible a",i=e.find(".dropdown-menu"+h);if(i.length){var j=i.index(c.target);38==c.which&&j>0&&j--,40==c.which&&j<i.length-1&&j++,~j||(j=0),i.eq(j).trigger("focus")}}}};var h=a.fn.dropdown;a.fn.dropdown=d,a.fn.dropdown.Constructor=g,a.fn.dropdown.noConflict=function(){return a.fn.dropdown=h,this},a(document).on("click.bs.dropdown.data-api",c).on("click.bs.dropdown.data-api",".dropdown form",function(a){a.stopPropagation()}).on("click.bs.dropdown.data-api",f,g.prototype.toggle).on("keydown.bs.dropdown.data-api",f,g.prototype.keydown).on("keydown.bs.dropdown.data-api",".dropdown-menu",g.prototype.keydown)}(jQuery),+function(a){"use strict";function b(b,d){return this.each(function(){var e=a(this),f=e.data("bs.modal"),g=a.extend({},c.DEFAULTS,e.data(),"object"==typeof b&&b);f||e.data("bs.modal",f=new c(this,g)),"string"==typeof b?f[b](d):g.show&&f.show(d)})}var c=function(b,c){this.options=c,this.$body=a(document.body),this.$element=a(b),this.$dialog=this.$element.find(".modal-dialog"),this.$backdrop=null,this.isShown=null,this.originalBodyPad=null,this.scrollbarWidth=0,this.ignoreBackdropClick=!1,this.options.remote&&this.$element.find(".modal-content").load(this.options.remote,a.proxy(function(){this.$element.trigger("loaded.bs.modal")},this))};c.VERSION="3.3.7",c.TRANSITION_DURATION=300,c.BACKDROP_TRANSITION_DURATION=150,c.DEFAULTS={backdrop:!0,keyboard:!0,show:!0},c.prototype.toggle=function(a){return this.isShown?this.hide():this.show(a)},c.prototype.show=function(b){var d=this,e=a.Event("show.bs.modal",{relatedTarget:b});this.$element.trigger(e),this.isShown||e.isDefaultPrevented()||(this.isShown=!0,this.checkScrollbar(),this.setScrollbar(),this.$body.addClass("modal-open"),this.escape(),this.resize(),this.$element.on("click.dismiss.bs.modal",'[data-dismiss="modal"]',a.proxy(this.hide,this)),this.$dialog.on("mousedown.dismiss.bs.modal",function(){d.$element.one("mouseup.dismiss.bs.modal",function(b){a(b.target).is(d.$element)&&(d.ignoreBackdropClick=!0)})}),this.backdrop(function(){var e=a.support.transition&&d.$element.hasClass("fade");d.$element.parent().length||d.$element.appendTo(d.$body),d.$element.show().scrollTop(0),d.adjustDialog(),e&&d.$element[0].offsetWidth,d.$element.addClass("in"),d.enforceFocus();var f=a.Event("shown.bs.modal",{relatedTarget:b});e?d.$dialog.one("bsTransitionEnd",function(){d.$element.trigger("focus").trigger(f)}).emulateTransitionEnd(c.TRANSITION_DURATION):d.$element.trigger("focus").trigger(f)}))},c.prototype.hide=function(b){b&&b.preventDefault(),b=a.Event("hide.bs.modal"),this.$element.trigger(b),this.isShown&&!b.isDefaultPrevented()&&(this.isShown=!1,this.escape(),this.resize(),a(document).off("focusin.bs.modal"),this.$element.removeClass("in").off("click.dismiss.bs.modal").off("mouseup.dismiss.bs.modal"),this.$dialog.off("mousedown.dismiss.bs.modal"),a.support.transition&&this.$element.hasClass("fade")?this.$element.one("bsTransitionEnd",a.proxy(this.hideModal,this)).emulateTransitionEnd(c.TRANSITION_DURATION):this.hideModal())},c.prototype.enforceFocus=function(){a(document).off("focusin.bs.modal").on("focusin.bs.modal",a.proxy(function(a){document===a.target||this.$element[0]===a.target||this.$element.has(a.target).length||this.$element.trigger("focus")},this))},c.prototype.escape=function(){this.isShown&&this.options.keyboard?this.$element.on("keydown.dismiss.bs.modal",a.proxy(function(a){27==a.which&&this.hide()},this)):this.isShown||this.$element.off("keydown.dismiss.bs.modal")},c.prototype.resize=function(){this.isShown?a(window).on("resize.bs.modal",a.proxy(this.handleUpdate,this)):a(window).off("resize.bs.modal")},c.prototype.hideModal=function(){var a=this;this.$element.hide(),this.backdrop(function(){a.$body.removeClass("modal-open"),a.resetAdjustments(),a.resetScrollbar(),a.$element.trigger("hidden.bs.modal")})},c.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null},c.prototype.backdrop=function(b){var d=this,e=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var f=a.support.transition&&e;if(this.$backdrop=a(document.createElement("div")).addClass("modal-backdrop "+e).appendTo(this.$body),this.$element.on("click.dismiss.bs.modal",a.proxy(function(a){return this.ignoreBackdropClick?void(this.ignoreBackdropClick=!1):void(a.target===a.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus():this.hide()))},this)),f&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!b)return;f?this.$backdrop.one("bsTransitionEnd",b).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION):b()}else if(!this.isShown&&this.$backdrop){this.$backdrop.removeClass("in");var g=function(){d.removeBackdrop(),b&&b()};a.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one("bsTransitionEnd",g).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION):g()}else b&&b()},c.prototype.handleUpdate=function(){this.adjustDialog()},c.prototype.adjustDialog=function(){var a=this.$element[0].scrollHeight>document.documentElement.clientHeight;this.$element.css({paddingLeft:!this.bodyIsOverflowing&&a?this.scrollbarWidth:"",paddingRight:this.bodyIsOverflowing&&!a?this.scrollbarWidth:""})},c.prototype.resetAdjustments=function(){this.$element.css({paddingLeft:"",paddingRight:""})},c.prototype.checkScrollbar=function(){var a=window.innerWidth;if(!a){var b=document.documentElement.getBoundingClientRect();a=b.right-Math.abs(b.left)}this.bodyIsOverflowing=document.body.clientWidth<a,this.scrollbarWidth=this.measureScrollbar()},c.prototype.setScrollbar=function(){var a=parseInt(this.$body.css("padding-right")||0,10);this.originalBodyPad=document.body.style.paddingRight||"",this.bodyIsOverflowing&&this.$body.css("padding-right",a+this.scrollbarWidth)},c.prototype.resetScrollbar=function(){this.$body.css("padding-right",this.originalBodyPad)},c.prototype.measureScrollbar=function(){var a=document.createElement("div");a.className="modal-scrollbar-measure",this.$body.append(a);var b=a.offsetWidth-a.clientWidth;return this.$body[0].removeChild(a),b};var d=a.fn.modal;a.fn.modal=b,a.fn.modal.Constructor=c,a.fn.modal.noConflict=function(){return a.fn.modal=d,this},a(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(c){var d=a(this),e=d.attr("href"),f=a(d.attr("data-target")||e&&e.replace(/.*(?=#[^\s]+$)/,"")),g=f.data("bs.modal")?"toggle":a.extend({remote:!/#/.test(e)&&e},f.data(),d.data());d.is("a")&&c.preventDefault(),f.one("show.bs.modal",function(a){a.isDefaultPrevented()||f.one("hidden.bs.modal",function(){d.is(":visible")&&d.trigger("focus")})}),b.call(f,g,this)})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.tooltip"),f="object"==typeof b&&b;!e&&/destroy|hide/.test(b)||(e||d.data("bs.tooltip",e=new c(this,f)),"string"==typeof b&&e[b]())})}var c=function(a,b){this.type=null,this.options=null,this.enabled=null,this.timeout=null,this.hoverState=null,this.$element=null,this.inState=null,this.init("tooltip",a,b)};c.VERSION="3.3.7",c.TRANSITION_DURATION=150,c.DEFAULTS={animation:!0,placement:"top",selector:!1,template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,container:!1,viewport:{selector:"body",padding:0}},c.prototype.init=function(b,c,d){if(this.enabled=!0,this.type=b,this.$element=a(c),this.options=this.getOptions(d),this.$viewport=this.options.viewport&&a(a.isFunction(this.options.viewport)?this.options.viewport.call(this,this.$element):this.options.viewport.selector||this.options.viewport),this.inState={click:!1,hover:!1,focus:!1},this.$element[0]instanceof document.constructor&&!this.options.selector)throw new Error("`selector` option must be specified when initializing "+this.type+" on the window.document object!");for(var e=this.options.trigger.split(" "),f=e.length;f--;){var g=e[f];if("click"==g)this.$element.on("click."+this.type,this.options.selector,a.proxy(this.toggle,this));else if("manual"!=g){var h="hover"==g?"mouseenter":"focusin",i="hover"==g?"mouseleave":"focusout";this.$element.on(h+"."+this.type,this.options.selector,a.proxy(this.enter,this)),this.$element.on(i+"."+this.type,this.options.selector,a.proxy(this.leave,this))}}this.options.selector?this._options=a.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()},c.prototype.getDefaults=function(){return c.DEFAULTS},c.prototype.getOptions=function(b){return b=a.extend({},this.getDefaults(),this.$element.data(),b),b.delay&&"number"==typeof b.delay&&(b.delay={show:b.delay,hide:b.delay}),b},c.prototype.getDelegateOptions=function(){var b={},c=this.getDefaults();return this._options&&a.each(this._options,function(a,d){c[a]!=d&&(b[a]=d)}),b},c.prototype.enter=function(b){var c=b instanceof this.constructor?b:a(b.currentTarget).data("bs."+this.type);return c||(c=new this.constructor(b.currentTarget,this.getDelegateOptions()),a(b.currentTarget).data("bs."+this.type,c)),b instanceof a.Event&&(c.inState["focusin"==b.type?"focus":"hover"]=!0),c.tip().hasClass("in")||"in"==c.hoverState?void(c.hoverState="in"):(clearTimeout(c.timeout),c.hoverState="in",c.options.delay&&c.options.delay.show?void(c.timeout=setTimeout(function(){"in"==c.hoverState&&c.show()},c.options.delay.show)):c.show())},c.prototype.isInStateTrue=function(){for(var a in this.inState)if(this.inState[a])return!0;return!1},c.prototype.leave=function(b){var c=b instanceof this.constructor?b:a(b.currentTarget).data("bs."+this.type);if(c||(c=new this.constructor(b.currentTarget,this.getDelegateOptions()),a(b.currentTarget).data("bs."+this.type,c)),b instanceof a.Event&&(c.inState["focusout"==b.type?"focus":"hover"]=!1),!c.isInStateTrue())return clearTimeout(c.timeout),c.hoverState="out",c.options.delay&&c.options.delay.hide?void(c.timeout=setTimeout(function(){"out"==c.hoverState&&c.hide()},c.options.delay.hide)):c.hide()},c.prototype.show=function(){var b=a.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){this.$element.trigger(b);var d=a.contains(this.$element[0].ownerDocument.documentElement,this.$element[0]);if(b.isDefaultPrevented()||!d)return;var e=this,f=this.tip(),g=this.getUID(this.type);this.setContent(),f.attr("id",g),this.$element.attr("aria-describedby",g),this.options.animation&&f.addClass("fade");var h="function"==typeof this.options.placement?this.options.placement.call(this,f[0],this.$element[0]):this.options.placement,i=/\s?auto?\s?/i,j=i.test(h);j&&(h=h.replace(i,"")||"top"),f.detach().css({top:0,left:0,display:"block"}).addClass(h).data("bs."+this.type,this),this.options.container?f.appendTo(this.options.container):f.insertAfter(this.$element),this.$element.trigger("inserted.bs."+this.type);var k=this.getPosition(),l=f[0].offsetWidth,m=f[0].offsetHeight;if(j){var n=h,o=this.getPosition(this.$viewport);h="bottom"==h&&k.bottom+m>o.bottom?"top":"top"==h&&k.top-m<o.top?"bottom":"right"==h&&k.right+l>o.width?"left":"left"==h&&k.left-l<o.left?"right":h,f.removeClass(n).addClass(h)}var p=this.getCalculatedOffset(h,k,l,m);this.applyPlacement(p,h);var q=function(){var a=e.hoverState;e.$element.trigger("shown.bs."+e.type),e.hoverState=null,"out"==a&&e.leave(e)};a.support.transition&&this.$tip.hasClass("fade")?f.one("bsTransitionEnd",q).emulateTransitionEnd(c.TRANSITION_DURATION):q()}},c.prototype.applyPlacement=function(b,c){var d=this.tip(),e=d[0].offsetWidth,f=d[0].offsetHeight,g=parseInt(d.css("margin-top"),10),h=parseInt(d.css("margin-left"),10);isNaN(g)&&(g=0),isNaN(h)&&(h=0),b.top+=g,b.left+=h,a.offset.setOffset(d[0],a.extend({using:function(a){d.css({top:Math.round(a.top),left:Math.round(a.left)})}},b),0),d.addClass("in");var i=d[0].offsetWidth,j=d[0].offsetHeight;"top"==c&&j!=f&&(b.top=b.top+f-j);var k=this.getViewportAdjustedDelta(c,b,i,j);k.left?b.left+=k.left:b.top+=k.top;var l=/top|bottom/.test(c),m=l?2*k.left-e+i:2*k.top-f+j,n=l?"offsetWidth":"offsetHeight";d.offset(b),this.replaceArrow(m,d[0][n],l)},c.prototype.replaceArrow=function(a,b,c){this.arrow().css(c?"left":"top",50*(1-a/b)+"%").css(c?"top":"left","")},c.prototype.setContent=function(){var a=this.tip(),b=this.getTitle();a.find(".tooltip-inner")[this.options.html?"html":"text"](b),a.removeClass("fade in top bottom left right")},c.prototype.hide=function(b){function d(){"in"!=e.hoverState&&f.detach(),e.$element&&e.$element.removeAttr("aria-describedby").trigger("hidden.bs."+e.type),b&&b()}var e=this,f=a(this.$tip),g=a.Event("hide.bs."+this.type);if(this.$element.trigger(g),!g.isDefaultPrevented())return f.removeClass("in"),a.support.transition&&f.hasClass("fade")?f.one("bsTransitionEnd",d).emulateTransitionEnd(c.TRANSITION_DURATION):d(),this.hoverState=null,this},c.prototype.fixTitle=function(){var a=this.$element;(a.attr("title")||"string"!=typeof a.attr("data-original-title"))&&a.attr("data-original-title",a.attr("title")||"").attr("title","")},c.prototype.hasContent=function(){return this.getTitle()},c.prototype.getPosition=function(b){b=b||this.$element;var c=b[0],d="BODY"==c.tagName,e=c.getBoundingClientRect();null==e.width&&(e=a.extend({},e,{width:e.right-e.left,height:e.bottom-e.top}));var f=window.SVGElement&&c instanceof window.SVGElement,g=d?{top:0,left:0}:f?null:b.offset(),h={scroll:d?document.documentElement.scrollTop||document.body.scrollTop:b.scrollTop()},i=d?{width:a(window).width(),height:a(window).height()}:null;return a.extend({},e,h,i,g)},c.prototype.getCalculatedOffset=function(a,b,c,d){return"bottom"==a?{top:b.top+b.height,left:b.left+b.width/2-c/2}:"top"==a?{top:b.top-d,left:b.left+b.width/2-c/2}:"left"==a?{top:b.top+b.height/2-d/2,left:b.left-c}:{top:b.top+b.height/2-d/2,left:b.left+b.width}},c.prototype.getViewportAdjustedDelta=function(a,b,c,d){var e={top:0,left:0};if(!this.$viewport)return e;var f=this.options.viewport&&this.options.viewport.padding||0,g=this.getPosition(this.$viewport);if(/right|left/.test(a)){var h=b.top-f-g.scroll,i=b.top+f-g.scroll+d;h<g.top?e.top=g.top-h:i>g.top+g.height&&(e.top=g.top+g.height-i)}else{var j=b.left-f,k=b.left+f+c;j<g.left?e.left=g.left-j:k>g.right&&(e.left=g.left+g.width-k)}return e},c.prototype.getTitle=function(){var a,b=this.$element,c=this.options;return a=b.attr("data-original-title")||("function"==typeof c.title?c.title.call(b[0]):c.title)},c.prototype.getUID=function(a){do a+=~~(1e6*Math.random());while(document.getElementById(a));return a},c.prototype.tip=function(){if(!this.$tip&&(this.$tip=a(this.options.template),1!=this.$tip.length))throw new Error(this.type+" `template` option must consist of exactly 1 top-level element!");return this.$tip},c.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".tooltip-arrow")},c.prototype.enable=function(){this.enabled=!0},c.prototype.disable=function(){this.enabled=!1},c.prototype.toggleEnabled=function(){this.enabled=!this.enabled},c.prototype.toggle=function(b){var c=this;b&&(c=a(b.currentTarget).data("bs."+this.type),c||(c=new this.constructor(b.currentTarget,this.getDelegateOptions()),a(b.currentTarget).data("bs."+this.type,c))),b?(c.inState.click=!c.inState.click,c.isInStateTrue()?c.enter(c):c.leave(c)):c.tip().hasClass("in")?c.leave(c):c.enter(c)},c.prototype.destroy=function(){var a=this;clearTimeout(this.timeout),this.hide(function(){a.$element.off("."+a.type).removeData("bs."+a.type),a.$tip&&a.$tip.detach(),a.$tip=null,a.$arrow=null,a.$viewport=null,a.$element=null})};var d=a.fn.tooltip;a.fn.tooltip=b,a.fn.tooltip.Constructor=c,a.fn.tooltip.noConflict=function(){return a.fn.tooltip=d,this}}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.popover"),f="object"==typeof b&&b;!e&&/destroy|hide/.test(b)||(e||d.data("bs.popover",e=new c(this,f)),"string"==typeof b&&e[b]())})}var c=function(a,b){this.init("popover",a,b)};if(!a.fn.tooltip)throw new Error("Popover requires tooltip.js");c.VERSION="3.3.7",c.DEFAULTS=a.extend({},a.fn.tooltip.Constructor.DEFAULTS,{placement:"right",trigger:"click",content:"",template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'}),c.prototype=a.extend({},a.fn.tooltip.Constructor.prototype),c.prototype.constructor=c,c.prototype.getDefaults=function(){return c.DEFAULTS},c.prototype.setContent=function(){var a=this.tip(),b=this.getTitle(),c=this.getContent();a.find(".popover-title")[this.options.html?"html":"text"](b),a.find(".popover-content").children().detach().end()[this.options.html?"string"==typeof c?"html":"append":"text"](c),a.removeClass("fade top bottom left right in"),a.find(".popover-title").html()||a.find(".popover-title").hide()},c.prototype.hasContent=function(){return this.getTitle()||this.getContent()},c.prototype.getContent=function(){var a=this.$element,b=this.options;return a.attr("data-content")||("function"==typeof b.content?b.content.call(a[0]):b.content)},c.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")};var d=a.fn.popover;a.fn.popover=b,a.fn.popover.Constructor=c,a.fn.popover.noConflict=function(){return a.fn.popover=d,this}}(jQuery),+function(a){"use strict";function b(c,d){this.$body=a(document.body),this.$scrollElement=a(a(c).is(document.body)?window:c),this.options=a.extend({},b.DEFAULTS,d),this.selector=(this.options.target||"")+" .nav li > a",this.offsets=[],this.targets=[],this.activeTarget=null,this.scrollHeight=0,this.$scrollElement.on("scroll.bs.scrollspy",a.proxy(this.process,this)),this.refresh(),this.process()}function c(c){return this.each(function(){var d=a(this),e=d.data("bs.scrollspy"),f="object"==typeof c&&c;e||d.data("bs.scrollspy",e=new b(this,f)),"string"==typeof c&&e[c]()})}b.VERSION="3.3.7",b.DEFAULTS={offset:10},b.prototype.getScrollHeight=function(){return this.$scrollElement[0].scrollHeight||Math.max(this.$body[0].scrollHeight,document.documentElement.scrollHeight)},b.prototype.refresh=function(){var b=this,c="offset",d=0;this.offsets=[],this.targets=[],this.scrollHeight=this.getScrollHeight(),a.isWindow(this.$scrollElement[0])||(c="position",d=this.$scrollElement.scrollTop()),this.$body.find(this.selector).map(function(){var b=a(this),e=b.data("target")||b.attr("href"),f=/^#./.test(e)&&a(e);return f&&f.length&&f.is(":visible")&&[[f[c]().top+d,e]]||null}).sort(function(a,b){return a[0]-b[0]}).each(function(){b.offsets.push(this[0]),b.targets.push(this[1])})},b.prototype.process=function(){var a,b=this.$scrollElement.scrollTop()+this.options.offset,c=this.getScrollHeight(),d=this.options.offset+c-this.$scrollElement.height(),e=this.offsets,f=this.targets,g=this.activeTarget;if(this.scrollHeight!=c&&this.refresh(),b>=d)return g!=(a=f[f.length-1])&&this.activate(a);if(g&&b<e[0])return this.activeTarget=null,this.clear();for(a=e.length;a--;)g!=f[a]&&b>=e[a]&&(void 0===e[a+1]||b<e[a+1])&&this.activate(f[a])},b.prototype.activate=function(b){

this.activeTarget=b,this.clear();var c=this.selector+'[data-target="'+b+'"],'+this.selector+'[href="'+b+'"]',d=a(c).parents("li").addClass("active");d.parent(".dropdown-menu").length&&(d=d.closest("li.dropdown").addClass("active")),d.trigger("activate.bs.scrollspy")},b.prototype.clear=function(){a(this.selector).parentsUntil(this.options.target,".active").removeClass("active")};var d=a.fn.scrollspy;a.fn.scrollspy=c,a.fn.scrollspy.Constructor=b,a.fn.scrollspy.noConflict=function(){return a.fn.scrollspy=d,this},a(window).on("load.bs.scrollspy.data-api",function(){a('[data-spy="scroll"]').each(function(){var b=a(this);c.call(b,b.data())})})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.tab");e||d.data("bs.tab",e=new c(this)),"string"==typeof b&&e[b]()})}var c=function(b){this.element=a(b)};c.VERSION="3.3.7",c.TRANSITION_DURATION=150,c.prototype.show=function(){var b=this.element,c=b.closest("ul:not(.dropdown-menu)"),d=b.data("target");if(d||(d=b.attr("href"),d=d&&d.replace(/.*(?=#[^\s]*$)/,"")),!b.parent("li").hasClass("active")){var e=c.find(".active:last a"),f=a.Event("hide.bs.tab",{relatedTarget:b[0]}),g=a.Event("show.bs.tab",{relatedTarget:e[0]});if(e.trigger(f),b.trigger(g),!g.isDefaultPrevented()&&!f.isDefaultPrevented()){var h=a(d);this.activate(b.closest("li"),c),this.activate(h,h.parent(),function(){e.trigger({type:"hidden.bs.tab",relatedTarget:b[0]}),b.trigger({type:"shown.bs.tab",relatedTarget:e[0]})})}}},c.prototype.activate=function(b,d,e){function f(){g.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!1),b.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded",!0),h?(b[0].offsetWidth,b.addClass("in")):b.removeClass("fade"),b.parent(".dropdown-menu").length&&b.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!0),e&&e()}var g=d.find("> .active"),h=e&&a.support.transition&&(g.length&&g.hasClass("fade")||!!d.find("> .fade").length);g.length&&h?g.one("bsTransitionEnd",f).emulateTransitionEnd(c.TRANSITION_DURATION):f(),g.removeClass("in")};var d=a.fn.tab;a.fn.tab=b,a.fn.tab.Constructor=c,a.fn.tab.noConflict=function(){return a.fn.tab=d,this};var e=function(c){c.preventDefault(),b.call(a(this),"show")};a(document).on("click.bs.tab.data-api",'[data-toggle="tab"]',e).on("click.bs.tab.data-api",'[data-toggle="pill"]',e)}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.affix"),f="object"==typeof b&&b;e||d.data("bs.affix",e=new c(this,f)),"string"==typeof b&&e[b]()})}var c=function(b,d){this.options=a.extend({},c.DEFAULTS,d),this.$target=a(this.options.target).on("scroll.bs.affix.data-api",a.proxy(this.checkPosition,this)).on("click.bs.affix.data-api",a.proxy(this.checkPositionWithEventLoop,this)),this.$element=a(b),this.affixed=null,this.unpin=null,this.pinnedOffset=null,this.checkPosition()};c.VERSION="3.3.7",c.RESET="affix affix-top affix-bottom",c.DEFAULTS={offset:0,target:window},c.prototype.getState=function(a,b,c,d){var e=this.$target.scrollTop(),f=this.$element.offset(),g=this.$target.height();if(null!=c&&"top"==this.affixed)return e<c&&"top";if("bottom"==this.affixed)return null!=c?!(e+this.unpin<=f.top)&&"bottom":!(e+g<=a-d)&&"bottom";var h=null==this.affixed,i=h?e:f.top,j=h?g:b;return null!=c&&e<=c?"top":null!=d&&i+j>=a-d&&"bottom"},c.prototype.getPinnedOffset=function(){if(this.pinnedOffset)return this.pinnedOffset;this.$element.removeClass(c.RESET).addClass("affix");var a=this.$target.scrollTop(),b=this.$element.offset();return this.pinnedOffset=b.top-a},c.prototype.checkPositionWithEventLoop=function(){setTimeout(a.proxy(this.checkPosition,this),1)},c.prototype.checkPosition=function(){if(this.$element.is(":visible")){var b=this.$element.height(),d=this.options.offset,e=d.top,f=d.bottom,g=Math.max(a(document).height(),a(document.body).height());"object"!=typeof d&&(f=e=d),"function"==typeof e&&(e=d.top(this.$element)),"function"==typeof f&&(f=d.bottom(this.$element));var h=this.getState(g,b,e,f);if(this.affixed!=h){null!=this.unpin&&this.$element.css("top","");var i="affix"+(h?"-"+h:""),j=a.Event(i+".bs.affix");if(this.$element.trigger(j),j.isDefaultPrevented())return;this.affixed=h,this.unpin="bottom"==h?this.getPinnedOffset():null,this.$element.removeClass(c.RESET).addClass(i).trigger(i.replace("affix","affixed")+".bs.affix")}"bottom"==h&&this.$element.offset({top:g-b-f})}};var d=a.fn.affix;a.fn.affix=b,a.fn.affix.Constructor=c,a.fn.affix.noConflict=function(){return a.fn.affix=d,this},a(window).on("load",function(){a('[data-spy="affix"]').each(function(){var c=a(this),d=c.data();d.offset=d.offset||{},null!=d.offsetBottom&&(d.offset.bottom=d.offsetBottom),null!=d.offsetTop&&(d.offset.top=d.offsetTop),b.call(c,d)})})}(jQuery);





!function(a,b){"use strict";function c(a){this.callback=a,this.ticking=!1}function d(a){if(arguments.length<=0)throw new Error("Missing arguments in extend function");var b,c,e=a||{};for(c=1;c<arguments.length;c++){var f=arguments[c]||{};for(b in f)e[b]="object"==typeof e[b]?d(e[b],f[b]):e[b]||f[b]}return e}function e(a){return a===Object(a)?a:{down:a,up:a}}function f(a,b){b=d(b,f.options),this.lastKnownScrollY=0,this.elem=a,this.debouncer=new c(this.update.bind(this)),this.tolerance=e(b.tolerance),this.classes=b.classes,this.offset=b.offset,this.initialised=!1,this.onPin=b.onPin,this.onUnpin=b.onUnpin,this.onTop=b.onTop,this.onNotTop=b.onNotTop}var g={bind:!!function(){}.bind,classList:"classList"in b.documentElement,rAF:!!(a.requestAnimationFrame||a.webkitRequestAnimationFrame||a.mozRequestAnimationFrame)};a.requestAnimationFrame=a.requestAnimationFrame||a.webkitRequestAnimationFrame||a.mozRequestAnimationFrame,c.prototype={constructor:c,update:function(){this.callback&&this.callback(),this.ticking=!1},requestTick:function(){this.ticking||(requestAnimationFrame(this.rafCallback||(this.rafCallback=this.update.bind(this))),this.ticking=!0)},handleEvent:function(){this.requestTick()}},f.prototype={constructor:f,init:function(){return f.cutsTheMustard?(this.elem.classList.add(this.classes.initial),setTimeout(this.attachEvent.bind(this),100),this):void 0},destroy:function(){var b=this.classes;this.initialised=!1,a.removeEventListener("scroll",this.debouncer,!1),this.elem.classList.remove(b.unpinned,b.pinned,b.top,b.initial)},attachEvent:function(){this.initialised||(this.lastKnownScrollY=this.getScrollY(),this.initialised=!0,a.addEventListener("scroll",this.debouncer,!1),this.debouncer.handleEvent())},unpin:function(){var a=this.elem.classList,b=this.classes;(a.contains(b.pinned)||!a.contains(b.unpinned))&&(a.add(b.unpinned),a.remove(b.pinned),this.onUnpin&&this.onUnpin.call(this))},pin:function(){var a=this.elem.classList,b=this.classes;a.contains(b.unpinned)&&(a.remove(b.unpinned),a.add(b.pinned),this.onPin&&this.onPin.call(this))},top:function(){var a=this.elem.classList,b=this.classes;a.contains(b.top)||(a.add(b.top),a.remove(b.notTop),this.onTop&&this.onTop.call(this))},notTop:function(){var a=this.elem.classList,b=this.classes;a.contains(b.notTop)||(a.add(b.notTop),a.remove(b.top),this.onNotTop&&this.onNotTop.call(this))},getScrollY:function(){return void 0!==a.pageYOffset?a.pageYOffset:(b.documentElement||b.body.parentNode||b.body).scrollTop},getViewportHeight:function(){return a.innerHeight||b.documentElement.clientHeight||b.body.clientHeight},getDocumentHeight:function(){var a=b.body,c=b.documentElement;return Math.max(a.scrollHeight,c.scrollHeight,a.offsetHeight,c.offsetHeight,a.clientHeight,c.clientHeight)},isOutOfBounds:function(a){var b=0>a,c=a+this.getViewportHeight()>this.getDocumentHeight();return b||c},toleranceExceeded:function(a,b){return Math.abs(a-this.lastKnownScrollY)>=this.tolerance[b]},shouldUnpin:function(a,b){var c=a>this.lastKnownScrollY,d=a>=this.offset;return c&&d&&b},shouldPin:function(a,b){var c=a<this.lastKnownScrollY,d=a<=this.offset;return c&&b||d},update:function(){var a=this.getScrollY(),b=a>this.lastKnownScrollY?"down":"up",c=this.toleranceExceeded(a,b);this.isOutOfBounds(a)||(a<=this.offset?this.top():this.notTop(),this.shouldUnpin(a,c)?this.unpin():this.shouldPin(a,c)&&this.pin(),this.lastKnownScrollY=a)}},f.options={tolerance:{up:0,down:0},offset:0,classes:{pinned:"headroom--pinned",unpinned:"headroom--unpinned",top:"headroom--top",notTop:"headroom--not-top",initial:"headroom"}},f.cutsTheMustard="undefined"!=typeof g&&g.rAF&&g.bind&&g.classList,a.Headroom=f}(window,document);



!function(a){a&&(a.fn.headroom=function(b){return this.each(function(){var c=a(this),d=c.data("headroom"),e="object"==typeof b&&b;e=a.extend(!0,{},Headroom.options,e),d||(d=new Headroom(this,e),d.init(),c.data("headroom",d)),"string"==typeof b&&d[b]()})},a("[data-headroom]").each(function(){var b=a(this);b.headroom(b.data())}))}(window.Zepto||window.jQuery);





;(function(root,factory){if(typeof define==='function'&&define.amd){define(['jquery'],factory)}else if(typeof exports==='object'){module.exports=factory(require('jquery'))}else{root.jquery_mmenu_js=factory(root.jQuery)}}(this,function(jQuery){!function(e){function t(){e[n].glbl||(l={$wndw:e(window),$docu:e(document),$html:e("html"),$body:e("body")},s={},a={},r={},e.each([s,a,r],function(e,t){t.add=function(e){e=e.split(" ");for(var n=0,i=e.length;n<i;n++)t[e[n]]=t.mm(e[n])}}),s.mm=function(e){return"mm-"+e},s.add("wrapper menu panels panel nopanel navbar listview nolistview listitem btn hidden"),s.umm=function(e){return"mm-"==e.slice(0,3)&&(e=e.slice(3)),e},a.mm=function(e){return"mm-"+e},a.add("parent child title"),r.mm=function(e){return e+".mm"},r.add("transitionend webkitTransitionEnd click scroll resize keydown mousedown mouseup touchstart touchmove touchend orientationchange"),e[n]._c=s,e[n]._d=a,e[n]._e=r,e[n].glbl=l)}var n="mmenu",i="7.0.3";if(!(e[n]&&e[n].version>i)){e[n]=function(e,t,n){return this.$menu=e,this._api=["bind","getInstance","initPanels","openPanel","closePanel","closeAllPanels","setSelected"],this.opts=t,this.conf=n,this.vars={},this.cbck={},this.mtch={},"function"==typeof this.___deprecated&&this.___deprecated(),this._initHooks(),this._initWrappers(),this._initAddons(),this._initExtensions(),this._initMenu(),this._initPanels(),this._initOpened(),this._initAnchors(),this._initMatchMedia(),"function"==typeof this.___debug&&this.___debug(),this},e[n].version=i,e[n].uniqueId=0,e[n].wrappers={},e[n].addons={},e[n].defaults={hooks:{},extensions:[],wrappers:[],navbar:{add:!0,title:"Menu",titleLink:"parent"},onClick:{setSelected:!0},slidingSubmenus:!0},e[n].configuration={classNames:{divider:"Divider",inset:"Inset",nolistview:"NoListview",nopanel:"NoPanel",panel:"Panel",selected:"Selected",spacer:"Spacer",vertical:"Vertical"},clone:!1,openingInterval:25,panelNodetype:"ul, ol, div",transitionDuration:400},e[n].prototype={getInstance:function(){return this},initPanels:function(e){this._initPanels(e)},openPanel:function(t,i){if(this.trigger("openPanel:before",t),t&&t.length&&(t.is("."+s.panel)||(t=t.closest("."+s.panel)),t.is("."+s.panel))){var r=this;if("boolean"!=typeof i&&(i=!0),t.parent("."+s.listitem+"_vertical").length)t.parents("."+s.listitem+"_vertical").addClass(s.listitem+"_opened").children("."+s.panel).removeClass(s.hidden),this.openPanel(t.parents("."+s.panel).not(function(){return e(this).parent("."+s.listitem+"_vertical").length}).first()),this.trigger("openPanel:start",t),this.trigger("openPanel:finish",t);else{if(t.hasClass(s.panel+"_opened"))return;var l=this.$pnls.children("."+s.panel),o=this.$pnls.children("."+s.panel+"_opened");if(!e[n].support.csstransitions)return o.addClass(s.hidden).removeClass(s.panel+"_opened"),t.removeClass(s.hidden).addClass(s.panel+"_opened"),this.trigger("openPanel:start",t),void this.trigger("openPanel:finish",t);l.not(t).removeClass(s.panel+"_opened-parent");for(var d=t.data(a.parent);d;)d=d.closest("."+s.panel),d.parent("."+s.listitem+"_vertical").length||d.addClass(s.panel+"_opened-parent"),d=d.data(a.parent);l.removeClass(s.panel+"_highest").not(o).not(t).addClass(s.hidden),t.removeClass(s.hidden);var c=function(){o.removeClass(s.panel+"_opened"),t.addClass(s.panel+"_opened"),t.hasClass(s.panel+"_opened-parent")?(o.addClass(s.panel+"_highest"),t.removeClass(s.panel+"_opened-parent")):(o.addClass(s.panel+"_opened-parent"),t.addClass(s.panel+"_highest")),r.trigger("openPanel:start",t)},h=function(){o.removeClass(s.panel+"_highest").addClass(s.hidden),t.removeClass(s.panel+"_highest"),r.trigger("openPanel:finish",t)};i&&!t.hasClass(s.panel+"_noanimation")?setTimeout(function(){r.__transitionend(t,function(){h()},r.conf.transitionDuration),c()},r.conf.openingInterval):(c(),h())}this.trigger("openPanel:after",t)}},closePanel:function(e){this.trigger("closePanel:before",e);var t=e.parent();t.hasClass(s.listitem+"_vertical")&&(t.removeClass(s.listitem+"_opened"),e.addClass(s.hidden),this.trigger("closePanel",e)),this.trigger("closePanel:after",e)},closeAllPanels:function(e){this.trigger("closeAllPanels:before"),this.$pnls.find("."+s.listview).children().removeClass(s.listitem+"_selected").filter("."+s.listitem+"_vertical").removeClass(s.listitem+"_opened");var t=this.$pnls.children("."+s.panel),n=e&&e.length?e:t.first();this.$pnls.children("."+s.panel).not(n).removeClass(s.panel+"_opened").removeClass(s.panel+"_opened-parent").removeClass(s.panel+"_highest").addClass(s.hidden),this.openPanel(n,!1),this.trigger("closeAllPanels:after")},togglePanel:function(e){var t=e.parent();t.hasClass(s.listitem+"_vertical")&&this[t.hasClass(s.listitem+"_opened")?"closePanel":"openPanel"](e)},setSelected:function(e){this.trigger("setSelected:before",e),this.$menu.find("."+s.listitem+"_selected").removeClass(s.listitem+"_selected"),e.addClass(s.listitem+"_selected"),this.trigger("setSelected:after",e)},bind:function(e,t){this.cbck[e]=this.cbck[e]||[],this.cbck[e].push(t)},trigger:function(){var e=this,t=Array.prototype.slice.call(arguments),n=t.shift();if(this.cbck[n])for(var i=0,s=this.cbck[n].length;i<s;i++)this.cbck[n][i].apply(e,t)},matchMedia:function(e,t,n){var i={yes:t,no:n};this.mtch[e]=this.mtch[e]||[],this.mtch[e].push(i)},_initHooks:function(){for(var e in this.opts.hooks)this.bind(e,this.opts.hooks[e])},_initWrappers:function(){this.trigger("initWrappers:before");for(var t=0;t<this.opts.wrappers.length;t++){var i=e[n].wrappers[this.opts.wrappers[t]];"function"==typeof i&&i.call(this)}this.trigger("initWrappers:after")},_initAddons:function(){this.trigger("initAddons:before");var t;for(t in e[n].addons)e[n].addons[t].add.call(this),e[n].addons[t].add=function(){};for(t in e[n].addons)e[n].addons[t].setup.call(this);this.trigger("initAddons:after")},_initExtensions:function(){this.trigger("initExtensions:before");var e=this;this.opts.extensions.constructor===Array&&(this.opts.extensions={all:this.opts.extensions});for(var t in this.opts.extensions)this.opts.extensions[t]=this.opts.extensions[t].length?s.menu+"_"+this.opts.extensions[t].join(" "+s.menu+"_"):"",this.opts.extensions[t]&&!function(t){e.matchMedia(t,function(){this.$menu.addClass(this.opts.extensions[t])},function(){this.$menu.removeClass(this.opts.extensions[t])})}(t);this.trigger("initExtensions:after")},_initMenu:function(){this.trigger("initMenu:before");this.conf.clone&&(this.$orig=this.$menu,this.$menu=this.$orig.clone(),this.$menu.add(this.$menu.find("[id]")).filter("[id]").each(function(){e(this).attr("id",s.mm(e(this).attr("id")))})),this.$menu.attr("id",this.$menu.attr("id")||this.__getUniqueId()),this.$pnls=e('<div class="'+s.panels+'" />').append(this.$menu.children(this.conf.panelNodetype)).prependTo(this.$menu),this.$menu.addClass(s.menu).parent().addClass(s.wrapper),this.trigger("initMenu:after")},_initPanels:function(t){this.trigger("initPanels:before",t),t=t||this.$pnls.children(this.conf.panelNodetype);var n=e(),i=this,a=function(t){t.filter(i.conf.panelNodetype).each(function(t){var r=i._initPanel(e(this));if(r){i._initNavbar(r),i._initListview(r),n=n.add(r);var l=r.children("."+s.listview).children("li").children(i.conf.panelNodeType).add(r.children("."+i.conf.classNames.panel));l.length&&a(l)}})};a(t),this.trigger("initPanels:after",n)},_initPanel:function(e){this.trigger("initPanel:before",e);if(e.hasClass(s.panel))return e;if(this.__refactorClass(e,this.conf.classNames.panel,s.panel),this.__refactorClass(e,this.conf.classNames.nopanel,s.nopanel),this.__refactorClass(e,this.conf.classNames.inset,s.listview+"_inset"),e.filter("."+s.listview+"_inset").addClass(s.nopanel),e.hasClass(s.nopanel))return!1;var t=e.hasClass(this.conf.classNames.vertical)||!this.opts.slidingSubmenus;e.removeClass(this.conf.classNames.vertical);var n=e.attr("id")||this.__getUniqueId();e.is("ul, ol")&&(e.removeAttr("id"),e.wrap("<div />"),e=e.parent()),e.attr("id",n),e.addClass(s.panel+" "+s.hidden);var i=e.parent("li");return t?i.addClass(s.listitem+"_vertical"):e.appendTo(this.$pnls),i.length&&(i.data(a.child,e),e.data(a.parent,i)),this.trigger("initPanel:after",e),e},_initNavbar:function(t){if(this.trigger("initNavbar:before",t),!t.children("."+s.navbar).length){var n=t.data(a.parent),i=e('<div class="'+s.navbar+'" />'),r=this.__getPanelTitle(t,this.opts.navbar.title),l="";if(n&&n.length){if(n.hasClass(s.listitem+"_vertical"))return;if(n.parent().is("."+s.listview))var o=n.children("a, span").not("."+s.btn+"_next");else var o=n.closest("."+s.panel).find('a[href="#'+t.attr("id")+'"]');o=o.first(),n=o.closest("."+s.panel);var d=n.attr("id");switch(r=this.__getPanelTitle(t,e("<span>"+o.text()+"</span>").text()),this.opts.navbar.titleLink){case"anchor":l=o.attr("href");break;case"parent":l="#"+d}i.append('<a class="'+s.btn+" "+s.btn+"_prev "+s.navbar+'__btn" href="#'+d+'" />')}else if(!this.opts.navbar.title)return;this.opts.navbar.add&&t.addClass(s.panel+"_has-navbar"),i.append('<a class="'+s.navbar+'__title"'+(l.length?' href="'+l+'"':"")+">"+r+"</a>").prependTo(t),this.trigger("initNavbar:after",t)}},_initListview:function(t){this.trigger("initListview:before",t);var n=this.__childAddBack(t,"ul, ol");this.__refactorClass(n,this.conf.classNames.nolistview,s.nolistview);var i=n.not("."+s.nolistview).addClass(s.listview).children().addClass(s.listitem);this.__refactorClass(i,this.conf.classNames.selected,s.listitem+"_selected"),this.__refactorClass(i,this.conf.classNames.divider,s.listitem+"_divider"),this.__refactorClass(i,this.conf.classNames.spacer,s.listitem+"_spacer");var r=t.data(a.parent);if(r&&r.is("."+s.listitem)&&!r.children("."+s.btn+"_next").length){var l=r.children("a, span").first(),o=e('<a class="'+s.btn+'_next" href="#'+t.attr("id")+'" />').insertBefore(l);l.is("span")&&o.addClass(s.btn+"_fullwidth")}this.trigger("initListview:after",t)},_initOpened:function(){this.trigger("initOpened:before");var e=this.$pnls.find("."+s.listitem+"_selected").removeClass(s.listitem+"_selected").last().addClass(s.listitem+"_selected"),t=e.length?e.closest("."+s.panel):this.$pnls.children("."+s.panel).first();this.openPanel(t,!1),this.trigger("initOpened:after")},_initAnchors:function(){this.trigger("initAnchors:before");var t=this;l.$body.on(r.click+"-oncanvas","a[href]",function(i){var a=e(this),r=a.attr("href"),l=t.$menu.find(a).length,o=a.is("."+s.listitem+" > a"),d=a.is('[rel="external"]')||a.is('[target="_blank"]');if(l&&r.length>1&&"#"==r.slice(0,1))try{var c=t.$menu.find(r);if(c.is("."+s.panel))return t[a.parent().hasClass(s.listitem+"_vertical")?"togglePanel":"openPanel"](c),void i.preventDefault()}catch(h){}var f={close:null,setSelected:null,preventDefault:"#"==r.slice(0,1)};for(var p in e[n].addons){var u=e[n].addons[p].clickAnchor.call(t,a,l,o,d);if(u){if("boolean"==typeof u)return void i.preventDefault();"object"==typeof u&&(f=e.extend({},f,u))}}l&&o&&!d&&(t.__valueOrFn(a,t.opts.onClick.setSelected,f.setSelected)&&t.setSelected(e(i.target).parent()),t.__valueOrFn(a,t.opts.onClick.preventDefault,f.preventDefault)&&i.preventDefault(),t.__valueOrFn(a,t.opts.onClick.close,f.close)&&t.opts.offCanvas&&"function"==typeof t.close&&t.close())}),this.trigger("initAnchors:after")},_initMatchMedia:function(){var e=this;for(var t in this.mtch)!function(){var n=t,i=window.matchMedia(n);e._fireMatchMedia(n,i),i.addListener(function(t){e._fireMatchMedia(n,t)})}()},_fireMatchMedia:function(e,t){for(var n=t.matches?"yes":"no",i=0;i<this.mtch[e].length;i++)this.mtch[e][i][n].call(this)},_getOriginalMenuId:function(){var e=this.$menu.attr("id");return this.conf.clone&&e&&e.length&&(e=s.umm(e)),e},__api:function(){var t=this,n={};return e.each(this._api,function(e){var i=this;n[i]=function(){var e=t[i].apply(t,arguments);return"undefined"==typeof e?n:e}}),n},__valueOrFn:function(e,t,n){if("function"==typeof t){var i=t.call(e[0]);if("undefined"!=typeof i)return i}return"function"!=typeof t&&"undefined"!=typeof t||"undefined"==typeof n?t:n},__getPanelTitle:function(t,i){var s;return"function"==typeof this.opts.navbar.title&&(s=this.opts.navbar.title.call(t[0])),"undefined"==typeof s&&(s=t.data(a.title)),"undefined"!=typeof s?s:"string"==typeof i?e[n].i18n(i):e[n].i18n(e[n].defaults.navbar.title)},__refactorClass:function(e,t,n){return e.filter("."+t).removeClass(t).addClass(n)},__findAddBack:function(e,t){return e.find(t).add(e.filter(t))},__childAddBack:function(e,t){return e.children(t).add(e.filter(t))},__filterListItems:function(e){return e.not("."+s.listitem+"_divider").not("."+s.hidden)},__filterListItemAnchors:function(e){return this.__filterListItems(e).children("a").not("."+s.btn+"_next")},__openPanelWoAnimation:function(e){e.hasClass(s.panel+"_noanimation")||(e.addClass(s.panel+"_noanimation"),this.__transitionend(e,function(){e.removeClass(s.panel+"_noanimation")},this.conf.openingInterval),this.openPanel(e))},__transitionend:function(e,t,n){var i=!1,s=function(n){"undefined"!=typeof n&&n.target!=e[0]||(i||(e.off(r.transitionend),e.off(r.webkitTransitionEnd),t.call(e[0])),i=!0)};e.on(r.transitionend,s),e.on(r.webkitTransitionEnd,s),setTimeout(s,1.1*n)},__getUniqueId:function(){return s.mm(e[n].uniqueId++)}},e.fn[n]=function(i,s){t(),i=e.extend(!0,{},e[n].defaults,i),s=e.extend(!0,{},e[n].configuration,s);var a=e();return this.each(function(){var t=e(this);if(!t.data(n)){var r=new e[n](t,i,s);r.$menu.data(n,r.__api()),a=a.add(r.$menu)}}),a},e[n].i18n=function(){var t={};return function(n){switch(typeof n){case"object":return e.extend(t,n),t;case"string":return t[n]||n;case"undefined":default:return t}}}(),e[n].support={touch:"ontouchstart"in window||navigator.msMaxTouchPoints||!1,csstransitions:function(){return"undefined"==typeof Modernizr||"undefined"==typeof Modernizr.csstransitions||Modernizr.csstransitions}(),csstransforms:function(){return"undefined"==typeof Modernizr||"undefined"==typeof Modernizr.csstransforms||Modernizr.csstransforms}(),csstransforms3d:function(){return"undefined"==typeof Modernizr||"undefined"==typeof Modernizr.csstransforms3d||Modernizr.csstransforms3d}()};var s,a,r,l}}(jQuery);!function(e){var t="mmenu",n="offCanvas";e[t].addons[n]={setup:function(){if(this.opts[n]){var i=this.opts[n],s=this.conf[n];r=e[t].glbl,this._api=e.merge(this._api,["open","close","setPage"]),"object"!=typeof i&&(i={}),i=this.opts[n]=e.extend(!0,{},e[t].defaults[n],i),"string"!=typeof s.pageSelector&&(s.pageSelector="> "+s.pageNodetype),this.vars.opened=!1;var a=[o.menu+"_offcanvas"];e[t].support.csstransforms||a.push(o["no-csstransforms"]),e[t].support.csstransforms3d||a.push(o["no-csstransforms3d"]),this.bind("initMenu:after",function(){var e=this;this.setPage(r.$page),this._initBlocker(),this["_initWindow_"+n](),this.$menu.addClass(a.join(" ")).parent("."+o.wrapper).removeClass(o.wrapper),this.$menu[s.menuInsertMethod](s.menuInsertSelector);var t=window.location.hash;if(t){var i=this._getOriginalMenuId();i&&i==t.slice(1)&&setTimeout(function(){e.open()},1e3)}}),this.bind("open:start:sr-aria",function(){this.__sr_aria(this.$menu,"hidden",!1)}),this.bind("close:finish:sr-aria",function(){this.__sr_aria(this.$menu,"hidden",!0)}),this.bind("initMenu:after:sr-aria",function(){this.__sr_aria(this.$menu,"hidden",!0)})}},add:function(){o=e[t]._c,i=e[t]._d,s=e[t]._e,o.add("slideout page no-csstransforms3d"),i.add("style")},clickAnchor:function(e,t){var i=this;if(this.opts[n]){var s=this._getOriginalMenuId();if(s&&e.is('[href="#'+s+'"]')){if(t)return this.open(),!0;var a=e.closest("."+o.menu);if(a.length){var p=a.data("mmenu");if(p&&p.close)return p.close(),i.__transitionend(a,function(){i.open()},i.conf.transitionDuration),!0}return this.open(),!0}if(r.$page)return s=r.$page.first().attr("id"),s&&e.is('[href="#'+s+'"]')?(this.close(),!0):void 0}}},e[t].defaults[n]={blockUI:!0,moveBackground:!0},e[t].configuration[n]={pageNodetype:"div",pageSelector:null,noPageSelector:[],wrapPageIfNeeded:!0,menuInsertMethod:"prependTo",menuInsertSelector:"body"},e[t].prototype.open=function(){if(this.trigger("open:before"),!this.vars.opened){var e=this;this._openSetup(),setTimeout(function(){e._openFinish()},this.conf.openingInterval),this.trigger("open:after")}},e[t].prototype._openSetup=function(){var t=this,a=this.opts[n];this.closeAllOthers(),r.$page.each(function(){e(this).data(i.style,e(this).attr("style")||"")}),r.$wndw.trigger(s.resize+"-"+n,[!0]);var p=[o.wrapper+"_opened"];a.blockUI&&p.push(o.wrapper+"_blocking"),"modal"==a.blockUI&&p.push(o.wrapper+"_modal"),a.moveBackground&&p.push(o.wrapper+"_background"),r.$html.addClass(p.join(" ")),setTimeout(function(){t.vars.opened=!0},this.conf.openingInterval),this.$menu.addClass(o.menu+"_opened")},e[t].prototype._openFinish=function(){var e=this;this.__transitionend(r.$page.first(),function(){e.trigger("open:finish")},this.conf.transitionDuration),this.trigger("open:start"),r.$html.addClass(o.wrapper+"_opening")},e[t].prototype.close=function(){if(this.trigger("close:before"),this.vars.opened){var t=this;this.__transitionend(r.$page.first(),function(){t.$menu.removeClass(o.menu+"_opened");var n=[o.wrapper+"_opened",o.wrapper+"_blocking",o.wrapper+"_modal",o.wrapper+"_background"];r.$html.removeClass(n.join(" ")),r.$page.each(function(){e(this).attr("style",e(this).data(i.style))}),t.vars.opened=!1,t.trigger("close:finish")},this.conf.transitionDuration),this.trigger("close:start"),r.$html.removeClass(o.wrapper+"_opening"),this.trigger("close:after")}},e[t].prototype.closeAllOthers=function(){r.$body.find("."+o.menu+"_offcanvas").not(this.$menu).each(function(){var n=e(this).data(t);n&&n.close&&n.close()})},e[t].prototype.setPage=function(t){this.trigger("setPage:before",t);var i=this,s=this.conf[n];t&&t.length||(t=r.$body.find(s.pageSelector),s.noPageSelector.length&&(t=t.not(s.noPageSelector.join(", "))),t.length>1&&s.wrapPageIfNeeded&&(t=t.wrapAll("<"+this.conf[n].pageNodetype+" />").parent())),t.each(function(){e(this).attr("id",e(this).attr("id")||i.__getUniqueId())}),t.addClass(o.page+" "+o.slideout),r.$page=t,this.trigger("setPage:after",t)},e[t].prototype["_initWindow_"+n]=function(){r.$wndw.off(s.keydown+"-"+n).on(s.keydown+"-"+n,function(e){if(r.$html.hasClass(o.wrapper+"_opened")&&9==e.keyCode)return e.preventDefault(),!1});var e=0;r.$wndw.off(s.resize+"-"+n).on(s.resize+"-"+n,function(t,n){if(1==r.$page.length&&(n||r.$html.hasClass(o.wrapper+"_opened"))){var i=r.$wndw.height();(n||i!=e)&&(e=i,r.$page.css("minHeight",i))}})},e[t].prototype._initBlocker=function(){var t=this;this.opts[n].blockUI&&(r.$blck||(r.$blck=e('<div class="'+o.page+"__blocker "+o.slideout+'" />')),r.$blck.appendTo(r.$body).off(s.touchstart+"-"+n+" "+s.touchmove+"-"+n).on(s.touchstart+"-"+n+" "+s.touchmove+"-"+n,function(e){e.preventDefault(),e.stopPropagation(),r.$blck.trigger(s.mousedown+"-"+n)}).off(s.mousedown+"-"+n).on(s.mousedown+"-"+n,function(e){e.preventDefault(),r.$html.hasClass(o.wrapper+"_modal")||(t.closeAllOthers(),t.close())}))};var o,i,s,r}(jQuery);!function(t){var i="mmenu",n="screenReader";t[i].addons[n]={setup:function(){var a=this,o=this.opts[n],h=this.conf[n];s=t[i].glbl,"boolean"==typeof o&&(o={aria:o,text:o}),"object"!=typeof o&&(o={}),o=this.opts[n]=t.extend(!0,{},t[i].defaults[n],o),o.aria&&(this.bind("initAddons:after",function(){this.bind("initMenu:after",function(){this.trigger("initMenu:after:sr-aria")}),this.bind("initNavbar:after",function(){this.trigger("initNavbar:after:sr-aria",arguments[0])}),this.bind("openPanel:start",function(){this.trigger("openPanel:start:sr-aria",arguments[0])}),this.bind("close:start",function(){this.trigger("close:start:sr-aria")}),this.bind("close:finish",function(){this.trigger("close:finish:sr-aria")}),this.bind("open:start",function(){this.trigger("open:start:sr-aria")}),this.bind("initOpened:after",function(){this.trigger("initOpened:after:sr-aria")})}),this.bind("updateListview",function(){this.$pnls.find("."+e.listview).children().each(function(){a.__sr_aria(t(this),"hidden",t(this).is("."+e.hidden))})}),this.bind("openPanel:start",function(t){var i=this.$menu.find("."+e.panel).not(t).not(t.parents("."+e.panel)),n=t.add(t.find("."+e.listitem+"_vertical ."+e.listitem+"_opened").children("."+e.panel));this.__sr_aria(i,"hidden",!0),this.__sr_aria(n,"hidden",!1)}),this.bind("closePanel",function(t){this.__sr_aria(t,"hidden",!0)}),this.bind("initPanels:after",function(i){var n=i.find("."+e.btn).each(function(){a.__sr_aria(t(this),"owns",t(this).attr("href").replace("#",""))});this.__sr_aria(n,"haspopup",!0)}),this.bind("initNavbar:after",function(t){var i=t.children("."+e.navbar);this.__sr_aria(i,"hidden",!t.hasClass(e.panel+"_has-navbar"))}),o.text&&(this.bind("initlistview:after",function(t){var i=t.find("."+e.listview).find("."+e.btn+"_fullwidth").parent().children("span");this.__sr_aria(i,"hidden",!0)}),"parent"==this.opts.navbar.titleLink&&this.bind("initNavbar:after",function(t){var i=t.children("."+e.navbar),n=!!i.children("."+e.btn+"_prev").length;this.__sr_aria(i.children("."+e.title),"hidden",n)}))),o.text&&(this.bind("initAddons:after",function(){this.bind("setPage:after",function(){this.trigger("setPage:after:sr-text",arguments[0])})}),this.bind("initNavbar:after",function(n){var r=n.children("."+e.navbar),a=r.children("."+e.title).text(),s=t[i].i18n(h.text.closeSubmenu);a&&(s+=" ("+a+")"),r.children("."+e.btn+"_prev").html(this.__sr_text(s))}),this.bind("initListview:after",function(n){var s=n.data(r.parent);if(s&&s.length){var o=s.children("."+e.btn+"_next"),d=o.nextAll("span, a").first().text(),l=t[i].i18n(h.text[o.parent().is("."+e.listitem+"_vertical")?"toggleSubmenu":"openSubmenu"]);d&&(l+=" ("+d+")"),o.html(a.__sr_text(l))}}))},add:function(){e=t[i]._c,r=t[i]._d,a=t[i]._e,e.add("sronly")},clickAnchor:function(t,i){}},t[i].defaults[n]={aria:!0,text:!0},t[i].configuration[n]={text:{closeMenu:"Close menu",closeSubmenu:"Close submenu",openSubmenu:"Open submenu",toggleSubmenu:"Toggle submenu"}},t[i].prototype.__sr_aria=function(t,i,n){t.prop("aria-"+i,n)[n?"attr":"removeAttr"]("aria-"+i,n)},t[i].prototype.__sr_role=function(t,i){t.prop("role",i)[i?"attr":"removeAttr"]("role",i)},t[i].prototype.__sr_text=function(t){return'<span class="'+e.sronly+'">'+t+"</span>"};var e,r,a,s}(jQuery);!function(o){var t="mmenu",n="scrollBugFix";o[t].addons[n]={setup:function(){var r=this.opts[n];this.conf[n];i=o[t].glbl,o[t].support.touch&&this.opts.offCanvas&&this.opts.offCanvas.blockUI&&("boolean"==typeof r&&(r={fix:r}),"object"!=typeof r&&(r={}),r=this.opts[n]=o.extend(!0,{},o[t].defaults[n],r),r.fix&&(this.bind("open:start",function(){this.$pnls.children("."+e.panel+"_opened").scrollTop(0)}),this.bind("initMenu:after",function(){this["_initWindow_"+n]()})))},add:function(){e=o[t]._c,r=o[t]._d,s=o[t]._e},clickAnchor:function(o,t){}},o[t].defaults[n]={fix:!0},o[t].prototype["_initWindow_"+n]=function(){var t=this;i.$docu.off(s.touchmove+"-"+n).on(s.touchmove+"-"+n,function(o){i.$html.hasClass(e.wrapper+"_opened")&&o.preventDefault()});var r=!1;i.$body.off(s.touchstart+"-"+n).on(s.touchstart+"-"+n,"."+e.panels+"> ."+e.panel,function(o){i.$html.hasClass(e.wrapper+"_opened")&&(r||(r=!0,0===o.currentTarget.scrollTop?o.currentTarget.scrollTop=1:o.currentTarget.scrollHeight===o.currentTarget.scrollTop+o.currentTarget.offsetHeight&&(o.currentTarget.scrollTop-=1),r=!1))}).off(s.touchmove+"-"+n).on(s.touchmove+"-"+n,"."+e.panels+"> ."+e.panel,function(t){i.$html.hasClass(e.wrapper+"_opened")&&o(this)[0].scrollHeight>o(this).innerHeight()&&t.stopPropagation()}),i.$wndw.off(s.orientationchange+"-"+n).on(s.orientationchange+"-"+n,function(){t.$pnls.children("."+e.panel+"_opened").scrollTop(0).css({"-webkit-overflow-scrolling":"auto"}).css({"-webkit-overflow-scrolling":"touch"})})};var e,r,s,i}(jQuery);return true}));



;(function(root, factory) {

  if (typeof define === 'function' && define.amd) {

    define(['jquery'], factory);

  } else if (typeof exports === 'object') {

    module.exports = factory(require('jquery'));

  } else {

    root.jquery_mmenu_js = factory(root.jQuery);

  }

}(this, function(jQuery) {

/*

 * jQuery mmenu v7.0.3

 * @requires jQuery 1.7.0 or later

 *

 * mmenu.frebsite.nl

 *

 * Copyright (c) Fred Heusschen

 * www.frebsite.nl

 *

 * License: CC-BY-NC-4.0

 * http://creativecommons.org/licenses/by-nc/4.0/

 */

!function(e){function t(){e[n].glbl||(l={$wndw:e(window),$docu:e(document),$html:e("html"),$body:e("body")},s={},a={},r={},e.each([s,a,r],function(e,t){t.add=function(e){e=e.split(" ");for(var n=0,i=e.length;n<i;n++)t[e[n]]=t.mm(e[n])}}),s.mm=function(e){return"mm-"+e},s.add("wrapper menu panels panel nopanel navbar listview nolistview listitem btn hidden"),s.umm=function(e){return"mm-"==e.slice(0,3)&&(e=e.slice(3)),e},a.mm=function(e){return"mm-"+e},a.add("parent child title"),r.mm=function(e){return e+".mm"},r.add("transitionend webkitTransitionEnd click scroll resize keydown mousedown mouseup touchstart touchmove touchend orientationchange"),e[n]._c=s,e[n]._d=a,e[n]._e=r,e[n].glbl=l)}var n="mmenu",i="7.0.3";if(!(e[n]&&e[n].version>i)){e[n]=function(e,t,n){return this.$menu=e,this._api=["bind","getInstance","initPanels","openPanel","closePanel","closeAllPanels","setSelected"],this.opts=t,this.conf=n,this.vars={},this.cbck={},this.mtch={},"function"==typeof this.___deprecated&&this.___deprecated(),this._initHooks(),this._initWrappers(),this._initAddons(),this._initExtensions(),this._initMenu(),this._initPanels(),this._initOpened(),this._initAnchors(),this._initMatchMedia(),"function"==typeof this.___debug&&this.___debug(),this},e[n].version=i,e[n].uniqueId=0,e[n].wrappers={},e[n].addons={},e[n].defaults={hooks:{},extensions:[],wrappers:[],navbar:{add:!0,title:"Menu",titleLink:"parent"},onClick:{setSelected:!0},slidingSubmenus:!0},e[n].configuration={classNames:{divider:"Divider",inset:"Inset",nolistview:"NoListview",nopanel:"NoPanel",panel:"Panel",selected:"Selected",spacer:"Spacer",vertical:"Vertical"},clone:!1,openingInterval:25,panelNodetype:"ul, ol, div",transitionDuration:400},e[n].prototype={getInstance:function(){return this},initPanels:function(e){this._initPanels(e)},openPanel:function(t,i){if(this.trigger("openPanel:before",t),t&&t.length&&(t.is("."+s.panel)||(t=t.closest("."+s.panel)),t.is("."+s.panel))){var r=this;if("boolean"!=typeof i&&(i=!0),t.parent("."+s.listitem+"_vertical").length)t.parents("."+s.listitem+"_vertical").addClass(s.listitem+"_opened").children("."+s.panel).removeClass(s.hidden),this.openPanel(t.parents("."+s.panel).not(function(){return e(this).parent("."+s.listitem+"_vertical").length}).first()),this.trigger("openPanel:start",t),this.trigger("openPanel:finish",t);else{if(t.hasClass(s.panel+"_opened"))return;var l=this.$pnls.children("."+s.panel),o=this.$pnls.children("."+s.panel+"_opened");if(!e[n].support.csstransitions)return o.addClass(s.hidden).removeClass(s.panel+"_opened"),t.removeClass(s.hidden).addClass(s.panel+"_opened"),this.trigger("openPanel:start",t),void this.trigger("openPanel:finish",t);l.not(t).removeClass(s.panel+"_opened-parent");for(var d=t.data(a.parent);d;)d=d.closest("."+s.panel),d.parent("."+s.listitem+"_vertical").length||d.addClass(s.panel+"_opened-parent"),d=d.data(a.parent);l.removeClass(s.panel+"_highest").not(o).not(t).addClass(s.hidden),t.removeClass(s.hidden);var c=function(){o.removeClass(s.panel+"_opened"),t.addClass(s.panel+"_opened"),t.hasClass(s.panel+"_opened-parent")?(o.addClass(s.panel+"_highest"),t.removeClass(s.panel+"_opened-parent")):(o.addClass(s.panel+"_opened-parent"),t.addClass(s.panel+"_highest")),r.trigger("openPanel:start",t)},h=function(){o.removeClass(s.panel+"_highest").addClass(s.hidden),t.removeClass(s.panel+"_highest"),r.trigger("openPanel:finish",t)};i&&!t.hasClass(s.panel+"_noanimation")?setTimeout(function(){r.__transitionend(t,function(){h()},r.conf.transitionDuration),c()},r.conf.openingInterval):(c(),h())}this.trigger("openPanel:after",t)}},closePanel:function(e){this.trigger("closePanel:before",e);var t=e.parent();t.hasClass(s.listitem+"_vertical")&&(t.removeClass(s.listitem+"_opened"),e.addClass(s.hidden),this.trigger("closePanel",e)),this.trigger("closePanel:after",e)},closeAllPanels:function(e){this.trigger("closeAllPanels:before"),this.$pnls.find("."+s.listview).children().removeClass(s.listitem+"_selected").filter("."+s.listitem+"_vertical").removeClass(s.listitem+"_opened");var t=this.$pnls.children("."+s.panel),n=e&&e.length?e:t.first();this.$pnls.children("."+s.panel).not(n).removeClass(s.panel+"_opened").removeClass(s.panel+"_opened-parent").removeClass(s.panel+"_highest").addClass(s.hidden),this.openPanel(n,!1),this.trigger("closeAllPanels:after")},togglePanel:function(e){var t=e.parent();t.hasClass(s.listitem+"_vertical")&&this[t.hasClass(s.listitem+"_opened")?"closePanel":"openPanel"](e)},setSelected:function(e){this.trigger("setSelected:before",e),this.$menu.find("."+s.listitem+"_selected").removeClass(s.listitem+"_selected"),e.addClass(s.listitem+"_selected"),this.trigger("setSelected:after",e)},bind:function(e,t){this.cbck[e]=this.cbck[e]||[],this.cbck[e].push(t)},trigger:function(){var e=this,t=Array.prototype.slice.call(arguments),n=t.shift();if(this.cbck[n])for(var i=0,s=this.cbck[n].length;i<s;i++)this.cbck[n][i].apply(e,t)},matchMedia:function(e,t,n){var i={yes:t,no:n};this.mtch[e]=this.mtch[e]||[],this.mtch[e].push(i)},_initHooks:function(){for(var e in this.opts.hooks)this.bind(e,this.opts.hooks[e])},_initWrappers:function(){this.trigger("initWrappers:before");for(var t=0;t<this.opts.wrappers.length;t++){var i=e[n].wrappers[this.opts.wrappers[t]];"function"==typeof i&&i.call(this)}this.trigger("initWrappers:after")},_initAddons:function(){this.trigger("initAddons:before");var t;for(t in e[n].addons)e[n].addons[t].add.call(this),e[n].addons[t].add=function(){};for(t in e[n].addons)e[n].addons[t].setup.call(this);this.trigger("initAddons:after")},_initExtensions:function(){this.trigger("initExtensions:before");var e=this;this.opts.extensions.constructor===Array&&(this.opts.extensions={all:this.opts.extensions});for(var t in this.opts.extensions)this.opts.extensions[t]=this.opts.extensions[t].length?s.menu+"_"+this.opts.extensions[t].join(" "+s.menu+"_"):"",this.opts.extensions[t]&&!function(t){e.matchMedia(t,function(){this.$menu.addClass(this.opts.extensions[t])},function(){this.$menu.removeClass(this.opts.extensions[t])})}(t);this.trigger("initExtensions:after")},_initMenu:function(){this.trigger("initMenu:before");this.conf.clone&&(this.$orig=this.$menu,this.$menu=this.$orig.clone(),this.$menu.add(this.$menu.find("[id]")).filter("[id]").each(function(){e(this).attr("id",s.mm(e(this).attr("id")))})),this.$menu.attr("id",this.$menu.attr("id")||this.__getUniqueId()),this.$pnls=e('<div class="'+s.panels+'" />').append(this.$menu.children(this.conf.panelNodetype)).prependTo(this.$menu),this.$menu.addClass(s.menu).parent().addClass(s.wrapper),this.trigger("initMenu:after")},_initPanels:function(t){this.trigger("initPanels:before",t),t=t||this.$pnls.children(this.conf.panelNodetype);var n=e(),i=this,a=function(t){t.filter(i.conf.panelNodetype).each(function(t){var r=i._initPanel(e(this));if(r){i._initNavbar(r),i._initListview(r),n=n.add(r);var l=r.children("."+s.listview).children("li").children(i.conf.panelNodeType).add(r.children("."+i.conf.classNames.panel));l.length&&a(l)}})};a(t),this.trigger("initPanels:after",n)},_initPanel:function(e){this.trigger("initPanel:before",e);if(e.hasClass(s.panel))return e;if(this.__refactorClass(e,this.conf.classNames.panel,s.panel),this.__refactorClass(e,this.conf.classNames.nopanel,s.nopanel),this.__refactorClass(e,this.conf.classNames.inset,s.listview+"_inset"),e.filter("."+s.listview+"_inset").addClass(s.nopanel),e.hasClass(s.nopanel))return!1;var t=e.hasClass(this.conf.classNames.vertical)||!this.opts.slidingSubmenus;e.removeClass(this.conf.classNames.vertical);var n=e.attr("id")||this.__getUniqueId();e.is("ul, ol")&&(e.removeAttr("id"),e.wrap("<div />"),e=e.parent()),e.attr("id",n),e.addClass(s.panel+" "+s.hidden);var i=e.parent("li");return t?i.addClass(s.listitem+"_vertical"):e.appendTo(this.$pnls),i.length&&(i.data(a.child,e),e.data(a.parent,i)),this.trigger("initPanel:after",e),e},_initNavbar:function(t){if(this.trigger("initNavbar:before",t),!t.children("."+s.navbar).length){var n=t.data(a.parent),i=e('<div class="'+s.navbar+'" />'),r=this.__getPanelTitle(t,this.opts.navbar.title),l="";if(n&&n.length){if(n.hasClass(s.listitem+"_vertical"))return;if(n.parent().is("."+s.listview))var o=n.children("a, span").not("."+s.btn+"_next");else var o=n.closest("."+s.panel).find('a[href="#'+t.attr("id")+'"]');o=o.first(),n=o.closest("."+s.panel);var d=n.attr("id");switch(r=this.__getPanelTitle(t,e("<span>"+o.text()+"</span>").text()),this.opts.navbar.titleLink){case"anchor":l=o.attr("href");break;case"parent":l="#"+d}i.append('<a class="'+s.btn+" "+s.btn+"_prev "+s.navbar+'__btn" href="#'+d+'" />')}else if(!this.opts.navbar.title)return;this.opts.navbar.add&&t.addClass(s.panel+"_has-navbar"),i.append('<a class="'+s.navbar+'__title"'+(l.length?' href="'+l+'"':"")+">"+r+"</a>").prependTo(t),this.trigger("initNavbar:after",t)}},_initListview:function(t){this.trigger("initListview:before",t);var n=this.__childAddBack(t,"ul, ol");this.__refactorClass(n,this.conf.classNames.nolistview,s.nolistview);var i=n.not("."+s.nolistview).addClass(s.listview).children().addClass(s.listitem);this.__refactorClass(i,this.conf.classNames.selected,s.listitem+"_selected"),this.__refactorClass(i,this.conf.classNames.divider,s.listitem+"_divider"),this.__refactorClass(i,this.conf.classNames.spacer,s.listitem+"_spacer");var r=t.data(a.parent);if(r&&r.is("."+s.listitem)&&!r.children("."+s.btn+"_next").length){var l=r.children("a, span").first(),o=e('<a class="'+s.btn+'_next" href="#'+t.attr("id")+'" />').insertBefore(l);l.is("span")&&o.addClass(s.btn+"_fullwidth")}this.trigger("initListview:after",t)},_initOpened:function(){this.trigger("initOpened:before");var e=this.$pnls.find("."+s.listitem+"_selected").removeClass(s.listitem+"_selected").last().addClass(s.listitem+"_selected"),t=e.length?e.closest("."+s.panel):this.$pnls.children("."+s.panel).first();this.openPanel(t,!1),this.trigger("initOpened:after")},_initAnchors:function(){this.trigger("initAnchors:before");var t=this;l.$body.on(r.click+"-oncanvas","a[href]",function(i){var a=e(this),r=a.attr("href"),l=t.$menu.find(a).length,o=a.is("."+s.listitem+" > a"),d=a.is('[rel="external"]')||a.is('[target="_blank"]');if(l&&r.length>1&&"#"==r.slice(0,1))try{var c=t.$menu.find(r);if(c.is("."+s.panel))return t[a.parent().hasClass(s.listitem+"_vertical")?"togglePanel":"openPanel"](c),void i.preventDefault()}catch(h){}var f={close:null,setSelected:null,preventDefault:"#"==r.slice(0,1)};for(var p in e[n].addons){var u=e[n].addons[p].clickAnchor.call(t,a,l,o,d);if(u){if("boolean"==typeof u)return void i.preventDefault();"object"==typeof u&&(f=e.extend({},f,u))}}l&&o&&!d&&(t.__valueOrFn(a,t.opts.onClick.setSelected,f.setSelected)&&t.setSelected(e(i.target).parent()),t.__valueOrFn(a,t.opts.onClick.preventDefault,f.preventDefault)&&i.preventDefault(),t.__valueOrFn(a,t.opts.onClick.close,f.close)&&t.opts.offCanvas&&"function"==typeof t.close&&t.close())}),this.trigger("initAnchors:after")},_initMatchMedia:function(){var e=this;for(var t in this.mtch)!function(){var n=t,i=window.matchMedia(n);e._fireMatchMedia(n,i),i.addListener(function(t){e._fireMatchMedia(n,t)})}()},_fireMatchMedia:function(e,t){for(var n=t.matches?"yes":"no",i=0;i<this.mtch[e].length;i++)this.mtch[e][i][n].call(this)},_getOriginalMenuId:function(){var e=this.$menu.attr("id");return this.conf.clone&&e&&e.length&&(e=s.umm(e)),e},__api:function(){var t=this,n={};return e.each(this._api,function(e){var i=this;n[i]=function(){var e=t[i].apply(t,arguments);return"undefined"==typeof e?n:e}}),n},__valueOrFn:function(e,t,n){if("function"==typeof t){var i=t.call(e[0]);if("undefined"!=typeof i)return i}return"function"!=typeof t&&"undefined"!=typeof t||"undefined"==typeof n?t:n},__getPanelTitle:function(t,i){var s;return"function"==typeof this.opts.navbar.title&&(s=this.opts.navbar.title.call(t[0])),"undefined"==typeof s&&(s=t.data(a.title)),"undefined"!=typeof s?s:"string"==typeof i?e[n].i18n(i):e[n].i18n(e[n].defaults.navbar.title)},__refactorClass:function(e,t,n){return e.filter("."+t).removeClass(t).addClass(n)},__findAddBack:function(e,t){return e.find(t).add(e.filter(t))},__childAddBack:function(e,t){return e.children(t).add(e.filter(t))},__filterListItems:function(e){return e.not("."+s.listitem+"_divider").not("."+s.hidden)},__filterListItemAnchors:function(e){return this.__filterListItems(e).children("a").not("."+s.btn+"_next")},__openPanelWoAnimation:function(e){e.hasClass(s.panel+"_noanimation")||(e.addClass(s.panel+"_noanimation"),this.__transitionend(e,function(){e.removeClass(s.panel+"_noanimation")},this.conf.openingInterval),this.openPanel(e))},__transitionend:function(e,t,n){var i=!1,s=function(n){"undefined"!=typeof n&&n.target!=e[0]||(i||(e.off(r.transitionend),e.off(r.webkitTransitionEnd),t.call(e[0])),i=!0)};e.on(r.transitionend,s),e.on(r.webkitTransitionEnd,s),setTimeout(s,1.1*n)},__getUniqueId:function(){return s.mm(e[n].uniqueId++)}},e.fn[n]=function(i,s){t(),i=e.extend(!0,{},e[n].defaults,i),s=e.extend(!0,{},e[n].configuration,s);var a=e();return this.each(function(){var t=e(this);if(!t.data(n)){var r=new e[n](t,i,s);r.$menu.data(n,r.__api()),a=a.add(r.$menu)}}),a},e[n].i18n=function(){var t={};return function(n){switch(typeof n){case"object":return e.extend(t,n),t;case"string":return t[n]||n;case"undefined":default:return t}}}(),e[n].support={touch:"ontouchstart"in window||navigator.msMaxTouchPoints||!1,csstransitions:function(){return"undefined"==typeof Modernizr||"undefined"==typeof Modernizr.csstransitions||Modernizr.csstransitions}(),csstransforms:function(){return"undefined"==typeof Modernizr||"undefined"==typeof Modernizr.csstransforms||Modernizr.csstransforms}(),csstransforms3d:function(){return"undefined"==typeof Modernizr||"undefined"==typeof Modernizr.csstransforms3d||Modernizr.csstransforms3d}()};var s,a,r,l}}(jQuery);

/*

 * jQuery mmenu offCanvas add-on

 * mmenu.frebsite.nl

 *

 * Copyright (c) Fred Heusschen

 */

!function(e){var t="mmenu",n="offCanvas";e[t].addons[n]={setup:function(){if(this.opts[n]){var i=this.opts[n],s=this.conf[n];r=e[t].glbl,this._api=e.merge(this._api,["open","close","setPage"]),"object"!=typeof i&&(i={}),i=this.opts[n]=e.extend(!0,{},e[t].defaults[n],i),"string"!=typeof s.pageSelector&&(s.pageSelector="> "+s.pageNodetype),this.vars.opened=!1;var a=[o.menu+"_offcanvas"];e[t].support.csstransforms||a.push(o["no-csstransforms"]),e[t].support.csstransforms3d||a.push(o["no-csstransforms3d"]),this.bind("initMenu:after",function(){var e=this;this.setPage(r.$page),this._initBlocker(),this["_initWindow_"+n](),this.$menu.addClass(a.join(" ")).parent("."+o.wrapper).removeClass(o.wrapper),this.$menu[s.menuInsertMethod](s.menuInsertSelector);var t=window.location.hash;if(t){var i=this._getOriginalMenuId();i&&i==t.slice(1)&&setTimeout(function(){e.open()},1e3)}}),this.bind("open:start:sr-aria",function(){this.__sr_aria(this.$menu,"hidden",!1)}),this.bind("close:finish:sr-aria",function(){this.__sr_aria(this.$menu,"hidden",!0)}),this.bind("initMenu:after:sr-aria",function(){this.__sr_aria(this.$menu,"hidden",!0)})}},add:function(){o=e[t]._c,i=e[t]._d,s=e[t]._e,o.add("slideout page no-csstransforms3d"),i.add("style")},clickAnchor:function(e,t){var i=this;if(this.opts[n]){var s=this._getOriginalMenuId();if(s&&e.is('[href="#'+s+'"]')){if(t)return this.open(),!0;var a=e.closest("."+o.menu);if(a.length){var p=a.data("mmenu");if(p&&p.close)return p.close(),i.__transitionend(a,function(){i.open()},i.conf.transitionDuration),!0}return this.open(),!0}if(r.$page)return s=r.$page.first().attr("id"),s&&e.is('[href="#'+s+'"]')?(this.close(),!0):void 0}}},e[t].defaults[n]={blockUI:!0,moveBackground:!0},e[t].configuration[n]={pageNodetype:"div",pageSelector:null,noPageSelector:[],wrapPageIfNeeded:!0,menuInsertMethod:"prependTo",menuInsertSelector:"body"},e[t].prototype.open=function(){if(this.trigger("open:before"),!this.vars.opened){var e=this;this._openSetup(),setTimeout(function(){e._openFinish()},this.conf.openingInterval),this.trigger("open:after")}},e[t].prototype._openSetup=function(){var t=this,a=this.opts[n];this.closeAllOthers(),r.$page.each(function(){e(this).data(i.style,e(this).attr("style")||"")}),r.$wndw.trigger(s.resize+"-"+n,[!0]);var p=[o.wrapper+"_opened"];a.blockUI&&p.push(o.wrapper+"_blocking"),"modal"==a.blockUI&&p.push(o.wrapper+"_modal"),a.moveBackground&&p.push(o.wrapper+"_background"),r.$html.addClass(p.join(" ")),setTimeout(function(){t.vars.opened=!0},this.conf.openingInterval),this.$menu.addClass(o.menu+"_opened")},e[t].prototype._openFinish=function(){var e=this;this.__transitionend(r.$page.first(),function(){e.trigger("open:finish")},this.conf.transitionDuration),this.trigger("open:start"),r.$html.addClass(o.wrapper+"_opening")},e[t].prototype.close=function(){if(this.trigger("close:before"),this.vars.opened){var t=this;this.__transitionend(r.$page.first(),function(){t.$menu.removeClass(o.menu+"_opened");var n=[o.wrapper+"_opened",o.wrapper+"_blocking",o.wrapper+"_modal",o.wrapper+"_background"];r.$html.removeClass(n.join(" ")),r.$page.each(function(){e(this).attr("style",e(this).data(i.style))}),t.vars.opened=!1,t.trigger("close:finish")},this.conf.transitionDuration),this.trigger("close:start"),r.$html.removeClass(o.wrapper+"_opening"),this.trigger("close:after")}},e[t].prototype.closeAllOthers=function(){r.$body.find("."+o.menu+"_offcanvas").not(this.$menu).each(function(){var n=e(this).data(t);n&&n.close&&n.close()})},e[t].prototype.setPage=function(t){this.trigger("setPage:before",t);var i=this,s=this.conf[n];t&&t.length||(t=r.$body.find(s.pageSelector),s.noPageSelector.length&&(t=t.not(s.noPageSelector.join(", "))),t.length>1&&s.wrapPageIfNeeded&&(t=t.wrapAll("<"+this.conf[n].pageNodetype+" />").parent())),t.each(function(){e(this).attr("id",e(this).attr("id")||i.__getUniqueId())}),t.addClass(o.page+" "+o.slideout),r.$page=t,this.trigger("setPage:after",t)},e[t].prototype["_initWindow_"+n]=function(){r.$wndw.off(s.keydown+"-"+n).on(s.keydown+"-"+n,function(e){if(r.$html.hasClass(o.wrapper+"_opened")&&9==e.keyCode)return e.preventDefault(),!1});var e=0;r.$wndw.off(s.resize+"-"+n).on(s.resize+"-"+n,function(t,n){if(1==r.$page.length&&(n||r.$html.hasClass(o.wrapper+"_opened"))){var i=r.$wndw.height();(n||i!=e)&&(e=i,r.$page.css("minHeight",i))}})},e[t].prototype._initBlocker=function(){var t=this;this.opts[n].blockUI&&(r.$blck||(r.$blck=e('<div class="'+o.page+"__blocker "+o.slideout+'" />')),r.$blck.appendTo(r.$body).off(s.touchstart+"-"+n+" "+s.touchmove+"-"+n).on(s.touchstart+"-"+n+" "+s.touchmove+"-"+n,function(e){e.preventDefault(),e.stopPropagation(),r.$blck.trigger(s.mousedown+"-"+n)}).off(s.mousedown+"-"+n).on(s.mousedown+"-"+n,function(e){e.preventDefault(),r.$html.hasClass(o.wrapper+"_modal")||(t.closeAllOthers(),t.close())}))};var o,i,s,r}(jQuery);

/*

 * jQuery mmenu screenReader add-on

 * mmenu.frebsite.nl

 *

 * Copyright (c) Fred Heusschen

 */

!function(t){var i="mmenu",n="screenReader";t[i].addons[n]={setup:function(){var a=this,o=this.opts[n],h=this.conf[n];s=t[i].glbl,"boolean"==typeof o&&(o={aria:o,text:o}),"object"!=typeof o&&(o={}),o=this.opts[n]=t.extend(!0,{},t[i].defaults[n],o),o.aria&&(this.bind("initAddons:after",function(){this.bind("initMenu:after",function(){this.trigger("initMenu:after:sr-aria")}),this.bind("initNavbar:after",function(){this.trigger("initNavbar:after:sr-aria",arguments[0])}),this.bind("openPanel:start",function(){this.trigger("openPanel:start:sr-aria",arguments[0])}),this.bind("close:start",function(){this.trigger("close:start:sr-aria")}),this.bind("close:finish",function(){this.trigger("close:finish:sr-aria")}),this.bind("open:start",function(){this.trigger("open:start:sr-aria")}),this.bind("initOpened:after",function(){this.trigger("initOpened:after:sr-aria")})}),this.bind("updateListview",function(){this.$pnls.find("."+e.listview).children().each(function(){a.__sr_aria(t(this),"hidden",t(this).is("."+e.hidden))})}),this.bind("openPanel:start",function(t){var i=this.$menu.find("."+e.panel).not(t).not(t.parents("."+e.panel)),n=t.add(t.find("."+e.listitem+"_vertical ."+e.listitem+"_opened").children("."+e.panel));this.__sr_aria(i,"hidden",!0),this.__sr_aria(n,"hidden",!1)}),this.bind("closePanel",function(t){this.__sr_aria(t,"hidden",!0)}),this.bind("initPanels:after",function(i){var n=i.find("."+e.btn).each(function(){a.__sr_aria(t(this),"owns",t(this).attr("href").replace("#",""))});this.__sr_aria(n,"haspopup",!0)}),this.bind("initNavbar:after",function(t){var i=t.children("."+e.navbar);this.__sr_aria(i,"hidden",!t.hasClass(e.panel+"_has-navbar"))}),o.text&&(this.bind("initlistview:after",function(t){var i=t.find("."+e.listview).find("."+e.btn+"_fullwidth").parent().children("span");this.__sr_aria(i,"hidden",!0)}),"parent"==this.opts.navbar.titleLink&&this.bind("initNavbar:after",function(t){var i=t.children("."+e.navbar),n=!!i.children("."+e.btn+"_prev").length;this.__sr_aria(i.children("."+e.title),"hidden",n)}))),o.text&&(this.bind("initAddons:after",function(){this.bind("setPage:after",function(){this.trigger("setPage:after:sr-text",arguments[0])})}),this.bind("initNavbar:after",function(n){var r=n.children("."+e.navbar),a=r.children("."+e.title).text(),s=t[i].i18n(h.text.closeSubmenu);a&&(s+=" ("+a+")"),r.children("."+e.btn+"_prev").html(this.__sr_text(s))}),this.bind("initListview:after",function(n){var s=n.data(r.parent);if(s&&s.length){var o=s.children("."+e.btn+"_next"),d=o.nextAll("span, a").first().text(),l=t[i].i18n(h.text[o.parent().is("."+e.listitem+"_vertical")?"toggleSubmenu":"openSubmenu"]);d&&(l+=" ("+d+")"),o.html(a.__sr_text(l))}}))},add:function(){e=t[i]._c,r=t[i]._d,a=t[i]._e,e.add("sronly")},clickAnchor:function(t,i){}},t[i].defaults[n]={aria:!0,text:!0},t[i].configuration[n]={text:{closeMenu:"Close menu",closeSubmenu:"Close submenu",openSubmenu:"Open submenu",toggleSubmenu:"Toggle submenu"}},t[i].prototype.__sr_aria=function(t,i,n){t.prop("aria-"+i,n)[n?"attr":"removeAttr"]("aria-"+i,n)},t[i].prototype.__sr_role=function(t,i){t.prop("role",i)[i?"attr":"removeAttr"]("role",i)},t[i].prototype.__sr_text=function(t){return'<span class="'+e.sronly+'">'+t+"</span>"};var e,r,a,s}(jQuery);

/*

 * jQuery mmenu scrollBugFix add-on

 * mmenu.frebsite.nl

 *

 * Copyright (c) Fred Heusschen

 */

!function(o){var t="mmenu",n="scrollBugFix";o[t].addons[n]={setup:function(){var r=this.opts[n];this.conf[n];i=o[t].glbl,o[t].support.touch&&this.opts.offCanvas&&this.opts.offCanvas.blockUI&&("boolean"==typeof r&&(r={fix:r}),"object"!=typeof r&&(r={}),r=this.opts[n]=o.extend(!0,{},o[t].defaults[n],r),r.fix&&(this.bind("open:start",function(){this.$pnls.children("."+e.panel+"_opened").scrollTop(0)}),this.bind("initMenu:after",function(){this["_initWindow_"+n]()})))},add:function(){e=o[t]._c,r=o[t]._d,s=o[t]._e},clickAnchor:function(o,t){}},o[t].defaults[n]={fix:!0},o[t].prototype["_initWindow_"+n]=function(){var t=this;i.$docu.off(s.touchmove+"-"+n).on(s.touchmove+"-"+n,function(o){i.$html.hasClass(e.wrapper+"_opened")&&o.preventDefault()});var r=!1;i.$body.off(s.touchstart+"-"+n).on(s.touchstart+"-"+n,"."+e.panels+"> ."+e.panel,function(o){i.$html.hasClass(e.wrapper+"_opened")&&(r||(r=!0,0===o.currentTarget.scrollTop?o.currentTarget.scrollTop=1:o.currentTarget.scrollHeight===o.currentTarget.scrollTop+o.currentTarget.offsetHeight&&(o.currentTarget.scrollTop-=1),r=!1))}).off(s.touchmove+"-"+n).on(s.touchmove+"-"+n,"."+e.panels+"> ."+e.panel,function(t){i.$html.hasClass(e.wrapper+"_opened")&&o(this)[0].scrollHeight>o(this).innerHeight()&&t.stopPropagation()}),i.$wndw.off(s.orientationchange+"-"+n).on(s.orientationchange+"-"+n,function(){t.$pnls.children("."+e.panel+"_opened").scrollTop(0).css({"-webkit-overflow-scrolling":"auto"}).css({"-webkit-overflow-scrolling":"touch"})})};var e,r,s,i}(jQuery);

return true;

}));



/**

 * Owl Carousel v2.3.4

 * Copyright 2013-2018 David Deutsch

 * Licensed under: SEE LICENSE IN https://github.com/OwlCarousel2/OwlCarousel2/blob/master/LICENSE

 */

/**

 * Owl carousel

 * @version 2.3.4

 * @author Bartosz Wojciechowski

 * @author David Deutsch

 * @license The MIT License (MIT)

 * @todo Lazy Load Icon

 * @todo prevent animationend bubling

 * @todo itemsScaleUp

 * @todo Test Zepto

 * @todo stagePadding calculate wrong active classes

 */

;(function($, window, document, undefined) {



	/**

	 * Creates a carousel.

	 * @class The Owl Carousel.

	 * @public

	 * @param {HTMLElement|jQuery} element - The element to create the carousel for.

	 * @param {Object} [options] - The options

	 */

	function Owl(element, options) {



		/**

		 * Current settings for the carousel.

		 * @public

		 */

		this.settings = null;



		/**

		 * Current options set by the caller including defaults.

		 * @public

		 */

		this.options = $.extend({}, Owl.Defaults, options);



		/**

		 * Plugin element.

		 * @public

		 */

		this.$element = $(element);



		/**

		 * Proxied event handlers.

		 * @protected

		 */

		this._handlers = {};



		/**

		 * References to the running plugins of this carousel.

		 * @protected

		 */

		this._plugins = {};



		/**

		 * Currently suppressed events to prevent them from being retriggered.

		 * @protected

		 */

		this._supress = {};



		/**

		 * Absolute current position.

		 * @protected

		 */

		this._current = null;



		/**

		 * Animation speed in milliseconds.

		 * @protected

		 */

		this._speed = null;



		/**

		 * Coordinates of all items in pixel.

		 * @todo The name of this member is missleading.

		 * @protected

		 */

		this._coordinates = [];



		/**

		 * Current breakpoint.

		 * @todo Real media queries would be nice.

		 * @protected

		 */

		this._breakpoint = null;



		/**

		 * Current width of the plugin element.

		 */

		this._width = null;



		/**

		 * All real items.

		 * @protected

		 */

		this._items = [];



		/**

		 * All cloned items.

		 * @protected

		 */

		this._clones = [];



		/**

		 * Merge values of all items.

		 * @todo Maybe this could be part of a plugin.

		 * @protected

		 */

		this._mergers = [];



		/**

		 * Widths of all items.

		 */

		this._widths = [];



		/**

		 * Invalidated parts within the update process.

		 * @protected

		 */

		this._invalidated = {};



		/**

		 * Ordered list of workers for the update process.

		 * @protected

		 */

		this._pipe = [];



		/**

		 * Current state information for the drag operation.

		 * @todo #261

		 * @protected

		 */

		this._drag = {

			time: null,

			target: null,

			pointer: null,

			stage: {

				start: null,

				current: null

			},

			direction: null

		};



		/**

		 * Current state information and their tags.

		 * @type {Object}

		 * @protected

		 */

		this._states = {

			current: {},

			tags: {

				'initializing': [ 'busy' ],

				'animating': [ 'busy' ],

				'dragging': [ 'interacting' ]

			}

		};



		$.each([ 'onResize', 'onThrottledResize' ], $.proxy(function(i, handler) {

			this._handlers[handler] = $.proxy(this[handler], this);

		}, this));



		$.each(Owl.Plugins, $.proxy(function(key, plugin) {

			this._plugins[key.charAt(0).toLowerCase() + key.slice(1)]

				= new plugin(this);

		}, this));



		$.each(Owl.Workers, $.proxy(function(priority, worker) {

			this._pipe.push({

				'filter': worker.filter,

				'run': $.proxy(worker.run, this)

			});

		}, this));



		this.setup();

		this.initialize();

	}



	/**

	 * Default options for the carousel.

	 * @public

	 */

	Owl.Defaults = {

		items: 3,

		loop: false,

		center: false,

		rewind: false,

		checkVisibility: true,



		mouseDrag: true,

		touchDrag: true,

		pullDrag: true,

		freeDrag: false,



		margin: 0,

		stagePadding: 0,



		merge: false,

		mergeFit: true,

		autoWidth: false,



		startPosition: 0,

		rtl: false,



		smartSpeed: 250,

		fluidSpeed: false,

		dragEndSpeed: false,



		responsive: {},

		responsiveRefreshRate: 200,

		responsiveBaseElement: window,



		fallbackEasing: 'swing',

		slideTransition: '',



		info: false,



		nestedItemSelector: false,

		itemElement: 'div',

		stageElement: 'div',



		refreshClass: 'owl-refresh',

		loadedClass: 'owl-loaded',

		loadingClass: 'owl-loading',

		rtlClass: 'owl-rtl',

		responsiveClass: 'owl-responsive',

		dragClass: 'owl-drag',

		itemClass: 'owl-item',

		stageClass: 'owl-stage',

		stageOuterClass: 'owl-stage-outer',

		grabClass: 'owl-grab'

	};



	/**

	 * Enumeration for width.

	 * @public

	 * @readonly

	 * @enum {String}

	 */

	Owl.Width = {

		Default: 'default',

		Inner: 'inner',

		Outer: 'outer'

	};



	/**

	 * Enumeration for types.

	 * @public

	 * @readonly

	 * @enum {String}

	 */

	Owl.Type = {

		Event: 'event',

		State: 'state'

	};



	/**

	 * Contains all registered plugins.

	 * @public

	 */

	Owl.Plugins = {};



	/**

	 * List of workers involved in the update process.

	 */

	Owl.Workers = [ {

		filter: [ 'width', 'settings' ],

		run: function() {

			this._width = this.$element.width();

		}

	}, {

		filter: [ 'width', 'items', 'settings' ],

		run: function(cache) {

			cache.current = this._items && this._items[this.relative(this._current)];

		}

	}, {

		filter: [ 'items', 'settings' ],

		run: function() {

			this.$stage.children('.cloned').remove();

		}

	}, {

		filter: [ 'width', 'items', 'settings' ],

		run: function(cache) {

			var margin = this.settings.margin || '',

				grid = !this.settings.autoWidth,

				rtl = this.settings.rtl,

				css = {

					'width': 'auto',

					'margin-left': rtl ? margin : '',

					'margin-right': rtl ? '' : margin

				};



			!grid && this.$stage.children().css(css);



			cache.css = css;

		}

	}, {

		filter: [ 'width', 'items', 'settings' ],

		run: function(cache) {

			var width = (this.width() / this.settings.items).toFixed(3) - this.settings.margin,

				merge = null,

				iterator = this._items.length,

				grid = !this.settings.autoWidth,

				widths = [];



			cache.items = {

				merge: false,

				width: width

			};



			while (iterator--) {

				merge = this._mergers[iterator];

				merge = this.settings.mergeFit && Math.min(merge, this.settings.items) || merge;



				cache.items.merge = merge > 1 || cache.items.merge;



				widths[iterator] = !grid ? this._items[iterator].width() : width * merge;

			}



			this._widths = widths;

		}

	}, {

		filter: [ 'items', 'settings' ],

		run: function() {

			var clones = [],

				items = this._items,

				settings = this.settings,

				// TODO: Should be computed from number of min width items in stage

				view = Math.max(settings.items * 2, 4),

				size = Math.ceil(items.length / 2) * 2,

				repeat = settings.loop && items.length ? settings.rewind ? view : Math.max(view, size) : 0,

				append = '',

				prepend = '';



			repeat /= 2;



			while (repeat > 0) {

				// Switch to only using appended clones

				clones.push(this.normalize(clones.length / 2, true));

				append = append + items[clones[clones.length - 1]][0].outerHTML;

				clones.push(this.normalize(items.length - 1 - (clones.length - 1) / 2, true));

				prepend = items[clones[clones.length - 1]][0].outerHTML + prepend;

				repeat -= 1;

			}



			this._clones = clones;



			$(append).addClass('cloned').appendTo(this.$stage);

			$(prepend).addClass('cloned').prependTo(this.$stage);

		}

	}, {

		filter: [ 'width', 'items', 'settings' ],

		run: function() {

			var rtl = this.settings.rtl ? 1 : -1,

				size = this._clones.length + this._items.length,

				iterator = -1,

				previous = 0,

				current = 0,

				coordinates = [];



			while (++iterator < size) {

				previous = coordinates[iterator - 1] || 0;

				current = this._widths[this.relative(iterator)] + this.settings.margin;

				coordinates.push(previous + current * rtl);

			}



			this._coordinates = coordinates;

		}

	}, {

		filter: [ 'width', 'items', 'settings' ],

		run: function() {

			var padding = this.settings.stagePadding,

				coordinates = this._coordinates,

				css = {

					'width': Math.ceil(Math.abs(coordinates[coordinates.length - 1])) + padding * 2,

					'padding-left': padding || '',

					'padding-right': padding || ''

				};



			this.$stage.css(css);

		}

	}, {

		filter: [ 'width', 'items', 'settings' ],

		run: function(cache) {

			var iterator = this._coordinates.length,

				grid = !this.settings.autoWidth,

				items = this.$stage.children();



			if (grid && cache.items.merge) {

				while (iterator--) {

					cache.css.width = this._widths[this.relative(iterator)];

					items.eq(iterator).css(cache.css);

				}

			} else if (grid) {

				cache.css.width = cache.items.width;

				items.css(cache.css);

			}

		}

	}, {

		filter: [ 'items' ],

		run: function() {

			this._coordinates.length < 1 && this.$stage.removeAttr('style');

		}

	}, {

		filter: [ 'width', 'items', 'settings' ],

		run: function(cache) {

			cache.current = cache.current ? this.$stage.children().index(cache.current) : 0;

			cache.current = Math.max(this.minimum(), Math.min(this.maximum(), cache.current));

			this.reset(cache.current);

		}

	}, {

		filter: [ 'position' ],

		run: function() {

			this.animate(this.coordinates(this._current));

		}

	}, {

		filter: [ 'width', 'position', 'items', 'settings' ],

		run: function() {

			var rtl = this.settings.rtl ? 1 : -1,

				padding = this.settings.stagePadding * 2,

				begin = this.coordinates(this.current()) + padding,

				end = begin + this.width() * rtl,

				inner, outer, matches = [], i, n;



			for (i = 0, n = this._coordinates.length; i < n; i++) {

				inner = this._coordinates[i - 1] || 0;

				outer = Math.abs(this._coordinates[i]) + padding * rtl;



				if ((this.op(inner, '<=', begin) && (this.op(inner, '>', end)))

					|| (this.op(outer, '<', begin) && this.op(outer, '>', end))) {

					matches.push(i);

				}

			}



			this.$stage.children('.active').removeClass('active');

			this.$stage.children(':eq(' + matches.join('), :eq(') + ')').addClass('active');



			this.$stage.children('.center').removeClass('center');

			if (this.settings.center) {

				this.$stage.children().eq(this.current()).addClass('center');

			}

		}

	} ];



	/**

	 * Create the stage DOM element

	 */

	Owl.prototype.initializeStage = function() {

		this.$stage = this.$element.find('.' + this.settings.stageClass);



		// if the stage is already in the DOM, grab it and skip stage initialization

		if (this.$stage.length) {

			return;

		}



		this.$element.addClass(this.options.loadingClass);



		// create stage

		this.$stage = $('<' + this.settings.stageElement + '>', {

			"class": this.settings.stageClass

		}).wrap( $( '<div/>', {

			"class": this.settings.stageOuterClass

		}));



		// append stage

		this.$element.append(this.$stage.parent());

	};



	/**

	 * Create item DOM elements

	 */

	Owl.prototype.initializeItems = function() {

		var $items = this.$element.find('.owl-item');



		// if the items are already in the DOM, grab them and skip item initialization

		if ($items.length) {

			this._items = $items.get().map(function(item) {

				return $(item);

			});



			this._mergers = this._items.map(function() {

				return 1;

			});



			this.refresh();



			return;

		}



		// append content

		this.replace(this.$element.children().not(this.$stage.parent()));



		// check visibility

		if (this.isVisible()) {

			// update view

			this.refresh();

		} else {

			// invalidate width

			this.invalidate('width');

		}



		this.$element

			.removeClass(this.options.loadingClass)

			.addClass(this.options.loadedClass);

	};



	/**

	 * Initializes the carousel.

	 * @protected

	 */

	Owl.prototype.initialize = function() {

		this.enter('initializing');

		this.trigger('initialize');



		this.$element.toggleClass(this.settings.rtlClass, this.settings.rtl);



		if (this.settings.autoWidth && !this.is('pre-loading')) {

			var imgs, nestedSelector, width;

			imgs = this.$element.find('img');

			nestedSelector = this.settings.nestedItemSelector ? '.' + this.settings.nestedItemSelector : undefined;

			width = this.$element.children(nestedSelector).width();



			if (imgs.length && width <= 0) {

				this.preloadAutoWidthImages(imgs);

			}

		}



		this.initializeStage();

		this.initializeItems();



		// register event handlers

		this.registerEventHandlers();



		this.leave('initializing');

		this.trigger('initialized');

	};



	/**

	 * @returns {Boolean} visibility of $element

	 *                    if you know the carousel will always be visible you can set `checkVisibility` to `false` to

	 *                    prevent the expensive browser layout forced reflow the $element.is(':visible') does

	 */

	Owl.prototype.isVisible = function() {

		return this.settings.checkVisibility

			? this.$element.is(':visible')

			: true;

	};



	/**

	 * Setups the current settings.

	 * @todo Remove responsive classes. Why should adaptive designs be brought into IE8?

	 * @todo Support for media queries by using `matchMedia` would be nice.

	 * @public

	 */

	Owl.prototype.setup = function() {

		var viewport = this.viewport(),

			overwrites = this.options.responsive,

			match = -1,

			settings = null;



		if (!overwrites) {

			settings = $.extend({}, this.options);

		} else {

			$.each(overwrites, function(breakpoint) {

				if (breakpoint <= viewport && breakpoint > match) {

					match = Number(breakpoint);

				}

			});



			settings = $.extend({}, this.options, overwrites[match]);

			if (typeof settings.stagePadding === 'function') {

				settings.stagePadding = settings.stagePadding();

			}

			delete settings.responsive;



			// responsive class

			if (settings.responsiveClass) {

				this.$element.attr('class',

					this.$element.attr('class').replace(new RegExp('(' + this.options.responsiveClass + '-)\\S+\\s', 'g'), '$1' + match)

				);

			}

		}



		this.trigger('change', { property: { name: 'settings', value: settings } });

		this._breakpoint = match;

		this.settings = settings;

		this.invalidate('settings');

		this.trigger('changed', { property: { name: 'settings', value: this.settings } });

	};



	/**

	 * Updates option logic if necessery.

	 * @protected

	 */

	Owl.prototype.optionsLogic = function() {

		if (this.settings.autoWidth) {

			this.settings.stagePadding = false;

			this.settings.merge = false;

		}

	};



	/**

	 * Prepares an item before add.

	 * @todo Rename event parameter `content` to `item`.

	 * @protected

	 * @returns {jQuery|HTMLElement} - The item container.

	 */

	Owl.prototype.prepare = function(item) {

		var event = this.trigger('prepare', { content: item });



		if (!event.data) {

			event.data = $('<' + this.settings.itemElement + '/>')

				.addClass(this.options.itemClass).append(item)

		}



		this.trigger('prepared', { content: event.data });



		return event.data;

	};



	/**

	 * Updates the view.

	 * @public

	 */

	Owl.prototype.update = function() {

		var i = 0,

			n = this._pipe.length,

			filter = $.proxy(function(p) { return this[p] }, this._invalidated),

			cache = {};



		while (i < n) {

			if (this._invalidated.all || $.grep(this._pipe[i].filter, filter).length > 0) {

				this._pipe[i].run(cache);

			}

			i++;

		}



		this._invalidated = {};



		!this.is('valid') && this.enter('valid');

	};



	/**

	 * Gets the width of the view.

	 * @public

	 * @param {Owl.Width} [dimension=Owl.Width.Default] - The dimension to return.

	 * @returns {Number} - The width of the view in pixel.

	 */

	Owl.prototype.width = function(dimension) {

		dimension = dimension || Owl.Width.Default;

		switch (dimension) {

			case Owl.Width.Inner:

			case Owl.Width.Outer:

				return this._width;

			default:

				return this._width - this.settings.stagePadding * 2 + this.settings.margin;

		}

	};



	/**

	 * Refreshes the carousel primarily for adaptive purposes.

	 * @public

	 */

	Owl.prototype.refresh = function() {

		this.enter('refreshing');

		this.trigger('refresh');



		this.setup();



		this.optionsLogic();



		this.$element.addClass(this.options.refreshClass);



		this.update();



		this.$element.removeClass(this.options.refreshClass);



		this.leave('refreshing');

		this.trigger('refreshed');

	};



	/**

	 * Checks window `resize` event.

	 * @protected

	 */

	Owl.prototype.onThrottledResize = function() {

		window.clearTimeout(this.resizeTimer);

		this.resizeTimer = window.setTimeout(this._handlers.onResize, this.settings.responsiveRefreshRate);

	};



	/**

	 * Checks window `resize` event.

	 * @protected

	 */

	Owl.prototype.onResize = function() {

		if (!this._items.length) {

			return false;

		}



		if (this._width === this.$element.width()) {

			return false;

		}



		if (!this.isVisible()) {

			return false;

		}



		this.enter('resizing');



		if (this.trigger('resize').isDefaultPrevented()) {

			this.leave('resizing');

			return false;

		}



		this.invalidate('width');



		this.refresh();



		this.leave('resizing');

		this.trigger('resized');

	};



	/**

	 * Registers event handlers.

	 * @todo Check `msPointerEnabled`

	 * @todo #261

	 * @protected

	 */

	Owl.prototype.registerEventHandlers = function() {

		if ($.support.transition) {

			this.$stage.on($.support.transition.end + '.owl.core', $.proxy(this.onTransitionEnd, this));

		}



		if (this.settings.responsive !== false) {

			this.on(window, 'resize', this._handlers.onThrottledResize);

		}



		if (this.settings.mouseDrag) {

			this.$element.addClass(this.options.dragClass);

			this.$stage.on('mousedown.owl.core', $.proxy(this.onDragStart, this));

			this.$stage.on('dragstart.owl.core selectstart.owl.core', function() { return false });

		}



		if (this.settings.touchDrag){

			this.$stage.on('touchstart.owl.core', $.proxy(this.onDragStart, this));

			this.$stage.on('touchcancel.owl.core', $.proxy(this.onDragEnd, this));

		}

	};



	/**

	 * Handles `touchstart` and `mousedown` events.

	 * @todo Horizontal swipe threshold as option

	 * @todo #261

	 * @protected

	 * @param {Event} event - The event arguments.

	 */

	Owl.prototype.onDragStart = function(event) {

		var stage = null;



		if (event.which === 3) {

			return;

		}



		if ($.support.transform) {

			stage = this.$stage.css('transform').replace(/.*\(|\)| /g, '').split(',');

			stage = {

				x: stage[stage.length === 16 ? 12 : 4],

				y: stage[stage.length === 16 ? 13 : 5]

			};

		} else {

			stage = this.$stage.position();

			stage = {

				x: this.settings.rtl ?

					stage.left + this.$stage.width() - this.width() + this.settings.margin :

					stage.left,

				y: stage.top

			};

		}



		if (this.is('animating')) {

			$.support.transform ? this.animate(stage.x) : this.$stage.stop()

			this.invalidate('position');

		}



		this.$element.toggleClass(this.options.grabClass, event.type === 'mousedown');



		this.speed(0);



		this._drag.time = new Date().getTime();

		this._drag.target = $(event.target);

		this._drag.stage.start = stage;

		this._drag.stage.current = stage;

		this._drag.pointer = this.pointer(event);



		$(document).on('mouseup.owl.core touchend.owl.core', $.proxy(this.onDragEnd, this));



		$(document).one('mousemove.owl.core touchmove.owl.core', $.proxy(function(event) {

			var delta = this.difference(this._drag.pointer, this.pointer(event));



			$(document).on('mousemove.owl.core touchmove.owl.core', $.proxy(this.onDragMove, this));



			if (Math.abs(delta.x) < Math.abs(delta.y) && this.is('valid')) {

				return;

			}



			event.preventDefault();



			this.enter('dragging');

			this.trigger('drag');

		}, this));

	};



	/**

	 * Handles the `touchmove` and `mousemove` events.

	 * @todo #261

	 * @protected

	 * @param {Event} event - The event arguments.

	 */

	Owl.prototype.onDragMove = function(event) {

		var minimum = null,

			maximum = null,

			pull = null,

			delta = this.difference(this._drag.pointer, this.pointer(event)),

			stage = this.difference(this._drag.stage.start, delta);



		if (!this.is('dragging')) {

			return;

		}



		event.preventDefault();



		if (this.settings.loop) {

			minimum = this.coordinates(this.minimum());

			maximum = this.coordinates(this.maximum() + 1) - minimum;

			stage.x = (((stage.x - minimum) % maximum + maximum) % maximum) + minimum;

		} else {

			minimum = this.settings.rtl ? this.coordinates(this.maximum()) : this.coordinates(this.minimum());

			maximum = this.settings.rtl ? this.coordinates(this.minimum()) : this.coordinates(this.maximum());

			pull = this.settings.pullDrag ? -1 * delta.x / 5 : 0;

			stage.x = Math.max(Math.min(stage.x, minimum + pull), maximum + pull);

		}



		this._drag.stage.current = stage;



		this.animate(stage.x);

	};



	/**

	 * Handles the `touchend` and `mouseup` events.

	 * @todo #261

	 * @todo Threshold for click event

	 * @protected

	 * @param {Event} event - The event arguments.

	 */

	Owl.prototype.onDragEnd = function(event) {

		var delta = this.difference(this._drag.pointer, this.pointer(event)),

			stage = this._drag.stage.current,

			direction = delta.x > 0 ^ this.settings.rtl ? 'left' : 'right';



		$(document).off('.owl.core');



		this.$element.removeClass(this.options.grabClass);



		if (delta.x !== 0 && this.is('dragging') || !this.is('valid')) {

			this.speed(this.settings.dragEndSpeed || this.settings.smartSpeed);

			this.current(this.closest(stage.x, delta.x !== 0 ? direction : this._drag.direction));

			this.invalidate('position');

			this.update();



			this._drag.direction = direction;



			if (Math.abs(delta.x) > 3 || new Date().getTime() - this._drag.time > 300) {

				this._drag.target.one('click.owl.core', function() { return false; });

			}

		}



		if (!this.is('dragging')) {

			return;

		}



		this.leave('dragging');

		this.trigger('dragged');

	};



	/**

	 * Gets absolute position of the closest item for a coordinate.

	 * @todo Setting `freeDrag` makes `closest` not reusable. See #165.

	 * @protected

	 * @param {Number} coordinate - The coordinate in pixel.

	 * @param {String} direction - The direction to check for the closest item. Ether `left` or `right`.

	 * @return {Number} - The absolute position of the closest item.

	 */

	Owl.prototype.closest = function(coordinate, direction) {

		var position = -1,

			pull = 30,

			width = this.width(),

			coordinates = this.coordinates();



		if (!this.settings.freeDrag) {

			// check closest item

			$.each(coordinates, $.proxy(function(index, value) {

				// on a left pull, check on current index

				if (direction === 'left' && coordinate > value - pull && coordinate < value + pull) {

					position = index;

				// on a right pull, check on previous index

				// to do so, subtract width from value and set position = index + 1

				} else if (direction === 'right' && coordinate > value - width - pull && coordinate < value - width + pull) {

					position = index + 1;

				} else if (this.op(coordinate, '<', value)

					&& this.op(coordinate, '>', coordinates[index + 1] !== undefined ? coordinates[index + 1] : value - width)) {

					position = direction === 'left' ? index + 1 : index;

				}

				return position === -1;

			}, this));

		}



		if (!this.settings.loop) {

			// non loop boundries

			if (this.op(coordinate, '>', coordinates[this.minimum()])) {

				position = coordinate = this.minimum();

			} else if (this.op(coordinate, '<', coordinates[this.maximum()])) {

				position = coordinate = this.maximum();

			}

		}



		return position;

	};



	/**

	 * Animates the stage.

	 * @todo #270

	 * @public

	 * @param {Number} coordinate - The coordinate in pixels.

	 */

	Owl.prototype.animate = function(coordinate) {

		var animate = this.speed() > 0;



		this.is('animating') && this.onTransitionEnd();



		if (animate) {

			this.enter('animating');

			this.trigger('translate');

		}



		if ($.support.transform3d && $.support.transition) {

			this.$stage.css({

				transform: 'translate3d(' + coordinate + 'px,0px,0px)',

				transition: (this.speed() / 1000) + 's' + (

					this.settings.slideTransition ? ' ' + this.settings.slideTransition : ''

				)

			});

		} else if (animate) {

			this.$stage.animate({

				left: coordinate + 'px'

			}, this.speed(), this.settings.fallbackEasing, $.proxy(this.onTransitionEnd, this));

		} else {

			this.$stage.css({

				left: coordinate + 'px'

			});

		}

	};



	/**

	 * Checks whether the carousel is in a specific state or not.

	 * @param {String} state - The state to check.

	 * @returns {Boolean} - The flag which indicates if the carousel is busy.

	 */

	Owl.prototype.is = function(state) {

		return this._states.current[state] && this._states.current[state] > 0;

	};



	/**

	 * Sets the absolute position of the current item.

	 * @public

	 * @param {Number} [position] - The new absolute position or nothing to leave it unchanged.

	 * @returns {Number} - The absolute position of the current item.

	 */

	Owl.prototype.current = function(position) {

		if (position === undefined) {

			return this._current;

		}



		if (this._items.length === 0) {

			return undefined;

		}



		position = this.normalize(position);



		if (this._current !== position) {

			var event = this.trigger('change', { property: { name: 'position', value: position } });



			if (event.data !== undefined) {

				position = this.normalize(event.data);

			}



			this._current = position;



			this.invalidate('position');



			this.trigger('changed', { property: { name: 'position', value: this._current } });

		}



		return this._current;

	};



	/**

	 * Invalidates the given part of the update routine.

	 * @param {String} [part] - The part to invalidate.

	 * @returns {Array.<String>} - The invalidated parts.

	 */

	Owl.prototype.invalidate = function(part) {

		if ($.type(part) === 'string') {

			this._invalidated[part] = true;

			this.is('valid') && this.leave('valid');

		}

		return $.map(this._invalidated, function(v, i) { return i });

	};



	/**

	 * Resets the absolute position of the current item.

	 * @public

	 * @param {Number} position - The absolute position of the new item.

	 */

	Owl.prototype.reset = function(position) {

		position = this.normalize(position);



		if (position === undefined) {

			return;

		}



		this._speed = 0;

		this._current = position;



		this.suppress([ 'translate', 'translated' ]);



		this.animate(this.coordinates(position));



		this.release([ 'translate', 'translated' ]);

	};



	/**

	 * Normalizes an absolute or a relative position of an item.

	 * @public

	 * @param {Number} position - The absolute or relative position to normalize.

	 * @param {Boolean} [relative=false] - Whether the given position is relative or not.

	 * @returns {Number} - The normalized position.

	 */

	Owl.prototype.normalize = function(position, relative) {

		var n = this._items.length,

			m = relative ? 0 : this._clones.length;



		if (!this.isNumeric(position) || n < 1) {

			position = undefined;

		} else if (position < 0 || position >= n + m) {

			position = ((position - m / 2) % n + n) % n + m / 2;

		}



		return position;

	};



	/**

	 * Converts an absolute position of an item into a relative one.

	 * @public

	 * @param {Number} position - The absolute position to convert.

	 * @returns {Number} - The converted position.

	 */

	Owl.prototype.relative = function(position) {

		position -= this._clones.length / 2;

		return this.normalize(position, true);

	};



	/**

	 * Gets the maximum position for the current item.

	 * @public

	 * @param {Boolean} [relative=false] - Whether to return an absolute position or a relative position.

	 * @returns {Number}

	 */

	Owl.prototype.maximum = function(relative) {

		var settings = this.settings,

			maximum = this._coordinates.length,

			iterator,

			reciprocalItemsWidth,

			elementWidth;



		if (settings.loop) {

			maximum = this._clones.length / 2 + this._items.length - 1;

		} else if (settings.autoWidth || settings.merge) {

			iterator = this._items.length;

			if (iterator) {

				reciprocalItemsWidth = this._items[--iterator].width();

				elementWidth = this.$element.width();

				while (iterator--) {

					reciprocalItemsWidth += this._items[iterator].width() + this.settings.margin;

					if (reciprocalItemsWidth > elementWidth) {

						break;

					}

				}

			}

			maximum = iterator + 1;

		} else if (settings.center) {

			maximum = this._items.length - 1;

		} else {

			maximum = this._items.length - settings.items;

		}



		if (relative) {

			maximum -= this._clones.length / 2;

		}



		return Math.max(maximum, 0);

	};



	/**

	 * Gets the minimum position for the current item.

	 * @public

	 * @param {Boolean} [relative=false] - Whether to return an absolute position or a relative position.

	 * @returns {Number}

	 */

	Owl.prototype.minimum = function(relative) {

		return relative ? 0 : this._clones.length / 2;

	};



	/**

	 * Gets an item at the specified relative position.

	 * @public

	 * @param {Number} [position] - The relative position of the item.

	 * @return {jQuery|Array.<jQuery>} - The item at the given position or all items if no position was given.

	 */

	Owl.prototype.items = function(position) {

		if (position === undefined) {

			return this._items.slice();

		}



		position = this.normalize(position, true);

		return this._items[position];

	};



	/**

	 * Gets an item at the specified relative position.

	 * @public

	 * @param {Number} [position] - The relative position of the item.

	 * @return {jQuery|Array.<jQuery>} - The item at the given position or all items if no position was given.

	 */

	Owl.prototype.mergers = function(position) {

		if (position === undefined) {

			return this._mergers.slice();

		}



		position = this.normalize(position, true);

		return this._mergers[position];

	};



	/**

	 * Gets the absolute positions of clones for an item.

	 * @public

	 * @param {Number} [position] - The relative position of the item.

	 * @returns {Array.<Number>} - The absolute positions of clones for the item or all if no position was given.

	 */

	Owl.prototype.clones = function(position) {

		var odd = this._clones.length / 2,

			even = odd + this._items.length,

			map = function(index) { return index % 2 === 0 ? even + index / 2 : odd - (index + 1) / 2 };



		if (position === undefined) {

			return $.map(this._clones, function(v, i) { return map(i) });

		}



		return $.map(this._clones, function(v, i) { return v === position ? map(i) : null });

	};



	/**

	 * Sets the current animation speed.

	 * @public

	 * @param {Number} [speed] - The animation speed in milliseconds or nothing to leave it unchanged.

	 * @returns {Number} - The current animation speed in milliseconds.

	 */

	Owl.prototype.speed = function(speed) {

		if (speed !== undefined) {

			this._speed = speed;

		}



		return this._speed;

	};



	/**

	 * Gets the coordinate of an item.

	 * @todo The name of this method is missleanding.

	 * @public

	 * @param {Number} position - The absolute position of the item within `minimum()` and `maximum()`.

	 * @returns {Number|Array.<Number>} - The coordinate of the item in pixel or all coordinates.

	 */

	Owl.prototype.coordinates = function(position) {

		var multiplier = 1,

			newPosition = position - 1,

			coordinate;



		if (position === undefined) {

			return $.map(this._coordinates, $.proxy(function(coordinate, index) {

				return this.coordinates(index);

			}, this));

		}



		if (this.settings.center) {

			if (this.settings.rtl) {

				multiplier = -1;

				newPosition = position + 1;

			}



			coordinate = this._coordinates[position];

			coordinate += (this.width() - coordinate + (this._coordinates[newPosition] || 0)) / 2 * multiplier;

		} else {

			coordinate = this._coordinates[newPosition] || 0;

		}



		coordinate = Math.ceil(coordinate);



		return coordinate;

	};



	/**

	 * Calculates the speed for a translation.

	 * @protected

	 * @param {Number} from - The absolute position of the start item.

	 * @param {Number} to - The absolute position of the target item.

	 * @param {Number} [factor=undefined] - The time factor in milliseconds.

	 * @returns {Number} - The time in milliseconds for the translation.

	 */

	Owl.prototype.duration = function(from, to, factor) {

		if (factor === 0) {

			return 0;

		}



		return Math.min(Math.max(Math.abs(to - from), 1), 6) * Math.abs((factor || this.settings.smartSpeed));

	};



	/**

	 * Slides to the specified item.

	 * @public

	 * @param {Number} position - The position of the item.

	 * @param {Number} [speed] - The time in milliseconds for the transition.

	 */

	Owl.prototype.to = function(position, speed) {

		var current = this.current(),

			revert = null,

			distance = position - this.relative(current),

			direction = (distance > 0) - (distance < 0),

			items = this._items.length,

			minimum = this.minimum(),

			maximum = this.maximum();



		if (this.settings.loop) {

			if (!this.settings.rewind && Math.abs(distance) > items / 2) {

				distance += direction * -1 * items;

			}



			position = current + distance;

			revert = ((position - minimum) % items + items) % items + minimum;



			if (revert !== position && revert - distance <= maximum && revert - distance > 0) {

				current = revert - distance;

				position = revert;

				this.reset(current);

			}

		} else if (this.settings.rewind) {

			maximum += 1;

			position = (position % maximum + maximum) % maximum;

		} else {

			position = Math.max(minimum, Math.min(maximum, position));

		}



		this.speed(this.duration(current, position, speed));

		this.current(position);



		if (this.isVisible()) {

			this.update();

		}

	};



	/**

	 * Slides to the next item.

	 * @public

	 * @param {Number} [speed] - The time in milliseconds for the transition.

	 */

	Owl.prototype.next = function(speed) {

		speed = speed || false;

		this.to(this.relative(this.current()) + 1, speed);

	};



	/**

	 * Slides to the previous item.

	 * @public

	 * @param {Number} [speed] - The time in milliseconds for the transition.

	 */

	Owl.prototype.prev = function(speed) {

		speed = speed || false;

		this.to(this.relative(this.current()) - 1, speed);

	};



	/**

	 * Handles the end of an animation.

	 * @protected

	 * @param {Event} event - The event arguments.

	 */

	Owl.prototype.onTransitionEnd = function(event) {



		// if css2 animation then event object is undefined

		if (event !== undefined) {

			event.stopPropagation();



			// Catch only owl-stage transitionEnd event

			if ((event.target || event.srcElement || event.originalTarget) !== this.$stage.get(0)) {

				return false;

			}

		}



		this.leave('animating');

		this.trigger('translated');

	};



	/**

	 * Gets viewport width.

	 * @protected

	 * @return {Number} - The width in pixel.

	 */

	Owl.prototype.viewport = function() {

		var width;

		if (this.options.responsiveBaseElement !== window) {

			width = $(this.options.responsiveBaseElement).width();

		} else if (window.innerWidth) {

			width = window.innerWidth;

		} else if (document.documentElement && document.documentElement.clientWidth) {

			width = document.documentElement.clientWidth;

		} else {

			console.warn('Can not detect viewport width.');

		}

		return width;

	};



	/**

	 * Replaces the current content.

	 * @public

	 * @param {HTMLElement|jQuery|String} content - The new content.

	 */

	Owl.prototype.replace = function(content) {

		this.$stage.empty();

		this._items = [];



		if (content) {

			content = (content instanceof jQuery) ? content : $(content);

		}



		if (this.settings.nestedItemSelector) {

			content = content.find('.' + this.settings.nestedItemSelector);

		}



		content.filter(function() {

			return this.nodeType === 1;

		}).each($.proxy(function(index, item) {

			item = this.prepare(item);

			this.$stage.append(item);

			this._items.push(item);

			this._mergers.push(item.find('[data-merge]').addBack('[data-merge]').attr('data-merge') * 1 || 1);

		}, this));



		this.reset(this.isNumeric(this.settings.startPosition) ? this.settings.startPosition : 0);



		this.invalidate('items');

	};



	/**

	 * Adds an item.

	 * @todo Use `item` instead of `content` for the event arguments.

	 * @public

	 * @param {HTMLElement|jQuery|String} content - The item content to add.

	 * @param {Number} [position] - The relative position at which to insert the item otherwise the item will be added to the end.

	 */

	Owl.prototype.add = function(content, position) {

		var current = this.relative(this._current);



		position = position === undefined ? this._items.length : this.normalize(position, true);

		content = content instanceof jQuery ? content : $(content);



		this.trigger('add', { content: content, position: position });



		content = this.prepare(content);



		if (this._items.length === 0 || position === this._items.length) {

			this._items.length === 0 && this.$stage.append(content);

			this._items.length !== 0 && this._items[position - 1].after(content);

			this._items.push(content);

			this._mergers.push(content.find('[data-merge]').addBack('[data-merge]').attr('data-merge') * 1 || 1);

		} else {

			this._items[position].before(content);

			this._items.splice(position, 0, content);

			this._mergers.splice(position, 0, content.find('[data-merge]').addBack('[data-merge]').attr('data-merge') * 1 || 1);

		}



		this._items[current] && this.reset(this._items[current].index());



		this.invalidate('items');



		this.trigger('added', { content: content, position: position });

	};



	/**

	 * Removes an item by its position.

	 * @todo Use `item` instead of `content` for the event arguments.

	 * @public

	 * @param {Number} position - The relative position of the item to remove.

	 */

	Owl.prototype.remove = function(position) {

		position = this.normalize(position, true);



		if (position === undefined) {

			return;

		}



		this.trigger('remove', { content: this._items[position], position: position });



		this._items[position].remove();

		this._items.splice(position, 1);

		this._mergers.splice(position, 1);



		this.invalidate('items');



		this.trigger('removed', { content: null, position: position });

	};



	/**

	 * Preloads images with auto width.

	 * @todo Replace by a more generic approach

	 * @protected

	 */

	Owl.prototype.preloadAutoWidthImages = function(images) {

		images.each($.proxy(function(i, element) {

			this.enter('pre-loading');

			element = $(element);

			$(new Image()).one('load', $.proxy(function(e) {

				element.attr('src', e.target.src);

				element.css('opacity', 1);

				this.leave('pre-loading');

				!this.is('pre-loading') && !this.is('initializing') && this.refresh();

			}, this)).attr('src', element.attr('src') || element.attr('data-src') || element.attr('data-src-retina'));

		}, this));

	};



	/**

	 * Destroys the carousel.

	 * @public

	 */

	Owl.prototype.destroy = function() {



		this.$element.off('.owl.core');

		this.$stage.off('.owl.core');

		$(document).off('.owl.core');



		if (this.settings.responsive !== false) {

			window.clearTimeout(this.resizeTimer);

			this.off(window, 'resize', this._handlers.onThrottledResize);

		}



		for (var i in this._plugins) {

			this._plugins[i].destroy();

		}



		this.$stage.children('.cloned').remove();



		this.$stage.unwrap();

		this.$stage.children().contents().unwrap();

		this.$stage.children().unwrap();

		this.$stage.remove();

		this.$element

			.removeClass(this.options.refreshClass)

			.removeClass(this.options.loadingClass)

			.removeClass(this.options.loadedClass)

			.removeClass(this.options.rtlClass)

			.removeClass(this.options.dragClass)

			.removeClass(this.options.grabClass)

			.attr('class', this.$element.attr('class').replace(new RegExp(this.options.responsiveClass + '-\\S+\\s', 'g'), ''))

			.removeData('owl.carousel');

	};



	/**

	 * Operators to calculate right-to-left and left-to-right.

	 * @protected

	 * @param {Number} [a] - The left side operand.

	 * @param {String} [o] - The operator.

	 * @param {Number} [b] - The right side operand.

	 */

	Owl.prototype.op = function(a, o, b) {

		var rtl = this.settings.rtl;

		switch (o) {

			case '<':

				return rtl ? a > b : a < b;

			case '>':

				return rtl ? a < b : a > b;

			case '>=':

				return rtl ? a <= b : a >= b;

			case '<=':

				return rtl ? a >= b : a <= b;

			default:

				break;

		}

	};



	/**

	 * Attaches to an internal event.

	 * @protected

	 * @param {HTMLElement} element - The event source.

	 * @param {String} event - The event name.

	 * @param {Function} listener - The event handler to attach.

	 * @param {Boolean} capture - Wether the event should be handled at the capturing phase or not.

	 */

	Owl.prototype.on = function(element, event, listener, capture) {

		if (element.addEventListener) {

			element.addEventListener(event, listener, capture);

		} else if (element.attachEvent) {

			element.attachEvent('on' + event, listener);

		}

	};



	/**

	 * Detaches from an internal event.

	 * @protected

	 * @param {HTMLElement} element - The event source.

	 * @param {String} event - The event name.

	 * @param {Function} listener - The attached event handler to detach.

	 * @param {Boolean} capture - Wether the attached event handler was registered as a capturing listener or not.

	 */

	Owl.prototype.off = function(element, event, listener, capture) {

		if (element.removeEventListener) {

			element.removeEventListener(event, listener, capture);

		} else if (element.detachEvent) {

			element.detachEvent('on' + event, listener);

		}

	};



	/**

	 * Triggers a public event.

	 * @todo Remove `status`, `relatedTarget` should be used instead.

	 * @protected

	 * @param {String} name - The event name.

	 * @param {*} [data=null] - The event data.

	 * @param {String} [namespace=carousel] - The event namespace.

	 * @param {String} [state] - The state which is associated with the event.

	 * @param {Boolean} [enter=false] - Indicates if the call enters the specified state or not.

	 * @returns {Event} - The event arguments.

	 */

	Owl.prototype.trigger = function(name, data, namespace, state, enter) {

		var status = {

			item: { count: this._items.length, index: this.current() }

		}, handler = $.camelCase(

			$.grep([ 'on', name, namespace ], function(v) { return v })

				.join('-').toLowerCase()

		), event = $.Event(

			[ name, 'owl', namespace || 'carousel' ].join('.').toLowerCase(),

			$.extend({ relatedTarget: this }, status, data)

		);



		if (!this._supress[name]) {

			$.each(this._plugins, function(name, plugin) {

				if (plugin.onTrigger) {

					plugin.onTrigger(event);

				}

			});



			this.register({ type: Owl.Type.Event, name: name });

			this.$element.trigger(event);



			if (this.settings && typeof this.settings[handler] === 'function') {

				this.settings[handler].call(this, event);

			}

		}



		return event;

	};



	/**

	 * Enters a state.

	 * @param name - The state name.

	 */

	Owl.prototype.enter = function(name) {

		$.each([ name ].concat(this._states.tags[name] || []), $.proxy(function(i, name) {

			if (this._states.current[name] === undefined) {

				this._states.current[name] = 0;

			}



			this._states.current[name]++;

		}, this));

	};



	/**

	 * Leaves a state.

	 * @param name - The state name.

	 */

	Owl.prototype.leave = function(name) {

		$.each([ name ].concat(this._states.tags[name] || []), $.proxy(function(i, name) {

			this._states.current[name]--;

		}, this));

	};



	/**

	 * Registers an event or state.

	 * @public

	 * @param {Object} object - The event or state to register.

	 */

	Owl.prototype.register = function(object) {

		if (object.type === Owl.Type.Event) {

			if (!$.event.special[object.name]) {

				$.event.special[object.name] = {};

			}



			if (!$.event.special[object.name].owl) {

				var _default = $.event.special[object.name]._default;

				$.event.special[object.name]._default = function(e) {

					if (_default && _default.apply && (!e.namespace || e.namespace.indexOf('owl') === -1)) {

						return _default.apply(this, arguments);

					}

					return e.namespace && e.namespace.indexOf('owl') > -1;

				};

				$.event.special[object.name].owl = true;

			}

		} else if (object.type === Owl.Type.State) {

			if (!this._states.tags[object.name]) {

				this._states.tags[object.name] = object.tags;

			} else {

				this._states.tags[object.name] = this._states.tags[object.name].concat(object.tags);

			}



			this._states.tags[object.name] = $.grep(this._states.tags[object.name], $.proxy(function(tag, i) {

				return $.inArray(tag, this._states.tags[object.name]) === i;

			}, this));

		}

	};



	/**

	 * Suppresses events.

	 * @protected

	 * @param {Array.<String>} events - The events to suppress.

	 */

	Owl.prototype.suppress = function(events) {

		$.each(events, $.proxy(function(index, event) {

			this._supress[event] = true;

		}, this));

	};



	/**

	 * Releases suppressed events.

	 * @protected

	 * @param {Array.<String>} events - The events to release.

	 */

	Owl.prototype.release = function(events) {

		$.each(events, $.proxy(function(index, event) {

			delete this._supress[event];

		}, this));

	};



	/**

	 * Gets unified pointer coordinates from event.

	 * @todo #261

	 * @protected

	 * @param {Event} - The `mousedown` or `touchstart` event.

	 * @returns {Object} - Contains `x` and `y` coordinates of current pointer position.

	 */

	Owl.prototype.pointer = function(event) {

		var result = { x: null, y: null };



		event = event.originalEvent || event || window.event;



		event = event.touches && event.touches.length ?

			event.touches[0] : event.changedTouches && event.changedTouches.length ?

				event.changedTouches[0] : event;



		if (event.pageX) {

			result.x = event.pageX;

			result.y = event.pageY;

		} else {

			result.x = event.clientX;

			result.y = event.clientY;

		}



		return result;

	};



	/**

	 * Determines if the input is a Number or something that can be coerced to a Number

	 * @protected

	 * @param {Number|String|Object|Array|Boolean|RegExp|Function|Symbol} - The input to be tested

	 * @returns {Boolean} - An indication if the input is a Number or can be coerced to a Number

	 */

	Owl.prototype.isNumeric = function(number) {

		return !isNaN(parseFloat(number));

	};



	/**

	 * Gets the difference of two vectors.

	 * @todo #261

	 * @protected

	 * @param {Object} - The first vector.

	 * @param {Object} - The second vector.

	 * @returns {Object} - The difference.

	 */

	Owl.prototype.difference = function(first, second) {

		return {

			x: first.x - second.x,

			y: first.y - second.y

		};

	};



	/**

	 * The jQuery Plugin for the Owl Carousel

	 * @todo Navigation plugin `next` and `prev`

	 * @public

	 */

	$.fn.owlCarousel = function(option) {

		var args = Array.prototype.slice.call(arguments, 1);



		return this.each(function() {

			var $this = $(this),

				data = $this.data('owl.carousel');



			if (!data) {

				data = new Owl(this, typeof option == 'object' && option);

				$this.data('owl.carousel', data);



				$.each([

					'next', 'prev', 'to', 'destroy', 'refresh', 'replace', 'add', 'remove'

				], function(i, event) {

					data.register({ type: Owl.Type.Event, name: event });

					data.$element.on(event + '.owl.carousel.core', $.proxy(function(e) {

						if (e.namespace && e.relatedTarget !== this) {

							this.suppress([ event ]);

							data[event].apply(this, [].slice.call(arguments, 1));

							this.release([ event ]);

						}

					}, data));

				});

			}



			if (typeof option == 'string' && option.charAt(0) !== '_') {

				data[option].apply(data, args);

			}

		});

	};



	/**

	 * The constructor for the jQuery Plugin

	 * @public

	 */

	$.fn.owlCarousel.Constructor = Owl;



})(window.Zepto || window.jQuery, window, document);



/**

 * AutoRefresh Plugin

 * @version 2.3.4

 * @author Artus Kolanowski

 * @author David Deutsch

 * @license The MIT License (MIT)

 */

;(function($, window, document, undefined) {



	/**

	 * Creates the auto refresh plugin.

	 * @class The Auto Refresh Plugin

	 * @param {Owl} carousel - The Owl Carousel

	 */

	var AutoRefresh = function(carousel) {

		/**

		 * Reference to the core.

		 * @protected

		 * @type {Owl}

		 */

		this._core = carousel;



		/**

		 * Refresh interval.

		 * @protected

		 * @type {number}

		 */

		this._interval = null;



		/**

		 * Whether the element is currently visible or not.

		 * @protected

		 * @type {Boolean}

		 */

		this._visible = null;



		/**

		 * All event handlers.

		 * @protected

		 * @type {Object}

		 */

		this._handlers = {

			'initialized.owl.carousel': $.proxy(function(e) {

				if (e.namespace && this._core.settings.autoRefresh) {

					this.watch();

				}

			}, this)

		};



		// set default options

		this._core.options = $.extend({}, AutoRefresh.Defaults, this._core.options);



		// register event handlers

		this._core.$element.on(this._handlers);

	};



	/**

	 * Default options.

	 * @public

	 */

	AutoRefresh.Defaults = {

		autoRefresh: true,

		autoRefreshInterval: 500

	};



	/**

	 * Watches the element.

	 */

	AutoRefresh.prototype.watch = function() {

		if (this._interval) {

			return;

		}



		this._visible = this._core.isVisible();

		this._interval = window.setInterval($.proxy(this.refresh, this), this._core.settings.autoRefreshInterval);

	};



	/**

	 * Refreshes the element.

	 */

	AutoRefresh.prototype.refresh = function() {

		if (this._core.isVisible() === this._visible) {

			return;

		}



		this._visible = !this._visible;



		this._core.$element.toggleClass('owl-hidden', !this._visible);



		this._visible && (this._core.invalidate('width') && this._core.refresh());

	};



	/**

	 * Destroys the plugin.

	 */

	AutoRefresh.prototype.destroy = function() {

		var handler, property;



		window.clearInterval(this._interval);



		for (handler in this._handlers) {

			this._core.$element.off(handler, this._handlers[handler]);

		}

		for (property in Object.getOwnPropertyNames(this)) {

			typeof this[property] != 'function' && (this[property] = null);

		}

	};



	$.fn.owlCarousel.Constructor.Plugins.AutoRefresh = AutoRefresh;



})(window.Zepto || window.jQuery, window, document);



/**

 * Lazy Plugin

 * @version 2.3.4

 * @author Bartosz Wojciechowski

 * @author David Deutsch

 * @license The MIT License (MIT)

 */

;(function($, window, document, undefined) {



	/**

	 * Creates the lazy plugin.

	 * @class The Lazy Plugin

	 * @param {Owl} carousel - The Owl Carousel

	 */

	var Lazy = function(carousel) {



		/**

		 * Reference to the core.

		 * @protected

		 * @type {Owl}

		 */

		this._core = carousel;



		/**

		 * Already loaded items.

		 * @protected

		 * @type {Array.<jQuery>}

		 */

		this._loaded = [];



		/**

		 * Event handlers.

		 * @protected

		 * @type {Object}

		 */

		this._handlers = {

			'initialized.owl.carousel change.owl.carousel resized.owl.carousel': $.proxy(function(e) {

				if (!e.namespace) {

					return;

				}



				if (!this._core.settings || !this._core.settings.lazyLoad) {

					return;

				}



				if ((e.property && e.property.name == 'position') || e.type == 'initialized') {

					var settings = this._core.settings,

						n = (settings.center && Math.ceil(settings.items / 2) || settings.items),

						i = ((settings.center && n * -1) || 0),

						position = (e.property && e.property.value !== undefined ? e.property.value : this._core.current()) + i,

						clones = this._core.clones().length,

						load = $.proxy(function(i, v) { this.load(v) }, this);

					//TODO: Need documentation for this new option

					if (settings.lazyLoadEager > 0) {

						n += settings.lazyLoadEager;

						// If the carousel is looping also preload images that are to the "left"

						if (settings.loop) {

              position -= settings.lazyLoadEager;

              n++;

            }

					}



					while (i++ < n) {

						this.load(clones / 2 + this._core.relative(position));

						clones && $.each(this._core.clones(this._core.relative(position)), load);

						position++;

					}

				}

			}, this)

		};



		// set the default options

		this._core.options = $.extend({}, Lazy.Defaults, this._core.options);



		// register event handler

		this._core.$element.on(this._handlers);

	};



	/**

	 * Default options.

	 * @public

	 */

	Lazy.Defaults = {

		lazyLoad: false,

		lazyLoadEager: 0

	};



	/**

	 * Loads all resources of an item at the specified position.

	 * @param {Number} position - The absolute position of the item.

	 * @protected

	 */

	Lazy.prototype.load = function(position) {

		var $item = this._core.$stage.children().eq(position),

			$elements = $item && $item.find('.owl-lazy');



		if (!$elements || $.inArray($item.get(0), this._loaded) > -1) {

			return;

		}



		$elements.each($.proxy(function(index, element) {

			var $element = $(element), image,

                url = (window.devicePixelRatio > 1 && $element.attr('data-src-retina')) || $element.attr('data-src') || $element.attr('data-srcset');



			this._core.trigger('load', { element: $element, url: url }, 'lazy');



			if ($element.is('img')) {

				$element.one('load.owl.lazy', $.proxy(function() {

					$element.css('opacity', 1);

					this._core.trigger('loaded', { element: $element, url: url }, 'lazy');

				}, this)).attr('src', url);

            } else if ($element.is('source')) {

                $element.one('load.owl.lazy', $.proxy(function() {

                    this._core.trigger('loaded', { element: $element, url: url }, 'lazy');

                }, this)).attr('srcset', url);

			} else {

				image = new Image();

				image.onload = $.proxy(function() {

					$element.css({

						'background-image': 'url("' + url + '")',

						'opacity': '1'

					});

					this._core.trigger('loaded', { element: $element, url: url }, 'lazy');

				}, this);

				image.src = url;

			}

		}, this));



		this._loaded.push($item.get(0));

	};



	/**

	 * Destroys the plugin.

	 * @public

	 */

	Lazy.prototype.destroy = function() {

		var handler, property;



		for (handler in this.handlers) {

			this._core.$element.off(handler, this.handlers[handler]);

		}

		for (property in Object.getOwnPropertyNames(this)) {

			typeof this[property] != 'function' && (this[property] = null);

		}

	};



	$.fn.owlCarousel.Constructor.Plugins.Lazy = Lazy;



})(window.Zepto || window.jQuery, window, document);



/**

 * AutoHeight Plugin

 * @version 2.3.4

 * @author Bartosz Wojciechowski

 * @author David Deutsch

 * @license The MIT License (MIT)

 */

;(function($, window, document, undefined) {



	/**

	 * Creates the auto height plugin.

	 * @class The Auto Height Plugin

	 * @param {Owl} carousel - The Owl Carousel

	 */

	var AutoHeight = function(carousel) {

		/**

		 * Reference to the core.

		 * @protected

		 * @type {Owl}

		 */

		this._core = carousel;



		this._previousHeight = null;



		/**

		 * All event handlers.

		 * @protected

		 * @type {Object}

		 */

		this._handlers = {

			'initialized.owl.carousel refreshed.owl.carousel': $.proxy(function(e) {

				if (e.namespace && this._core.settings.autoHeight) {

					this.update();

				}

			}, this),

			'changed.owl.carousel': $.proxy(function(e) {

				if (e.namespace && this._core.settings.autoHeight && e.property.name === 'position'){

					this.update();

				}

			}, this),

			'loaded.owl.lazy': $.proxy(function(e) {

				if (e.namespace && this._core.settings.autoHeight

					&& e.element.closest('.' + this._core.settings.itemClass).index() === this._core.current()) {

					this.update();

				}

			}, this)

		};



		// set default options

		this._core.options = $.extend({}, AutoHeight.Defaults, this._core.options);



		// register event handlers

		this._core.$element.on(this._handlers);

		this._intervalId = null;

		var refThis = this;



		// These changes have been taken from a PR by gavrochelegnou proposed in #1575

		// and have been made compatible with the latest jQuery version

		$(window).on('load', function() {

			if (refThis._core.settings.autoHeight) {

				refThis.update();

			}

		});



		// Autoresize the height of the carousel when window is resized

		// When carousel has images, the height is dependent on the width

		// and should also change on resize

		$(window).resize(function() {

			if (refThis._core.settings.autoHeight) {

				if (refThis._intervalId != null) {

					clearTimeout(refThis._intervalId);

				}



				refThis._intervalId = setTimeout(function() {

					refThis.update();

				}, 250);

			}

		});



	};



	/**

	 * Default options.

	 * @public

	 */

	AutoHeight.Defaults = {

		autoHeight: false,

		autoHeightClass: 'owl-height'

	};



	/**

	 * Updates the view.

	 */

	AutoHeight.prototype.update = function() {

		var start = this._core._current,

			end = start + this._core.settings.items,

			lazyLoadEnabled = this._core.settings.lazyLoad,

			visible = this._core.$stage.children().toArray().slice(start, end),

			heights = [],

			maxheight = 0;



		$.each(visible, function(index, item) {

			heights.push($(item).height());

		});



		maxheight = Math.max.apply(null, heights);



		if (maxheight <= 1 && lazyLoadEnabled && this._previousHeight) {

			maxheight = this._previousHeight;

		}



		this._previousHeight = maxheight;



		this._core.$stage.parent()

			.height(maxheight)

			.addClass(this._core.settings.autoHeightClass);

	};



	AutoHeight.prototype.destroy = function() {

		var handler, property;



		for (handler in this._handlers) {

			this._core.$element.off(handler, this._handlers[handler]);

		}

		for (property in Object.getOwnPropertyNames(this)) {

			typeof this[property] !== 'function' && (this[property] = null);

		}

	};



	$.fn.owlCarousel.Constructor.Plugins.AutoHeight = AutoHeight;



})(window.Zepto || window.jQuery, window, document);



/**

 * Video Plugin

 * @version 2.3.4

 * @author Bartosz Wojciechowski

 * @author David Deutsch

 * @license The MIT License (MIT)

 */

;(function($, window, document, undefined) {



	/**

	 * Creates the video plugin.

	 * @class The Video Plugin

	 * @param {Owl} carousel - The Owl Carousel

	 */

	var Video = function(carousel) {

		/**

		 * Reference to the core.

		 * @protected

		 * @type {Owl}

		 */

		this._core = carousel;



		/**

		 * Cache all video URLs.

		 * @protected

		 * @type {Object}

		 */

		this._videos = {};



		/**

		 * Current playing item.

		 * @protected

		 * @type {jQuery}

		 */

		this._playing = null;



		/**

		 * All event handlers.

		 * @todo The cloned content removale is too late

		 * @protected

		 * @type {Object}

		 */

		this._handlers = {

			'initialized.owl.carousel': $.proxy(function(e) {

				if (e.namespace) {

					this._core.register({ type: 'state', name: 'playing', tags: [ 'interacting' ] });

				}

			}, this),

			'resize.owl.carousel': $.proxy(function(e) {

				if (e.namespace && this._core.settings.video && this.isInFullScreen()) {

					e.preventDefault();

				}

			}, this),

			'refreshed.owl.carousel': $.proxy(function(e) {

				if (e.namespace && this._core.is('resizing')) {

					this._core.$stage.find('.cloned .owl-video-frame').remove();

				}

			}, this),

			'changed.owl.carousel': $.proxy(function(e) {

				if (e.namespace && e.property.name === 'position' && this._playing) {

					this.stop();

				}

			}, this),

			'prepared.owl.carousel': $.proxy(function(e) {

				if (!e.namespace) {

					return;

				}



				var $element = $(e.content).find('.owl-video');



				if ($element.length) {

					$element.css('display', 'none');

					this.fetch($element, $(e.content));

				}

			}, this)

		};



		// set default options

		this._core.options = $.extend({}, Video.Defaults, this._core.options);



		// register event handlers

		this._core.$element.on(this._handlers);



		this._core.$element.on('click.owl.video', '.owl-video-play-icon', $.proxy(function(e) {

			this.play(e);

		}, this));

	};



	/**

	 * Default options.

	 * @public

	 */

	Video.Defaults = {

		video: false,

		videoHeight: false,

		videoWidth: false

	};



	/**

	 * Gets the video ID and the type (YouTube/Vimeo/vzaar only).

	 * @protected

	 * @param {jQuery} target - The target containing the video data.

	 * @param {jQuery} item - The item containing the video.

	 */

	Video.prototype.fetch = function(target, item) {

			var type = (function() {

					if (target.attr('data-vimeo-id')) {

						return 'vimeo';

					} else if (target.attr('data-vzaar-id')) {

						return 'vzaar'

					} else {

						return 'youtube';

					}

				})(),

				id = target.attr('data-vimeo-id') || target.attr('data-youtube-id') || target.attr('data-vzaar-id'),

				width = target.attr('data-width') || this._core.settings.videoWidth,

				height = target.attr('data-height') || this._core.settings.videoHeight,

				url = target.attr('href');



		if (url) {



			/*

					Parses the id's out of the following urls (and probably more):

					https://www.youtube.com/watch?v=:id

					https://youtu.be/:id

					https://vimeo.com/:id

					https://vimeo.com/channels/:channel/:id

					https://vimeo.com/groups/:group/videos/:id

					https://app.vzaar.com/videos/:id



					Visual example: https://regexper.com/#(http%3A%7Chttps%3A%7C)%5C%2F%5C%2F(player.%7Cwww.%7Capp.)%3F(vimeo%5C.com%7Cyoutu(be%5C.com%7C%5C.be%7Cbe%5C.googleapis%5C.com)%7Cvzaar%5C.com)%5C%2F(video%5C%2F%7Cvideos%5C%2F%7Cembed%5C%2F%7Cchannels%5C%2F.%2B%5C%2F%7Cgroups%5C%2F.%2B%5C%2F%7Cwatch%5C%3Fv%3D%7Cv%5C%2F)%3F(%5BA-Za-z0-9._%25-%5D*)(%5C%26%5CS%2B)%3F

			*/



			id = url.match(/(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com|be\-nocookie\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);



			if (id[3].indexOf('youtu') > -1) {

				type = 'youtube';

			} else if (id[3].indexOf('vimeo') > -1) {

				type = 'vimeo';

			} else if (id[3].indexOf('vzaar') > -1) {

				type = 'vzaar';

			} else {

				throw new Error('Video URL not supported.');

			}

			id = id[6];

		} else {

			throw new Error('Missing video URL.');

		}



		this._videos[url] = {

			type: type,

			id: id,

			width: width,

			height: height

		};



		item.attr('data-video', url);



		this.thumbnail(target, this._videos[url]);

	};



	/**

	 * Creates video thumbnail.

	 * @protected

	 * @param {jQuery} target - The target containing the video data.

	 * @param {Object} info - The video info object.

	 * @see `fetch`

	 */

	Video.prototype.thumbnail = function(target, video) {

		var tnLink,

			icon,

			path,

			dimensions = video.width && video.height ? 'width:' + video.width + 'px;height:' + video.height + 'px;' : '',

			customTn = target.find('img'),

			srcType = 'src',

			lazyClass = '',

			settings = this._core.settings,

			create = function(path) {

				icon = '<div class="owl-video-play-icon"></div>';



				if (settings.lazyLoad) {

					tnLink = $('<div/>',{

						"class": 'owl-video-tn ' + lazyClass,

						"srcType": path

					});

				} else {

					tnLink = $( '<div/>', {

						"class": "owl-video-tn",

						"style": 'opacity:1;background-image:url(' + path + ')'

					});

				}

				target.after(tnLink);

				target.after(icon);

			};



		// wrap video content into owl-video-wrapper div

		target.wrap( $( '<div/>', {

			"class": "owl-video-wrapper",

			"style": dimensions

		}));



		if (this._core.settings.lazyLoad) {

			srcType = 'data-src';

			lazyClass = 'owl-lazy';

		}



		// custom thumbnail

		if (customTn.length) {

			create(customTn.attr(srcType));

			customTn.remove();

			return false;

		}



		if (video.type === 'youtube') {

			path = "//img.youtube.com/vi/" + video.id + "/hqdefault.jpg";

			create(path);

		} else if (video.type === 'vimeo') {

			$.ajax({

				type: 'GET',

				url: '//vimeo.com/api/v2/video/' + video.id + '.json',

				jsonp: 'callback',

				dataType: 'jsonp',

				success: function(data) {

					path = data[0].thumbnail_large;

					create(path);

				}

			});

		} else if (video.type === 'vzaar') {

			$.ajax({

				type: 'GET',

				url: '//vzaar.com/api/videos/' + video.id + '.json',

				jsonp: 'callback',

				dataType: 'jsonp',

				success: function(data) {

					path = data.framegrab_url;

					create(path);

				}

			});

		}

	};



	/**

	 * Stops the current video.

	 * @public

	 */

	Video.prototype.stop = function() {

		this._core.trigger('stop', null, 'video');

		this._playing.find('.owl-video-frame').remove();

		this._playing.removeClass('owl-video-playing');

		this._playing = null;

		this._core.leave('playing');

		this._core.trigger('stopped', null, 'video');

	};



	/**

	 * Starts the current video.

	 * @public

	 * @param {Event} event - The event arguments.

	 */

	Video.prototype.play = function(event) {

		var target = $(event.target),

			item = target.closest('.' + this._core.settings.itemClass),

			video = this._videos[item.attr('data-video')],

			width = video.width || '100%',

			height = video.height || this._core.$stage.height(),

			html,

			iframe;



		if (this._playing) {

			return;

		}



		this._core.enter('playing');

		this._core.trigger('play', null, 'video');



		item = this._core.items(this._core.relative(item.index()));



		this._core.reset(item.index());



		html = $( '<iframe frameborder="0" allowfullscreen mozallowfullscreen webkitAllowFullScreen ></iframe>' );

		html.attr( 'height', height );

		html.attr( 'width', width );

		if (video.type === 'youtube') {

			html.attr( 'src', '//www.youtube.com/embed/' + video.id + '?autoplay=1&rel=0&v=' + video.id );

		} else if (video.type === 'vimeo') {

			html.attr( 'src', '//player.vimeo.com/video/' + video.id + '?autoplay=1' );

		} else if (video.type === 'vzaar') {

			html.attr( 'src', '//view.vzaar.com/' + video.id + '/player?autoplay=true' );

		}



		iframe = $(html).wrap( '<div class="owl-video-frame" />' ).insertAfter(item.find('.owl-video'));



		this._playing = item.addClass('owl-video-playing');

	};



	/**

	 * Checks whether an video is currently in full screen mode or not.

	 * @todo Bad style because looks like a readonly method but changes members.

	 * @protected

	 * @returns {Boolean}

	 */

	Video.prototype.isInFullScreen = function() {

		var element = document.fullscreenElement || document.mozFullScreenElement ||

				document.webkitFullscreenElement;



		return element && $(element).parent().hasClass('owl-video-frame');

	};



	/**

	 * Destroys the plugin.

	 */

	Video.prototype.destroy = function() {

		var handler, property;



		this._core.$element.off('click.owl.video');



		for (handler in this._handlers) {

			this._core.$element.off(handler, this._handlers[handler]);

		}

		for (property in Object.getOwnPropertyNames(this)) {

			typeof this[property] != 'function' && (this[property] = null);

		}

	};



	$.fn.owlCarousel.Constructor.Plugins.Video = Video;



})(window.Zepto || window.jQuery, window, document);



/**

 * Animate Plugin

 * @version 2.3.4

 * @author Bartosz Wojciechowski

 * @author David Deutsch

 * @license The MIT License (MIT)

 */

;(function($, window, document, undefined) {



	/**

	 * Creates the animate plugin.

	 * @class The Navigation Plugin

	 * @param {Owl} scope - The Owl Carousel

	 */

	var Animate = function(scope) {

		this.core = scope;

		this.core.options = $.extend({}, Animate.Defaults, this.core.options);

		this.swapping = true;

		this.previous = undefined;

		this.next = undefined;



		this.handlers = {

			'change.owl.carousel': $.proxy(function(e) {

				if (e.namespace && e.property.name == 'position') {

					this.previous = this.core.current();

					this.next = e.property.value;

				}

			}, this),

			'drag.owl.carousel dragged.owl.carousel translated.owl.carousel': $.proxy(function(e) {

				if (e.namespace) {

					this.swapping = e.type == 'translated';

				}

			}, this),

			'translate.owl.carousel': $.proxy(function(e) {

				if (e.namespace && this.swapping && (this.core.options.animateOut || this.core.options.animateIn)) {

					this.swap();

				}

			}, this)

		};



		this.core.$element.on(this.handlers);

	};



	/**

	 * Default options.

	 * @public

	 */

	Animate.Defaults = {

		animateOut: false,

		animateIn: false

	};



	/**

	 * Toggles the animation classes whenever an translations starts.

	 * @protected

	 * @returns {Boolean|undefined}

	 */

	Animate.prototype.swap = function() {



		if (this.core.settings.items !== 1) {

			return;

		}



		if (!$.support.animation || !$.support.transition) {

			return;

		}



		this.core.speed(0);



		var left,

			clear = $.proxy(this.clear, this),

			previous = this.core.$stage.children().eq(this.previous),

			next = this.core.$stage.children().eq(this.next),

			incoming = this.core.settings.animateIn,

			outgoing = this.core.settings.animateOut;



		if (this.core.current() === this.previous) {

			return;

		}



		if (outgoing) {

			left = this.core.coordinates(this.previous) - this.core.coordinates(this.next);

			previous.one($.support.animation.end, clear)

				.css( { 'left': left + 'px' } )

				.addClass('animated owl-animated-out')

				.addClass(outgoing);

		}



		if (incoming) {

			next.one($.support.animation.end, clear)

				.addClass('animated owl-animated-in')

				.addClass(incoming);

		}

	};



	Animate.prototype.clear = function(e) {

		$(e.target).css( { 'left': '' } )

			.removeClass('animated owl-animated-out owl-animated-in')

			.removeClass(this.core.settings.animateIn)

			.removeClass(this.core.settings.animateOut);

		this.core.onTransitionEnd();

	};



	/**

	 * Destroys the plugin.

	 * @public

	 */

	Animate.prototype.destroy = function() {

		var handler, property;



		for (handler in this.handlers) {

			this.core.$element.off(handler, this.handlers[handler]);

		}

		for (property in Object.getOwnPropertyNames(this)) {

			typeof this[property] != 'function' && (this[property] = null);

		}

	};



	$.fn.owlCarousel.Constructor.Plugins.Animate = Animate;



})(window.Zepto || window.jQuery, window, document);



/**

 * Autoplay Plugin

 * @version 2.3.4

 * @author Bartosz Wojciechowski

 * @author Artus Kolanowski

 * @author David Deutsch

 * @author Tom De Caluwé

 * @license The MIT License (MIT)

 */

;(function($, window, document, undefined) {



	/**

	 * Creates the autoplay plugin.

	 * @class The Autoplay Plugin

	 * @param {Owl} scope - The Owl Carousel

	 */

	var Autoplay = function(carousel) {

		/**

		 * Reference to the core.

		 * @protected

		 * @type {Owl}

		 */

		this._core = carousel;



		/**

		 * The autoplay timeout id.

		 * @type {Number}

		 */

		this._call = null;



		/**

		 * Depending on the state of the plugin, this variable contains either

		 * the start time of the timer or the current timer value if it's

		 * paused. Since we start in a paused state we initialize the timer

		 * value.

		 * @type {Number}

		 */

		this._time = 0;



		/**

		 * Stores the timeout currently used.

		 * @type {Number}

		 */

		this._timeout = 0;



		/**

		 * Indicates whenever the autoplay is paused.

		 * @type {Boolean}

		 */

		this._paused = true;



		/**

		 * All event handlers.

		 * @protected

		 * @type {Object}

		 */

		this._handlers = {

			'changed.owl.carousel': $.proxy(function(e) {

				if (e.namespace && e.property.name === 'settings') {

					if (this._core.settings.autoplay) {

						this.play();

					} else {

						this.stop();

					}

				} else if (e.namespace && e.property.name === 'position' && this._paused) {

					// Reset the timer. This code is triggered when the position

					// of the carousel was changed through user interaction.

					this._time = 0;

				}

			}, this),

			'initialized.owl.carousel': $.proxy(function(e) {

				if (e.namespace && this._core.settings.autoplay) {

					this.play();

				}

			}, this),

			'play.owl.autoplay': $.proxy(function(e, t, s) {

				if (e.namespace) {

					this.play(t, s);

				}

			}, this),

			'stop.owl.autoplay': $.proxy(function(e) {

				if (e.namespace) {

					this.stop();

				}

			}, this),

			'mouseover.owl.autoplay': $.proxy(function() {

				if (this._core.settings.autoplayHoverPause && this._core.is('rotating')) {

					this.pause();

				}

			}, this),

			'mouseleave.owl.autoplay': $.proxy(function() {

				if (this._core.settings.autoplayHoverPause && this._core.is('rotating')) {

					this.play();

				}

			}, this),

			'touchstart.owl.core': $.proxy(function() {

				if (this._core.settings.autoplayHoverPause && this._core.is('rotating')) {

					this.pause();

				}

			}, this),

			'touchend.owl.core': $.proxy(function() {

				if (this._core.settings.autoplayHoverPause) {

					this.play();

				}

			}, this)

		};



		// register event handlers

		this._core.$element.on(this._handlers);



		// set default options

		this._core.options = $.extend({}, Autoplay.Defaults, this._core.options);

	};



	/**

	 * Default options.

	 * @public

	 */

	Autoplay.Defaults = {

		autoplay: false,

		autoplayTimeout: 5000,

		autoplayHoverPause: false,

		autoplaySpeed: false

	};



	/**

	 * Transition to the next slide and set a timeout for the next transition.

	 * @private

	 * @param {Number} [speed] - The animation speed for the animations.

	 */

	Autoplay.prototype._next = function(speed) {

		this._call = window.setTimeout(

			$.proxy(this._next, this, speed),

			this._timeout * (Math.round(this.read() / this._timeout) + 1) - this.read()

		);



		if (this._core.is('interacting') || document.hidden) {

			return;

		}

		this._core.next(speed || this._core.settings.autoplaySpeed);

	}



	/**

	 * Reads the current timer value when the timer is playing.

	 * @public

	 */

	Autoplay.prototype.read = function() {

		return new Date().getTime() - this._time;

	};



	/**

	 * Starts the autoplay.

	 * @public

	 * @param {Number} [timeout] - The interval before the next animation starts.

	 * @param {Number} [speed] - The animation speed for the animations.

	 */

	Autoplay.prototype.play = function(timeout, speed) {

		var elapsed;



		if (!this._core.is('rotating')) {

			this._core.enter('rotating');

		}



		timeout = timeout || this._core.settings.autoplayTimeout;



		// Calculate the elapsed time since the last transition. If the carousel

		// wasn't playing this calculation will yield zero.

		elapsed = Math.min(this._time % (this._timeout || timeout), timeout);



		if (this._paused) {

			// Start the clock.

			this._time = this.read();

			this._paused = false;

		} else {

			// Clear the active timeout to allow replacement.

			window.clearTimeout(this._call);

		}



		// Adjust the origin of the timer to match the new timeout value.

		this._time += this.read() % timeout - elapsed;



		this._timeout = timeout;

		this._call = window.setTimeout($.proxy(this._next, this, speed), timeout - elapsed);

	};



	/**

	 * Stops the autoplay.

	 * @public

	 */

	Autoplay.prototype.stop = function() {

		if (this._core.is('rotating')) {

			// Reset the clock.

			this._time = 0;

			this._paused = true;



			window.clearTimeout(this._call);

			this._core.leave('rotating');

		}

	};



	/**

	 * Pauses the autoplay.

	 * @public

	 */

	Autoplay.prototype.pause = function() {

		if (this._core.is('rotating') && !this._paused) {

			// Pause the clock.

			this._time = this.read();

			this._paused = true;



			window.clearTimeout(this._call);

		}

	};



	/**

	 * Destroys the plugin.

	 */

	Autoplay.prototype.destroy = function() {

		var handler, property;



		this.stop();



		for (handler in this._handlers) {

			this._core.$element.off(handler, this._handlers[handler]);

		}

		for (property in Object.getOwnPropertyNames(this)) {

			typeof this[property] != 'function' && (this[property] = null);

		}

	};



	$.fn.owlCarousel.Constructor.Plugins.autoplay = Autoplay;



})(window.Zepto || window.jQuery, window, document);



/**

 * Navigation Plugin

 * @version 2.3.4

 * @author Artus Kolanowski

 * @author David Deutsch

 * @license The MIT License (MIT)

 */

;(function($, window, document, undefined) {

	'use strict';



	/**

	 * Creates the navigation plugin.

	 * @class The Navigation Plugin

	 * @param {Owl} carousel - The Owl Carousel.

	 */

	var Navigation = function(carousel) {

		/**

		 * Reference to the core.

		 * @protected

		 * @type {Owl}

		 */

		this._core = carousel;



		/**

		 * Indicates whether the plugin is initialized or not.

		 * @protected

		 * @type {Boolean}

		 */

		this._initialized = false;



		/**

		 * The current paging indexes.

		 * @protected

		 * @type {Array}

		 */

		this._pages = [];



		/**

		 * All DOM elements of the user interface.

		 * @protected

		 * @type {Object}

		 */

		this._controls = {};



		/**

		 * Markup for an indicator.

		 * @protected

		 * @type {Array.<String>}

		 */

		this._templates = [];



		/**

		 * The carousel element.

		 * @type {jQuery}

		 */

		this.$element = this._core.$element;



		/**

		 * Overridden methods of the carousel.

		 * @protected

		 * @type {Object}

		 */

		this._overrides = {

			next: this._core.next,

			prev: this._core.prev,

			to: this._core.to

		};



		/**

		 * All event handlers.

		 * @protected

		 * @type {Object}

		 */

		this._handlers = {

			'prepared.owl.carousel': $.proxy(function(e) {

				if (e.namespace && this._core.settings.dotsData) {

					this._templates.push('<div class="' + this._core.settings.dotClass + '">' +

						$(e.content).find('[data-dot]').addBack('[data-dot]').attr('data-dot') + '</div>');

				}

			}, this),

			'added.owl.carousel': $.proxy(function(e) {

				if (e.namespace && this._core.settings.dotsData) {

					this._templates.splice(e.position, 0, this._templates.pop());

				}

			}, this),

			'remove.owl.carousel': $.proxy(function(e) {

				if (e.namespace && this._core.settings.dotsData) {

					this._templates.splice(e.position, 1);

				}

			}, this),

			'changed.owl.carousel': $.proxy(function(e) {

				if (e.namespace && e.property.name == 'position') {

					this.draw();

				}

			}, this),

			'initialized.owl.carousel': $.proxy(function(e) {

				if (e.namespace && !this._initialized) {

					this._core.trigger('initialize', null, 'navigation');

					this.initialize();

					this.update();

					this.draw();

					this._initialized = true;

					this._core.trigger('initialized', null, 'navigation');

				}

			}, this),

			'refreshed.owl.carousel': $.proxy(function(e) {

				if (e.namespace && this._initialized) {

					this._core.trigger('refresh', null, 'navigation');

					this.update();

					this.draw();

					this._core.trigger('refreshed', null, 'navigation');

				}

			}, this)

		};



		// set default options

		this._core.options = $.extend({}, Navigation.Defaults, this._core.options);



		// register event handlers

		this.$element.on(this._handlers);

	};



	/**

	 * Default options.

	 * @public

	 * @todo Rename `slideBy` to `navBy`

	 */

	Navigation.Defaults = {

		nav: false,

		navText: [

			'<span aria-label="' + 'Previous' + '">&#x2039;</span>',

			'<span aria-label="' + 'Next' + '">&#x203a;</span>'

		],

		navSpeed: false,

		navElement: 'button type="button" role="presentation"',

		navContainer: false,

		navContainerClass: 'owl-nav',

		navClass: [

			'owl-prev',

			'owl-next'

		],

		slideBy: 1,

		dotClass: 'owl-dot',

		dotsClass: 'owl-dots',

		dots: true,

		dotsEach: false,

		dotsData: false,

		dotsSpeed: false,

		dotsContainer: false

	};



	/**

	 * Initializes the layout of the plugin and extends the carousel.

	 * @protected

	 */

	Navigation.prototype.initialize = function() {

		var override,

			settings = this._core.settings;



		// create DOM structure for relative navigation

		this._controls.$relative = (settings.navContainer ? $(settings.navContainer)

			: $('<div>').addClass(settings.navContainerClass).appendTo(this.$element)).addClass('disabled');



		this._controls.$previous = $('<' + settings.navElement + '>')

			.addClass(settings.navClass[0])

			.html(settings.navText[0])

			.prependTo(this._controls.$relative)

			.on('click', $.proxy(function(e) {

				this.prev(settings.navSpeed);

			}, this));

		this._controls.$next = $('<' + settings.navElement + '>')

			.addClass(settings.navClass[1])

			.html(settings.navText[1])

			.appendTo(this._controls.$relative)

			.on('click', $.proxy(function(e) {

				this.next(settings.navSpeed);

			}, this));



		// create DOM structure for absolute navigation

		if (!settings.dotsData) {

			this._templates = [ $('<button role="button">')

				.addClass(settings.dotClass)

				.append($('<span>'))

				.prop('outerHTML') ];

		}



		this._controls.$absolute = (settings.dotsContainer ? $(settings.dotsContainer)

			: $('<div>').addClass(settings.dotsClass).appendTo(this.$element)).addClass('disabled');



		this._controls.$absolute.on('click', 'button', $.proxy(function(e) {

			var index = $(e.target).parent().is(this._controls.$absolute)

				? $(e.target).index() : $(e.target).parent().index();



			e.preventDefault();



			this.to(index, settings.dotsSpeed);

		}, this));



		/*$el.on('focusin', function() {

			$(document).off(".carousel");



			$(document).on('keydown.carousel', function(e) {

				if(e.keyCode == 37) {

					$el.trigger('prev.owl')

				}

				if(e.keyCode == 39) {

					$el.trigger('next.owl')

				}

			});

		});*/



		// override public methods of the carousel

		for (override in this._overrides) {

			this._core[override] = $.proxy(this[override], this);

		}

	};



	/**

	 * Destroys the plugin.

	 * @protected

	 */

	Navigation.prototype.destroy = function() {

		var handler, control, property, override, settings;

		settings = this._core.settings;



		for (handler in this._handlers) {

			this.$element.off(handler, this._handlers[handler]);

		}

		for (control in this._controls) {

			if (control === '$relative' && settings.navContainer) {

				this._controls[control].html('');

			} else {

				this._controls[control].remove();

			}

		}

		for (override in this.overides) {

			this._core[override] = this._overrides[override];

		}

		for (property in Object.getOwnPropertyNames(this)) {

			typeof this[property] != 'function' && (this[property] = null);

		}

	};



	/**

	 * Updates the internal state.

	 * @protected

	 */

	Navigation.prototype.update = function() {

		var i, j, k,

			lower = this._core.clones().length / 2,

			upper = lower + this._core.items().length,

			maximum = this._core.maximum(true),

			settings = this._core.settings,

			size = settings.center || settings.autoWidth || settings.dotsData

				? 1 : settings.dotsEach || settings.items;



		if (settings.slideBy !== 'page') {

			settings.slideBy = Math.min(settings.slideBy, settings.items);

		}



		if (settings.dots || settings.slideBy == 'page') {

			this._pages = [];



			for (i = lower, j = 0, k = 0; i < upper; i++) {

				if (j >= size || j === 0) {

					this._pages.push({

						start: Math.min(maximum, i - lower),

						end: i - lower + size - 1

					});

					if (Math.min(maximum, i - lower) === maximum) {

						break;

					}

					j = 0, ++k;

				}

				j += this._core.mergers(this._core.relative(i));

			}

		}

	};



	/**

	 * Draws the user interface.

	 * @todo The option `dotsData` wont work.

	 * @protected

	 */

	Navigation.prototype.draw = function() {

		var difference,

			settings = this._core.settings,

			disabled = this._core.items().length <= settings.items,

			index = this._core.relative(this._core.current()),

			loop = settings.loop || settings.rewind;



		this._controls.$relative.toggleClass('disabled', !settings.nav || disabled);



		if (settings.nav) {

			this._controls.$previous.toggleClass('disabled', !loop && index <= this._core.minimum(true));

			this._controls.$next.toggleClass('disabled', !loop && index >= this._core.maximum(true));

		}



		this._controls.$absolute.toggleClass('disabled', !settings.dots || disabled);



		if (settings.dots) {

			difference = this._pages.length - this._controls.$absolute.children().length;



			if (settings.dotsData && difference !== 0) {

				this._controls.$absolute.html(this._templates.join(''));

			} else if (difference > 0) {

				this._controls.$absolute.append(new Array(difference + 1).join(this._templates[0]));

			} else if (difference < 0) {

				this._controls.$absolute.children().slice(difference).remove();

			}



			this._controls.$absolute.find('.active').removeClass('active');

			this._controls.$absolute.children().eq($.inArray(this.current(), this._pages)).addClass('active');

		}

	};



	/**

	 * Extends event data.

	 * @protected

	 * @param {Event} event - The event object which gets thrown.

	 */

	Navigation.prototype.onTrigger = function(event) {

		var settings = this._core.settings;



		event.page = {

			index: $.inArray(this.current(), this._pages),

			count: this._pages.length,

			size: settings && (settings.center || settings.autoWidth || settings.dotsData

				? 1 : settings.dotsEach || settings.items)

		};

	};



	/**

	 * Gets the current page position of the carousel.

	 * @protected

	 * @returns {Number}

	 */

	Navigation.prototype.current = function() {

		var current = this._core.relative(this._core.current());

		return $.grep(this._pages, $.proxy(function(page, index) {

			return page.start <= current && page.end >= current;

		}, this)).pop();

	};



	/**

	 * Gets the current succesor/predecessor position.

	 * @protected

	 * @returns {Number}

	 */

	Navigation.prototype.getPosition = function(successor) {

		var position, length,

			settings = this._core.settings;



		if (settings.slideBy == 'page') {

			position = $.inArray(this.current(), this._pages);

			length = this._pages.length;

			successor ? ++position : --position;

			position = this._pages[((position % length) + length) % length].start;

		} else {

			position = this._core.relative(this._core.current());

			length = this._core.items().length;

			successor ? position += settings.slideBy : position -= settings.slideBy;

		}



		return position;

	};



	/**

	 * Slides to the next item or page.

	 * @public

	 * @param {Number} [speed=false] - The time in milliseconds for the transition.

	 */

	Navigation.prototype.next = function(speed) {

		$.proxy(this._overrides.to, this._core)(this.getPosition(true), speed);

	};



	/**

	 * Slides to the previous item or page.

	 * @public

	 * @param {Number} [speed=false] - The time in milliseconds for the transition.

	 */

	Navigation.prototype.prev = function(speed) {

		$.proxy(this._overrides.to, this._core)(this.getPosition(false), speed);

	};



	/**

	 * Slides to the specified item or page.

	 * @public

	 * @param {Number} position - The position of the item or page.

	 * @param {Number} [speed] - The time in milliseconds for the transition.

	 * @param {Boolean} [standard=false] - Whether to use the standard behaviour or not.

	 */

	Navigation.prototype.to = function(position, speed, standard) {

		var length;



		if (!standard && this._pages.length) {

			length = this._pages.length;

			$.proxy(this._overrides.to, this._core)(this._pages[((position % length) + length) % length].start, speed);

		} else {

			$.proxy(this._overrides.to, this._core)(position, speed);

		}

	};



	$.fn.owlCarousel.Constructor.Plugins.Navigation = Navigation;



})(window.Zepto || window.jQuery, window, document);



/**

 * Hash Plugin

 * @version 2.3.4

 * @author Artus Kolanowski

 * @author David Deutsch

 * @license The MIT License (MIT)

 */

;(function($, window, document, undefined) {

	'use strict';



	/**

	 * Creates the hash plugin.

	 * @class The Hash Plugin

	 * @param {Owl} carousel - The Owl Carousel

	 */

	var Hash = function(carousel) {

		/**

		 * Reference to the core.

		 * @protected

		 * @type {Owl}

		 */

		this._core = carousel;



		/**

		 * Hash index for the items.

		 * @protected

		 * @type {Object}

		 */

		this._hashes = {};



		/**

		 * The carousel element.

		 * @type {jQuery}

		 */

		this.$element = this._core.$element;



		/**

		 * All event handlers.

		 * @protected

		 * @type {Object}

		 */

		this._handlers = {

			'initialized.owl.carousel': $.proxy(function(e) {

				if (e.namespace && this._core.settings.startPosition === 'URLHash') {

					$(window).trigger('hashchange.owl.navigation');

				}

			}, this),

			'prepared.owl.carousel': $.proxy(function(e) {

				if (e.namespace) {

					var hash = $(e.content).find('[data-hash]').addBack('[data-hash]').attr('data-hash');



					if (!hash) {

						return;

					}



					this._hashes[hash] = e.content;

				}

			}, this),

			'changed.owl.carousel': $.proxy(function(e) {

				if (e.namespace && e.property.name === 'position') {

					var current = this._core.items(this._core.relative(this._core.current())),

						hash = $.map(this._hashes, function(item, hash) {

							return item === current ? hash : null;

						}).join();



					if (!hash || window.location.hash.slice(1) === hash) {

						return;

					}



					window.location.hash = hash;

				}

			}, this)

		};



		// set default options

		this._core.options = $.extend({}, Hash.Defaults, this._core.options);



		// register the event handlers

		this.$element.on(this._handlers);



		// register event listener for hash navigation

		$(window).on('hashchange.owl.navigation', $.proxy(function(e) {

			var hash = window.location.hash.substring(1),

				items = this._core.$stage.children(),

				position = this._hashes[hash] && items.index(this._hashes[hash]);



			if (position === undefined || position === this._core.current()) {

				return;

			}



			this._core.to(this._core.relative(position), false, true);

		}, this));

	};



	/**

	 * Default options.

	 * @public

	 */

	Hash.Defaults = {

		URLhashListener: false

	};



	/**

	 * Destroys the plugin.

	 * @public

	 */

	Hash.prototype.destroy = function() {

		var handler, property;



		$(window).off('hashchange.owl.navigation');



		for (handler in this._handlers) {

			this._core.$element.off(handler, this._handlers[handler]);

		}

		for (property in Object.getOwnPropertyNames(this)) {

			typeof this[property] != 'function' && (this[property] = null);

		}

	};



	$.fn.owlCarousel.Constructor.Plugins.Hash = Hash;



})(window.Zepto || window.jQuery, window, document);



/**

 * Support Plugin

 *

 * @version 2.3.4

 * @author Vivid Planet Software GmbH

 * @author Artus Kolanowski

 * @author David Deutsch

 * @license The MIT License (MIT)

 */

;(function($, window, document, undefined) {



	var style = $('<support>').get(0).style,

		prefixes = 'Webkit Moz O ms'.split(' '),

		events = {

			transition: {

				end: {

					WebkitTransition: 'webkitTransitionEnd',

					MozTransition: 'transitionend',

					OTransition: 'oTransitionEnd',

					transition: 'transitionend'

				}

			},

			animation: {

				end: {

					WebkitAnimation: 'webkitAnimationEnd',

					MozAnimation: 'animationend',

					OAnimation: 'oAnimationEnd',

					animation: 'animationend'

				}

			}

		},

		tests = {

			csstransforms: function() {

				return !!test('transform');

			},

			csstransforms3d: function() {

				return !!test('perspective');

			},

			csstransitions: function() {

				return !!test('transition');

			},

			cssanimations: function() {

				return !!test('animation');

			}

		};



	function test(property, prefixed) {

		var result = false,

			upper = property.charAt(0).toUpperCase() + property.slice(1);



		$.each((property + ' ' + prefixes.join(upper + ' ') + upper).split(' '), function(i, property) {

			if (style[property] !== undefined) {

				result = prefixed ? property : true;

				return false;

			}

		});



		return result;

	}



	function prefixed(property) {

		return test(property, true);

	}



	if (tests.csstransitions()) {

		/* jshint -W053 */

		$.support.transition = new String(prefixed('transition'))

		$.support.transition.end = events.transition.end[ $.support.transition ];

	}



	if (tests.cssanimations()) {

		/* jshint -W053 */

		$.support.animation = new String(prefixed('animation'))

		$.support.animation.end = events.animation.end[ $.support.animation ];

	}



	if (tests.csstransforms()) {

		/* jshint -W053 */

		$.support.transform = new String(prefixed('transform'));

		$.support.transform3d = tests.csstransforms3d();

	}



})(window.Zepto || window.jQuery, window, document);



    (function($) {





var Accordion = function() {

  

  var

    toggleItems,

    items;

  

  var _init = function() {

    toggleItems     = document.querySelectorAll('.accordion__itemTitleWrap');

    toggleItems     = Array.prototype.slice.call(toggleItems);

    items           = document.querySelectorAll('.accordion__item');

    items           = Array.prototype.slice.call(items);

    

    _addEventHandlers();

    TweenLite.set(items, {visibility:'visible'});

    TweenMax.staggerFrom(items, 0.9,{opacity:0, x:-100, ease:Power2.easeOut}, 0.3)

  }

  

  var _addEventHandlers = function() {

    toggleItems.forEach(function(element, index) {

      element.addEventListener('click', _toggleItem, false);

    });

  }

  

  var _toggleItem = function() {

    var parent = this.parentNode;

    var content = parent.children[1];

    if(!parent.classList.contains('is-active')) {

      parent.classList.add('is-active');

      TweenLite.set(content, {height:'auto'})

      TweenLite.from(content, 0.6, {height: 0, immediateRender:false, ease: Back.easeOut})

      

    } else {

      parent.classList.remove('is-active');

      TweenLite.to(content, 0.3, {height: 0, immediateRender:false, ease: Power1.easeOut})

    }

  }

  

  return {

    init: _init

  }

  

}();



Accordion.init();

         

         $("#menu1").mmenu({

  // options

}, {

//  pageNodeType: "div"

  pageSelector: ".wrapper"

});

         $(".box-interest-rate > .h2").click(function(){



            

        $(".interest-rates, .box-interest-rate").toggleClass("active");



    });

             $('.click-close, .wrapper').click(function () {

        $('#load-data').hide();

        $(".click-close").hide();



    });



             $(".search-ajax").keyup(function () {

        $(".click-close").show();

        $('#load-data').show();

    });

 $('.owl-project').owlCarousel({

    loop: true,

    margin: 30,dots:false,

    nav: false,navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],

    dots: false,

    responsiveClass: true,

    responsiveRefreshRate: true,

    responsive: {

        0: {

            items: 1,

        },

        768: {

            items: 2,

        },

        960: {

            items: 3

        },

        1100: {

            items: 4

        },

    }

});

 $('.slider-home-3').owlCarousel({

    loop:true,

    margin:0,

    nav:false,navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],

    dot:false,

    responsive:{

        0:{

            items:1

        },

        600:{

            items:1

        },

        1000:{

            items:1

        }

    }

});

  $('.slider_intro, .slider_events').owlCarousel({

    loop:true,

    margin:0,

    nav:false,navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],

    dot:false,

    responsive:{

        0:{

            items:1

        },

        600:{

            items:1

        },

        1000:{

            items:1

        }

    }

});

    $('.slider_awards').owlCarousel({

    loop:true,

    margin:0,

    nav:false,navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],

    dot:false,

    responsive:{

        0:{

            items:1

        },

        600:{

            items:2

        },

        1000:{

            items:3

        }

    }

});

    $('.owl-3').owlCarousel({

    loop:true,

    margin:0,

    nav:false,navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],

    dot:false,

    responsive:{

        0:{

            items:1

        },

        600:{

            items:1

        },

        1000:{

            items:1

        }

    }

});

$('.project-carousel.mobiles').owlCarousel({

    loop: true,

    margin: 30,dots:false,

    nav: false,navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],

    dots: false,

    responsiveClass: true,

    responsiveRefreshRate: true,

    responsive: {

        0: {

            items: 1,stagePadding: 50,

        },

        768: {

            items: 2,stagePadding: 50,

        },

        960: {

            items: 2

        },

        1100: {

            items: 2

        },

    }

});

$('.newsrooms-mobile').owlCarousel({

    loop: true,

    margin: 30,dots:false,

    nav: false,navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],

    dots: false,

    responsiveClass: true,

    responsiveRefreshRate: true,

    responsive: {

        0: {

            items: 1,stagePadding: 50,

        },

        768: {

            items: 2,stagePadding: 50,

        },

        960: {

            items: 2

        },

        1100: {

            items: 2

        },

    }

});



$('.image-carousel').owlCarousel({

                    margin: 20,

                    loop: false,

                    items: 2,

                    dots: false,

                    autoplaySpeed: 2000,

                    lazyLoad: true,

                    nav: true,

                    navText: ["", ""],

                    responsive: {

                        0: {

                            items: 1,

                            loop: true,

                            nav: false



                        },

                        480: {

                            items: 1,

                            loop: true,

                            nav: false



                        },

                        920: {

                            items: 2,

                            nav: false,

                        },

                        1025: {

                            nav: true



                        }

                    }

                });



$('.image-carousel').owlCarousel({

margin: 20,

loop: false,

items: 2,

dots: false,

autoplaySpeed: 2000,

lazyLoad: true,

nav: true,

navText: ["", ""],

responsive: {

0: {

items: 1,

loop: true,

nav: false

},

480: {

items: 1,

loop: true,

nav: false

},

920: {

items: 2,

nav: false,

},

1025: {

nav: true

}

}

});

    $('.slider_sp').owlCarousel({

    loop:true,autoplay:false,

    margin:0,autoplayTimeout:5000,

    autoplayHoverPause:true,

    nav:true,navText: ["<",">"],

    dots:false,

    responsive:{

        0:{

            items:1

        },

        600:{

            items:1

        },

        1000:{

            items:1

        }

    }

});





  })(jQuery);




function validateEmail(e) {
  var r = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return !!r.test(e);
}
function validatePhone(e) {
  var r = /^(016([0-9]{1})|012([0-9]{1})|09[0-9]|08[0-9]|03[0-9]|07[0-9]|05[0-9])(\d{7})$/i;
  return !!r.test(e);
}
function ErrForm(e, r) {
  var b = r + ' #err_note';
  0 == jQuery(b).length
    ? jQuery(r).append('<div class="c"></div><div style="text-align:left; color: #f00; font-size: 12px; margin-top: 5px; margin-bottom: 10px;" id="err_note">' + e + "</div>")
    : jQuery(b).html(e), jQuery(r).focus();
}

var request_form = !1;

function Submit_Form1(x, y) {
  var r = x === 'sidebar' ? '.cele-form-sidebar' : '.cele-form-modal';
  var p = r + ' .celephone';
  var e = r + ' .celeemail';
  var n = r + ' .celename';
  var name1 = jQuery(n + ' input').val(),
    phone1 = jQuery(p + ' input').val();
  email1 = jQuery(e + ' input').val();
  console.log(name1);
  console.log(phone1);
  console.log(email1);

  switch (y) {
    case 'noname':
      if (phone1 == "") {
        jQuery("#err_note").css({ display: "block" });
        return void ErrForm(error2, p);
      }
      if (!validatePhone(phone1)) {
        jQuery("#err_note").css({ display: "block" });
        return void ErrForm(error5, p);
      }
      if (name1 == "") name1 = "name";
      if (email1 == "" || !validateEmail(email1)) email1 = "tuancele@gmail.com";
      return void (request_form || (request_form = !0, jQuery(r).submit()));

    case 'all':
      if (name1 == "") {
        jQuery("#err_note").css({ display: "block" });
        return void ErrForm(error1, n);
      }
      if (phone1 == "") {
        jQuery("#err_note").css({ display: "block" });
        return void ErrForm(error3, e);
      }
      if (email1 == "" || validateEmail(email1)) {
        if (phone1 == "") {
          jQuery("#err_note").css({ display: "block" });
          return void ErrForm(error2, p);
        }
        if (phone1 == "" || validatePhone(phone1)) {
          return void (request_form || (request_form = !0, jQuery(r).submit()));
        } else {
          jQuery("#err_note").css({ display: "block" });
          return void ErrForm(error5, p);
        }
      } else {
        jQuery("#err_note").css({ display: "block" });
        return void ErrForm(error4, e);
      }
      break;
  }
}

function Submit_Form(x, y) {
  var r = '.cele-form-' + x;
  var p = r + ' .celephone';
  var e = r + ' .celeemail';
  var n = r + ' .celename';
  var name1 = jQuery(n + ' input').val(),
    phone1 = jQuery(p + ' input').val();
  email1 = jQuery(e + ' input').val();
  console.log(name1);
  console.log(phone1);
  console.log(email1);

  switch (y) {
    case 'noname':
      if (phone1 == "") {
        jQuery(p + " #err_note").css({ display: "block" });
        return void ErrForm(error2, p);
      }
      if (!validatePhone(phone1)) {
        jQuery(p + " #err_note").css({ display: "block" });
        return void ErrForm(error5, p);
      }
      if (name1 == "") name1 = "name";
      if (email1 == "" || !validateEmail(email1)) {
        email1 = "tuancele@gmail.com";
        jQuery(e + " #err_note").hide();
      }
      jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxurl,
        data: {
          'action': 'cele_ajax',
          'order_name': name1,
          'order_phone': phone1,
          'order_email': email1,
          'order_link': window.location.href
        },
        beforeSend: function () {
          jQuery('.overlay').addClass('active');
        },
        success: function (data) {
          if (data.success == true) {
            window.location.href = returnurl + '?ids=' + data.data;
          } else {
            jQuery('.note_success_wrapper').html('<p class="error_success">Xin Quý khách vui lòng điền đủ thông các ô thông tin.</p>');
            jQuery('.order_btn').attr('disabled', false);
          }
          jQuery('.overlay').removeClass('active');
        },
        error: function (errorThrown) {
          console.log(errorThrown);
        }
      });
      break;

    case 'all':
      if (name1 == "") {
        var name = !1;
        jQuery(n + " #err_note").css({ display: "block" }),
          void ErrForm(error1, n);
      } else {
        var name = !0;
        jQuery(n + " #err_note").css({ display: "none" });
      }
      if (phone1 == "") {
        var phone = !1;
        jQuery(p + " #err_note").css({ display: "block" }),
          void ErrForm(error2, p);
      } else {
        if (validatePhone(phone1)) {
          var phone = !0;
          jQuery(p + " #err_note").css({ display: "none" });
        } else {
          var phone = !1;
          jQuery(p + " #err_note").css({ display: "block" }),
            void ErrForm(error5, p);
        }
      }
      if (email1 == "") {
        var email = !1;
        jQuery(e + " #err_note").css({ display: "block" }),
          void ErrForm(error3, e);
      } else {
        if (validateEmail(email1)) {
          var email = !0;
          jQuery(e + " #err_note").css({ display: "none" });
        } else {
          var email = !1;
          jQuery(e + " #err_note").css({ display: "block" }),
            void ErrForm(error4, e);
        }
      }
      if (email == !0 && phone == !0 && name == !0) {
        jQuery.ajax({
          type: 'POST',
          dataType: 'json',
          url: ajaxurl,
          data: {
            'action': 'cele_ajax',
            'order_name': name1,
            'order_phone': phone1,
            'order_email': email1,
            'order_link': window.location.href
          },
          beforeSend: function () {
            jQuery('.overlay').addClass('active');
          },
          success: function (data) {
            if (data.success == true) {
              window.location.href = returnurl + '?ids=' + data.data;
            } else {
              jQuery('.note_success_wrapper').html('<p class="error_success">Xin Quý khách vui lòng điền đủ thông các ô thông tin.</p>');
              jQuery('.order_btn').attr('disabled', false);
            }
            jQuery('.overlay').removeClass('active');
          },
          error: function (errorThrown) {
            console.log(errorThrown);
          }
        });
      }
      break;
  }
}




function form_content(x) {

    var r = '.form-content-' + x;

    var e = r + ' #phone_project' + x;

    var phone1 = jQuery(e).val();



            if (phone1 == "") {

                var phone = !1;

                jQuery(r + " #err_note").css({

                    display: "block"

                }),void ErrForm(error2,r)

            } else {

                if (validatePhone(phone1)) {

                    var phone = !0;

                    jQuery(r + " #err_note").css({

                        display: "none"

                    })

                    jQuery.ajax({

                                type: 'POST',

                                dataType: 'json',

                                url: ajaxurl,

                                data: {

                                    'action': 'cele_content_ajax',

                                    'order_phone': phone1,

                                    'order_link': window.location.href

                                },

                                beforeSend: function() {

                                    jQuery('.overlay').addClass('active');

                                },

                                success: function (data) {

                                    if(data.success == true) {

                                        //Order_ResetAll();

                                        window.location.href = returnurl + '?sdt=' + data.data;

                                    } else {

                                        jQuery('.note_success_wrapper').html('<p class="error_success">Xin Quý khách vui lòng điền đủ thông các ô thông tin.</p>');

                                        jQuery('.order_btn').attr('disabled', false);

                                    }

                                    jQuery('.overlay').removeClass('active');

                                },

                                error: function (errorThrown) {

                                    console.log(errorThrown);

                                }

                            });

                } else {

                    var phone = !1;

                    jQuery(r + " #err_note").css({

                        display: "block"

                    }),void ErrForm(error5,r)

                }   

            }

}







var requestSent_eproject2 = !1,

    requestSent_eproject = !1,

    requestSent_fthl1 = !1,

    requestSent_email = !1,

    requestSent_sdt = !1,

    request_downow = !1,

    request_red = !1,

    request_blue = !1,

    request_yellow = !1;

    request_content = !1,

jQuery.noConflict(),

    function(e) {

        e(document).ready(function() {

            e(".nav-header").affix({

                offset: {

                    top: e(".banner").outerHeight(!0)

                }

            })

            e(".section2-left").height() >= e(".section2-right").height() && e("#dowload-last-link").affix({

              

                    offset: {

                        top: e(".section2-right").outerHeight(!0),

                        bottom: e(".section3").outerHeight(!0) + 900

                    }

                

                })



            e(".header-top").headroom({

                              "tolerance": 5,

                              "offset": 0,

                              "classes": {

                                "initial": "animated",

                                "pinned": "slideDown",

                                "unpinned": "slideUp",

                                "top": "headroom--top",

                                "notTop": "headroom--not-top"

                              }

                            });





            e("#menu").mmenu({

                                    extensions: [

                                        "position-front",

                                        "pagedim-black",

                                        "position-right",

                                        "fx-listitems-slide",

                                        "theme-dark"

                                    ],

                                   

                                    navbar: {

                                        title: "MOBILE MENU"

                                    },

                                    navbars: [{

                                        position: "bottom",

                                        content: ['<a href="https://tuancele.net" target="_blank">Designed by Tuancele</a>']

                                    }],

                                    

                                    

                                },

                                {

                                     // configuration

                                     offCanvas: {

                                        pageSelector: ".wrappers"

                                     }

                                

                                })













            e("#dowload-last-link").width(e("#dowload-last-link").parent().width());

        }), e("document").ready(function() {

            e("#btn_startdownloadtailieu").click(function() {

                return e(".step_down0").removeClass("active"), e(".step_down1").addClass("active"), !1

            }), 

           

            e(".tai-bang-gia a").on("click", function(r) {

                var t = e(r.target);

                e(t.attr("href")).length > 0  && (e("html, body").stop().animate({

                    scrollTop: e(t.attr("href")).offset().top - 50

                }, 1500), r.preventDefault())

            })

            e(".v2_danhgia_nsb_link a").on("click", function(r) {

                var t = e(r.target);

                e(t.attr("href")).length > 0  && (e("html, body").stop().animate({

                    scrollTop: e(t.attr("href")).offset().top - 100

                }, 1500), r.preventDefault())

            })

        }), e(document).ready(function() {

            var r = 220,

                t = 500;

            e(window).scroll(function() {

                e(this).scrollTop() > r ? e(".back-to-top").fadeIn(t) : e(".back-to-top").fadeOut(t)

            }), e(".back-to-top").click(function(r) {

                return r.preventDefault(), e("html, body").animate({

                    scrollTop: 0

                }, t), !1

            })

        });

        



    }(jQuery);

var requestSent_eprojectttt = !1;

