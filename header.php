<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<?php wp_head();?>
</head>
<body>
    <?php
        $logo = get_theme_mod( 'logo_upload' );
        $get_started_link = esc_url( get_theme_mod( 'get_started_section' ) );
    ?>

    <!--====== Start Header ======-->
    <header class="template-header">
        <div class="container">
            <div class="header-inner">
                
                <div class="header-left">
                    <div class="site-logo">
                        <h2 class="m-0 font-weight-bold text-white"> 
                            <a href="<?php echo site_url( '/' ) ?>"> 
                                <img src="<?php echo $logo; ?>" alt="img"/>
                            </a>
                        </h2>
                    </div>
                </div>

                <div class="header-right">

                    <?php
                      $defaults = array(
                        'theme_location'  => 'primary',
                        'container_id'    => '',
                        'container'       => 'nav',
                        'container_class' => 'nav-menu',
                        'items_wrap'      => '<ul class="primary-menu" %2$s">%3$s</ul>',
                        'walker' => new WP_Bootstrap_Navwalker()
                      );

                      wp_nav_menu( $defaults );
                    ?>

                    <!-- <nav class="nav-menu">
                        <ul class="primary-menu">
                            <li class="has-multistep">
                                <a href="" class=" multistep-toggle">CV WRITING PACKAGES</a>
                                <div class="multistep-wrap">
                                    <div class="container">
                                        <ul class="multistep-menus row">
                                            <li>
                                                <div class="ins">
                                                    <a href="#" class="multistep-toggle">Mid-Career CV Writing</a>
                                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="ins">
                                                    <a href="#" class="multistep-toggle">Leadership CV Writing</a>
                                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="ins">
                                                    <a href="#" class="multistep-toggle">Executive CV Writing</a>
                                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li><a href="#">about us</a></li>
                            <li><a href="#">contact us</a></li>
                            <li class="d-lg-none">
                                <div class="login-btns">
                                    <a href="#">Your account</a>
                                    <a href="#">Login</a>
                                </div>
                            </li>
                        </ul>
                    </nav> -->
                    
                </div>

                <div class="right-cont-nv ms-auto">
                
                    <ul class="d-flex align-items-center">
                    
                    <?php if( is_user_logged_in() ) { ?>    
                      
                        <li>
                            <a href="#" class="user">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21.262" height="24.919" viewBox="0 0 21.262 24.919">
                                    <path id="np_account_4755877_000000" d="M29.465,21.047,28.8,18.116a4.231,4.231,0,0,0-4.18-3.338h-8.83a4.231,4.231,0,0,0-4.18,3.338l-.661,2.931a4.243,4.243,0,0,0,4.179,5.227H25.283a4.246,4.246,0,0,0,4.18-5.227ZM20.21,13.513a4.812,4.812,0,1,0-3.4-1.409A4.8,4.8,0,0,0,20.21,13.513Zm4.3-.516a5.962,5.962,0,0,1-.587.516h.7a5.511,5.511,0,0,1,5.41,4.327l.661,2.931a5.515,5.515,0,0,1-5.409,6.769H15.136a5.509,5.509,0,0,1-5.409-6.769l.661-2.931a5.511,5.511,0,0,1,5.41-4.327h.7A6.216,6.216,0,0,1,15.914,13a6.079,6.079,0,1,1,8.6,0Z" transform="translate(-9.58 -2.621)" fill="#282140"/>
                                </svg>
                            </a>
                        </li>

                        <li>
                            <div class="d-lg-none">
                                <div class="navbar-toggler">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </li>

                    <?php } ?>

                        <li> <a href="<?php echo $get_started_link; ?>" class="btn">get started </a> </li>

                    </ul>

                </div>
            </div>
        </div>
    </header>
    <!--====== End Header ======-->
	
    <div class="example-height w-100 mb-5" style="height: 500px; background: #fff;"> </div>