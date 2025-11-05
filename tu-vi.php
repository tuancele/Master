<?php /* Template Name: Danh Mục Tử vi */ ?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php wp_title(' '); ?></title>
        <link rel='shortcut icon' href='tuvi_ls/icon.ico' type='image/x-icon' />
        <style type="text/css">
        input[type="number"] {width: 40px;}
        @font-fare {
        font-family: 'Chu Nom Khai';
        src: "tuvi_ls/font/NomKhai.ttf";
        }
        </style>
        <script src="<?php echo get_template_directory_uri();?>/tuvi/js/tuvi.js"></script>
        <script>
        g_isIpad = 0;
        g_Path_toTV = "<?php echo get_template_directory_uri();?>/tuvi/";
        
        isFirst = 0;
        isGetLS = 0;
        g_isLuuHan = 1;
        g_isFullOpt = 0;
        g_hoten = "";
        g_isduonglich = 1;
        g_ngayCur = 9;
        
        g_namHan = 2019;
        g_namSinh = 1988;
        g_mau = 1;
        g_gioSinh = 10;
        g_gioDH = 11;
        g_gioDM = 30;
        g_isLuu4Hoa = 0;
        g_isLuu4Duc = 0;
        g_isLuuKhoiVietKhac = 0;
        g_isLuuThaiTueDB = 1;
        g_isLocNhap = 0;
        g_isInLS = 1;
        </script>
    </head>
    <body onload='showHidden();'>
        <center>
        <div id='beginLS'>
            <?php the_field('info_top')?>
        </div>
        <table>
            <td>
                <tr>
                    <div id='hiddenPrint'></div>
                </tr>
                <?php the_field('info_bottom')?>
            </td>
        </table>
        </center>
        <div id='testrespond'></div>
    </body>
</html>