import toggleWindowScroll from "../functions/toggleWindowScroll";
import {addClass, removeClass} from "../functions/classMethods";

export default function sidebars () {
    const sidebar = document.querySelector('.sidebar'),
        closeBtn = document.querySelector('.sidebar__close-btn'),
        burger = document.querySelector('.header__burger')

    document.addEventListener('click', (evt) => {
        const target = evt.target
        if(target.closest('[data-type="open-sidebar"]')) {
            const btn = target.closest('[data-type="open-sidebar"]')
            const removingClass = [...sidebar.classList].find(item => item !== 'sidebar' && item !== 'active')
            removingClass && removeClass(sidebar, removingClass)
            addClass(sidebar, 'active', btn.dataset.sidebar)
            toggleWindowScroll(false)
            addClass(burger, 'opened')
            burger.dataset.type = 'close-sidebar'
            return
        }
        if(target.closest('[data-type="close-sidebar"]')) {
            closeSidebar(sidebar, burger)
        }
    })
    closeBtn.addEventListener('click', () => {
        closeSidebar(sidebar, burger)
    })
    sidebar.addEventListener('click', (evt) => {
        if (evt.target.classList.contains('sidebar__inner') || evt.target.closest('.sidebar__inner')) {
            return
        }
        closeSidebar(sidebar, burger)
    })
}

function closeSidebar (sidebar, burger) {
    removeClass(sidebar, 'active')
    setTimeout(() => sidebar.className = 'sidebar', 600 )
    toggleWindowScroll(true)
    removeClass(burger, 'opened')
    burger.dataset.type = 'open-sidebar'
}


