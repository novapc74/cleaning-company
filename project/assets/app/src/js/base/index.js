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
})
window.addEventListener('load', () => {
    const loader = document.querySelector('.page-loader')
    animations()
    removeClass(loader, 'active')
    setTimeout(() => loader.remove(), 600)
})