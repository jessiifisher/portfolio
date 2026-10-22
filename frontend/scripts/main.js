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
