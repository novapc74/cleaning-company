import swipers from "./swipers";
import dropdowns from "./dropdowns";
// import forms from "./forms";
import sidebars from "./sidebars";
import animations from "./animations";
import videos from "./videos";
import maps from "./maps";
import {removeClass} from "../functions/classMethods";
import toggleWindowScroll from "../functions/toggleWindowScroll";
document.addEventListener('DOMContentLoaded', () => {
    swipers()
    sidebars()
    dropdowns()
    // forms()
    videos()
    maps()

    setTimeout(()=> removeLoader(), 2000)
})
window.addEventListener('load', () => {
    animations()
    removeLoader()
})

function removeLoader() {
    const loader = document.querySelector('.page-loader')
    if(loader && loader.classList.contains('active')) {
        removeClass(loader, 'active')
        setTimeout(() => loader.remove(), 600)
        toggleWindowScroll(1)
    }
}