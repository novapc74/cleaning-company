import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['form', 'feedBackForm'];
    static values = {
        url: String,
        identifier: String
    }

    connect() {
        this.getFeedBackForm();
    }

    async getFeedBackForm(event) {
        const params = new URLSearchParams({
            type: this.typeValue,
        });

        const response = await fetch(this.urlValue, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (this.formTarget.innerHTML === '') {
            this.formTarget.innerHTML = await response.text();
        }
    }

    async resolveFeedBack(event) {
        const formData = new FormData(this.feedBackFormTarget);

        const response = await fetch(this.urlValue,
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
