window.addEventListener('load', () => {
    function dropSubMenu() {
        let menu = document.querySelector('#menu')
        let submenu = document.querySelector('#sub-menu')
        menu.addEventListener('click', (e) => {
            submenu.classList.toggle('hidden')
        })
    }

    dropSubMenu()
})

