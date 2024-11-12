<?php
/**
 * Localization related callback functions and action hook calls
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Register strings for Polylang string translations.
 *
 * @return array $strings Array of strings to be registered.
 */
add_filter(
	'air_helper_pll_register_strings',
	function () {
		$strings = array(
		// 'Key: String' => 'String',
		);

		/**
		 * Uncomment if you need to have default eternia accessibility strings
		 * translatable via Polylang string translations.
		 */

		// Commented out code below:
		// foreach ( get_default_localization_strings() as $key => $value ) {
		// $strings[ "Accessibility: {$key}" ] = $value;
		// }
		// End of commented out code.

		return $strings;
	}
);

/**
 * Returns default localization strings.
 *
 * @param string $language Language code.
 * @return array $strings default localization strings.
 */
function get_default_localization_strings( $language = 'en' ) {
	$strings = array(
		'en' => array(
			'Test'                                         => translate__( 'Test', '', 'eternia' ),

			'Add a menu'                                   => translate__( 'Add a menu', '', 'eternia' ),
			'Open main menu'                               => translate__( 'Open main menu', '', 'eternia' ),
			'Close main menu'                              => translate__( 'Close main menu', '', 'eternia' ),
			'Main navigation'                              => translate__( 'Main navigation', '', 'eternia' ),
			'Back to top'                                  => translate__( 'Back to top', '', 'eternia' ),
			'Open child menu'                              => translate__( 'Open child menu', '', 'eternia' ),
			'Open child menu for'                          => translate__( 'Open child menu for', '', 'eternia' ),
			'Close child menu'                             => translate__( 'Close child menu', '', 'eternia' ),
			'Close child menu for'                         => translate__( 'Close child menu for', '', 'eternia' ),
			'Footer menu'                                  => translate__( 'Footer menu', '', 'eternia' ),
			'Social media menu'                            => translate__( 'Social media menu', '', 'eternia' ),
			'Skip to content'                              => translate__( 'Skip to content', '', 'eternia' ),
			'Skip over the carousel element'               => translate__( 'Skip over the carousel element', '', 'eternia' ),
			'External site'                                => translate__( 'External site', '', 'eternia' ),
			'opens in a new window'                        => translate__( 'opens in a new window', '', 'eternia' ),
			'Page not found.'                              => translate__( 'Page not found.', '', 'eternia' ),
			'The reason might be mistyped or expired URL.' => translate__( 'The reason might be mistyped or expired URL.', '', 'eternia' ),
			'Search'                                       => translate__( 'Search', '', 'eternia' ),
			'Block missing required data'                  => translate__( 'Block missing required data', '', 'eternia' ),
			'This error is shown only for logged in users' => translate__( 'This error is shown only for logged in users', '', 'eternia' ),
			'No results found for your search'             => translate__( 'No results found for your search', '', 'eternia' ),
			'Edit'                                         => translate__( 'Edit', '', 'eternia' ),
			'Previous slide'                               => translate__( 'Previous slide', '', 'eternia' ),
			'Next slide'                                   => translate__( 'Next slide', '', 'eternia' ),
			'Last slide'                                   => translate__( 'Last slide', '', 'eternia' ),
		),
		'fi' => array(
			'Add a menu'                                   => 'Luo uusi valikko',
			'Open main menu'                               => 'Avaa päävalikko',
			'Close main menu'                              => 'Sulje päävalikko',
			'Main navigation'                              => 'Päävalikko',
			'Back to top'                                  => 'Siirry takaisin sivun alkuun',
			'Open child menu'                              => 'Avaa alavalikko',
			'Open child menu for'                          => 'Avaa alavalikko kohteelle',
			'Close child menu'                             => 'Sulje alavalikko',
			'Close child menu for'                         => 'Sulje alavalikko kohteelle',
			'Footer menu'                                  => 'Alatunnisteen valikko',
			'Social media menu'                            => 'Sosiaalisen median linkit',
			'Skip to content'                              => 'Siirry suoraan sisältöön',
			'Skip over the carousel element'               => 'Hyppää karusellisisällön yli seuraavaan sisältöön',
			'External site'                                => 'Ulkoinen sivusto',
			'opens in a new window'                        => 'avautuu uuteen ikkunaan',
			'Page not found.'                              => 'Hups. Näyttää, ettei sivua löydy.',
			'The reason might be mistyped or expired URL.' => 'Syynä voi olla virheellisesti kirjoitettu tai vanhentunut linkki.',
			'Search'                                       => 'Haku',
			'Block missing required data'                  => 'Lohkon pakollisia tietoja puuttuu',
			'This error is shown only for logged in users' => 'Tämä virhe näytetään vain kirjautuneille käyttäjille',
			'No results for your search'                   => 'Haullasi ei löytynyt tuloksia',
			'Edit'                                         => 'Muokkaa',
			'Previous slide'                               => 'Edellinen dia',
			'Next slide'                                   => 'Seuraava dia',
			'Last slide'                                   => 'Viimeinen dia',
		),
	);

	return ( array_key_exists( $language, $strings ) ) ? $strings[ $language ] : $strings['en'];
} // end get_default_localization_strings

/**
 * Returns default localization string.
 *
 * @param string $string_to_be_localized string to be localized.
 * @return string The localized string.
 */
function get_default_localization( $string_to_be_localized ) {
	if ( function_exists( 'ask__' ) && array_key_exists( "Accessibility: {$string_to_be_localized}", apply_filters( 'air_helper_pll_register_strings', array() ) ) ) {
		return ask__( "Accessibility: {$string_to_be_localized}" );
	}

	return esc_html( get_default_localization_translation( $string_to_be_localized ) );
} // end get_default_localization

/**
 * Returns default translation
 *
 * @param string $string_to_be_translated string to be translated.
 * @return string The translated string.
 */
function get_default_localization_translation( $string_to_be_translated ) {
	$language = get_bloginfo( 'language' );
	if ( function_exists( 'pll_the_languages' ) ) {
		$language = pll_current_language();
	}

	$translations = get_default_localization_strings( $language );

	return ( array_key_exists( $string_to_be_translated, $translations ) ) ? $translations[ $string_to_be_translated ] : '';
} // end get_default_localization_translation
