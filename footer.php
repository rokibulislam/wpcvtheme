<?php 
    $copyright_section  = get_theme_mod( 'copyright_section' );
    $chat_link  = esc_url( get_theme_mod( 'chat_section' ) );

    $footer_column_one  = get_theme_mod( 'footer_column_one' );
    $footer_column_two  = get_theme_mod( 'footer_column_two' );
    $footer_column_three  = get_theme_mod( 'footer_column_three' );

    $footer_menu_one = array(
        'theme_location'  => 'footer_menu_one',
        'container_id'    => '',
        'container'       => 'nav',
        'container_class' => 'nav-menu',
        'items_wrap'      => '<ul class="primary-menu" %2$s">%3$s</ul>',
    );

    $footer_menu_two = array(
        'theme_location'  => 'footer_menu_two',
        'container_id'    => '',
        'container'       => 'nav',
        'container_class' => 'nav-menu',
        'items_wrap'      => '<ul class="primary-menu" %2$s">%3$s</ul>',
    );


    $footer_menu_three = array(
        'theme_location'  => 'footer_menu_three',
        'container_id'    => '',
        'container'       => 'nav',
        'container_class' => 'nav-menu',
        'items_wrap'      => '<ul class="primary-menu" %2$s">%3$s</ul>',
    );

?>

    <footer class="footer-cls">
        
        <div class="container">
        
            <div class="row">
                
                <div class="col-md-3">
                    <div class="widget-single-ft">
                        <h3> <?php echo $footer_column_one; ?> </h3>
                        <?php wp_nav_menu( $footer_menu_one ); ?>
                    </div><!--/.widget-single-ft-->
                </div>
                
                <div class="col-md-3">
                    <div class="widget-single-ft">
                        <h3> <?php echo $footer_column_two; ?> </h3>
                        <?php wp_nav_menu( $footer_menu_two ); ?>
                    </div><!--/.widget-single-ft-->
                </div>

                <div class="col-md-3">
                    <div class="widget-single-ft">
                        <h3> <?php echo $footer_column_three; ?> </h3>
                        <?php wp_nav_menu( $footer_menu_three ); ?>
                    </div><!--/.widget-single-ft-->
                </div>

                <div class="col-md-3 text-end">
                    <a href="<?php echo $chat_link; ?>" class="chat-mobile">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/chat.svg " alt="">
                    </a>
                </div>

                <div class="col-12">
                    <div class="copyright-text-ft">
                        <p> <?php echo $copyright_section; ?>
                            <a href="#">Terms & Conditions</a> - 
                            <a href="#">Privacy Policy</a>
                        </p>
                    </div>
                </div>

            </div>
        
        </div>

    </footer>

<?php wp_footer(); ?>
</body>
</html>