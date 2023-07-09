import {validateForm} from "../functions/validateForm";

export default function forms() {
    const feedbackForms = [...document.querySelectorAll('.feedback-form')]
    feedbackForms.forEach(form => validateForm(form, '/feedback'))
}