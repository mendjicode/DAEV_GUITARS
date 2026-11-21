<?php get_header(); ?>
<main id="main-content" class="section entry" tabindex="-1">
	<div class="container">
		<?php if ( is_search() ) : ?>
			<h1 class="entry-title"><?php echo esc_html( 'Поиск: ' . get_search_query( false ) ); ?></h1>
		<?php elseif ( is_archive() ) : ?>
			<h1 class="entry-title"><?php echo wp_kses_post( get_the_archive_title() ); ?></h1>
		<?php else : ?>
			<h1 class="entry-title">Записи</h1>
		<?php endif; ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article class="entry-content">
				<h2><a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a></h2>
				<?php the_excerpt(); ?>
			</article>
		<?php endwhile; ?>
		<?php if ( ! $wp_query->post_count ) : ?><p>Записи не найдены.</p><?php endif; ?>
		<?php the_posts_pagination(); ?>
	</div>
</main>
<?php get_footer(); ?>
