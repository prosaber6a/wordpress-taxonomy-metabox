<?php
/**
 * Plugin Name: Tags Meta
 * Plugin URI: http://saberhr.com
 * Author: SaberHR
 * Author URI: http://saberhr.com
 * Description: WordPress Taxonomy Metabox API Demo
 * Licence: GPLv2 or Later
 * Text Domain: tags-meta
 */

function tagsm_load_textdomain() {
	load_plugin_textdomain( 'tags_meta', false, plugin_dir_url( __FILE__ ) . '/languages' );
}

add_action( 'plugins_loaded', 'tagsm_load_textdomain' );

function tagsm_init() {
	$args = array(
		'type'              => 'string',
		'sanitize_callback' => 'sanitize_text_field',
		'single'            => true,
		'description'       => 'Sample meta field for category taxonomy',
		'show_in_rest'      => true
	);
	register_meta( 'term', 'tagsm_extra_info', $args );
}

add_action( 'init', 'tagsm_init' );

function tagsm_meta_field_form() {
	$_label  = __( 'Extra Info', 'tags-meta' );
	$_label2 = __( 'Some help text', 'tags-meta' );
	$markup  = <<<EOD
<div class="form-field form-required term-name-wrap">
	<label for="extra-field">{$_label}</label>
	<input name="extra-field" id="extra-field" type="text" value="" size="40" aria-required="true">
	<p>{$_label2}</p>
</div>
EOD;
	echo $markup;
}

add_action( 'category_add_form_fields', 'tagsm_meta_field_form' );
add_action( 'add_tag_form_fields', 'tagsm_meta_field_form' );

function tagsm_meta_field_edit_form( $term ) {
	$extra_info = esc_attr( get_term_meta( $term->term_id, 'tagsm_extra_info', true ) );
	$_label     = __( 'Extra Info', 'tags-meta' );
	$_label2    = __( 'Some help text', 'tags-meta' );
	$markup     = <<<EOD
	<tr class="form-field form-required term-name-wrap">
		<th scope="row">
			<label for="extra-field">{$_label}</label>
		</th>
		<td>
			<input name="extra-field" id="extra-field" type="text" value="{$extra_info}" size="40" aria-required="true">
			<p class="description">{$_label2}</p>
		</td>
	</tr>
EOD;
	echo $markup;
}

add_action( 'category_edit_form_fields', 'tagsm_meta_field_edit_form' );
add_action( 'post_tag_edit_form_fields', 'tagsm_meta_field_edit_form' );

function tagsm_save_category_meta( $term_id ) {
	if ( wp_verify_nonce( $_POST['_wpnonce_add-tag'], 'add-tag' ) ) {
		$extra_info = sanitize_text_field( $_POST['extra-field'] );
		update_term_meta( $term_id, 'tagsm_extra_info', $extra_info );
	}
}

add_action( 'create_category', 'tagsm_save_category_meta' );
add_action( 'create_post_tag', 'tagsm_save_category_meta' );

function tagsm_update_category_meta( $term_id ) {
	if ( wp_verify_nonce( $_POST['_wpnonce'], 'update-tag_' . $term_id ) ) {
		$extra_info = sanitize_text_field( $_POST['extra-field'] );
		update_term_meta( $term_id, 'tagsm_extra_info', $extra_info );
	}
}

add_action( 'edit_category', 'tagsm_update_category_meta' );
add_action( 'edit_post_tag', 'tagsm_update_category_meta' );


