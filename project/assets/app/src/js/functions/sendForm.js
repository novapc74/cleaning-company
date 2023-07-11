import axios from "axios";
import {addClass, removeClass} from "./classMethods";
import {closeSidebar, openSidebar} from "../base/sidebars";

export default async function sendForm(form, url, popup = null) {
    const message = popup.querySelector('.sidebar-notice__title'),
        burger = document.querySelector('.header__burger')
    const messageSuccess = 'Ваша заявка отправлена!',
        messageError = 'Пожалуйста, проверьте введенные данные и повторите попытку позже. Если проблема сохраняется, свяжитесь с нами напрямую для получения дополнительной помощи.'

    const identifier = form.parentElement.dataset.feedbackIdentifierValue
    const formData = new FormData(form)
    const urlValue = identifier ? `${url}?identifier=${identifier}` : url

    // inputs.length && inputs.forEach(input => formData.append(input.dataset.name, input.value))

    await axios.post(urlValue, formData, {
        headers: {
            "X-Requested-With": 'XMLHttpRequest'
        }
    }).then((response) => {
        if (popup) {
            if (popup.classList.contains('sidebar')) {
                if (response.data.success) {
                    message.textContent = messageSuccess
                    removeClass(message, 'sidebar-notice__title_error')
                } else {
                    message.textContent = messageError
                    addClass(message, 'sidebar-notice__title_error')
                }
            }
            openSidebar(popup, burger, 'sidebar-notice')
        }
        form.reset()
        setTimeout(() => {
           popup.classList.contains('active') && closeSidebar(popup, burger)
        }, 3000)
    }).catch((e) => {
        console.log(e)
        if (popup.classList.contains('sidebar')) {
            openSidebar(popup, burger, 'sidebar-notice')
            message.textContent = messageError
            addClass(message, 'sidebar-notice__title_error')
        }
        popup && addClass(popup, 'active')
    })
}