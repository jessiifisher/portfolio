console.log('hoi js')

document.addEventListener('click', (event) => {
    if (!(event.target instanceof Element)) {
        return
    }

    const carouselButton = event.target.closest('[data-carousel-direction]')
    if (carouselButton) {
        const carousel = carouselButton.closest('[data-project-carousel]')
        const track = carousel?.querySelector('.project-carousel-track')
        const slide = track?.querySelector('.project-carousel-slide')
        if (track && slide) {
            track.scrollBy({
                left: (slide.getBoundingClientRect().width + 20) * Number(carouselButton.dataset.carouselDirection),
                behavior: 'smooth',
            })
        }
        return
    }

    const galleryFilter = event.target.closest('[data-gallery-filter]')
    if (galleryFilter) {
        const module = galleryFilter.closest('[data-module="foto"]')
        const selectedGallery = galleryFilter.dataset.galleryFilter
        if (module && selectedGallery) {
            module.querySelectorAll('[data-gallery-filter]').forEach((button) => {
                button.setAttribute('aria-pressed', String(button === galleryFilter))
            })
            module.querySelectorAll('[data-foto-gallery]').forEach((gallery) => {
                gallery.hidden = selectedGallery !== 'all' && gallery.dataset.fotoGallery !== selectedGallery
            })
        }
        return
    }

    const openButton = event.target.closest('[data-project-open]')
    if (openButton) {
        const dialog = document.getElementById(openButton.dataset.projectOpen)
        if (dialog instanceof HTMLDialogElement) {
            dialog.showModal()
        }
        return
    }

    const closeButton = event.target.closest('[data-project-close]')
    if (closeButton) {
        closeButton.closest('dialog')?.close()
    }
})

document.addEventListener('click', (event) => {
    if (event.target instanceof HTMLDialogElement && event.target.open) {
        event.target.close()
    }
})
