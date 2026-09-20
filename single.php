<?php get_header(); ?>

<main class="single-post-page">

    <article class="single-post">

        <!-- =========================
             POST HEADER
        ========================== -->

        <header class="single-post-header">

            <?php $categories = get_the_category(); ?>

            <?php if ( ! empty( $categories ) ) : ?>

                <div class="single-post-category">
                    <?php echo esc_html( $categories[0]->name ); ?>
                </div>

            <?php endif; ?>


            <h1 class="single-post-title">
                <?php the_title(); ?>
            </h1>


            <div class="single-post-meta">

                <span>
                    By <?php echo esc_html( get_the_author() ); ?>
                </span>

                <span class="single-post-meta-divider">
                    •
                </span>

                <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                    <?php echo esc_html( get_the_date() ); ?>
                </time>

            </div>

        </header>


        <!-- =========================
             FEATURED IMAGE
        ========================== -->

        <?php if ( has_post_thumbnail() ) : ?>

            <div class="single-post-image">
                <?php the_post_thumbnail( 'full' ); ?>
            </div>

        <?php endif; ?>


        <!-- =========================
             POST CONTENT
        ========================== -->

        <div class="single-post-content">

            <?php the_content(); ?>

        </div>


        <!-- =========================
             POST NAVIGATION
        ========================== -->

        <nav
            class="single-post-navigation"
            aria-label="Post Navigation"
        >

            <div class="single-post-previous">
                <?php previous_post_link( '%link', '← %title' ); ?>
            </div>

            <div class="single-post-next">
                <?php next_post_link( '%link', '%title →' ); ?>
            </div>

        </nav>

    </article>

</main>

<?php get_footer(); ?>