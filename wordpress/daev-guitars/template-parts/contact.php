<?php
$phone_url = daev_phone_url();
$telegram = daev_setting( 'telegram' );
$website = daev_setting( 'website' );
$rows = array(
	array( 'Мастерская', daev_setting( 'address' ), '' ),
	array( 'Часы', daev_setting( 'hours' ), '' ),
	array( 'Телефон', $phone_url ? daev_setting( 'phone' ) : '', $phone_url ),
	array( 'Действующий сайт', wp_parse_url( $website, PHP_URL_HOST ), $website ),
);
?>
<section class="section cta" id="contact">
	<div class="container cta-grid">
		<div class="reveal">
			<div class="label">06 / Контакт</div>
			<h2 class="cta-title"><?php echo daev_lines( daev_setting( 'contact_title' ) ); ?> <span><?php echo daev_lines( daev_setting( 'contact_accent' ) ); ?></span></h2>
			<p class="cta-copy"><?php echo daev_lines( daev_setting( 'contact_copy' ) ); ?></p>
			<?php if ( $telegram ) : ?>
				<a class="btn fill" href="<?php echo esc_url( $telegram, array( 'https', 'http' ) ); ?>">Написать в Telegram ↗</a>
			<?php elseif ( $phone_url ) : ?>
				<a class="btn fill" href="<?php echo esc_url( $phone_url ); ?>">Позвонить ↗</a>
			<?php endif; ?>
		</div>
		<div class="cta-list reveal">
			<?php foreach ( $rows as list( $label, $value, $href ) ) : ?>
				<?php if ( ! $value ) { continue; } ?>
				<?php if ( $href ) : ?>
					<a href="<?php echo esc_url( $href ); ?>"><small><?php echo esc_html( $label ); ?></small><strong><?php echo esc_html( $value ); ?> ↗</strong></a>
				<?php else : ?>
					<div><small><?php echo esc_html( $label ); ?></small><strong><?php echo esc_html( $value ); ?></strong></div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
