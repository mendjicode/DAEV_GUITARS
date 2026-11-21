<?php $key = $args['key']; ?>
<div class="section-top reveal">
	<div>
		<div class="label"><?php echo esc_html( $args['label'] ); ?></div>
		<h2 class="section-title"><?php echo daev_lines( daev_setting( $key . '_title' ) ); ?> <em><?php echo daev_lines( daev_setting( $key . '_accent' ) ); ?></em></h2>
	</div>
	<p><?php echo daev_lines( daev_setting( $key . '_copy' ) ); ?></p>
</div>
