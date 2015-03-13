
    <div class="row">
        	<div class="contain-to-grid">
                <nav class="top-bar" data-topbar data-options="mobile_show_parent_link: true">
                    <ul class="title-area">
											<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
													<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo/rml.png" alt="<?php bloginfo( 'name' ); ?>"> 
											</a>
                        <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
                        <li class="toggle-topbar menu-icon"><a href="#"><span><?php // _e( 'Menu', 'wpforge' ); ?></span></a></li>
                    </ul>
                    <section class="top-bar-section">
                        <?php
                        wp_nav_menu( array(
                            'theme_location' => 'primary',
                            'container' => false,
                            'depth' => 0,
                            'items_wrap' => '<ul class="left">%3$s</ul>',
                            'fallback_cb' => 'wpforge_menu_fallback', // workaround to show a message to set up a menu
                            'walker' => new wpforge_walker( array(
                                'in_top_bar' => true,
                                'item_type' => 'li',
                                'menu_type' => 'main-menu'
                            ) ),
                        ) );
                        ?>
                    </section>
                </nav>
            </div><!-- contain-to-grid sticky -->
    </div><!-- .row -->