<?php
$illustrations = array(
	'repair'       => 'Характер инструмента',
	'acoustic'     => 'Форма и материал',
	'instruments'  => 'За каждым звуком',
);
?>
<div class="gallery">
	<?php foreach ( $illustrations as $name => $caption ) : ?>
		<div class="gallery-item reveal">
			<img src="<?php echo esc_url( daev_bundled_image( $name ) ); ?>" alt="" loading="lazy" decoding="async">
			<div class="gallery-caption"><small>Иллюстрация</small><strong><?php echo esc_html( $caption ); ?></strong></div>
		</div>
	<?php endforeach; ?>
</div>
<p class="gallery-note">Фотографии с Unsplash иллюстрируют оформление галереи. Работы мастерской появятся здесь после публикации.</p>
