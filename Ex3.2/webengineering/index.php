<?php get_header(); ?>

<!--<div id="main" class="group">-->
	
	<!--<div id="blog">-->
	
	<div style="background-color: <?php echo get_option('mam_theme_options')['basebackgroundcolor']; ?> ">
	
		<!--- ==== ABOUT, PART DESIGNER, PART CODER AS WORDPRESS-PAGES ==== -->
		<?php
			$params = array( 'post_type' => 'page', post_name__in => array('About', 'Part Designer', 'Part Coder'), 'orderby' => 'order', 'order' => 'ASC' );
			$myPosts = new WP_Query($params);
			while( $myPosts->have_posts()) :
				$myPosts->the_post();
				the_content();
			endwhile;
		?>
		
		<!-- ==== TECHNICAL SKILLS ==== -->
		<section id="technicalskills">
			<h1 class="h1centered animate"> My Technical Skills</h1>
			<div id="barhtml" class="bar">
				<div class="charttextupper">95<span>%</span></div>
				<div class="charttextlower">HTML</div>
			</div>
			<div id="barcss" class="bar">
				<div class="charttextupper">80<span>%</span></div>
				<div class="charttextlower">CSS</div>
			</div>
			<div id="barjs" class="bar">
				<div class="charttextupper">90<span>%</span></div>
				<div class="charttextlower">JavaScript</div>
			</div>
			<div id="barwp" class="bar">
				<div class="charttextupper">80<span>%</span></div>
				<div class="charttextlower">WordPress</div>
			</div>
		</section>

		<!-- ==== PORTFOLIO ==== -->
		<section id="portfolio" name="portfolio">
			<br>
			<br>
			<h1 class="h1centered">I WORKED ON COOL STUFF</h1>
			<hr>
			<br>
			<br>
			<nav id="portfolioCategories">
				<section name="ALL" class="portfolioCat animate" id="portfolioSelected" onclick="toggleVisiblePortfolioProjects(this)">
					<p>ALL</p>
				</section>
				<section name="UI DESIGN" class="portfolioCat animate" onclick="toggleVisiblePortfolioProjects(this)">
					<p> UI DESIGN </p>
				</section>
				<section name="ANDROID PAGE" class="portfolioCat animate" onclick="toggleVisiblePortfolioProjects(this)">
					<p> ANDROID PAGE </p>
				</section>
			</nav>
			<br>

			<div id="porfolioProjects">
				
				 <!-- PORTFOLIO IMAGE 1 -->
				<figure name="UI DESIGN" class="portfolioFigure">
					<img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio01.jpg" alt="">
					<figcaption>
						<h5>UI DESIGN</h5>
						<a data-toggle="modal" href="#id01">Take a Look</a>
					</figcaption>
				</figure>
				
				<div id="id01" class="modal">
					<div class="modal-dialog">
						<div class="modal-content">
							<header class="container">
								<a  href="#l"class="closebtn">×</a>
								<h2 class="popup-h2">UI Design</h2>
							</header>
							<div class="container">
								<img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio01.jpg" alt="" class="image-popup">
								<p>The quality of a user interface relies on a easily understandable operation concept, adapted to the user’s workflow. Nevertheless, it is the optimization of visual design and dynamic elements that create an extraordinary user experience..</p>
							</div>
						</div>
					</div>
				</div>
					
				<!-- PORTFOLIO IMAGE 2 -->
				<figure name="UI DESIGN" class="portfolioFigure">
					<img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio02.jpg" alt="">
					<figcaption>
						<h5>UI DESIGN</h5>
						<a data-toggle="modal" href="#id02">Take a Look</a>
					</figcaption>
				</figure>
				
				<div id="id02" class="modal">
					<div class="modal-dialog">
						<div class="modal-content">
							<header class="container">
								<a  href="#l"class="closebtn">×</a>
								<h2 class="popup-h2">UI Design</h2>
							</header>
							<div class="container">
								<img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio02.jpg"alt="" class="image-popup">
								<p>The quality of a user interface relies on a easily understandable operation concept, adapted to the user’s workflow. Nevertheless, it is the optimization of visual design and dynamic elements that create an extraordinary user experience..</p>
							</div>                        
						</div>
					</div>
				</div>

				<!-- PORTFOLIO IMAGE 3 -->
				<figure name="ANDROID PAGE" class="portfolioFigure">
					<img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio03.jpg" alt="">
					<figcaption>
						<h5>ANDROID PAGE</h5>
						<a data-toggle="modal" href="#id03">Take a Look</a>
					</figcaption>
				</figure>
				
				<div id="id03" class="modal">
					<div class="modal-dialog">
						<div class="modal-content">
							<header class="container">
								<a  href="#l"class="closebtn">×</a>
								<h2 class="popup-h2">ANDROID PAGE</h2>
							</header>
							<div class="container">
								<img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio03.jpg" alt="" class="image-popup">
								<p>The quality of a user interface relies on a easily understandable operation concept, adapted to the user’s workflow. Nevertheless, it is the optimization of visual design and dynamic elements that create an extraordinary user experience..</p>
							</div>            
						</div>
					</div>
				</div>
				
				<!-- PORTFOLIO IMAGE 4 -->
				<figure name="ANDROID PAGE" class="portfolioFigure">
					<img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio04.jpg" alt="">
					<figcaption>
						<h5>ANDROID PAGE</h5>
						<a data-toggle="modal" href="#id04">Take a Look</a>
					</figcaption>
				</figure>
				
				<div id="id04" class="modal">
					<div class="modal-dialog">
						<div class="modal-content">
							<header class="container">
								<a  href="#l"class="closebtn">×</a>
								<h2 class="popup-h2">ANDROID PAGE</h2>
							</header>
							<div class="container">
								<img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio04.jpg" class="image-popup">
								<p>The quality of a user interface relies on a easily understandable operation concept, adapted to the user’s workflow. Nevertheless, it is the optimization of visual design and dynamic elements that create an extraordinary user experience..</p>
							</div>            
						</div>
					</div>
				</div>
				
				<!-- PORTFOLIO IMAGE 5 -->
				<figure name="ANDROID PAGE" class="portfolioFigure">
					<img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio05.jpg" alt="">
					<figcaption>
						<h5>ANDROID PAGE</h5>
						<a data-toggle="modal" href="#id05">Take a Look</a>
					</figcaption>
				</figure>
				
				<div id="id05" class="modal">
					<div class="modal-dialog">
						<div class="modal-content">
							<header class="container">
								<a  href="#l"class="closebtn">×</a>
								<h2 class="popup-h2">ANDROID PAGE</h2>
							</header>
							<div class="container">
								<img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio05.jpg" alt="" class="image-popup">
									<p>The quality of a user interface relies on a easily understandable operation concept, adapted to the user’s workflow. Nevertheless, it is the optimization of visual design and dynamic elements that create an extraordinary user experience..</p>
							</div>
						</div>
					</div>
				</div>

				<!-- PORTFOLIO IMAGE 6 -->            
				<figure name="ANDROID PAGE" class="portfolioFigure">
					<img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio06.jpg" alt="">
					<figcaption>
						<h5>ANDROID PAGE</h5>
						<a data-toggle="modal" href="#id06">Take a Look</a>
					</figcaption>
				</figure>
				
				<div id="id06" class="modal">
					<div class="modal-dialog">
						<div class="modal-content">
							<header class="container">
								<a  href="#l"class="closebtn">×</a>
								<h2 class="popup-h2">ANDROID PAGE</h2>
							</header>
							<div class="container">
								<img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio06.jpg" alt="" class="image-popup">
									<p>The quality of a user interface relies on a easily understandable operation concept, adapted to the user’s workflow. Nevertheless, it is the optimization of visual design and dynamic elements that create an extraordinary user experience..</p>
									</div>
							
						</div>
					</div>
				</div>
					
			</div>
			<br>
			<br>
		</section>
		
		<!--- ==== BLOG AS WORDPRESS-POSTS ==== -->
		<section id="blog" name="blog">
        <br>
        <br>
        <h1 class="h1centered">MY  PERSONAL BLOG</h1>
        <hr>
        <br>
        <br>

        <div id="blogcontainer">
		<?php 
			$params = array( 'posts_per_page' => 2, 'orderby' => 'date', 'order' => 'DESC');
			$myPosts = new WP_Query($params);
			while( $myPosts->have_posts()) :
				$myPosts->the_post();
		?>
				<article class="blogitem">
					<aside class="blogauthor">
						<br>
						<p><img src="<?php bloginfo('template_url'); ?>/assets/img/team/u1.jpg" width="60px" height="60px"></p>
						<h4><?php the_author(); ?></h4>
						<h5><?php the_date(); ?></h5>
					</aside>
					<section class="blogtext animator">
						<h2><?php the_title(); ?></h2>
						<?php the_content(); ?>
						<p><a href="#"> Read More</a></p>
						<br>
					</section>
				</article>	
		<?php
			endwhile;
		?>
		
			<nav id="blogpreviews">
			
			<?php 
				$params = array( 'posts_per_page' => 3, 'orderby' => 'date', 'order' => 'DESC', 'offset' => 2);
				$myPosts = new WP_Query($params);
				while( $myPosts->have_posts()) :
					$myPosts->the_post();
			?>
				<aside class="blogpreview">
                    <p><?php the_title(); ?></p>
                    <p><?php the_date(); ?></p>
                    <p><a href="#"> Read More</a></p>
                </aside>
                
			<?php
				endwhile;
			?>
            </nav>
        </div>			
        <br>
        <br>
    </section>
				
		
		<!--- ==== CRAFTED AS WORDPRESS-PAGES ==== -->
		<?php
			$params = array( 'post_type' => 'page', post_name__in => array('Crafted'), 'orderby' => 'order', 'order' => 'ASC' );
			$myPosts = new WP_Query($params);
			while( $myPosts->have_posts()) :
				$myPosts->the_post();
				the_content();
			endwhile;
		?>
	
<?php get_footer(); ?>