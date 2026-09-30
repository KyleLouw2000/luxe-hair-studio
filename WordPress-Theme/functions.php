<?php
if (!defined('ABSPATH')) {
    exit;
}

// Enable WordPress page titles and editor features.
function luxe_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('html5', array('search-form', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'luxe_theme_setup');

// Load the theme stylesheet.
function luxe_load_styles() {
    wp_enqueue_style(
        'luxe-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'luxe_load_styles');

// Find a page URL without depending on permalink settings.
function luxe_page_url($slug) {
    $page = get_page_by_path($slug, OBJECT, 'page');
    return $page ? get_permalink($page->ID) : home_url('/');
}

// Create starter pages once, on theme activation.
function luxe_create_pages() {
    if (get_option('luxe_starter_complete')) {
        return;
    }

    $home = <<<'HTML'
<section class="hero">
  <div class="hero-copy">
    <div>
      <p class="eyebrow">Welcome to LUXE Hair Studio</p>
      <h1>A fresh look starts here.</h1>
      <p class="muted">Thoughtful hair services in a relaxed space. Come as you are and leave feeling ready for whatever comes next.</p>
      <div class="actions">
        <a class="button" href="{{booking}}">Book an Appointment</a>
        <a class="button outline" href="{{services}}">Explore Services</a>
      </div>
    </div>
  </div>
  <img class="hero-photo" src="https://images.unsplash.com/photo-1560066984-138dadb4c035?w=1400&q=85" alt="Bright modern hair salon interior">
</section>

<section class="section white center">
  <div class="wrap">
    <div class="narrow">
      <p class="eyebrow">The LUXE experience</p>
      <h2>Good hair. Good company.</h2>
      <p class="muted">LUXE is a welcoming hair studio for everyone. We listen to what you want, offer honest guidance and take care with every cut, colour and style. Your appointment is time set aside just for you.</p>
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <p class="eyebrow">What we do</p>
    <h2>Our most loved services</h2>
    <div class="grid-three">
      <article class="card">
        <img class="card-photo" src="https://images.unsplash.com/photo-1599351431202-1e0f0137899a?w=800&q=80" alt="Haircut service" loading="lazy">
        <p class="eyebrow">From R280</p>
        <h3>Cut &amp; Finish</h3>
        <p>A tailored cut, wash and finish that works with your style.</p>
        <a class="button" href="{{booking}}">Book Now</a>
      </article>
      <article class="card">
        <img class="card-photo" src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=800&q=80" alt="Salon hair service" loading="lazy">
        <p class="eyebrow">From R650</p>
        <h3>Colour Refresh</h3>
        <p>Rich colour or a subtle change, planned with your stylist.</p>
        <a class="button" href="{{booking}}">Book Now</a>
      </article>
      <article class="card">
        <img class="card-photo" src="https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?w=800&q=80" alt="Hair styling in a salon" loading="lazy">
        <p class="eyebrow">From R250</p>
        <h3>Wash &amp; Style</h3>
        <p>An easy refresh or a polished look for your next occasion.</p>
        <a class="button" href="{{booking}}">Book Now</a>
      </article>
    </div>
  </div>
</section>

<section class="section dark">
  <div class="wrap">
    <p class="eyebrow">Why LUXE?</p>
    <h2>The details make the difference.</h2>
    <div class="grid-three">
      <div><span class="number">01</span><h3>We listen first</h3><p>We talk through your ideas before getting started.</p></div>
      <div><span class="number">02</span><h3>Made for you</h3><p>Our recommendations fit your hair, routine and preferences.</p></div>
      <div><span class="number">03</span><h3>Easy to book</h3><p>Choose a service and request your appointment online.</p></div>
    </div>
  </div>
</section>

<section class="section white">
  <div class="wrap">
    <p class="eyebrow center">Client experiences</p>
    <h2 class="center">Words from our clients</h2>
    <div class="grid-two">
      <blockquote class="card sand"><p>“I felt listened to, and my new cut is so easy to manage.”</p><cite>— Sam, sample client</cite></blockquote>
      <blockquote class="card sand"><p>“Such a welcoming space. I left with exactly the style I asked for.”</p><cite>— Jordan, sample client</cite></blockquote>
    </div>
    <p class="small muted center">Sample testimonials for this student project.</p>
  </div>
</section>
HTML;

    $services = '<p class="eyebrow">Explore the menu</p>
    <h2>Salon services</h2>
    <p class="muted">Starting prices are shown below. Final pricing may vary by hair length and the service discussed during your appointment.</p>
    <div class="grid-three">';

    $service_list = array(
        array('Cut & Finish', 280, 60, 'A consultation, wash, tailored haircut and finished style.'),
        array('Express Trim', 180, 30, 'A quick tidy-up to maintain your current haircut.'),
        array('Colour Refresh', 650, 120, 'Refresh your colour or explore a new shade with your stylist.'),
        array('Highlights', 850, 150, 'Add dimension and brightness to your look.'),
        array('Wash & Style', 250, 45, 'A refreshing wash and finished style for any occasion.'),
        array('Hair Treatment', 320, 45, 'Extra care selected according to your hair’s needs.')
    );

    foreach ($service_list as $service) {
        $services .= '<article class="card">
            <h3>' . esc_html($service[0]) . '</h3>
            <p>' . esc_html($service[3]) . '</p>
            <p class="price">From R' . esc_html($service[1]) . '</p>
            <p>Approximately ' . esc_html($service[2]) . ' minutes</p>
            <a class="button" href="{{booking}}">Book Now</a>
        </article>';
    }
    $services .= '</div>';

    $about = <<<'HTML'
<div class="grid-two">
  <div>
    <p class="eyebrow">Our story</p>
    <h2>A space to feel at home.</h2>
    <p>LUXE Hair Studio was imagined as a place where everyone can feel comfortable exploring their personal style. A great appointment starts with listening.</p>
    <p>Before the first cut or colour, we take time to understand what you want and how you like to wear your hair. Our goal is to make each visit relaxed, collaborative and enjoyable.</p>
  </div>
  <img class="story-photo" src="https://images.unsplash.com/photo-1560066984-138dadb4c035?w=1200&q=85" alt="Welcoming contemporary salon space">
</div>

<section class="section">
  <p class="eyebrow">What guides us</p>
  <h2>Our mission &amp; values</h2>
  <div class="grid-three">
    <article class="card"><span class="number">01</span><h3>Listen</h3><p>Your ideas and preferences shape the service we provide.</p></article>
    <article class="card"><span class="number">02</span><h3>Create</h3><p>We combine creativity and care to find a style that feels right for you.</p></article>
    <article class="card"><span class="number">03</span><h3>Welcome</h3><p>We aim to make every client feel at ease from the moment they arrive.</p></article>
  </div>
</section>

<section>
  <p class="eyebrow center">Meet the team</p>
  <h2 class="center">Your stylists</h2>
  <div class="grid-three">
    <article class="card center"><div class="team-initial">A</div><h3>Alex</h3><p><strong>Cuts &amp; styling</strong></p><p>Alex enjoys creating easy-to-wear styles tailored to each client.</p></article>
    <article class="card center"><div class="team-initial">J</div><h3>Jamie</h3><p><strong>Colour</strong></p><p>Jamie loves helping clients plan a colour that suits them.</p></article>
    <article class="card center"><div class="team-initial">T</div><h3>Taylor</h3><p><strong>Hair care &amp; styling</strong></p><p>Taylor focuses on thoughtful care and finishing details.</p></article>
  </div>
  <p class="small center muted">Example team profiles for this student project.</p>
</section>
HTML;

    $booking = <<<'HTML'
<h2>Book an appointment</h2>
<p>Choose your preferred service and appointment time.</p>
<!-- Add the booking plugin block below this introduction. -->

<h2>Contact LUXE</h2>
<p><strong>Location:</strong> Cape Town, South Africa.</p>
<p><strong>Opening hours:</strong> Monday–Friday: 09:00–17:00. Saturday: 09:00–15:00. Sunday: closed.</p>
<p>Have a question about our services? Use the contact form below.</p>
<!-- Add the contact form plugin block here. -->
HTML;

    $pages = array(
        'home' => array('Home', $home),
        'services' => array('Services', $services),
        'booking' => array('Booking & Contact', $booking),
        'about' => array('About Us', $about)
    );

    $ids = array();
    $created = array();

    foreach ($pages as $slug => $details) {
        $existing = get_page_by_path($slug, OBJECT, 'page');

        if ($existing) {
            $ids[$slug] = $existing->ID;
            continue;
        }

        $id = wp_insert_post(array(
            'post_title' => $details[0],
            'post_name' => $slug,
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_content' => '',
            'post_author' => get_current_user_id(),
            'comment_status' => 'closed'
        ), true);

        if (!is_wp_error($id) && $id) {
            $ids[$slug] = $id;
            $created[$slug] = $id;
        }
    }

    // Add links after all page IDs are available.
    foreach ($created as $slug => $id) {
        $content = $pages[$slug][1];

        foreach ($ids as $link_slug => $link_id) {
            $content = str_replace(
                '{{' . $link_slug . '}}',
                esc_url(get_permalink($link_id)),
                $content
            );
        }

        wp_update_post(array(
            'ID' => $id,
            'post_content' => $content
        ));
    }

    if (!empty($ids['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $ids['home']);
    }

    if (count($ids) === 4) {
        update_option('luxe_starter_complete', 1);
    }
}
add_action('after_switch_theme', 'luxe_create_pages');

// SEO titles and descriptions for the four main pages.
function luxe_seo_details() {
    if (is_front_page()) {
        return array(
            'title' => 'LUXE Hair Studio | Hair Salon in Cape Town',
            'description' => 'Explore cuts, colour, styling and hair treatments at LUXE Hair Studio in Cape Town. View our services and book your next appointment.'
        );
    }

    if (is_page('services')) {
        return array(
            'title' => 'Hair Services & Prices | LUXE Hair Studio',
            'description' => 'View LUXE Hair Studio services, including haircuts, highlights, colour and treatments. Explore starting prices in rands and book in Cape Town.'
        );
    }

    if (is_page('booking')) {
        return array(
            'title' => 'Book an Appointment | LUXE Hair Studio',
            'description' => 'Book your next hair appointment at LUXE Hair Studio in Cape Town. Choose a service, select an available time or contact us with a question.'
        );
    }

    if (is_page('about')) {
        return array(
            'title' => 'About Our Cape Town Salon | LUXE Hair Studio',
            'description' => 'Meet the team at LUXE Hair Studio and discover our approach to welcoming service, personal style and thoughtful hair care in Cape Town.'
        );
    }

    return array();
}

function luxe_seo_title($parts) {
    $details = luxe_seo_details();

    if (!empty($details)) {
        return array('title' => $details['title']);
    }

    return $parts;
}
add_filter('document_title_parts', 'luxe_seo_title');

function luxe_seo_description() {
    $details = luxe_seo_details();

    if (!empty($details)) {
        echo '<meta name="description" content="' .
            esc_attr($details['description']) . '">' . "\n";
    }
}
add_action('wp_head', 'luxe_seo_description');