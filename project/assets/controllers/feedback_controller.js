import {Controller} from '@hotwired/stimulus';
import {log} from "video.js";
import {validateForm} from "../app/src/js/functions/validateForm";
import locoScroll from "../app/src/js/components/locoScroll";

export default class extends Controller {
    static targets = ['form'];
    static values = {
        url: String,
        identifier: String
    }

    connect() {
        this.getFeedBackForm();
    }

    async getFeedBackForm(event) {
        const params = new URLSearchParams({
            identifier: this.identifierValue,
        });

        const response = await fetch(`${this.urlValue}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (this.formTarget.innerHTML === '') {
            this.formTarget.innerHTML = await response.text();
            validateForm(this.formTarget.querySelector('form'), '/feedback', document.querySelector('.sidebar'))
            locoScroll.update()
        }
    }

    async resolveFeedBack(event) {
        const params = new URLSearchParams({
            identifier: this.identifierValue,
        });

        const form = this.formTarget.querySelector('form')
        const formData = new FormData(form);

        const response = await fetch(`${this.urlValue}?${params.toString()}`,
            {
                body: formData,
                method: "post",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

        this.formTarget.innerHTML = await response.text();

        if (response.status === 201) {
            this.formTarget.querySelectorAll(`input:not([type='hidden'])`).forEach(input => input.value = '');
        }
    }
}
