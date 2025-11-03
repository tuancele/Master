<div class="modal-adv">

    <div id="myModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <button type="button" class="close" data-dismiss="modal"><svg><use xlink:href="#close"></use></svg></button>
            <div class="modal-content">
                <div class="dowload-last">
                    <form class="form-download2 cele-form-modal">
                        <input name="Human" value="<?php echo wp_create_nonce( 'human' ); ?>" type="hidden">
                        <input name="Cele" value="mastergf-modal-right" type="hidden">
                        <input name="Website" value="<?php the_permalink(); ?>" type="hidden">
                        <div class="box-heading">
                            <p class="title-dowload-last"><?php _e('House quotation','master-gf') ?> <br> <?php bloginfo('name'); ?></p>
                        </div>
                        <p><?php _e('To get houses price, please enter correct information. All information shall be absolutely protected','master-gf') ?></p>
                        <div class="dowload-last-input1-modal celename">
                            <input class="form-control" id="name-downow-modal" aria-label="Name" name="Name" type="text" placeholder="<?php _e('Full name','master-gf') ?>">
                        </div>
                        <div class="dowload-last-input2-modal celeemail">
                            <input class="form-control" id="email-downow-modal" aria-label="Email" name="Email" type="text" placeholder="<?php _e('Email','master-gf') ?>Email">
                        </div>
                        <div class="dowload-last-input3-modal celephone">
                            <input class="form-control" id="phone-downow-modal" aria-label="Mobile" name="Mobile" type="number" placeholder="<?php _e('Phone number','master-gf') ?>" required>
                        </div>
                        <input id="link-dow-now-modal" class="dow-now" name="dangky" type="button" aria-label="Submit" value="<?php _e('Get information','master-gf') ?>" onclick="Submit_Form('modal','noname')">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="nhantuvanrieng" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <button type="button" class="close" data-dismiss="modal"><svg><use xlink:href="#close"></use></svg></button>
            <div class="modal-content">
                <div class="h3" style="text-align:center;"><?php _e('Get the advice','master-gf') ?></div>
                <div class="logo-modal"></div>
                <form id="form-header" class="cele-form-header">
                    <input name="Human" value="<?php echo wp_create_nonce( 'human' ); ?>" type="hidden">
                    <input name="Cele" value="mastergf-modal-header" type="hidden">
                    <input name="Website" value="<?php the_permalink(); ?>" type="hidden">
                    <div class="box-content-modal">
                        <div class="input-gr celename">
                            <p><?php _e('Full name','master-gf') ?>:</p>
                            <input type="text" name="Name" class="form-control">
                        </div>
                        <div class="input-gr input-gr-sdt celephone">
                            <p><?php _e('Phone number','master-gf') ?>:</p>
                            <input aria-label="Mobile" id="phone-header" type="number" name="Mobile" class="form-control" required>
                        </div>
                        <div class="input-gr input-gr-email celeemail">
                            <p><?php _e('Email','master-gf') ?>:</p>
                            <input aria-label="Email" id="email-header" type="text" name="Email" class="form-control">
                        </div>
                        <input aria-label="Submit" id="phone_prheader" type="button" name="dangky" value="<?php _e('Send','master-gf') ?>" onclick="Submit_Form('header','noname')" class="btn-send-moadl">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal-sc6-top">

        <form class="form-tlduan-red cele-form-red">
            <input name="Human" value="<?php echo wp_create_nonce( 'human' ); ?>" type="hidden">
            <input name="Cele" value="mastergf-modal-red" type="hidden">
            <input name="Website" value="<?php the_permalink(); ?>" type="hidden">
            <div id="sc6-red" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <button type="button" class="close" data-dismiss="modal"><svg><use xlink:href="#close"></use></svg></button>
                    <div class="modal-content">
                        <div class="dowload-last">
                            <div class="box-heading">
                                <p class="title-dowload-last"><?php _e('Project document','master-gf') ?> <br> <?php bloginfo('name'); ?></p>
                            </div>
                            <p><?php _e('Please fill in full and correct information<br> All information shall be absolutely protected','master-gf') ?></p>
                            <div class="input-red1 celename" style="margin-bottom: 17px;">
                                <input class="form-control" id="name-modal-red" name="Name" aria-label="Name" type="text" placeholder="<?php _e('Full name','master-gf') ?>">
                            </div>
                            <div class="input-red2 celeemail" style="margin-bottom: 17px;">
                                <input class="form-control" id="email-modal-red" name="Email" aria-label="Email" type="email" placeholder="<?php _e('Email','master-gf') ?>">
                            </div>
                            <div class="input-red3 celephone" style="margin-bottom: 17px;">
                                <input class="form-control" id="phone-modal-red" name="Mobile" aria-label="Mobile" type="number" placeholder="<?php _e('Phone number','master-gf') ?>" required>
                            </div>
                            <input id="link-modal-red" class="dow-now" name="dangky" aria-label="Submit" type="button" onclick="Submit_Form('red','noname')" value="<?php _e('Register','master-gf') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form class="form-banggia-blue cele-form-blue">
            <input name="Cele" value="mastergf-modal-blue" type="hidden">
            <input name="Website" value="<?php the_permalink(); ?>" type="hidden">
            <div id="sc6-blue" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <button type="button" class="close" data-dismiss="modal"><svg><use xlink:href="#close"></use></svg></button>
                    <div class="modal-content">
                        <div class="dowload-last">
                            <div class="box-heading">
                                <p class="title-dowload-last"><?php _e('House price','master-gf') ?> <br> <?php bloginfo('name'); ?></p>
                            </div>
                            <p><?php _e('Please fill in full and correct information. All information shall be absolutely protected','master-gf') ?></p>
                            <div class="input-blue1 celename" style="margin-bottom: 17px;">
                                <input class="form-control" id="name-modal-blue" name="Name" aria-label="Name" type="text" placeholder="<?php _e('Full name','master-gf') ?>">
                            </div>
                            <div class="input-blue2 celeemail" style="margin-bottom: 17px;">
                                <input class="form-control" id="email-modal-blue" name="Email" aria-label="Email" type="email" placeholder="<?php _e('Email','master-gf') ?>">
                            </div>
                            <div class="input-blue3 celephone" style="margin-bottom: 17px;">
                                <input class="form-control" id="phone-modal-blue" name="Mobile" aria-label="Mobile" type="number" placeholder="<?php _e('Phone number','master-gf') ?>" required>
                            </div>
                            <input id="link-modal-blue" class="dow-now" name="dangky" aria-label="Submit" type="button" onclick="Submit_Form('blue','noname')" value="<?php _e('Register','master-gf') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form class="form-lichmoban-yellow cele-form-yellow">
            <input name="Human" value="<?php echo wp_create_nonce( 'human' ); ?>" type="hidden">
            <input name="Website" value="<?php the_permalink(); ?>" type="hidden">
            <div id="sc6-vag" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <button type="button" class="close" data-dismiss="modal"><svg><use xlink:href="#close"></use></svg></button>
                    <div class="modal-content">
                        <div class="dowload-last">
                            <div class="box-heading">
                                <p class="title-dowload-last"><?php _e('Get information Sale open time','master-gf') ?></p>
                            </div>
                            <p><?php _e('Please fill in full and correct information. All information shall be absolutely protected','master-gf') ?></p>
                            <div class="input-vag1 celename" style="margin-bottom: 17px;">
                                <input class="form-control" id="name-modal-yellow" name="Name" aria-label="Name" type="text" placeholder="<?php _e('Full name','master-gf') ?>">
                            </div>
                            <div class="input-vag2 celeemail" style="margin-bottom: 17px;">
                                <input class="form-control" id="email-modal-yellow" name="Email" aria-label="Email" type="email" placeholder="<?php _e('Email','master-gf') ?>">
                            </div>
                            <div class="input-vag3 celephone" style="margin-bottom: 17px;">
                                <input class="form-control" id="phone-modal-yellow" name="Mobile" aria-label="Mobile" type="number" placeholder="<?php _e('Phone number','master-gf') ?>" required>
                            </div>
                            <input id="link-modal-vag" class="dow-now" name="dangky" type="button" aria-label="Submit" onclick="Submit_Form('yellow','noname')" value="<?php _e('Register','master-gf') ?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

</div>
