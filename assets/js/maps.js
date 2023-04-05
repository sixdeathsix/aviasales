ymaps.ready(() => {

    let map = new ymaps.Map('map', {
        center: [55.74237528405158,37.63033274609377],
        zoom: 15,
        controls: ['routePanelControl']
    });

    let control = map.controls.get('routePanelControl');
    let geolocation = ymaps.geolocation.get();

    geolocation.then(res => {

        let currentLocation = res.geoObjects.get(0).properties.get('text');

        const urlParams = new URLSearchParams(window.location.search);

        control.routePanel.state.set({
            type: 'masstransit',
            fromEnabled: true,
            from: `${currentLocation}`,
            toEnabled: true,
            to: urlParams.get('to')
        });
    });

});