import {addClass, removeClass} from "./classMethods";
import locoScroll from "../components/locoScroll";

export default function toggleWindowScroll(state) {
    if (state) {
        removeClass(document.body, 'no-scroll')
        locoScroll && locoScroll.start()
        return
    }
    addClass(document.body, 'no-scroll')
    locoScroll && locoScroll.stop()
}