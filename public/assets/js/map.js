mapboxgl.accessToken =
  "pk.eyJ1Ijoia2hhbGRvbnV0czY5IiwiYSI6ImNsY2JvNXFjZjE2bjMzb3FycjNnNmZsbXIifQ.HG0N6wONlxBIO_wFAzVmhA";
const map = new mapboxgl.Map({
  container: "map", // container ID
  // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
  style: "mapbox://styles/mapbox/streets-v12", // style URL
  center: [4.972940884770006, 45.76630585712442], // starting position
  zoom: 16, // starting zoom
});

// Add zoom and rotation controls to the map.
map.addControl(new mapboxgl.NavigationControl());
map.on("load", () => {
  map.addSource("places", {
    // This GeoJSON contains features that include an "icon"
    // property. The value of the "icon" property corresponds
    // to an image in the Mapbox Streets style's sprite.
    type: "geojson",
    data: {
      type: "FeatureCollection",
      features: [
        {
          type: "Feature",
          properties: {
            description:
              '<strong>Climair</strong><p><a href="https://localhost:8000/accueil" target="https://localhost:8000/accueil" title="Opens in a new window">Climair</a> est une entreprise de climatisation ouverte du Lundi au Vendredi de 8h à 17h.</p>',
            icon: "theatre",
          },
          geometry: {
            type: "Point",
            coordinates: [4.972940884770006, 45.76630585712442],
          },
        },
      ],
    },
  });
  // Add a layer showing the places.
  map.addLayer({
    id: "places",
    type: "symbol",
    source: "places",
    layout: {
      "icon-image": ["get", "icon"],
      "icon-allow-overlap": true,
    },
  });

  // When a click event occurs on a feature in the places layer, open a popup at the
  // location of the feature, with description HTML from its properties.
  map.on("click", "places", (e) => {
    // Copy coordinates array.
    const coordinates = e.features[0].geometry.coordinates.slice();
    const description = e.features[0].properties.description;

    // Ensure that if the map is zoomed out such that multiple
    // copies of the feature are visible, the popup appears
    // over the copy being pointed to.
    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
      coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
    }

    new mapboxgl.Popup().setLngLat(coordinates).setHTML(description).addTo(map);
  });

  // Change the cursor to a pointer when the mouse is over the places layer.
  map.on("mouseenter", "places", () => {
    map.getCanvas().style.cursor = "pointer";
  });

  // Change it back to a pointer when it leaves.
  map.on("mouseleave", "places", () => {
    map.getCanvas().style.cursor = "";
  });
});
// Create a default Marker and add it to the map.
const marker1 = new mapboxgl.Marker()
  .setLngLat([4.972940884770006, 45.76630585712442])
  .addTo(map);
