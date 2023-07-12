import swipers from "./swipers";
import dropdowns from "./dropdowns";
// import forms from "./forms";
import sidebars from "./sidebars";
import animations from "./animations";
import videos from "./videos";
import maps from "./maps";
import {removeClass} from "../functions/classMethods";
document.addEventListener('DOMContentLoaded', () => {
    swipers()
    sidebars()
    dropdowns()
    // forms()
    videos()
    maps()

    setTimeout(()=> removeLoader('time'), 2000)
})
window.addEventListener('load', () => {
    animations()
    removeLoader('loaded')
})

function removeLoader(mes) {
    const loader = document.querySelector('.page-loader')
    if(loader && loader.classList.contains('active')) {
        console.log(mes)
        removeClass(loader, 'active')
        setTimeout(() => loader.remove(), 600)
    }
}