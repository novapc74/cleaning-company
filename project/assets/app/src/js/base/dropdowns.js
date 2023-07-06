import {addClass, removeClass} from "../functions/classMethods";

export default function dropdowns() {

    document.addEventListener('click', (evt) => {
        const target = evt.target
        if (target.closest('[data-open-dropdown]')) {
            const dropdown = target.closest(`[data-dropdown="${target.dataset.name}"]`)

            if (dropdown.classList.contains('active')) {
                removeClass(dropdown, 'active')
                if (target.dataset.openText) {
                    target.textContent = target.dataset.openText
                }
            } else {
                addClass(dropdown, 'active')
                if (target.dataset.hideText) {
                    target.textContent = target.dataset.hideText
                }
            }

        }
    })
}

