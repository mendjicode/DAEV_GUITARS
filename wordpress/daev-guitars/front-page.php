<?php
get_header();
$hero_image = daev_image_id( 'hero_image' );
$workshop_image = daev_image_id( 'workshop_image' );
$services = get_posts( array(
	'post_type'      => 'daev_service',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC', 'ID' => 'ASC' ),
	'has_password'   => false,
) );
$cards = array();
$priced = array();
foreach ( $services as $service ) {
	if ( '1' === get_post_meta( $service->ID, '_daev_show_card', true ) ) {
		$cards[] = $service;
	}
	$price = get_post_meta( $service->ID, '_daev_service_price', true );
	if ( '' !== $price ) {
		$priced[ $service->ID ] = $price;
	}
}
$works = new WP_Query( array(
	'post_type'      => 'daev_work',
	'post_status'    => 'publish',
	'posts_per_page' => 9,
	'orderby'        => array( 'date' => 'DESC', 'ID' => 'DESC' ),
) );
?>
<main id="main-content" tabindex="-1">
	<section class="hero">
		<div class="hero-bg">
			<?php if ( $hero_image ) : ?>
				<?php echo wp_get_attachment_image( $hero_image, 'full', false, array( 'alt' => '', 'loading' => false, 'fetchpriority' => 'high', 'sizes' => '100vw' ) ); ?>
			<?php else : ?>
				<picture>
					<source media="(max-width: 790px)" srcset="<?php echo esc_url( daev_bundled_image( 'hero-small' ) ); ?>">
					<img src="<?php echo esc_url( daev_bundled_image( 'hero' ) ); ?>" alt="" fetchpriority="high">
				</picture>
			<?php endif; ?>
		</div>
		<div class="container hero-layout">
			<div class="hero-copy">
				<div class="hero-tag"><?php echo esc_html( daev_setting( 'hero_label' ) ); ?></div>
				<h1><?php echo daev_lines( daev_setting( 'hero_title' ) ); ?> <span><?php echo daev_lines( daev_setting( 'hero_accent' ) ); ?></span></h1>
				<p><?php echo daev_lines( daev_setting( 'hero_copy' ) ); ?></p>
				<div class="hero-actions">
					<a class="btn fill" href="#services">Услуги мастерской ↗</a>
					<a class="btn" href="#portfolio">Посмотреть работы ↗</a>
				</div>
				<?php if ( ! $hero_image ) : ?><p class="illustration-note">Фоновое фото — иллюстрация.</p><?php endif; ?>
			</div>
			<div class="hero-number" aria-hidden="true"><strong>DAEV<br>GUITARS</strong><small>РЕМЕСЛО И ЗВУК / SPB</small></div>
		</div>
		<div class="hero-bottom">
			<div class="container"><span>Ремонт / Реставрация / Изготовление</span><span>Листайте вниз ↓</span></div>
		</div>
		<div class="vertical" aria-hidden="true">INSTRUMENTS ARE STORIES</div>
	</section>
	<div class="strip" aria-hidden="true">
		<div class="strip-track">
			<?php for ( $repeat = 0; $repeat < 2; ++$repeat ) : ?>
				<div><span>REPAIR &amp; RESTORATION</span><i>✳</i><span>CUSTOM GUITARS</span><i>✳</i><span>LUTHIER WORKSHOP</span><i>✳</i><span>THE ART OF SOUND</span><i>✳</i></div>
			<?php endfor; ?>
		</div>
	</div>
	<section class="intro" id="about">
		<div class="container intro-grid">
			<div class="reveal">
				<div class="label">01 / Мастерская</div>
				<h2><?php echo daev_lines( daev_setting( 'about_title' ) ); ?> <em><?php echo daev_lines( daev_setting( 'about_accent' ) ); ?></em></h2>
			</div>
			<div class="intro-copy reveal">
				<p class="lead"><?php echo daev_lines( daev_setting( 'about_lead' ) ); ?></p>
				<?php echo daev_paragraphs( daev_setting( 'about_copy' ) ); ?>
				<?php if ( daev_setting( 'about_note' ) ) : ?>
					<div class="pill"><?php echo esc_html( daev_setting( 'about_note' ) ); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<section class="section services" id="services">
		<div class="container">
			<?php get_template_part( 'template-parts/section-heading', null, array( 'key' => 'services', 'label' => '02 / Направления' ) ); ?>
			<?php if ( $cards ) : ?>
				<div class="services-grid">
					<?php foreach ( $cards as $index => $card ) :
						$target = get_post_meta( $card->ID, '_daev_service_target', true );
						$illustration = get_post_meta( $card->ID, '_daev_illustration', true );
						$has_thumb = has_post_thumbnail( $card );
						$link_texts = array( 'prices' => 'Смотреть прайс', 'portfolio' => 'Смотреть портфолио', 'contact' => 'Задать вопрос' );
						$illustrated = ! $has_thumb && in_array( $illustration, array( 'repair', 'custom', 'learn' ), true );
						?>
						<a class="service reveal" href="<?php echo esc_url( isset( $link_texts[ $target ] ) ? '#' . $target : get_permalink( $card ) ); ?>">
							<?php if ( $has_thumb ) : ?>
								<?php echo get_the_post_thumbnail( $card, 'large', array( 'alt' => '', 'loading' => 'lazy', 'sizes' => '(max-width: 520px) 100vw, (max-width: 790px) 50vw, 33vw' ) ); ?>
							<?php elseif ( $illustrated ) : ?>
								<img src="<?php echo esc_url( daev_bundled_image( $illustration ) ); ?>" alt="" loading="lazy" decoding="async">
							<?php endif; ?>
							<div class="service-content">
								<span class="service-number"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?><?php if ( $illustrated ) : ?> / ИЛЛЮСТРАЦИЯ<?php endif; ?></span>
								<h3><?php echo esc_html( get_the_title( $card ) ); ?></h3>
								<p><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt( $card ) ), 28 ) ); ?></p>
								<span class="service-link"><?php echo esc_html( $link_texts[ $target ] ?? 'Подробнее' ); ?> ↗</span>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<section class="section portfolio" id="portfolio">
		<div class="container">
			<?php get_template_part( 'template-parts/section-heading', null, array( 'key' => 'portfolio', 'label' => '03 / Галерея' ) ); ?>
			<?php if ( $works->posts ) : ?>
				<?php get_template_part( 'template-parts/work-grid', null, array( 'works' => $works->posts ) ); ?>
				<?php if ( $works->max_num_pages > 1 ) : ?>
					<a class="btn entry-back" href="<?php echo esc_url( get_post_type_archive_link( 'daev_work' ) ); ?>">Все работы ↗</a>
				<?php endif; ?>
			<?php elseif ( daev_setting( 'portfolio_illustrations' ) ) : ?>
				<?php get_template_part( 'template-parts/illustrations' ); ?>
			<?php else : ?>
				<p>Здесь появятся опубликованные работы мастерской.</p>
			<?php endif; ?>
		</div>
	</section>
	<section class="section workshop">
		<div class="container workshop-layout">
			<div class="workshop-text reveal">
				<div class="label">04 / Подход</div>
				<h2 class="section-title"><?php echo daev_lines( daev_setting( 'workshop_title' ) ); ?> <em><?php echo daev_lines( daev_setting( 'workshop_accent' ) ); ?></em></h2>
				<?php echo daev_paragraphs( daev_setting( 'workshop_copy' ) ); ?>
				<a href="#contact" class="btn">Обсудить инструмент ↗</a>
			</div>
			<figure class="workshop-photo reveal">
				<?php if ( $workshop_image ) : ?>
					<?php echo wp_get_attachment_image( $workshop_image, 'large', false, array( 'loading' => 'lazy' ) ); ?>
				<?php else : ?>
					<img src="<?php echo esc_url( daev_bundled_image( 'acoustic' ) ); ?>" alt="Акустическая гитара крупным планом" loading="lazy" decoding="async">
					<figcaption class="illustration-note">Иллюстративная фотография</figcaption>
				<?php endif; ?>
			</figure>
		</div>
	</section>
	<section class="quote">
		<div class="container reveal">
			<div class="label">DAEV GUITARS / PHILOSOPHY</div>
			<h2 class="quote-title"><?php echo esc_html( daev_setting( 'quote_start' ) ); ?><br>
				<span><?php echo esc_html( daev_setting( 'quote_accent' ) ); ?></span><br>
				<?php echo esc_html( daev_setting( 'quote_end' ) ); ?></h2>
		</div>
	</section>
	<section class="section price" id="prices">
		<div class="container">
			<?php get_template_part( 'template-parts/section-heading', null, array( 'key' => 'prices', 'label' => '05 / Услуги и цены' ) ); ?>
			<?php if ( $priced ) : ?>
				<div class="price-table">
					<?php $index = 0; ?>
					<?php foreach ( $priced as $service_id => $price ) : ?>
						<a class="price-row" href="<?php echo esc_url( get_permalink( $service_id ) ); ?>">
							<span class="n" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', ++$index ) ); ?></span>
							<strong><?php echo esc_html( get_the_title( $service_id ) ); ?></strong>
							<span><?php echo esc_html( $price ); ?></span>
							<span class="arr" aria-hidden="true">↗</span>
						</a>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<p>Уточните стоимость в мастерской. <a class="text-link" href="#contact">Контакты ↗</a></p>
			<?php endif; ?>
			<?php if ( daev_setting( 'prices_note' ) ) : ?><p class="price-foot"><?php echo daev_lines( daev_setting( 'prices_note' ) ); ?></p><?php endif; ?>
		</div>
	</section>
	<?php get_template_part( 'template-parts/contact' ); ?>
</main>
<?php get_footer(); ?>
