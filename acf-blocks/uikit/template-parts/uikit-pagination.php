<?php
/**
 * Template part: UI Kit pagination.
 * Parent block: UI Kit
 *
 * @package Eternia
 */

namespace eternia;

?>
<section class="uikit__pagination" id="uikit-pagination">
	<nav class="navigation pagination" aria-label="Artikkelit">
		<h2 class="screen-reader-text">Artikkelien selaus</h2>
		<div class="nav-links"><a class="prev page-numbers" href="#">
			<span class="screen-reader-text">Move to previous page</span>
			<?php inline_svg( 'chevron-left.svg', array( 'wrapper' => 'i' ), true ); ?>
			<a class="page-numbers" href="#">
				<span class="screen-reader-text">page</span>1
			</a>
			<span aria-current="page" class="page-numbers current">
				<span class="screen-reader-text">page</span>2
			</span>
			</a>
		</div>
	</nav>

	<nav class="navigation pagination" aria-label="Artikkelit">
		<h2 class="screen-reader-text">Artikkelien selaus</h2>
		<div class="nav-links">
			<span aria-current="page" class="page-numbers current">
				<span class="screen-reader-text">page</span>1
			</span>
			<a class="page-numbers" href="#">
				<span class="screen-reader-text">page</span>2
			</a>
			<a class="page-numbers" href="#">
				<span class="screen-reader-text">page</span>3
			</a>
			<a class="next page-numbers" href="#">
				<span class="screen-reader-text">Move to next page</span>
				<?php inline_svg( 'chevron-right.svg', array( 'wrapper' => 'i' ), true ); ?>
			</a>
		</div>
	</nav>

	<nav class="navigation pagination" aria-label="Artikkelit">
		<h2 class="screen-reader-text">Artikkelien selaus</h2>
		<div class="nav-links">
			<a class="prev page-numbers" href="#">
				<span class="screen-reader-text">Move to previous page</span>
				<?php inline_svg( 'chevron-left.svg', array( 'wrapper' => 'i' ), true ); ?>
			</a>
			<a class="page-numbers" href="#">
				<span class="screen-reader-text">page</span>1
			</a>
			<span aria-current="page" class="page-numbers current">
				<span class="screen-reader-text">page</span>2
			</span>
			<a class="page-numbers" href="#">
				<span class="screen-reader-text">page</span>3
			</a>
			<a class="next page-numbers" href="#">
				<span class="screen-reader-text">Move to next page</span>
				<?php inline_svg( 'chevron-right.svg', array( 'wrapper' => 'i' ), true ); ?>
			</a>
		</div>
	</nav>

	<nav class="navigation pagination" aria-label="Artikkelit">
		<h2 class="screen-reader-text">Artikkelien selaus</h2>
		<div class="nav-links">
			<a class="prev page-numbers" href="#">
				<span class="screen-reader-text">Move to previous page</span>
				<?php inline_svg( 'chevron-left.svg', array( 'wrapper' => 'i' ), true ); ?>
			</a>
			<a class="page-numbers" href="#">
				<span class="screen-reader-text">page</span>1
			</a>
			<span class="page-numbers dots">…</span>
			<a class="page-numbers" href="#">
				<span class="screen-reader-text">page</span>5
			</a>
			<span aria-current="page" class="page-numbers current">
				<span class="screen-reader-text">page</span>6
			</span>
			<a class="page-numbers" href="#">
				<span class="screen-reader-text">page</span>7
			</a>
			<span class="page-numbers dots">…</span>
			<a class="page-numbers" href="#">
				<span class="screen-reader-text">page</span>12
			</a>
			<a class="next page-numbers" href="#">
				<span class="screen-reader-text">Move to next page</span>
				<?php inline_svg( 'chevron-right.svg', array( 'wrapper' => 'i' ), true ); ?>
			</a>
		</div>
	</nav>
</section>