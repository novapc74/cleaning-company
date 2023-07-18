import axios from "axios";
import toggleWindowScroll from "../functions/toggleWindowScroll";

export default function maps() {
    if (document.getElementById('geography-map')) {
        if (typeof ymaps === 'object') {
            ymaps.ready(async function () {
                const mapWrapper = document.querySelector('.geography-section__map'),
                    iconPath = mapWrapper.dataset.icon;
                const response = await axios.get('/location')
                const locations = await response.data

                const map = new ymaps.Map("geography-map", {
                    center: [59.938955, 30.315644],
                    controls: [],
                    zoom: 5
                }, {
                    suppressMapOpenBlock: true
                });

                locations.forEach(location => {
                    const address = new ymaps.Placemark(
                        location.coordinates.split(','),
                        {keyId: 'location-' + location.slug},
                        {
                            iconLayout: "default#image",
                            iconImageHref: iconPath,
                            iconImageOffset: [-20, -60],
                            iconImageSize: [38, 38]
                        }
                    )

                    map.geoObjects.add(address);
                })

                window.innerWidth < 768 && map.behaviors.disable(['drag']);

                mapWrapper.addEventListener('mouseenter', () => toggleWindowScroll(0))
                mapWrapper.addEventListener('mouseleave', () => toggleWindowScroll(1))
            });
        }
    }
}