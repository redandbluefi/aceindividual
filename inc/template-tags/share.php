<?php
/**
 * Social Media share
 *
 * @package eternia
 */

namespace Eternia;

/**
 * Social Media share
 */

$page_id   = get_the_id();
$home_url  = get_home_url();
$permalink = get_the_permalink();

?>
<div id="share-links" class="share-links" aria-label="<?php echo esc_html( translate__( 'Jaa artikkeli sosiaalisessa mediassa' ) ); ?>">
	<p class="share-links__title"><?php echo esc_html( translate__( 'Jaa:' ) ); ?></p>
	<ul>
		<li class="fb">
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( $permalink ); ?>" target="_blank" rel="noreferrer" class="no-external-link-indicator">
				<?php
				inline_svg( 'social-facebook.svg', array( 'wrapper' => 'i' ), true );
				?>
				<span class="screen-reader-text"><?php echo esc_html( translate__( 'Jaa Facebookissa' ) ); ?> (<?php echo esc_html( get_default_localization( 'opens in a new window' ) ); ?>)</span>
			</a>
		</li>
		<li class="twitter">
			<a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( $permalink ); ?>" target="_blank" rel="noreferrer" class="no-external-link-indicator">
				<?php
				inline_svg( 'social-x.svg', array( 'wrapper' => 'i' ), true );
				?>
				<span class="screen-reader-text"><?php echo esc_html( translate__( 'Jaa Twitterissä' ) ); ?> (<?php echo esc_html( get_default_localization( 'opens in a new window' ) ); ?>)</span>
			</a>
		</li>
		<li class="linkedin">
			<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo rawurlencode( $permalink ); ?>" target="_blank" rel="noreferrer" class="no-external-link-indicator">
				<?php
				inline_svg( 'social-linkedin.svg', array( 'wrapper' => 'i' ), true );
				?>
				<span class="screen-reader-text"><?php echo esc_html( translate__( 'Jaa LinkedInissä' ) ); ?> (<?php echo esc_html( get_default_localization( 'opens in a new window' ) ); ?>)</span>
			</a>
		</li>
		<li class="link">
			<button id="tooltip">
				<span class="tooltip-link screen-reader-text" aria-hidden="true"><?php echo esc_url( $permalink ); ?></span>
				<?php
				inline_svg( 'info.svg', array( 'wrapper' => 'i' ), true );
				?>
				<span class="screen-reader-text"><?php echo esc_html( translate__( 'Kopioi linkki leikepöydälle' ) ); ?></span>
			</button>
			<span id="tooltip-response" class="tooltip-response" aria-live="polite"><?php echo esc_html( translate__( 'Linkki kopioitu' ) ); ?></span>
		</li>
	</ul>
</div>
<?php
