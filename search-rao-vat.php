
    <form class="formSearchLabor" role="search" method="post" action="<?php echo home_url( 'tim-kiem' ); ?>">
        <div class="row">
            <div class="col-md-3">
                <select name="sp">
                    <option value="0"> -- Sản phẩm -- </option>
                    <?php $categories = get_categories( array( 'hide_empty' => 0,'parent'=>0,'taxonomy'=>'san-pham' ) );foreach ( $categories as $category ) {?>
                    <option value="<?php echo $category->cat_ID;?>" <?php if($_POST['sp']==$category->cat_ID){echo 'selected';}?>><?php echo $category->name ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="lh">
                    <option value="0"> -- Loại hình -- </option>
                    <?php $categories = get_categories( array( 'hide_empty' => 0,'parent'=>0,'taxonomy'=>'danh-muc-loai-hinh' ) );foreach ( $categories as $category ) {?>
                    <option value="<?php echo $category->cat_ID;?>" <?php if($_POST['lh']==$category->cat_ID){echo 'selected';}?>><?php echo $category->name ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="th">
                    <option value="0"> -- Tỉnh thành -- </option>
                    <?php $categories = get_categories( array( 'hide_empty' => 0,'parent'=>0,'taxonomy'=>'tinh-thanh' ) );foreach ( $categories as $category ) {?>
                    <option value="<?php echo $category->cat_ID;?>" <?php if($_POST['th']==$category->cat_ID){echo 'selected';}?>><?php echo $category->name ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="col-md-3">
                <div class="boxButton">
                    <button type="submit"></button>
                </div>
            </div>
        </div>
    </form>
