import toggleWindowScroll from "./toggleWindowScroll";
import {addClass, removeClass} from "./classMethods";

export default function initPopup(popup, initiator, {openFn, closeFn} = {
    openFn: () => false, closeFn: () => false
}) {

    const overlay = popup.querySelector('.default-popup__overlay'),
        closeBtn = popup.querySelector('.default-popup__close-btn'),
        cancelBtn = popup.querySelector('.default-popup__cancel-btn')

    initiator && addHandlerTogglePopup(initiator, 1)
    overlay && addHandlerTogglePopup(closeBtn, 0)
    closeBtn && addHandlerTogglePopup(overlay, 0)
    cancelBtn && addHandlerTogglePopup(cancelBtn, 0)

    function addHandlerTogglePopup(el, state) {
        if(state) {
            document.addEventListener('click', (evt) => {
                if(evt.target.closest(`[data-open-modal="${el}"]`)) {
                    popup.style.display = 'block'
                    setTimeout(() => addClass(popup, 'active'))
                    toggleWindowScroll(0)
                    openFn(evt)
                }
            })
        } else {
            el.addEventListener('click', (evt) => {
                evt.preventDefault()
                    removeClass(popup, 'active')
                    setTimeout(() => (popup.style.display = 'none'), 400)
                    toggleWindowScroll(1)
                    closeFn(evt)
            })
        }
    }
}

