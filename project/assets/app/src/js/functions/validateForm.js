import JustValidate from 'just-validate';
import phoneMask from "./phoneMask";
import sendForm from "./sendForm";

export const validateForm = (form, url, popup = null) => {
    const validation = new JustValidate(form, {
        errorFieldCssClass: ['error-input'],
        errorLabelCssClass: ['error-input-message'],
        successFieldCssClass: ['success-input'],
        validateBeforeSubmitting: true,
        errorLabelStyle: {
            color: "#ff0000",
        }
    });
    const inputs = [...form.querySelectorAll('input')],
        submitBtn = form.querySelector('button[type="submit"]')

    inputs.forEach(input => {
        if (input.dataset.name === 'phone') {
            phoneMask(input)
            validation.addField(input, [
                {
                    rule: 'function',
                    validator: () => {
                        const phone = input.inputmask.unmaskedvalue();
                        return phone.length === 10;
                    },
                    errorMessage: 'Некорректный номер',
                }
            ],)
        }
        if (input.dataset.name === 'fio') {
            validation.addField(input, [
                {
                    rule: 'required',
                    errorMessage: 'Обязательное поле',
                }
            ],)
        }
        if (input.dataset.name === 'isAgree') {
            validation.addField(input, [
                {
                    rule: 'required',
                    errorFieldCssClass: ['error-checkbox'],
                    errorLabelCssClass: ['hidden-error-message'],
                    errorLabelStyle: {
                        display: "none",
                    }
                }
            ],)
        }
    })

    validation.onSuccess(() => {
        sendForm(form, url, popup)
        validation.refresh()
    })
};
