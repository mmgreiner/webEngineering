<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--<title> J. O. Rob main page</title>-->
	<title><?php echo get_option('mam_theme_options')['websitetitle']; ?></title>	
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>	
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/menu.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/animation.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/portfolio.js"></script>
</head>

<body data-spy="scroll" data-offset="0" data-target="#navbar-main">

	<!-- ==== MENU ==== -->
    <nav>
        <ul class="nav">
            <li>
                <a href="#home">Home
                     <img src="<?php bloginfo('template_url'); ?>/assets/img/Icons/menu-home.png" alt="">
                </a>
            </li>
            <li>
                <a href="#about">About me
                     <img src="<?php bloginfo('template_url'); ?>/assets/img/Icons/menu-about.png" alt="">
                </a>
            </li>
            <li>
                <a href="#portfolio">Portfolio
                     <img src="<?php bloginfo('template_url'); ?>/assets/img/Icons/menu-portfolio.png" alt="">
                </a>
            </li>
            <li>
                <a href="#blog">Blog
                     <img src="<?php bloginfo('template_url'); ?>/assets/img/Icons/menu-blog.png" alt="">
                </a>
            </li>
            <li>
                <a href="#contact">Contact
                     <img src="<?php bloginfo('template_url'); ?>/assets/img/Icons/menu-contact.png" alt="">
                </a>
            </li>
        </ul>
    </nav>

	<!-- ==== HEADER ==== -->
    <section id="home">
        <header>
            <h1><span ></span></h1>
			<div class="animate">
				<!--<p>A 2.0 web developer.</p>
				<p>At your service</p>-->
				<?php echo get_option('mam_theme_options')['websitedescription']; ?>				
			</div>
        </header>
    </section>