<?php

/* =========================
   THEME SETUP
========================= */

function tech_blog_setup() {

    add_theme_support( 'post-thumbnails' );

    register_nav_menus(
        array(
            'primary' => 'Primary Menu',
        )
    );

}

add_action( 'after_setup_theme', 'tech_blog_setup' );


/* =========================
   ENQUEUE STYLES & SCRIPTS
========================= */

function tech_blog_enqueue_assets() {

    wp_enqueue_style(
        'tech-blog-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
        array(),
        '6.5.2'
    );

    wp_enqueue_style(
        'tech-blog-style',
        get_stylesheet_uri(),
        array(),
        '1.0'
    );

    wp_enqueue_script(
        'tech-blog-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0',
        true
    );

}

add_action( 'wp_enqueue_scripts', 'tech_blog_enqueue_assets' );


/* =========================
   CUSTOMIZER
========================= */

function tech_blog_customize_register( $wp_customize ) {


    /* =========================
       NEWS SECTION
    ========================= */

    $wp_customize->add_section(
        'news_section',
        array(
            'title'    => 'News Section',
            'priority' => 30,
        )
    );


    /* =========================
       SECTION TITLE
    ========================= */

    $wp_customize->add_setting(
        'news_section_title',
        array(
            'default'           => 'News',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'news_section_title',
        array(
            'label'       => 'Section Title',
            'description' => 'Change the title displayed above the News posts.',
            'section'     => 'news_section',
            'type'        => 'text',
        )
    );


    /* =========================
       TITLE ALIGNMENT
    ========================= */

    $wp_customize->add_setting(
        'news_title_alignment',
        array(
            'default'           => 'left',
            'sanitize_callback' => 'sanitize_key',
        )
    );

    $wp_customize->add_control(
        'news_title_alignment',
        array(
            'label'   => 'Title Alignment',
            'section' => 'news_section',
            'type'    => 'select',
            'choices' => array(
                'left'   => 'Left',
                'center' => 'Center',
                'right'  => 'Right',
            ),
        )
    );


    /* =========================
       SHOW DIVIDER
    ========================= */

    $wp_customize->add_setting(
        'news_show_divider',
        array(
            'default'           => true,
            'sanitize_callback' => 'wp_validate_boolean',
        )
    );

    $wp_customize->add_control(
        'news_show_divider',
        array(
            'label'   => 'Show Divider',
            'section' => 'news_section',
            'type'    => 'checkbox',
        )
    );


    /* =========================
       DIVIDER WIDTH
    ========================= */

    $wp_customize->add_setting(
        'news_divider_width',
        array(
            'default'           => 'full',
            'sanitize_callback' => 'sanitize_key',
        )
    );

    $wp_customize->add_control(
        'news_divider_width',
        array(
            'label'   => 'Divider Width',
            'section' => 'news_section',
            'type'    => 'select',
            'choices' => array(
                'full'  => 'Full Width',
                'short' => 'Short',
            ),
        )
    );


    /* =========================
       POSTS PER PAGE
    ========================= */

    $wp_customize->add_setting(
        'news_posts_per_page',
        array(
            'default'           => 5,
            'sanitize_callback' => 'absint',
        )
    );

    $wp_customize->add_control(
        'news_posts_per_page',
        array(
            'label'       => 'Posts Per Page',
            'description' => 'Choose how many News posts appear on each page.',
            'section'     => 'news_section',
            'type'        => 'number',
            'input_attrs' => array(
                'min'  => 1,
                'max'  => 50,
                'step' => 1,
            ),
        )
    );

}

add_action( 'customize_register', 'tech_blog_customize_register' );


/* =========================
   CONTACT FORM
========================= */

function tech_blog_handle_contact_form() {

    /*
     * Security check.
     */

    if (
        ! isset( $_POST['tech_blog_contact_nonce'] ) ||
        ! wp_verify_nonce(
            sanitize_text_field(
                wp_unslash( $_POST['tech_blog_contact_nonce'] )
            ),
            'tech_blog_contact_form'
        )
    ) {

        wp_die(
            'Security check failed.',
            'Contact Form Error',
            array(
                'response' => 403,
            )
        );

    }


    /*
     * Get and sanitize form data.
     */

    $name = isset( $_POST['contact_name'] )
        ? sanitize_text_field(
            wp_unslash( $_POST['contact_name'] )
        )
        : '';

    $email = isset( $_POST['contact_email'] )
        ? sanitize_email(
            wp_unslash( $_POST['contact_email'] )
        )
        : '';

    $message = isset( $_POST['contact_message'] )
        ? sanitize_textarea_field(
            wp_unslash( $_POST['contact_message'] )
        )
        : '';


    /*
     * Validate required fields.
     */

    if (
        empty( $name ) ||
        empty( $email ) ||
        empty( $message ) ||
        ! is_email( $email )
    ) {

        wp_safe_redirect(
            add_query_arg(
                'contact_status',
                'error',
                wp_get_referer()
            )
        );

        exit;

    }


    /*
     * Email destination.
     *
     * Uses the WordPress admin email.
     */

    $to = get_option( 'admin_email' );


    /*
     * Email subject.
     */

    $subject = 'New Contact Form Message';


    /*
     * Email body.
     */

    $body = "You received a new message from your website.\n\n";

    $body .= "Name: " . $name . "\n";

    $body .= "Email: " . $email . "\n\n";

    $body .= "Message:\n";

    $body .= $message;


    /*
     * Email headers.
     */

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    );


    /*
     * Send email.
     */

    $sent = wp_mail(
        $to,
        $subject,
        $body,
        $headers
    );


    /*
     * Redirect after submission.
     */

    if ( $sent ) {

        wp_safe_redirect(
            add_query_arg(
                'contact_status',
                'success',
                wp_get_referer()
            )
        );

    } else {

        wp_safe_redirect(
            add_query_arg(
                'contact_status',
                'error',
                wp_get_referer()
            )
        );

    }

    exit;
}


/* =========================
   CONTACT FORM HOOKS
========================= */

/*
 * Logged-in users.
 */

add_action(
    'admin_post_tech_blog_contact',
    'tech_blog_handle_contact_form'
);


/*
 * Visitors who are not logged in.
 */

add_action(
    'admin_post_nopriv_tech_blog_contact',
    'tech_blog_handle_contact_form'
);