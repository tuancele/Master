<?php /* Template Name: Tính Lãi */ get_header(); ?>
<?php if (have_posts()): while (have_posts()) : the_post(); ?>

<div class="interest-page">
    <div class="top">
        <div class="container">
            <h1>Tính lãi suất vay <span class="fa fa-angle-right"></span></h1>
            <div class="sub-title">Giúp bạn tính toán số tiền cần trả khi vay ngân hàng để mua nhà trả góp</div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="input">
                <div class="thumb-image"></div>
                <div class="box-input">
                    <div class="group">
                        <label>Số tiền vay</label>
                        <div class="input-text">                            <?php                                                       $price = ($_GET['price']) ? $_GET['price'] : ''; ?>
                            <input class="form-input currency amount" type="text" value="<?php echo $price;  ?>">
                            <span class="unit">Triệu VND</span>
                        </div>
                    </div>
                    <div class="group">
                        <label>Thời gian tiền vay</label>
                        <div class="input-text">
                            <input class="form-input time" type="number" value="10">
                            <span class="unit btn">Năm</span>
                        </div>
                    </div>
                    <div class="group">
                        <label>Lãi suất %</label>
                        <div class="input-text">
                            <input class="form-input interest" type="number" value="8">
                            <span class="unit btn">% /năm</span>
                        </div>
                    </div>
                    <div class="group">
                        <label>Loại hình</label>
                        <div class="input-text">
                            <select class="form-input interest-type" type="text" onchange="interest_changed(this)">
                                <option value="2">Trả lãi chia đều</option>
                                <option value="1">Trả lãi theo dư nợ giảm dần</option>
                            </select>
                        </div>
                    </div>

                    <div class="group" style="text-align: right">
                        <button class="btn-calculator" onclick="calculator()">Xem kết quả</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-result">
        <div class="container">
            <div class="table">
                <table id="example" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Số kỳ trả</th>
                            <th>Dư nợ đầu kỳ (VND)</th>
                            <th>Gốc phải trả (VND)</th>
                            <th>Lãi phải trả (VND)</th>
                            <th>Gốc + Lãi (VND)</th>
                        </tr>
                    </thead>
                    <tbody id="body_result">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Tổng</td>
                            <td id="rs_interest_total">0</td>
                            <td id="rs_total">0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endwhile; ?>
<?php endif; ?>

