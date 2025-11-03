<?php
/*
 Template Name: Phiếu báo giá tạm tính
 */
 ?>
<?php get_header(); ?>
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
               	<?php if ( is_user_logged_in() ) { ?>
                <div class="content">
                    <?php while(have_posts()):the_post(); ?>
                    <h1><span style="font-size: 18pt;"><strong><span style="font-family: 'times new roman', times, serif;"><?php the_title(); ?></span></strong></span></h1>
                    
                    <?php 
                    $id = $_GET['id'];
                    $vat = get_field('vat');
                    $sodot = get_field('sodot');
                    $tien = get_field('giamacdinh');
                    $uudai = get_field('uudaimacdinh');
                    $sovay = get_field('sovay');
                    $tratruoc = get_field('tratruoc');
                    $uudaitratruoc = get_field('uudaitratruoc');
                    
                    $tongvat = $tienvat = $pbt =  $vatuudai = $tonguudai = '';
                    
                    if($id) {
                    $idbanghang = get_field('idbanghang');
                    $i = $id-1;
                    $banghang = get_field('bang_hang',$idbanghang);
                        $data = $banghang[$i];
                        //var_dump($data);
                        //$vat = $data['vat'];
                        //$sodot = $data['so_dot'];
                        $tien = $data['dongia']*$data['dt'];
                        
                        
                    }
                    
                    $tienvat = $tien*$vat/100;
                    $pbt = $tien*2/100;
                    $tongall = $tien + $tienvat + $pbt;
                    
                    $sauuudai = $tien-$uudai;
                    $vatuudai = $sauuudai*$vat/100;
                    $pbtuudai = $sauuudai*2/100;
                    $tonguudai = $sauuudai+$vatuudai+$pbtuudai;
                    
                    
                    ?>
                    
                    
                    <div class="form-bg">
                        <div class="item nb">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>I. Thông tin khách hàng</b></p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <div class="col-md-6 col-xs-5">1: Ký hiệu căn hộ</div>
                                <div class="col-md-3 col-xs-3"></div>
                                <div class="col-md-3 col-xs-4"><?php echo $data['toa'].'.'.$data['can'] ?></div>
                            </div>
                        </div>
                        <div class="item">
                        <div class="row">
                            <div class="col-md-6">2: Ngày đầu tiên khách hàng nộp tiền cọc:</div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-md-6">3: Ngày KH nộp đủ tiền đặt cọc</div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-md-6">4: Ngày cuối ký hợp đồng mua bán:</div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                    <div class="item nb">
                        <div class="row">
                            <div class="col-md-12"><b>II. Giá bán tính theo diện tích thông thủy</b></div>
                       
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-md-6 col-xs-8">Diện tích thông thủy (m²):</div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 col-xs-4"><?php echo $data['dt']; ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-md-6 col-xs-6">Giá trị căn hộ chưa VAT (Triệu đồng)</div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 col-xs-6"><?php echo number_format($tien); ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-md-6 col-xs-4">Thuế VAT (Triệu đồng)</div>
                            <div class="col-md-3 col-xs-4"><?php echo $vat; ?>%</div>
                            <div class="col-md-3 vat1 col-xs-4"><?php echo number_format($tienvat); ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-md-6">Tổng giá trị căn hộ đã bao gồm VAT (Triệu đồng)</div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 tongvat1"><?php echo number_format($tien+$tienvat); ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-md-6 col-xs-4">
                                Phí bảo trì 
                            </div>
                            <div class="col-md-3 col-xs-4">Phí bảo trì 2% (Triệu đồng)</div>
                            <div class="col-md-3 pbt1 col-xs-4"><?php echo number_format($pbt); ?></div>
                        </div>
                    </div>
                    <div class="item">

                        <div class="row">
                            <div class="col-md-6">
                                Tổng giá trị căn hộ (gồm VAT và KPBT)
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 tong1">
                                <div class="red"><?php echo number_format($tongall); ?></div>
                            </div>
                        </div>
                         </div>
                         <div class="item nb"> 
                        <div class="row">
                            <div class="col-md-12">
                                <b>III. Ưu đãi theo chính sách bán hàng mới nhất</b>
                            </div>
                        </div>
                    </div>
                     <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Ưu đãi quà tặng:</p>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                     <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Quà tặng theo chính sách bán hàng (Triệu/Đồng)</p>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3"><?php echo number_format($uudai); ?></div>
                        </div>
                    </div>
                     <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Giá trị căn hộ sau ưu đãi (chưa VAT)</p>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 priceuudai"><?php echo number_format($sauuudai); ?></div>
                        </div>
                    </div>
                     <div class="item">
                        <div class="row">
                            <div class="col-md-6 col-xs-9">
                                <p>Thuế VAT sau ưu đãi</p>
                            </div>
                            <div class="col-md-3 col-xs-3"><?php echo $vat; ?>%</div>
                            <div class="col-md-3 vatuudai"><?php echo number_format($vatuudai); ?></div>
                        </div>
                    </div>
                     <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Tổng giá trị căn hộ sau ưu đãi ( gồm VAT)</p>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 tongvatuudai"><?php echo number_format($vatuudai+$sauuudai); ?></div>
                        </div>
                    </div>

                     <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Phí bảo trì sau ưu đãi</p>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 pbtuudai"><?php echo number_format($pbtuudai); ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Tổng giá trị căn hộ sau ưu đãi (gồm VAT và PBT)</p>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3 tonguudai"><div class="red"><?php echo number_format($tonguudai); ?></div></div>
                        </div>
                    </div>
					<?php if($tratruoc): ?>

                    <div class="item nb">
                        <div class="row">
                            <div class="col-md-12">
                                <b>IV. Phương thức thanh toán sớm</b>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Phương thức thanh toán sớm <?php echo $tratruoc; ?>%</p>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <?php echo number_format($tratruoc*$sauuudai/100); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Tỉ lệ chiết khấu chuyển tiền sớm (%)</p>
                            </div>
                            <div class="col-md-3">
                                
                            </div>
                            <div class="col-md-3">
                                <p><?php echo $uudaitratruoc; ?>%</p>
                            </div>
                        </div>
                    </div>
					<?php 
							$tienchietkhau = $uudaitratruoc*$sauuudai/100;
							$sauchietkhau = $sauuudai - $uudaitratruoc*$sauuudai/100;


					?>
                    <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Khoản chiết khấu chuyển tiền sớm</p>
                            </div>
                            <div class="col-md-3">
                                
                            </div>
                            <div class="col-md-3">
                                <?php echo number_format($tienchietkhau); ?>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Giá trị căn hộ sau ưu đãi và chiết khấu (chưa VAT)</p>
                            </div>
                            <div class="col-md-3">
                                
                            </div>
                            <div class="col-md-3">
                                <?php echo number_format($sauchietkhau); ?>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Thuế VAT sau ưu đãi và chiết khấu</p>
                            </div>
                            <div class="col-md-3">
                                
                            </div>
                            <div class="col-md-3">
                                <?php echo number_format($sauchietkhau*$vat/100); ?>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Giá trị căn hộ sau ưu đãi và chiết khấu (gồm VAT)</p>
                            </div>
                            <div class="col-md-3">
                                
                            </div>
                            <div class="col-md-3">
                                <?php echo number_format($sauchietkhau*(100+$vat)/100); ?>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Phí bảo trì sau ưu đãi và chiết khấu</p>
                            </div>
                            <div class="col-md-3">
                                
                            </div>
                            <div class="col-md-3">
                                <?php echo number_format($sauchietkhau*2/100); ?>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Tổng giá trị căn hộ sau ưu đãi và chiết khấu (gồm VAT và PBT)</p>
                            </div>
                            <div class="col-md-3">
                                
                            </div>
                            <div class="col-md-3"><div class="red">
                                <?php echo number_format($sauchietkhau*(102+$vat)/100); ?></div>
                            </div>
                        </div>
                    </div>
					
					<?php 
					$tonguudai = $sauchietkhau*(102+$vat)/100;
					
					endif; ?>
                     <div class="item">
                        <div class="row">
                            <div class="col-md-6">
                                <p>Ngân hàng hỗ trợ tối đa</p>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-3 col-xs-3"><div class="red">
                                        <p><?php echo $sovay; ?>%</p>
                                    </div> </div>
                                    <div class="col-md-3 col-xs-3"><div class="red">
										
                                        <p><?php echo number_format($tien*$sovay/100); ?></p></div>
                                    </div>
                                    <div class="col-md-6 more-result col-xs-6">
									<?php 
									$link = get_field('link_tinh_lai');
									 ?>
                                        <p><a href="<?php echo add_query_arg( 'price', $tien*$sovay/100000000 , $link ); ?>" target="_blank">Xem bảng tính lãi</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item nb">
                        <div class="row">
                            <div class="col-md-12">
                                <b>V. Tiến độ đóng tiền</b>
                            </div>
                        </div>
                    </div>

                     <div class="item">

                        <div class="row">
                            <div class="col-md-6">
                                <p>Căn cứ theo CSBH     </p>
                            </div>
                            <div class="col-md-6" id="sodot">
                                <?php
                                $i = 1;
                                foreach($sodot as $item) { ?>
                                    <div class="row">
                                        <div class="col-md-3 col-xs-3"><div class="s">Đợt <?php  echo $i;?></div></div>
                                        <div class="col-md-3 col-xs-3"><div class="s"><?php echo $item['phantram']; ?>%</div></div>
                                        <div class="col-md-6 col-xs-6">
                                                <div class="s"><?php echo number_format($tonguudai*$item['phantram']/100); ?></div>
                                        </div>
                                    </div>  
                                    
                                <?php ++$i; } ?>
                            
                            </div>
                            
                            
                        </div>
                    </div>
                     <div class="item">

                        <div class="row">
                            <div class="col-md-6">
                               <b> Tổng cộng</b>
                            </div>

                            <div class="col-md-6">
                                 <div class="red"><?php echo number_format($tongall); ?></div>
                            </div>
                        </div>
                    </div>

                    </div>
                    <?php endwhile; ?>
                </div>
                <?php } else { ?>
            	Vui lòng <a target="_blank" href="<?php bloginfo('home')?>/wp-login.php">đăng nhập</a> hoặc <a target="_blank" href="<?php bloginfo('home')?>/wp-login.php?action=register">đăng ký</a> để xem
                    <?php }?>
            </div>
        </div>
    </div>
</div>
</div>
</main>

<style>
    .form-bg .item{border-bottom: 1px solid #ddd;padding: 10px 0}
    input{width: 100%}
    .form-bg .item p{margin: 0}
    .form-bg .item.nb{background: #0e224b;
    color: #fff;
    padding-left: 15px;}
    .red{color: red;font-weight: 700}
    .form-bg .item .s{padding: 5px 0;border-bottom: 1px solid #0e224b}
</style>


<!--end maincontent-->
<?php get_footer(); ?>