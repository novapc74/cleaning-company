import axios from "axios";
import {addClass} from "./classMethods";

export default async function sendForm(form, url, popup = null) {
    const messageSuccess = 'Менеджер свяжется с Вами в ближайшее время, чтобы обсудить детали.',
        messageError = 'Пожалуйста, проверьте введенные данные и повторите попытку позже. Если проблема сохраняется, свяжитесь с нами напрямую для получения дополнительной помощи.'
    // const inputs = [...form.querySelectorAll('input')]
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
            if (popup.classList.contains('side-modal')) {
                const messageText = popup.querySelector('.notice-side__description')
                popup.querySelector('.notice-side__title').textContent = response.data.message
                popup.className = ('side-modal notice-side')
                if (response.data.success) {
                    messageText.textContent = messageSuccess
                } else {
                    addClass(popup, 'side-modal notice-side notice-side--error')
                    messageText.textContent = messageError
                }
            }
            popup && addClass(popup, 'active')
        }
        form.reset()
    }).catch((e) => {
        console.log(e)
        if (popup.classList.contains('side-modal')) {
            popup.className = ('side-modal notice-side notice-side--error')
            popup.querySelector('.notice-side__title').textContent = 'Ваша заявка не отправлена!'
            popup.querySelector('.notice-side__description').textContent = messageError
        }
        popup && addClass(popup, 'active')
    })
}