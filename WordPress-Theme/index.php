<?php
if (!defined('ABSPATH')) {
    exit;
}

$navigation = array(
    'home' => 'Home',
    'services' => 'Services',
    'booking' => 'Booking & Contact',
    'about' => 'About'
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content">Skip to content</a>

<header class="site-header">
    <nav class="wrap navbar" aria-label="Main navigation">
        <a class="logo" href="<?php echo esc_url(home_url('/')); ?>">
            LUXE<span>.</span>
        </a>

        <button class="menu-button"
                id="menu-button"
                type="button"
                aria-expanded="false"
                aria-controls="main-menu">
            Menu ☰
        </button>

        <div class="nav-links" id="main-menu">
            <?php foreach ($navigation as $slug => $label) :
                $active = ($slug === 'home' && is_front_page())
                    || ($slug !== 'home' && is_page($slug));
            ?>
                <a href="<?php echo esc_url(luxe_page_url($slug)); ?>"
                   <?php if ($active) echo 'aria-current="page"'; ?>>
                    <?php echo esc_html($label); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>
</header>

<main id="main-content">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>

            <?php if (!is_front_page()) : ?>
                <section class="page-heading dark">
                    <span class="eyebrow">LUXE Hair Studio</span>
                    <h1><?php the_title(); ?></h1>

                    <?php if (is_page('services')) : ?>
                        <p>Your hair, your way. Explore cuts, colour and care.</p>
                    <?php elseif (is_page('booking')) : ?>
                        <p>Make time for your next salon visit.</p>
                    <?php elseif (is_page('about')) : ?>
                        <p>A welcoming studio where good conversations and thoughtful service come together.</p>
                    <?php endif; ?>
                </section>
            <?php endif; ?>

            <div class="<?php echo is_front_page() ? 'home-content' : 'content-area'; ?>">
                <?php if (!is_front_page()) : ?>
                    <div class="wrap">
                <?php endif; ?>

                <?php the_content(); ?>

                <?php if (!is_front_page()) : ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php endwhile; ?>
    <?php else : ?>
        <section class="section wrap">
            <h1>Page not found</h1>
            <p>Please use the navigation to find the page you need.</p>
            <a class="button" href="<?php echo esc_url(home_url('/')); ?>">
                Back to Home
            </a>
        </section>
    <?php endif; ?>

    <?php if (!is_page('booking') && !is_404()) : ?>
        <section class="section sand center">
            <div class="wrap">
                <h2>Ready for your next appointment?</h2>
                <p>Choose a service and a time that works for you.</p>
                <a class="button" href="<?php echo esc_url(luxe_page_url('booking')); ?>">
                    Book an Appointment
                </a>
            </div>
        </section>
    <?php endif; ?>
</main>

<footer class="site-footer dark">
    <div class="wrap">
        <div class="footer-row">
            <div>
                <a class="logo" href="<?php echo esc_url(home_url('/')); ?>">
                    LUXE<span>.</span>
                </a>
                <p>Hair that feels like you.</p>
                <p>Cape Town, South Africa</p>
            </div>

            <nav class="footer-links" aria-label="Footer navigation">
                <?php foreach ($navigation as $slug => $label) : ?>
                    <a href="<?php echo esc_url(luxe_page_url($slug)); ?>">
                        <?php echo esc_html($label); ?>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <p class="footer-bottom">
            © <?php echo esc_html(wp_date('Y')); ?>
            LUXE Hair Studio. Student website project.
        </p>
    </div>
</footer>

<script>
const menuButton = document.getElementById("menu-button");
const menu = document.getElementById("main-menu");

menuButton.addEventListener("click", function () {
    const isOpen = menu.classList.toggle("open");
    menuButton.setAttribute("aria-expanded", String(isOpen));
});
</script>

<?php wp_footer(); ?>
</body>
</html>