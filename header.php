<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

    <meta charset="<?php bloginfo( 'charset' ); ?>">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<header class="site-header">

    <div class="header-container">

        <a
            class="site-logo"
            href="<?php echo esc_url( home_url( '/' ) ); ?>"
        >
            TechNova
        </a>


        <nav
            class="main-navigation"
            aria-label="Primary Navigation"
        >

            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'nav-menu',
                )
            );
            ?>

        </nav>


        <button
            class="mobile-menu-toggle"
            type="button"
            aria-label="Open menu"
            aria-expanded="false"
        >

            <span></span>
            <span></span>
            <span></span>

        </button>

    </div>

</header>