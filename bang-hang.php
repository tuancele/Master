<?php
/*
 Template Name: Bảng hàng
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
                        
                    <?php while(have_posts()):the_post(); ?>
                    <h1><span style="font-size: 18pt;"><strong><span style="font-family: 'times new roman', times, serif;"><?php the_title(); ?></span></strong></span></h1>
                    <div class="form-bh">
                        <table class="table table-bordered table-customize table-responsive" width="100%">
                            <thead>
                                <tr style="    color: #fff;
    background: #0e224b;">
                                    <td >STT</td>
                                    <td >Tòa / Block</td>
                                    <td >Căn hộ/Lô</td>
                                    <td >Diện tích (Thông thủy)</td>
                                    <td >Đơn giá/m2</td>
                                    <td >Đơn giá (Chưa VAT)</td>
                                    <td >Dòng tiền</td>
                                </tr>   
                                </thead>        
                            <tbody>
                                					<?php $banghang = get_field('bang_hang');								if ($banghang) :									$link = get_field('linkchitiet');									$i = 1;									foreach ($banghang as $item ) {																				//$can = $item['toa'].'.'.$item['can'];									//$linkchitiet = $link.'&dt='.$item["dt"].'&dongia='..'&can='.$item["toa"].'.'.$can.'&sodot='.$item["sodot"].'&vat='.$item["vat"];																		//$link1 = add_query_arg( 'id', $i , $link );																													?>																		<tr>										
                                                        <td data-title="STT"><?php  echo $i; ?></td>										
                                                        <td data-title="Tòa / Block"><?php echo $item['toa']; ?></td>										
                                                        <td data-title="Căn hộ/Lô"><?php echo $item['can']; ?></td>										
                                                        <td data-title="Diện tích (Thông thủy)"><?php echo $item['dt']; ?>m2</td>										
                                                        <td data-title="Đơn giá/m2"><?php echo number_format($item['dongia']); ?> đ</td>										
                                                        <td data-title="Đơn giá (Chưa VAT)"><?php echo number_format($item['dongia']*$item['dt']); ?>đ</td>				<td data-title="Dòng tiền"><a target="_blank" href="<?php echo add_query_arg( 'id', $i , $link ); ?>">Xem chi tiết</a></td>		
                                                        </tr>																																																	<?php ++$i; }	endif;	?>
                                


                            </tbody>
                        </table>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<style>
    .form-bh tr td{border-bottom: 1px solid #ddd;padding: 10px }
    input{width: 100%}
    /* Style for table */


@media (min-width: 320px) and (max-width: 767px) {

 .table-responsive {
    border-left: none;
    border-right: none;
    overflow: scroll;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar;}
}
</style>
<!--end maincontent-->
<?php get_footer(); ?>