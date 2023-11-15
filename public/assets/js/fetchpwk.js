function fetchPwk() {
    var aw = BASE_URL + ('/uploads/geojson/pwk.geojson')

    fetch(aw)
        .then(response => response.json())
        .then(geojsonData => {
            geojsonLayer = L.geoJSON(geojsonData, {
                style: function (feature) {
                    return {
                        color: feature.properties.stroke,
                        weight: feature.properties['stroke-width'] || 1,
                        opacity: feature.properties['stroke-opacity'] || 1
                    };
                },
                onEachFeature: function (feature, layer) {
                    var popupContent = feature.properties.name;

                    layer.bindPopup(popupContent);
                }
            });
            geojsonLayer.addTo(map);
            var bounds = geojsonLayer.getBounds();
            map.fitBounds(bounds);
        })
        .catch(error => {
            console.error(error);
        });
};