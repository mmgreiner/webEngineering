<?php get_header(); ?>

<!--<div id="main" class="group">-->

<!--<div id="blog">-->

<section style="background-color: <?php echo get_option('mam_theme_options')['basebackgroundcolor']; ?> ">

    <!--- ==== ABOUT, PART DESIGNER, PART CODER AS WORDPRESS-PAGES ==== -->
    <?php 
$params = array('post_type' => 'page', post_name__in => array('About', 'Part Designer', 'Part Coder'), 'orderby' => 'order', 'order' => 'ASC');
$myPosts = new WP_Query($params);
while ($myPosts->have_posts()): $myPosts->the_post();
    the_content();
endwhile;
?>

    <!-- ==== TECHNICAL SKILLS ==== -->
    <section id="technicalskills">
        <h1 class="h1centered animate"> My Technical Skills</h1>
        <div id="barhtml" class="bar">
            <!--<div class="charttextupper">95<span>%</span></div>-->
            <div class="charttextupper"><?php echo get_theme_mod('html_percentage', '0'); ?><span>%</span></div>
            <div class="charttextlower">HTML</div>
        </div>
        <div id="barcss" class="bar">
            <!--<div class="charttextupper">80<span>%</span></div>-->
            <div class="charttextupper"><?php echo get_theme_mod('css_percentage', '0'); ?><span>%</span></div>
            <div class="charttextlower">CSS</div>
        </div>
        <div id="barjs" class="bar">
            <!--<div class="charttextupper">90<span>%</span></div>-->
            <div class="charttextupper"><?php echo get_theme_mod('js_percentage', '0'); ?><span>%</span></div>
            <div class="charttextlower">JavaScript</div>
        </div>
        <div id="barwp" class="bar">
            <!--<div class="charttextupper">80<span>%</span></div>-->
            <div class="charttextupper"><?php echo get_theme_mod('wp_percentage', '0'); ?><span>%</span></div>
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
            <?php 
            $cats = get_portfolio_categories();
            foreach ($cats as $cat) {
                ?>
            <section name="<?php echo $cat; ?>" class="portfolioCat animate" onclick="toggleVisiblePortfolioProjects(this)">
                <p><?php echo $cat; ?></p>
            </section>
            <?php    
            }
            ?>
            <!-- 
            <section name="UI DESIGN" class="portfolioCat animate" onclick="toggleVisiblePortfolioProjects(this)">
                <p> UI DESIGN </p>
            </section>
            <section name="ANDROID PAGE" class="portfolioCat animate" onclick="toggleVisiblePortfolioProjects(this)">
                <p> ANDROID PAGE </p>
            </section>
            -->
        </nav>
        <br>

        <div id="portfolioProjects">
        <?php 
        $params = array('post_type' => 'portfolio', 'posts_per_page' => 6, 'orderby' => 'ID', 'order' => 'ASC');
        $portfolioPosts = new WP_Query($params);
        
        $counter = 1;
        while ($portfolioPosts->have_posts()) : $portfolioPosts->the_post(); 
            $category = the_portfolio_category(get_the_ID());
        ?>
<!--            <figure name="UI DESIGN" class="portfolioFigure"> -->
            <figure class="portfolioFigure" name="<?php echo $category;?>">
                <?php echo get_the_post_thumbnail();?>
                <!-- <img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio01.jpg" alt=""> -->
                <figcaption>
                    <h5><?php echo $category;?></h5>
                    <a data-toggle="modal" href="#id<?php echo $counter; ?>">Take a Look</a>
                </figcaption>
            </figure>
            
            <div id="id<?php echo $counter; ?>" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <header class="container">
                            <a href="#l" class="closebtn">×</a>
                            <h2 class="popup-h2"><?php the_title(); echo ' / ' . $category?></h2>
                        </header>
                        <div class="container">
                            <?php echo get_the_post_thumbnail(get_the_ID() /*, [600, 400] ['class' => 'image-popup']*/);?> 
                            <!-- <img src="<?php bloginfo('template_url'); ?>/assets/img/portfolio/folio01.jpg" alt="" class="image-popup"> -->
                            <p><?php the_content(); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
        $counter = $counter + 1;
        endwhile;
        ?>
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
$params = array('posts_per_page' => 2, 'orderby' => 'date', 'order' => 'DESC');
$myPosts = new WP_Query($params);
while ($myPosts->have_posts()): $myPosts->the_post();
?>
            <article class="blogitem">
                <aside class="blogauthor">
                    <br>
                    <p><img src="<?php bloginfo('template_url'); ?>/assets/img/team/u1.jpg" width="60px" height="60px"></p>
                    <h4><?php the_author(); ?></h4>
                    <h5><?php the_date(); ?></h5>
                </aside>
                <!--
					<section class="blogtext animator">
						<h2><?php the_title(); ?></h2>
						<?php the_content(); ?>
                            <p><a href="#"> Read More</a></p>
						<br>
					</section>
                    -->
                <section class="blogtext">
                    <h2><?php the_title(); ?></h2>
                    <div>
                        <?php the_excerpt(); ?>
                        <span onclick="displaySinglePost('<?php the_permalink(); ?>', 'post-<?php the_ID(); ?>')"> Read More</span>
                    </div>
                    <br>
                </section>
            </article>
            <?php 
endwhile;
?>

            <nav id="blogpreviews">

                <?php 
$params = array('posts_per_page' => 3, 'orderby' => 'date', 'order' => 'DESC', 'offset' => 2);
$myPosts = new WP_Query($params);
while ($myPosts->have_posts()): $myPosts->the_post();
?>
                <aside class="blogpreview">
                    <p><?php the_title(); ?></p>
                    <p><?php the_date(); ?></p>
                    <!-- <p><a href="#"> Read More</a></p> -->
                    <p><span  onclick="displaySinglePost('<?php the_permalink(); ?>', 'post-<?php the_ID(); ?>')"> Read More</span></p>

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
$params = array('post_type' => 'page', post_name__in => array('Crafted'), 'orderby' => 'order', 'order' => 'ASC');
$myPosts = new WP_Query($params);
while ($myPosts->have_posts()): $myPosts->the_post();
the_content();
endwhile;
?> <?php get_footer(); ?>