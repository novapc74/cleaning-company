import axios from "axios";
import {addClass} from "./classMethods";
import {openSidebar} from "../base/sidebars";

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
                openSidebar(popup, burger, 'sidebar-notice')
                if (response.data) {
                    message.textContent = messageSuccess
                } else {
                    message.textContent = messageError
                    openSidebar(popup, burger, 'sidebar-notice')
                }
            }
            popup && addClass(popup, 'active')
        }
        form.reset()
    }).catch((e) => {
        console.log(e)
        if (popup.classList.contains('sidebar')) {
            openSidebar(popup, burger, 'sidebar-notice')
            popup.querySelector('.notice-side__description').textContent = messageError
        }
        popup && addClass(popup, 'active')
    })
}