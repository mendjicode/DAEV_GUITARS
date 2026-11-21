<?php
/**
 * Portfolio, services and service fields.
 */
function daev_register_content() {
	register_post_type( 'daev_work', array(
		'labels' => array(
			'name' => 'Работы', 'singular_name' => 'Работа', 'add_new_item' => 'Добавить работу',
			'edit_item' => 'Редактировать работу', 'view_item' => 'Посмотреть работу',
			'not_found' => 'Работы не найдены', 'all_items' => 'Все работы',
		),
		'public'       => true,
		'has_archive'  => true,
		'rewrite'      => array( 'slug' => 'raboty', 'with_front' => false ),
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-format-gallery',
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
	) );

	register_post_type( 'daev_service', array(
		'labels' => array(
			'name' => 'Услуги', 'singular_name' => 'Услуга', 'add_new_item' => 'Добавить услугу',
			'edit_item' => 'Редактировать услугу', 'view_item' => 'Посмотреть услугу',
			'not_found' => 'Услуги не найдены', 'all_items' => 'Все услуги',
		),
		'public'       => true,
		'rewrite'      => array( 'slug' => 'uslugi', 'with_front' => false ),
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-hammer',
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
	) );
}
add_action( 'init', 'daev_register_content' );

function daev_service_destinations() {
	return array( '' => 'Страница услуги', 'prices' => 'Прайс', 'portfolio' => 'Портфолио', 'contact' => 'Контакты' );
}

function daev_add_service_box() {
	add_meta_box( 'daev-service-options', 'Карточка и цена', 'daev_service_box', 'daev_service', 'side' );
}
add_action( 'add_meta_boxes_daev_service', 'daev_add_service_box' );

function daev_service_box( $post ) {
	wp_nonce_field( 'daev_save_service', 'daev_service_nonce' );
	?>
	<p>
		<label><input type="checkbox" name="daev_show_card" value="1" <?php checked( get_post_meta( $post->ID, '_daev_show_card', true ), '1' ); ?>>
			Показывать карточку в разделе «Услуги»</label>
	</p>
	<p>
		<label for="daev_service_target">Куда ведёт карточка</label>
		<select id="daev_service_target" name="daev_service_target">
			<?php foreach ( daev_service_destinations() as $key => $label ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( get_post_meta( $post->ID, '_daev_service_target', true ), $key ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="daev_service_price">Цена</label>
		<input type="text" class="widefat" id="daev_service_price" name="daev_service_price" value="<?php echo esc_attr( get_post_meta( $post->ID, '_daev_service_price', true ) ); ?>" aria-describedby="daev-price-help">
		<span class="description" id="daev-price-help">Введите цену так, как её увидит посетитель, с валютой или уточнением. Пустое поле скрывает строку из прайса.</span>
	</p>
	<?php
}

function daev_save_service( $post_id ) {
	$nonce = isset( $_POST['daev_service_nonce'] ) && is_string( $_POST['daev_service_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['daev_service_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'daev_save_service' ) ||
		wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ||
		! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$price = isset( $_POST['daev_service_price'] ) && is_string( $_POST['daev_service_price'] ) ? sanitize_text_field( wp_unslash( $_POST['daev_service_price'] ) ) : '';
	$target = isset( $_POST['daev_service_target'] ) && is_string( $_POST['daev_service_target'] ) ? sanitize_key( wp_unslash( $_POST['daev_service_target'] ) ) : '';
	update_post_meta( $post_id, '_daev_show_card', isset( $_POST['daev_show_card'] ) ? '1' : '0' );
	update_post_meta( $post_id, '_daev_service_target', array_key_exists( $target, daev_service_destinations() ) ? $target : '' );
	if ( '' === $price ) {
		delete_post_meta( $post_id, '_daev_service_price' );
	} else {
		update_post_meta( $post_id, '_daev_service_price', wp_slash( $price ) );
	}
}
add_action( 'save_post_daev_service', 'daev_save_service' );

function daev_install_starter_content() {
	if ( ! add_option( 'daev_starter_content', 'installing', '', false ) ) {
		return;
	}
	$starter = array(
		'repair' => array( 'Ремонт и настройка', 'Отстройка, замена ладов, электроника, ремонт трещин и восстановление сложных повреждений.', 'prices' ),
		'custom' => array( 'Изготовление гитар', 'Акустические и электрогитары по индивидуальным пожеланиям и вдохновению классическими образцами.', 'portfolio' ),
		'learn'  => array( 'Обучение мастерству', 'Передача опыта и обучение тех, кто хочет освоить изготовление музыкальных инструментов.', 'contact' ),
	);
	$complete = true;
	$order = 0;
	foreach ( $starter as $slug => list( $title, $description, $target ) ) {
		++$order;
		if ( get_page_by_path( $slug, OBJECT, 'daev_service' ) ) {
			continue;
		}
		$id = wp_insert_post( array(
			'post_type'    => 'daev_service',
			'post_name'    => $slug,
			'post_title'   => $title,
			'post_content' => '<!-- wp:paragraph --><p>' . esc_html( $description ) . '</p><!-- /wp:paragraph -->',
			'post_status'  => 'publish',
			'menu_order'   => $order,
			'meta_input'   => array(
				'_daev_show_card'      => '1',
				'_daev_service_target' => $target,
				'_daev_illustration'   => $slug,
			),
		), true );
		$complete = $complete && ! is_wp_error( $id );
	}

	if ( $complete ) {
		update_option( 'daev_starter_content', 'installed' );
	} else {
		delete_option( 'daev_starter_content' );
	}
}
add_action( 'after_switch_theme', 'daev_install_starter_content' );
