if(window.eternia.lightbox){
	const { coreImagesEnableLightbox, initLightbox } = window.eternia.lightbox;
	document.addEventListener('DOMContentLoaded', () => {
		initLightbox();
		coreImagesEnableLightbox();
	});
}

export {}