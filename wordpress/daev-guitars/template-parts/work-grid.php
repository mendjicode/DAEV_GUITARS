<?php $mosaic = count( $args['works'] ) >= 3 ? ' gallery-mosaic' : ''; ?>
<div class="gallery work-gallery<?php echo esc_attr( $mosaic ); ?>">
	<?php foreach ( $args['works'] as $work ) :
		$has_thumb = ! post_password_required( $work ) && has_post_thumbnail( $work );
		?>
		<a class="gallery-item reveal<?php echo $has_thumb ? '' : ' no-image'; ?>" href="<?php echo esc_url( get_permalink( $work ) ); ?>">
			<?php if ( $has_thumb ) : ?>
				<?php echo get_the_post_thumbnail( $work, 'large', array( 'alt' => '', 'loading' => 'lazy', 'sizes' => '(max-width: 520px) 100vw, 57vw' ) ); ?>
			<?php endif; ?>
			<div class="gallery-caption">
				<small>Работы мастерской</small>
				<strong><?php echo esc_html( get_the_title( $work ) ); ?></strong>
			</div>
		</a>
	<?php endforeach; ?>
</div>
