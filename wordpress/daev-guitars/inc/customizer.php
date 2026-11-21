<?php
/**
 * Text, media and contact settings for the fixed homepage layout.
 */
function daev_home_fields() {
	static $sections = array(
		'hero' => array( 'Первый экран', array(
			'hero_label'  => array( 'Надпись над заголовком', 'Daev Guitars / Luthier workshop / Saint Petersburg' ),
			'hero_title'  => array( 'Заголовок', "У каждой\nгитары", 'textarea' ),
			'hero_accent' => array( 'Акцент заголовка', "своя\nистория.", 'textarea' ),
			'hero_copy'   => array( 'Описание', 'Мы помогаем инструментам снова звучать. Ремонтируем, реставрируем и создаём гитары на заказ, уделяя внимание каждой детали.', 'textarea' ),
			'hero_image'  => array( 'Фоновое фото', 0, 'image' ),
		) ),
		'about' => array( 'О мастерской', array(
			'about_title'  => array( 'Заголовок', "За звуком\nстоит", 'textarea' ),
			'about_accent' => array( 'Акцент заголовка', 'мастер.' ),
			'about_lead'   => array( 'Первый абзац', 'Гитара — не просто дерево, струны и фурнитура. Это инструмент с характером, в котором важна точность каждой детали.', 'textarea' ),
			'about_copy'   => array( 'Описание мастерской', 'Мастерская Александра Даева объединяет ремонт, реставрацию и изготовление инструментов.', 'textarea' ),
			'about_note'   => array( 'Короткая подпись', '' ),
		) ),
		'services' => array( 'Услуги и портфолио', array(
			'services_title'  => array( 'Заголовок услуг', "Три стороны\nодного", 'textarea' ),
			'services_accent' => array( 'Акцент заголовка услуг', 'ремесла.' ),
			'services_copy'   => array( 'Описание услуг', 'От точной настройки инструмента до гитары, созданной по индивидуальному замыслу.', 'textarea' ),
			'portfolio_title'  => array( 'Заголовок портфолио', "Инструменты\nкрупным", 'textarea' ),
			'portfolio_accent' => array( 'Акцент заголовка портфолио', 'планом.' ),
			'portfolio_copy'   => array( 'Описание портфолио', 'Инструменты, истории ремонта и внимание к деталям.', 'textarea' ),
			'portfolio_illustrations' => array( 'Показывать подписанные иллюстрации, пока нет опубликованных работ', true, 'checkbox' ),
		) ),
		'workshop' => array( 'Подход и философия', array(
			'workshop_title'  => array( 'Заголовок подхода', "Работа, которую\nможно", 'textarea' ),
			'workshop_accent' => array( 'Акцент заголовка подхода', 'услышать.' ),
			'workshop_copy'   => array( 'Текст о подходе', "Хорошая настройка не должна привлекать внимание к себе. Она должна дать музыканту свободу играть. Поэтому важен каждый лад, каждый порожек, каждый миллиметр высоты струн.\n\nРемонт начинается с осмотра инструмента: мастер определяет проблему, обсуждает варианты решения и только после этого приступает к работе.", 'textarea' ),
			'workshop_image'  => array( 'Фото для раздела «Подход»', 0, 'image' ),
			'quote_start'    => array( 'Философия · начало', 'Хороший инструмент' ),
			'quote_accent'   => array( 'Философия · акцент', 'заслуживает' ),
			'quote_end'      => array( 'Философия · окончание', 'второй жизни.' ),
		) ),
		'prices' => array( 'Прайс', array(
			'prices_title'  => array( 'Заголовок', "Честно\nо", 'textarea' ),
			'prices_accent' => array( 'Акцент заголовка', 'главном.' ),
			'prices_copy'   => array( 'Текст над прайсом', 'Окончательный объём работ определяется после осмотра инструмента.', 'textarea' ),
			'prices_note'   => array( 'Примечание под прайсом', '' ),
		) ),
		'contact' => array( 'Контакты', array(
			'contact_title'  => array( 'Заголовок', "Дадим\nгитаре", 'textarea' ),
			'contact_accent' => array( 'Акцент заголовка', 'голос.' ),
			'contact_copy'   => array( 'Текст', 'Расскажите, что случилось с инструментом, или обсудите идею новой гитары. Перед визитом в мастерскую лучше предварительно связаться с мастером.', 'textarea' ),
			'address'        => array( 'Адрес', 'Санкт-Петербург, Моховая, 31' ),
			'hours'          => array( 'Часы работы', 'Пн–Пт, 13:00–20:00' ),
			'phone'          => array( 'Телефон с кодом страны', '+7 (964) 342-92-54' ),
			'telegram'       => array( 'Ссылка на Telegram', 'https://t.me/daevguitar', 'url' ),
			'website'        => array( 'Ссылка на действующий сайт (можно оставить пустой)', 'https://daevguitars.ru/', 'url' ),
		) ),
	);
	return $sections;
}

function daev_setting( $name ) {
	foreach ( daev_home_fields() as list( , $fields ) ) {
		if ( isset( $fields[ $name ] ) ) {
			return get_theme_mod( 'daev_' . $name, $fields[ $name ][1] );
		}
	}
	return '';
}

function daev_sanitize_web_url( $url ) {
	$url = esc_url_raw( $url, array( 'https', 'http' ) );
	return wp_parse_url( $url, PHP_URL_HOST ) ? $url : '';
}

function daev_customize_register( $customizer ) {
	$customizer->add_panel( 'daev_home', array( 'title' => 'DAEV · Главная и контакты', 'priority' => 25 ) );
	$sanitizers = array(
		'text'     => 'sanitize_text_field',
		'textarea' => 'sanitize_textarea_field',
		'url'      => 'daev_sanitize_web_url',
		'image'    => 'absint',
		'checkbox' => 'rest_sanitize_boolean',
	);

	foreach ( daev_home_fields() as $section => list( $title, $fields ) ) {
		$section_id = 'daev_home_' . $section;
		$customizer->add_section( $section_id, array( 'title' => $title, 'panel' => 'daev_home' ) );

		foreach ( $fields as $name => $field ) {
			list( $label, $default ) = $field;
			$type = $field[2] ?? 'text';
			$id = 'daev_' . $name;
			$customizer->add_setting( $id, array(
				'default'           => $default,
				'sanitize_callback' => $sanitizers[ $type ],
			) );
			$args = array( 'label' => $label, 'section' => $section_id, 'type' => $type );
			if ( 'image' === $type ) {
				unset( $args['type'] );
				$args['mime_type'] = 'image';
				$customizer->add_control( new WP_Customize_Media_Control( $customizer, $id, $args ) );
			} else {
				$customizer->add_control( $id, $args );
			}
		}
	}
}
add_action( 'customize_register', 'daev_customize_register' );
