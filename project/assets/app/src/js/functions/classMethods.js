export function addClass(elem, ...classNames) {
    classNames.forEach(item => elem.classList.add(item))
}
export function removeClass(elem, ...classNames) {
    classNames.forEach(item => elem.classList.remove(item))
}
export function resetActiveClass(parent, className, activeClass, reset = true) {
    const elements = [...parent.querySelectorAll(className)]
    elements.forEach((el) =>
        reset ? removeClass(el, activeClass) : addClass(el, activeClass)
    )
}
export function toggleActiveClass(elem, className, activeClass) {
    const elements = [...document.querySelectorAll(className)]
    elements.forEach(
        (el) =>
            el.classList.contains(activeClass) &&
            el !== elem &&
            el.classList.toggle(activeClass)
    )
    elem.classList.toggle(activeClass)
}
export function toggleHidden(elem, isHidden, time = 400, display = 'block') {
    if (isHidden) {
        setTimeout(() => {
            elem.style.display = display
            removeClass(elem, 'hidden')
        }, time)
        return
    }
    addClass(elem, 'hidden')
    setTimeout(() => {
        elem.style.display = 'none'
    }, time)
}

export function removeExtraClass(el, className) {
    const removingClass = [...el.classList].find(item => item !== className && item !== 'active')
    removingClass && removeClass(el, removingClass)
}
