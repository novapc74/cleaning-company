import {Controller} from '@hotwired/stimulus';
import {log} from "video.js";

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
            console.log(this.formTarget)
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