<style>
                  @media(max-width:480px) {
                    .dataTables_filter, .dataTables_info, .dataTables_empty{display: none !important;}
.rating .content-rating .total-rating{width:108px}
.rating .all-rating{width:calc(100% - 110px);border-right:none}
}
.red{color:#e95155}
.blue{color:#1397d4}
.black{color:#3d4d64}
.interest-rates{border:1px solid #e8e8e8}
.interest-rates .input-rate .item{margin-top:12px;display:inline-block;width:100%}
.interest-rates .input-rate{padding:12px 32px;display:inline-block;width:100%;box-sizing:border-box}
.interest-rates .input-rate .inline{float:left}
.interest-rates .input-rate label{width:120px;font-size:17px;color:#3d4d64;font-weight:500;box-sizing:border-box;padding:10px 0}
.interest-rates .input-rate .btn-range{width:calc(100% - 360px);font-size:17px;color:#3d4d64;font-weight:500;box-sizing:border-box;padding:13px 16px}
.interest-rates .input-rate input[type=number],.interest-rates .input-rate input[type=text]{width:160px;border:1px solid #e8e8e8;background:#fff;box-sizing:border-box;height:40px;padding:0 8px;font-weight:500;font-size:15px;border-radius:0;-moz-border-radius:0;-webkit-border-radius:0;text-align:right}
.interest-rates .input-rate .unit{width:80px;border:1px solid #e8e8e8;box-sizing:border-box;font-size:15px;padding:10px 6px;font-style:italic;height: 40px;}
.interest-rates .input-rate .unit.unit-percent{padding:0}
.interest-rates .input-rate .unit.unit-percent input[type=text],.interest-rates .input-rate .unit.unit-percent input[type=number]{width:60px;padding:4px;padding-left:12px;height:38px;border:none}
.interest-rates .calculator-type{box-sizing:border-box;display:inline-block;width:100%;padding:25px 32px;border-top:1px solid #e8e8e8}
.interest-rates .calculator-type .item{float:left;width:50%}
.interest-rates .calculator-result{box-sizing:border-box;display:inline-block;width:100%;padding:16px;border-top:1px solid #e8e8e8}
.interest-rates .calculator-result .chart-reuslt{background:#f9f9f9;box-sizing:border-box;padding:16px;display:inline-block;width:100%}
.interest-rates .calculator-result .chart-reuslt .chart{width:180px;height:180px;float:left;position:relative}
.interest-rates .calculator-result .chart-reuslt .chart .title-total{position:absolute;text-align:center;font-size:22px;color:#1397d4;font-weight:500;top:50%;left:50%;transform:translate(-50%,-50%)}
.interest-rates .calculator-result .result{width:calc(100% - 180px);float:left;box-sizing:border-box;padding:16px;padding-right:0}
.interest-rates .calculator-result .result .inline{width:33.3333%;float:left;font-size:18px}
.interest-rates .calculator-result .result .inline label{opacity:.8}
.interest-rates .calculator-result .result .inline span{font-weight:700;display:inline-block;width:100%;margin-top:8px}
.interest-rates .calculator-result .result .inline span i,.interest-rates .calculator-result .result .first-value span i{font-style:normal}
.interest-rates .calculator-result .result .first-value{display:inline-block;width:100%;margin-top:16px;font-size:18px;border-top:1px solid #e8e8e8;padding-top:16px;font-weight:700}
.interest-rates .calculator-result .result .first-value label{float:left;margin-top:2px}
.interest-rates .calculator-result .result .first-value span{float:right;font-size:25px}
.interest-rates .calculator-result .more-result{font-size:16px;margin-top:16px;display:inline-block;width:100%}
.interest-rates .calculator-result .more-result a{font-style:italic;font-weight:500}
.interest-rates .calculator-result .more-result .note{color:#3d4d64;opacity:.7;margin-top:8px}
.container-radio{display:block;position:relative;padding-left:35px;cursor:pointer;font-size:16px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;font-weight:400}
.container-radio input{position:absolute;opacity:0;cursor:pointer}
.checkmark{position:absolute;top:-3px;left:0;height:25px;width:25px;background-color:#ddd;border-radius:50%}
canvas{-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none}
.container-radio:hover input~.checkmark{background-color:#ccc}
.container-radio input:checked~.checkmark{background-color:#2196f3}
.checkmark:after{content:"";position:absolute;display:none}
.container-radio input:checked~.checkmark:after{display:block}
.container-radio .checkmark:after{top:9px;left:9px;width:8px;height:8px;border-radius:50%;background:#fff}
.interest-page .top{background:#f5f5f5;padding:32px 0}
.interest-page .top h1{font-size:25px;color:#1397d4;font-weight:500}
.interest-page .top .sub-title{font-size:14px;color:#3d4d64;text-transform:uppercase;margin-top:4px}
.interest-page .content{padding:32px 0;display:inline-block;width:100%}
.interest-page .content .thumb-image{float:left;height:200px;width:50%;box-sizing:border-box;background:url(https://flcquangngai.nhadat86.vn/wp-content/themes/mastergf/images/ic-interest.png) no-repeat center;background-size:contain;margin-top:32px}
.interest-page .content .box-input{float:left;width:50%;box-sizing:border-box}
.interest-page .content .box-input label{width:150px;float:left;margin-top:12px;color:#3d4d64;font-weight:500;font-size:17px;opacity:.8}
.interest-page .content .box-input .input-text{width:calc(100% - 150px);float:left;position:relative}
.interest-page .content .box-input .group{margin-top:12px;display:inline-block;width:100%}
.interest-page .content .box-input .group .form-input{height:48px;border:1px solid #e3ebf9;background:#eceff4;width:100%;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;padding:12px 18px;box-sizing:border-box;font-size:17px;opacity:.8;padding-right:130px;text-align:right}
.interest-page .content .box-input .group .form-input.amount{padding-right:115px}
.interest-page .content .box-input select{-webkit-appearance:menulist;-moz-appearance:menulist}
.interest-page .content .box-input .group .unit{position:absolute;right:0;top:0;display:table-cell;font-size:15px;color:#3d4d64;padding:15px 18px;vertical-align:middle;border-left:1px solid #ddd}
.interest-page .content .box-input .group .unit.btn{background:#0098da;color:#fff;padding:15px 24px;min-width:60px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;text-align:center;height: 48px;}
.interest-page .content .box-input .group .btn-calculator{padding:15px 25px;background:#0098da;color:#fff;font-size:17px;border:none;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;cursor:pointer}
.interest-page .content .box-input .group .btn-calculator:hover{background:#0571a0}
.interest-page .box-result{display:inline-block;width:100%;border-top:1px solid #e8e8e8;padding:32px 0}
.interest-page .box-result .table{height:auto}
.interest-page .box-result table th{position:sticky;position:-webkit-sticky;top:0}
.interest-page .box-result table tfoot tr td{position:sticky;position:-webkit-sticky;bottom:0}
.interest-page .box-result table{width:100%;border-spacing:0}
.interest-page .box-result table>thead>tr>th{background:#27406d;color:#fff;padding:16px 0;font-size:16px;font-weight:400;text-align: center;}
.interest-page .box-result table>tbody>tr>td{color:#3d4d64;padding:10px 16px;border-right:1px solid #e8e8e8;font-size:16px;text-align:center}
.interest-page .box-result table>tbody>tr{background-color:#f5f5f5}
.interest-page .box-result table>tbody>tr.white{background-color:#fff}
.interest-page .box-result table>tfoot>tr>td{color:#3d4d64;font-weight:500;padding:16px;font-size:18px;text-align:center;background:#d4e3f3}
.mCSB_container{overflow:unset!important}
@media(max-width:920px) {
.interest-rates{margin-left:-8px;margin-right:-8px;border:none;border-bottom:8px solid #e8e8e8}
.interest-rates .input-rate{padding:8px}
.interest-rates .input-rate label{font-size:14px;width:95px}
.interest-rates .input-rate .btn-range{width:calc(100% - 95px);padding:10px 0}
.interest-rates .input-rate input[type=number],.interest-rates .input-rate input[type=text]{width:calc(100% - 80px)}
.interest-rates .calculator-type .item{padding:6px 0;width:100%}
.container-radio{font-size:15px}
.interest-rates .calculator-type{padding:8px 16px}
.interest-rates .calculator-result{padding:8px 0}
.interest-rates .calculator-result .chart-reuslt{background:none;padding:0}
.interest-rates .calculator-result .chart-reuslt .chart{width:110px;height:110px}
.interest-rates .calculator-result .result{width:calc(100% - 110px);padding:0}
.interest-rates .calculator-result .result .inline{width:100%;padding:8px;box-sizing:border-box;font-size:15px}
.interest-rates .calculator-result .result .inline span{margin-top:0;float:right;width:auto}
.interest-rates .calculator-result .result .first-value{width:calc(100% + 110px);margin-left:-110px;border-bottom:1px solid #e8e8e8;font-size:15px;padding:16px 8px;box-sizing:border-box}
.interest-rates .calculator-result .result .first-value span{font-size:20px;margin-top:-2px}
.interest-rates .calculator-result .more-result{padding:8px;margin:0;box-sizing:border-box}
.interest-page .content{padding:20px 0}
.interest-page .content .thumb-image{display:none}
.interest-page .content .box-input{width:100%}
.interest-page .content .box-input .group{margin-top:2px}
.interest-page .content .box-input .input-text{width:100%;margin-top:5px}
.interest-page .content .box-input .group:last-child{text-align:center!important;margin-top:8px}
.interest-page .top .sub-title{display:none}
.interest-page .top{padding:16px 0}
.interest-page .box-result{padding:0;border-top:0}
.interest-page .box-result table>thead>tr>th{font-size:13px}
.interest-page .box-result table>tbody>tr>td{font-size:14px;padding:10px}
.interest-page .box-result table>tfoot>tr>td{font-size:15px}
.mCSB_container{overflow:auto!important}
}
@media(max-width:320px) {
.interest-rates .calculator-result .result .inline span{float:none}
}
</style>
<script defer src="<?php bloginfo('template_url'); ?>/js/jquery.mCustomScrollbar.concat.min.js" type="text/javascript"></script>
<script defer src="<?php bloginfo('template_url'); ?>/js/jquery.inputmask.bundle.js" type="text/javascript"></script>
<script defer src="<?php bloginfo('template_url'); ?>/js/interest-rate-detail.js" type="text/javascript"></script>
<?php if(!wp_is_mobile()){?>

<?php
}
else
{ ?>

<?php } ?>
<?php get_footer(); ?>