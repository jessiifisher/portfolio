console.log('hoi js')

document.addEventListener('click', (event) => {
    if (!(event.target instanceof Element)) {
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
