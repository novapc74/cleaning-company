import JustValidate from 'just-validate';
import phoneMask from "./phoneMask";
import sendForm from "./sendForm";
import {addClass, removeClass} from "./classMethods";
import locoScroll from "../components/locoScroll";

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
    const inputs = [...form.querySelectorAll('input')]

    inputs.forEach(input => {

        input.closest('.base-input') && input.addEventListener('blur', (evt) => {
            const target = evt.currentTarget
            target.value !== '' ? addClass(target, 'fill-input') : removeClass(target, 'fill-input')
        } )

        if (input.type === 'tel') {
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
        if (input.type === 'text') {
            validation.addField(input, [
                {
                    rule: 'required',
                    errorMessage: 'Обязательное поле',
                }
            ],)
        }
        if (input.type === 'email') {
            validation.addField(input, [
                {
                    rule: 'function',
                    validator: () => /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(input.value),
                    errorMessage: 'Некорректный email',
                },
                {
                    rule: 'required',
                    errorMessage: 'Обязательное поле',
                }
            ],)
        }
        if (input.type === 'checkbox') {
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
