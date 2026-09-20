<?php get_header(); ?>

<main class="blogs-page">

    <section class="blogs-section">

        <?php

        /*
         * Get the current category.
         *
         * If no category is selected,
         * show all non-featured posts.
         */

        $current_category = isset( $_GET['category'] )
            ? sanitize_title( wp_unslash( $_GET['category'] ) )
            : '';

        ?>


        <!-- =========================
             BLOG CATEGORY TABS
        ========================== -->

        <div class="blog-tabs">

            <a
                class="blog-tab <?php echo empty( $current_category ) ? 'active' : ''; ?>"
                href="<?php echo esc_url( get_permalink() ); ?>"
            >
                All
            </a>


            <?php
            $blog_categories = get_categories(
                array(
                    'hide_empty' => true,
                    'exclude'    => get_category_by_slug( 'featured' )
                        ? get_category_by_slug( 'featured' )->term_id
                        : 0,
                )
            );
            ?>


            <?php foreach ( $blog_categories as $category ) : ?>

                <a
                    class="blog-tab <?php echo $current_category === $category->slug ? 'active' : ''; ?>"
                    href="<?php echo esc_url(
                        add_query_arg(
                            'category',
                            $category->slug,
                            get_permalink()
                        )
                    ); ?>"
                >

                    <?php echo esc_html( $category->name ); ?>

                </a>

            <?php endforeach; ?>

        </div>


        <!-- =========================
             BLOG POSTS
        ========================== -->

        <?php

        $blogs_per_page = 5;

        $paged = max(
            1,
            get_query_var( 'paged' ),
            get_query_var( 'page' )
        );


        $blog_query_args = array(
            'post_status'    => 'publish',
            'posts_per_page' => $blogs_per_page,
            'paged'          => $paged,
        );


        /*
         * Always exclude Featured.
         */

        $featured_category = get_category_by_slug( 'featured' );

        if ( $featured_category ) {

            $blog_query_args['category__not_in'] = array(
                $featured_category->term_id,
            );

        }


        /*
         * If a category tab is selected,
         * only show that category.
         */

        if ( ! empty( $current_category ) ) {

            $selected_category = get_category_by_slug(
                $current_category
            );

            if ( $selected_category ) {

                $blog_query_args['cat'] = $selected_category->term_id;

            }

        }


        $blogs_query = new WP_Query( $blog_query_args );

        ?>


        <?php if ( $blogs_query->have_posts() ) : ?>

            <div class="news-posts">

                <?php while ( $blogs_query->have_posts() ) : ?>

                    <?php $blogs_query->the_post(); ?>

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

            <?php if ( $blogs_query->max_num_pages > 1 ) : ?>

                <nav
                    class="news-pagination"
                    aria-label="Blog Pagination"
                >

                    <?php
                    echo paginate_links(
                        array(
                            'total'     => $blogs_query->max_num_pages,
                            'current'   => $paged,
                            'mid_size'  => 2,
                            'prev_text' => '← Previous',
                            'next_text' => 'Next →',
                        )
                    );
                    ?>

                </nav>

            <?php endif; ?>


        <?php else : ?>

            <p class="blogs-empty">
                No posts found in this category.
            </p>

        <?php endif; ?>


        <?php wp_reset_postdata(); ?>

    </section>

</main>

<?php get_footer(); ?>