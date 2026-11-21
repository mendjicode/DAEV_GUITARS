<footer class="footer">
	<div class="container footer-row">
		<?php get_template_part( 'template-parts/logo' ); ?>
		<span class="footnote">DAEV GUITARS · <?php echo esc_html( wp_date( 'Y' ) ); ?></span>
		<nav class="footer-links" aria-label="Навигация в подвале">
			<a href="<?php echo esc_url( daev_home_anchor( 'services' ) ); ?>">Услуги</a>
			<a href="<?php echo esc_url( daev_home_anchor( 'portfolio' ) ); ?>">Работы</a>
			<a href="<?php echo esc_url( daev_home_anchor( 'contact' ) ); ?>">Контакты</a>
		</nav>
	</div>
</footer>
<button type="button" id="toTop" aria-label="Наверх" title="Наверх" hidden>↑</button>
<?php wp_footer(); ?>
</body>
</html>
