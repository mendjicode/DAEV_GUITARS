<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#171712">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="top"></div>
<a class="skip-link" href="#main-content">К содержимому</a>
<?php
$topline = array_filter( array( daev_setting( 'address' ), daev_setting( 'hours' ) ) );
$phone_url = daev_phone_url();
$navigation = array(
	'about' => 'О мастерской',
	'services' => 'Услуги',
	'portfolio' => 'Проекты',
	'prices' => 'Ремонт и цены',
	'contact' => 'Контакты',
);
?>
<?php if ( $topline ) : ?>
	<div class="topline"><?php echo esc_html( implode( ' · ', $topline ) ); ?></div>
<?php endif; ?>
<header class="header">
	<div class="container navrow">
		<?php get_template_part( 'template-parts/logo' ); ?>
		<nav class="links" id="menu" aria-label="Основная навигация">
			<?php foreach ( $navigation as $target => $label ) : ?>
				<a href="<?php echo esc_url( daev_home_anchor( $target ) ); ?>"><?php echo esc_html( $label ); ?></a>
			<?php endforeach; ?>
		</nav>
		<div class="headright">
			<?php if ( $phone_url ) : ?>
				<a class="phone" href="<?php echo esc_url( $phone_url ); ?>"><?php echo esc_html( daev_setting( 'phone' ) ); ?></a>
			<?php endif; ?>
			<a class="btn" href="<?php echo esc_url( daev_home_anchor( 'contact' ) ); ?>">Связаться ↗</a>
			<button type="button" class="navmenu" id="toggle" aria-label="Меню" aria-controls="menu" aria-expanded="false" hidden>☰</button>
		</div>
	</div>
</header>
