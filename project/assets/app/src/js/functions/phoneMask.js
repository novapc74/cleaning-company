import Inputmask from "inputmask";

export default function phoneMask(input) {
    Inputmask({
        "mask": "+7 (999) 999-99-99",
        showMaskOnHover: false
    }).mask(input);
}