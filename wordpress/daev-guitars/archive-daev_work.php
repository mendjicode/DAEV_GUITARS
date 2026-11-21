<?php get_header(); ?>
<main id="main-content" class="section portfolio" tabindex="-1">
	<div class="container">
		<h1 class="entry-title">Работы мастерской</h1>
		<?php if ( have_posts() ) : ?>
			<?php get_template_part( 'template-parts/work-grid', null, array( 'works' => $wp_query->posts ) ); ?>
			<?php the_posts_pagination( array( 'screen_reader_text' => 'Страницы портфолио' ) ); ?>
		<?php else : ?>
			<p>Здесь появятся опубликованные работы мастерской.</p>
		<?php endif; ?>
		<a class="btn entry-back" href="<?php echo esc_url( daev_home_anchor( 'portfolio' ) ); ?>">На главную ↗</a>
	</div>
</main>
<?php get_footer(); ?>
