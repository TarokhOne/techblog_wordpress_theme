<?php get_header(); ?>

<main class="contact-page">

    <section class="contact-section">

        <div class="contact-container">

            <h1 class="contact-title">
                Contact Us
            </h1>


            <?php if ( isset( $_GET['contact_status'] ) ) : ?>

                <?php if ( 'success' === $_GET['contact_status'] ) : ?>

                    <div class="contact-message contact-message-success">
                        Your message has been sent successfully.
                    </div>

                <?php elseif ( 'error' === $_GET['contact_status'] ) : ?>

                    <div class="contact-message contact-message-error">
                        Something went wrong. Please try again.
                    </div>

                <?php endif; ?>

            <?php endif; ?>


            <form
                class="contact-form"
                method="post"
                action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
            >

                <input
                    type="hidden"
                    name="action"
                    value="tech_blog_contact"
                >

                <?php wp_nonce_field( 'tech_blog_contact_form', 'tech_blog_contact_nonce' ); ?>


                <!-- Full Name -->

                <div class="contact-form-group">

                    <label for="contact-name">
                        Full Name
                    </label>

                    <input
                        type="text"
                        id="contact-name"
                        name="contact_name"
                        placeholder="Your full name"
                        required
                    >

                </div>


                <!-- Email -->

                <div class="contact-form-group">

                    <label for="contact-email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="contact-email"
                        name="contact_email"
                        placeholder="you@example.com"
                        required
                    >

                </div>


                <!-- Message -->

                <div class="contact-form-group">

                    <label for="contact-message">
                        Message
                    </label>

                    <textarea
                        id="contact-message"
                        name="contact_message"
                        rows="7"
                        placeholder="Write your message..."
                        required
                    ></textarea>

                </div>


                <!-- Submit -->

                <button
                    type="submit"
                    class="contact-submit"
                >

                    <i
                        class="fa-solid fa-paper-plane"
                        aria-hidden="true"
                    ></i>

                    <span>Send</span>

                </button>

            </form>

        </div>

    </section>

</main>

<?php get_footer(); ?>