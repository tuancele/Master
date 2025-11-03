<?php
/*
Template Name: Dự toán chi tiết Teamplate
*/
?>
<?php get_header();
?>
<main id="main">
    <div id="content" class="nb">
        <div class="container">
            
            <div class="row">
                <div class="content col-md-12">
                    <div class="direction">
                        <?php
                   if ( function_exists('yoast_breadcrumb') ) {
                   yoast_breadcrumb('
                   <p id="breadcrumbs">','</p>
                   ');
                   }
                   ?>
                        <h1><span style="font-size: 18pt;"><strong><span style="font-family: 'times new roman', times, serif;"><?php the_title(); ?></span></strong></span></h1>
                        <div class="content-direction">
                            
                            <form action="" class="row" method="post" id="dutoan">
                                <div class="utils-row col-md-6">
                                    
                                    <div class="fl">
                                        <label class="fl">Chiều dài</label>
                                        <input id="Length" name="Length" type="number" <?php if (isset($_POST['Length'])){  echo 'value="'.$_POST['Length'].'"'; } ?>>
                                    </div>
                                </div>
                                <div class="utils-row col-md-6">
                                    
                                    <div class="fl">
                                        <label class="fl">Chiều rộng</label>
                                        <input id="Width" name="Width" type="number" <?php if (isset($_POST['Width'])){ echo 'value="'.$_POST['Width'].'"'; } ?>>
                                        
                                    </div>
                                </div>
                                <div class="utils-row col-md-6">
                                    
                                    <div class="fl">
                                        <label class="fl">Số tầng cao</label>
                                        <input id="StageNumber" name="StageNumber" type="number" <?php if (isset($_POST['StageNumber'])){   echo 'value="'.$_POST['StageNumber'].'"'; } ?>>
                                    </div>
                                </div>
                                <div class="utils-row col-md-6">
                                    
                                    <div class="fl">
                                        <label class="fl">Chiều cao một tầng</label>
                                        <input id="StageHeight" name="StageHeight" type="number" <?php if (isset($_POST['StageHeight'])){   echo 'value="'.$_POST['StageHeight'].'"'; } ?>>
                                    </div>
                                </div>
                                <div class="utils-row col-md-12">
                                    <label class="fl">Loại mái nhà</label>
                                    <select class="selectBox"  id="RoofType" name="RoofType">
                                        <option <?php if (isset($_POST['RoofType']) && $_POST['RoofType'] == 1 ){  echo ' selected'; } ?> value="1">Bê-tông</option>
                                        <option <?php if (isset($_POST['RoofType']) && $_POST['RoofType'] == 2 ){  echo ' selected'; } ?> value="2">Ngói</option>
                                        <option <?php if (isset($_POST['RoofType']) && $_POST['RoofType'] == 3 ){  echo ' selected'; } ?> value="3">Tôn</option>
                                    </select>
                                </div>
                                <div class="utils-row col-md-12">
                                    <label class="fl">&nbsp;</label>
                                    <div class="fl">
                                        <input type="submit" value="Xem kết quả" class="btnResult" style="width: auto">
                                    </div>
                                </div>
                            </form>
                            <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js'></script>
                            <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
                            <script>
                            // just for the demos, avoids form submit
                            jQuery.validator.setDefaults({
                            //debug: true,
                            success: "valid"
                            });
                            jQuery(document).ready(function($) {
                            $( "#dutoan" ).validate({
                            rules: {
                            Length: {
                            required: true,
                            max: 50,
                            number: true,
                            min: 1
                            },
                            Width : {
                            required: true,
                            max: 50,
                            step: 1,
                            number: true,
                            min: 1
                            },
                            StageNumber : {
                            required: true,
                            max: 20,
                            step: 1,
                            number: true,
                            min: 1
                            },
                            StageHeight :{
                            required: true,
                            max: 6,
                            min: 2
                            },
                            RoofType : {
                            required: true,
                            }
                            },
                            messages: {
                            Length: {
                            required: "Vui lòng nhập chiều dài",
                            max: "Giá trị nhập vào chưa đúng.<br>Chiều dài phải từ 1m - 50m",
                            min: "Giá trị nhập vào chưa đúng.<br>Chiều dài phải từ 1m - 50m"
                            },
                            Width: {
                            required: "Vui lòng nhập chiều rộng",
                            max: "Giá trị nhập vào chưa đúng.<br>Chiều rộng phải từ 1m - 50m",
                            min: "Giá trị nhập vào chưa đúng.<br>Chiều rộng phải từ 1m - 50m"
                            },
                            StageNumber: {
                            required: "Vui lòng nhập số tầng",
                            max: "Giá trị nhập vào chưa đúng.<br>Số tầng phải từ 1 - 20",
                            min: "Giá trị nhập vào chưa đúng.<br>Số tầng phải từ 1 - 20",
                            },
                            StageHeight: {
                            required: "Vui lòng nhập chiều cao",
                            max: "Giá trị nhập vào chưa đúng.<br>Chiều cao phải từ 2m - 6m",
                            min: "Giá trị nhập vào chưa đúng.<br>Chiều dài phải từ 2m - 6m"
                            },
                            RoofType : {
                            required: "Vui lòng chọn loại mái",
                            }
                            }
                            });
                            });
                            </script>
                            <?php
                            if (isset($_POST['Length'])){   $Length = $_POST['Length']; }
                            if (isset($_POST['Width'])){    $Width = $_POST['Width']; }
                            if (isset($_POST['StageNumber'])){  $StageNumber = $_POST['StageNumber']; }
                            if (isset($_POST['StageHeight'])){  $StageHeight = $_POST['StageHeight']; }
                            if (isset($_POST['RoofType'])){ $RoofType = $_POST['RoofType']; }
                            
                            
                            $baseSat = array(
                            'dai'   => 145.2345,
                            'rong'  => 205.037,
                            'coso'  => 1977.74925
                            );
                            $baseXimang = array(
                            'dai'   => 904.725,
                            'rong'  => 804.7695,
                            'coso'  => 4070.83275
                            );
                            $baseCat = array(
                            'dai'   => 3.2465,
                            'rong'  => 3.0755,
                            'coso'  => 6.534
                            );
                            $baseDa = array(
                            'dai'   => 1.1105,
                            'rong'  => 0.85425,
                            'coso'  => 12.002625
                            );
                            
                            $slSat = round($StageNumber*$StageHeight*($baseSat['coso']+($Length*$baseSat['dai']+$Width*$baseSat['rong'])/2),2);
                            $slXimang = round($StageNumber*$StageHeight*($baseXimang['coso']+($Length*$baseXimang['dai']+$Width*$baseXimang['rong'])/2),2);
                            $slCat = round($StageNumber*$StageHeight*($baseCat['coso']+($Length*$baseCat['dai']+$Width*$baseCat['rong'])/2),2);
                            $slDa = round($StageNumber*$StageHeight*($baseDa['coso']+($Length*$baseDa['dai']+$Width*$baseDa['rong'])/2),2);
                            
                            $dientich = $StageNumber*$Length*$Width;
                            $slNgoi = $dientich*22;
                            
                            $tuong = 2*($Length+$Width)*$StageNumber*$StageHeight;
                            $slTuong = $tuong/2;
                            $slGach = $tuong*65;
                            
                            $vatlieu = array(
                            'sat' => array('title' => 'Sắt','dongia' => '19000','donvi'  => 'kg','soluong'=>$slSat),
                            'gach' =>   array('title' => 'Gạch','dongia' => '900','donvi'  => 'viên','soluong'=>$slGach),
                            'ximang' =>     array('title' => 'Xi măng','dongia' => '1850','donvi'  => 'kg','soluong'=>$slXimang),
                            'cat' =>        array('title' => 'Cát','dongia' => '300000','donvi'  => 'm3','soluong'=>$slCat),
                            'da' =>     array('title' => 'Đá','dongia' => '350000','donvi'  => 'm3','soluong'=>$slDa),
                            'bottretngoaitroi' =>       array('title' => 'Bột trét ngoài trời','dongia' => '5000','donvi'  => 'kg','soluong'=>$slTuong),
                            'sonngoaitroi' =>       array('title' => 'Sơn ngoài trời','dongia' => '36000','donvi'  => 'kg','soluong'=>$slTuong),
                            'bottrettrongnha' =>        array('title' => 'Bột trét trong nhà','dongia' => '4000','donvi'  => 'kg','soluong'=>$slTuong),
                            'sontrongnha' =>        array('title' => 'Sơn trong nhà','dongia' => '900','donvi'  => 'viên','soluong'=>$slTuong),
                            'gachmen' =>        array('title' => 'Gạch men','dongia' => '300000','donvi'  => 'm2','soluong'=>$dientich),
                            'ngoi' =>       array('title' => 'Ngói','dongia' => '6500','donvi'  => 'viên','soluong'=>$slNgoi),
                            'ton' =>        array('title' => 'Tôn','dongia' => '110000','donvi'  => 'm2','soluong'=>$dientich)
                            
                            );
                            
                            
                            if ($RoofType == 2 ) { unset($vatlieu['ton']); }
                            if ($RoofType == 3 ) { unset($vatlieu['ngoi']); }
                            if ($RoofType == 1 ) { unset($vatlieu['ngoi']);
                            unset($vatlieu['ton']);
                            }
                            ?>
                            <div id="tabResult4" class="support" style="padding-top: 10px;">
                                <div class="result_chiphi_header">
                                    <div class="column1"><div class="subcolumn">Vật liệu</div></div>
                                    <div class="column2"><div class="subcolumn">Số lượng</div></div>
                                    <div class="column3"><div class="subcolumn">Đơn vị</div></div>
                                    <div class="column4"><div class="subcolumn">Đơn giá</div></div>
                                    <div class="column5"><div class="subcolumn">Thành tiền</div></div>
                                </div>
                                
                                
                                
                                <?php
                                
                                $tongtien = 0;
                                foreach($vatlieu as $item ) { ?>
                                <div class="result_chiphi_item">
                                    <div class="column1"><div class="subcolumn"><?php echo $item['title']; ?></div></div>
                                    <div class="column2"><div class="subcolumn"><?php echo $item['soluong']; ?></div></div>
                                    <div class="column3"><div class="subcolumn"><?php echo $item['donvi']; ?></div></div>
                                    <div class="column4"><div class="subcolumn"><?php echo number_format($item['dongia']); ?></div></div>
                                    <div class="column5"><div class="subcolumn"><?php echo number_format($item['dongia']*$item['soluong']); ?></div></div>
                                </div>
                                
                                
                                
                                <?php
                                $tongtien = $tongtien +  $item['dongia']*$item['soluong'];
                                
                                }
                                
                                
                                ?>
                            </div>
                            <div class="result_chiphi_footer">
                                Tổng chi phí: <span><?php echo number_format($tongtien); ?></span> đồng
                                <p>Chi phí này dựa trên bảng giá của tháng gần nhất và không bao gồm chi phí hoàn thiện (điện, nước, nội thất,…) và chi phí nhân công.</p>
                            </div>
                            
                        </div>
                    </div>
                    
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
</main>
<style>
.utils-row input{width: 100%;padding: 5px;border:1px solid #ddd;}
.btnResult{background-color: #055699;
    color: #fff;
    padding: 10px;
    border: 0;}
    .utils-row label{display: block;}
.result_chiphi_header {
width: 100%;
float: left;
font-weight: bold;
height: 30px;
line-height: 30px;
}
.result_chiphi_header .column1 {
width: 30%;
float: left;
background-color:
#fff;
color:
#fff;
font-weight: bold;
}
.result_chiphi_header .column2 {
width: 17%;
float: left;
background-color:
#fff;
color:
#fff;
font-weight: bold;
}
.result_chiphi_header .column3 {
width: 13%;
float: left;
background-color:
#fff;
color:
#fff;
font-weight: bold;
}
.result_chiphi_header .column4 {
width: 17%;
float: left;
background-color:
#fff;
color:
#fff;
font-weight: bold;
}
.result_chiphi_header .column5 {
width: 23%;
float: left;
background-color:
#fff;
color:
#fff;
font-weight: bold;
}
.result_chiphi_header .subcolumn {
background-color:
#055699;
margin-right: 1px;
padding: 0 0 0 10px;
}
.result_chiphi_item {
width: 100%;
float: left;
height: 30px;
line-height: 25px;
border-bottom: 1px
#ccc solid;
}
.result_chiphi_item .column1 {
width: 30%;
float: left;
background-color:
#fff;
}
.result_chiphi_item .subcolumn {
margin-right: 1px;
padding: 0 0 0 10px;
height: 30px;
overflow: hidden;
line-height: 30px;
}
.result_chiphi_item .column2 {
width: 17%;
float: left;
background-color:
#fff;
}
.result_chiphi_item .column3 {
width: 13%;
float: left;
background-color:
#fff;
}
.result_chiphi_item .column4 {
width: 17%;
float: left;
background-color:
#fff;
}
.result_chiphi_item .column5 {
width: 23%;
float: left;
background-color:
#fff;
}
.result_chiphi_footer {
width: 100%;
float: left;
margin: 10px 0 0 0;
font-weight: bold;
font-family: Tahoma;
font-size: 14px;
}
.result_chiphi_footer span {
color:
#f00;
font-size: 15px;
}
.result_chiphi_footer p {
font-size: 11px;
color:
#666;
font-style: italic;
font-weight: normal;
}
</style>
<?php get_footer(); ?>