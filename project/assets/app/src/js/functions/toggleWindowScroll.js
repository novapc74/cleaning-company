import {addClass, removeClass} from "./classMethods";

export default function toggleWindowScroll(state) {
    state ? removeClass(document.body, 'no-scroll') : addClass(document.body, 'no-scroll')
}