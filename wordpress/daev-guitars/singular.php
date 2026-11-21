<?php get_header(); ?>
<main id="main-content" class="section entry" tabindex="-1">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
			<article>
				<h1 class="entry-title"><?php echo esc_html( get_the_title() ); ?></h1>
				<?php if ( ! post_password_required() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'class' => 'entry-cover' ) ); ?>
					<?php
					$price = 'daev_service' === get_post_type() ? get_post_meta( get_the_ID(), '_daev_service_price', true ) : '';
					if ( '' !== $price ) :
						?>
						<p><strong>Цена</strong> <?php echo esc_html( $price ); ?></p>
					<?php endif; ?>
				<?php endif; ?>
				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				</div>
			</article>
			<?php if ( 'daev_work' === get_post_type() ) : ?>
				<a class="btn entry-back" href="<?php echo esc_url( get_post_type_archive_link( 'daev_work' ) ); ?>">Все работы ↗</a>
			<?php elseif ( 'daev_service' === get_post_type() ) : ?>
				<a class="btn entry-back" href="<?php echo esc_url( daev_home_anchor( 'services' ) ); ?>">Услуги мастерской ↗</a>
				<a class="btn entry-back" href="<?php echo esc_url( daev_home_anchor( 'contact' ) ); ?>">Связаться ↗</a>
			<?php endif; ?>
		<?php endwhile; ?>
	</div>
</main>
<?php get_footer(); ?>
