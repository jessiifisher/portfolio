console.log('hoi js')

const setMobileMenuOpen = (header, isOpen) => {
    const toggle = header.querySelector('[data-mobile-menu-toggle]')
    if (!(toggle instanceof HTMLButtonElement)) {
        return
    }

    toggle.setAttribute('aria-expanded', String(isOpen))
    toggle.setAttribute('aria-label', isOpen ? 'Menü schliessen' : 'Menü öffnen')
    header.toggleAttribute('data-mobile-menu-open', isOpen)
    document.body.classList.toggle('mobile-menu-open', isOpen)
}

document.addEventListener('click', (event) => {
    if (!(event.target instanceof Element)) {
        return
    }

    const menuToggle = event.target.closest('[data-mobile-menu-toggle]')
    if (menuToggle) {
        const header = menuToggle.closest('[data-layout="header"]')
        if (header) {
            setMobileMenuOpen(header, menuToggle.getAttribute('aria-expanded') !== 'true')
        }
        return
    }

    const menuLink = event.target.closest('[data-mobile-menu] a')
    if (menuLink) {
        const header = menuLink.closest('[data-layout="header"]')
        if (header) {
            setMobileMenuOpen(header, false)
        }
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
            module.querySelectorAll('[data-foto-gallery]').forEach((image) => {
                image.hidden = selectedGallery !== 'all' && image.dataset.fotoGallery !== selectedGallery
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

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        document.querySelectorAll('[data-layout="header"] [data-mobile-menu-toggle][aria-expanded="true"]').forEach((toggle) => {
            const header = toggle.closest('[data-layout="header"]')
            if (header) {
                setMobileMenuOpen(header, false)
                toggle.focus()
            }
        })
    }
})

window.addEventListener('resize', () => {
    if (window.matchMedia('(min-width: 769px)').matches) {
        document.querySelectorAll('[data-layout="header"] [data-mobile-menu-toggle][aria-expanded="true"]').forEach((toggle) => {
            const header = toggle.closest('[data-layout="header"]')
            if (header) {
                setMobileMenuOpen(header, false)
            }
        })
    }
})

document.addEventListener('click', (event) => {
    if (event.target instanceof HTMLDialogElement && event.target.open) {
        event.target.close()
    }
})
