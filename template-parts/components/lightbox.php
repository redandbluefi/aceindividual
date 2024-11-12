<?php
/**
 * Lightbox element for displaying images.
 *
 * Adds a custom lightbox for the site body, which can be
 * populated via javascript from image gallery or core
 * image blocks.
 *
 * Aria hidden is used to show and hide the lightbox visually as well.
 * Data swiper active is the state to determine if the lightbox is
 * currently populated through an image gallery.
 *
 * All the data is populated via javascript through rest
 *
 * @package Eternia
 */

?>
<dialog id="lightbox" class="lightbox lightbox--closed" aria-hidden="true" data-swiper-active="false">
	<div class="lightbox__content">
		<div class="lightbox__image">
		</div>
		<div class="lightbox__meta">
			<figcaption class="lightbox__excerpt"></figcaption>
			<div class="lightbox__swipernav">
				<button class="swiper-button swiper-button--prev" aria-label="Previous image">
					<i>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12.1536 24L14.2369 21.8546L5.75982 13.588L24 13.333L23.9565 10.3324L5.71935 10.5875L13.9642 2.08539L11.8209 0L0 12.1673L12.1536 24Z"></path></svg>
					</i>
				</button>
				<button class="swiper-button swiper-button--next" aria-label="Next image">
					<i>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11.8464 -1.0625e-06L9.76307 2.1454L18.2402 10.4119L1.16561e-06 10.667L0.0434656 13.6676L18.2806 13.4125L10.0358 21.9146L12.1791 24L24 11.8327L11.8464 -1.0625e-06Z"></path></svg>
					</i>
				</button>
			</div>
		</div>
		<button class="lightbox__close" aria-label="Close lightbox">
			<i>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22" fill="currentColor"><path d="M20.94 19.436a1.064 1.064 0 01-1.159 1.734 1.064 1.064 0 01-.345-.23l-8.81-8.812-8.811 8.812A1.063 1.063 0 11.31 19.436l8.812-8.81L.311 1.815A1.063 1.063 0 011.815.31l8.81 8.812L19.437.311a1.063 1.063 0 111.504 1.504l-8.812 8.81 8.812 8.811z"></path></svg>
			</i>
		</button>
	</div>
</dialog>
