import {addClass, removeClass} from "../functions/classMethods";

export default function videos() {
    const videoSections = [...document.querySelectorAll('.video-section')]
    if (videoSections.length) {
        videoSections.forEach(section => {
            const video = section.querySelector('video'),
                playBtn = section.querySelector('.video-section__btn'),
                overlay = section.querySelector('.video-section__overlay')

            playBtn.addEventListener('click', () => {
                addClass(overlay, 'hidden')
                video.play()
            })

            video.addEventListener('click', () => {
                removeClass(overlay, 'hidden')
                video.pause()
            })
        })
    }
}