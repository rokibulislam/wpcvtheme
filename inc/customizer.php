<?php 
	
	add_action( 'customize_register', 'customize_register' );

	function customize_register( $wp_customize ) {

		
		$wp_customize->add_section('header_section',array(
			'title'=> __('Header Settings','rawnet'),
			'priority'=>10,
		));


		$wp_customize->add_setting('get_started_section', array(
		  'default' => __( '', 'rawnet' ),
		  'transport'=>'refresh'
		) );

		$wp_customize->add_control( 'get_started_section', array(
		  'label' => __( 'Get Started Link','rawnet' ),
		  'section' => 'header_section',
		  'type'=>'text'
		) );



		$wp_customize->add_section('footer_section',array(
			'title'=> __('Footer Settings','rawnet'),
			'priority'=>10,
		));


		$wp_customize->add_setting('footer_column_one', array(
		  'default' => __( '', 'rawnet' ),
		  'transport'=>'refresh'
		) );

		$wp_customize->add_control( 'footer_column_one', array(
		  'label' => __( 'Footer Column One Title','rawnet' ),
		  'section' => 'footer_section',
		  'type'=>'text'
		) );


		$wp_customize->add_setting('footer_column_two', array(
		  'default' => __( '', 'rawnet' ),
		  'transport'=>'refresh'
		) );

		$wp_customize->add_control( 'footer_column_two', array(
		  'label' => __( 'Footer Column Two Title','rawnet' ),
		  'section' => 'footer_section',
		  'type'=>'text'
		) );


		$wp_customize->add_setting('footer_column_three', array(
		  'default' => __( '', 'rawnet' ),
		  'transport'=>'refresh'
		) );

		$wp_customize->add_control( 'footer_column_three', array(
		  'label' => __( 'Footer Column Three Title','rawnet' ),
		  'section' => 'footer_section',
		  'type'=>'text'
		) );


		$wp_customize->add_setting('copyright_section', array(
		  'default' => __( '', 'rawnet' ),
		  'transport'=>'refresh'
		) );

		$wp_customize->add_control( 'copyright_section', array(
		  'label' => __( 'Copy Right Text','rawnet' ),
		  'section' => 'footer_section',
		  'type'=>'text'
		) );

		$wp_customize->add_setting('chat_section', array(
		  'default' => __( '', 'rawnet' ),
		  'transport'=>'refresh'
		) );

		$wp_customize->add_control( 'chat_section', array(
		  'label' => __( 'Chat Link','rawnet' ),
		  'section' => 'footer_section',
		  'type'=>'text'
		) );

		$wp_customize->add_setting('logo_upload', array(
			'default'   => '',
			'transport' =>'postMessage'
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'logo_upload', array(
			'label'    => __( 'Logo Upload', 'rawnet' ),
			'section'  => 'title_tagline',
			'settings' =>'logo_upload'
		)));

	}