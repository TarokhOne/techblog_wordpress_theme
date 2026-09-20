<?php get_header(); ?>

<main class="home-page">

    <!-- =========================
         FEATURED POSTS GRID
    ========================== -->

    <section class="posts-grid">

        <?php
        $tech_blog_query = new WP_Query(
            array(
                'posts_per_page' => 5,
                'post_status'    => 'publish',
                'category_name'  => 'featured',
            )
        );
        ?>

        <?php if ( $tech_blog_query->have_posts() ) : ?>

            <?php $post_number = 1; ?>

            <?php while ( $tech_blog_query->have_posts() ) : ?>

                <?php $tech_blog_query->the_post(); ?>

                <article class="grid-card card-<?php echo esc_attr( $post_number ); ?>">

                    <a
                        class="grid-card-link"
                        href="<?php the_permalink(); ?>"
                    >

                        <?php if ( has_post_thumbnail() ) : ?>

                            <?php the_post_thumbnail( 'large' ); ?>

                        <?php endif; ?>

                        <div class="grid-card-overlay">

                            <h2>
                                <?php the_title(); ?>
                            </h2>

                        </div>

                    </a>

                </article>

                <?php $post_number++; ?>

            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>

        <?php endif; ?>

    </section>


    <!-- =========================
         NEWS SETTINGS
    ========================== -->

    <?php
    $news_alignment = get_theme_mod(
        'news_title_alignment',
        'left'
    );

    $news_show_divider = get_theme_mod(
        'news_show_divider',
        true
    );

    $news_divider_width = get_theme_mod(
        'news_divider_width',
        'full'
    );

    $news_section_title = get_theme_mod(
        'news_section_title',
        'News'
    );

    $news_posts_per_page = max(
        1,
        (int) get_theme_mod(
            'news_posts_per_page',
            5
        )
    );


    /*
     * Current pagination page.
     */

    $paged = max(
        1,
        (int) get_query_var( 'paged' ),
        (int) get_query_var( 'page' )
    );


    /*
     * Build News query.
     *
     * Featured posts are excluded.
     */

    $news_query_args = array(
        'post_status'    => 'publish',
        'posts_per_page' => $news_posts_per_page,
        'paged'          => $paged,
    );


    /*
     * Get Featured category.
     */

    $featured_category = get_category_by_slug( 'featured' );


    /*
     * Exclude Featured posts from News.
     */

    if ( $featured_category ) {

        $news_query_args['category__not_in'] = array(
            $featured_category->term_id,
        );

    }


    $news_query = new WP_Query( $news_query_args );
    ?>


    <!-- =========================
         NEWS SECTION
    ========================== -->

    <section class="news-section">

        <!-- News heading -->

        <div
            class="
                news-heading
                news-heading-<?php echo esc_attr( $news_alignment ); ?>
            "
        >

            <h3>
                <?php echo esc_html( $news_section_title ); ?>
            </h3>

            <?php if ( $news_show_divider ) : ?>

                <div
                    class="
                        news-divider
                        news-divider-<?php echo esc_attr( $news_divider_width ); ?>
                    "
                ></div>

            <?php endif; ?>

        </div>


        <!-- =========================
             NEWS POSTS
        ========================== -->

        <?php if ( $news_query->have_posts() ) : ?>

            <div class="news-posts">

                <?php while ( $news_query->have_posts() ) : ?>

                    <?php $news_query->the_post(); ?>

                    <article class="news-post">

                        <!-- Post Image -->

                        <a
                            class="news-post-image"
                            href="<?php the_permalink(); ?>"
                        >

                            <?php if ( has_post_thumbnail() ) : ?>

                                <?php the_post_thumbnail( 'medium_large' ); ?>

                            <?php else : ?>

                                <div class="news-post-image-placeholder">
                                    No Image
                                </div>

                            <?php endif; ?>

                        </a>


                        <!-- Post Information -->

                        <div class="news-post-content">

                            <?php
                            $categories = get_the_category();
                            ?>

                            <?php if ( ! empty( $categories ) ) : ?>

                                <div class="news-post-category">

                                    <?php echo esc_html( $categories[0]->name ); ?>

                                </div>

                            <?php endif; ?>


                            <h2 class="news-post-title">

                                <a href="<?php the_permalink(); ?>">

                                    <?php the_title(); ?>

                                </a>

                            </h2>


                            <p class="news-post-excerpt">

                                <?php
                                echo esc_html(
                                    wp_trim_words(
                                        get_the_excerpt(),
                                        25,
                                        '...'
                                    )
                                );
                                ?>

                            </p>


                            <div class="news-post-author">

                                By <?php echo esc_html( get_the_author() ); ?>

                            </div>

                        </div>

                    </article>

                <?php endwhile; ?>

            </div>


            <!-- =========================
                 PAGINATION
            ========================== -->

            <?php if ( $news_query->max_num_pages > 1 ) : ?>

                <nav
                    class="news-pagination"
                    aria-label="News Pagination"
                >

                    <?php
                    echo paginate_links(
                        array(
                            'base'      => str_replace(
                                999999999,
                                '%#%',
                                esc_url(
                                    get_pagenum_link( 999999999 )
                                )
                            ),
                            'format'    => '?paged=%#%',
                            'current'   => $paged,
                            'total'     => $news_query->max_num_pages,
                            'mid_size'  => 2,
                            'prev_text' => '← Previous',
                            'next_text' => 'Next →',
                        )
                    );
                    ?>

                </nav>

            <?php endif; ?>

        <?php endif; ?>


        <?php wp_reset_postdata(); ?>

    </section>

</main>

<?php get_footer(); ?>