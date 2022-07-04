


    window.addEventListener('load', initMap);

    function initMap() {
        var santiagoCity = { //coordenadas de la ciudad santiago
            lat: -33.4577756,
            lng: -70.6504502
        }
        var map = new google.maps.Map(document.getElementById("map"), {
            center: santiagoCity,
            zoom: 10,
        });


        //RESTRINGIR BUSQUEDA A 10 KM DE SANTIAGO
        var defaultBounds = {
            north: santiagoCity.lat + 0.1,
            south: santiagoCity.lat - 0.1,
            east: santiagoCity.lng + 0.1,
            west: santiagoCity.lng - 0.1,
        };

        var options = {
            //bounds: defaultBounds,
            componentRestrictions: {
                country: "cl"
            },

            //IMPORTANTE ESPECIFICAR LAS FIELDS CON LO NECESARIO PARA QUE PAGAR DE MÁS
            fields: ["place_id", "geometry", "name", "address_components"],
            origin: santiagoCity,
            strictBounds: false,
            types: ["address"],
        };

        var autocomplete = new google.maps.places.Autocomplete(document.getElementById("address"), options);
        console.log(autocomplete);
        console.log(document.getElementById("address"));

        autocomplete.bindTo("bounds", map);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById("infowindow-content");
        infowindow.setContent(infowindowContent);
        var geocoder = new google.maps.Geocoder();
        var marker = new google.maps.Marker({
            map: map
        });
        marker.addListener("click", () => {
            infowindow.open(map, marker);
        });

        
        marker.setPlace({
            placeId: document.getElementById("place_id").value,
            location: { 
                lat: Number(document.getElementById("latitude").value),
                lng: Number(document.getElementById("longitude").value)
            },
        });
        marker.setVisible(true);

     
        autocomplete.addListener("place_changed", function() {

            infowindow.close();

            //  const place = autocomplete.getPlace();

            // if (!place.place_id) {
            //     return;
            // }
            // document.getElementById('place_id').value = place.place_id;
          
         
            geocoder.geocode( {placeId: autocomplete.getPlace().place_id}, (results, status) => {
                //console.log('results', results[0]);
                // console.log('place', place);
                //console.log('status', status);

                if (status !== "OK" && results) {
                    window.alert("Geocoder falló debido a : " + status);
                    return;
                }
                map.setZoom(10);
                map.setCenter(results[0].geometry.location);
                // Set the position of the marker using the place ID and location.
                marker.setPlace({
                    placeId: results[0].place_id,
                    location: results[0].geometry.location,
                });
                marker.setVisible(true);

                let address = "";
                if (results[0].address_components) {
                    address = {
                        number:  (results[0].address_components[0] && results[0].address_components[0].short_name || ''),
                        street :  (results[0].address_components[1] && results[0].address_components[1].short_name || ''), 
                        commune :  (results[0].address_components[2] && results[0].address_components[2].short_name || ''),
                        commune2 :  (results[0].address_components[3] && results[0].address_components[3].short_name || ''),
                        city :  (results[0].address_components[4] && results[0].address_components[4].short_name || ''),
                        region :  (results[0].address_components[5] && results[0].address_components[5].short_name || ''),
                        country :  (results[0].address_components[6] && results[0].address_components[6].short_name || ''),
                        latitude :  (results[0].geometry.location.lat()),
                        longitude :  (results[0].geometry.location.lng()),
                        place_id :  (results[0].place_id),
                        address :  (results[0].formatted_address)
                    };
                    // document.getElementById('commune').value = address.commune;
                    // document.getElementById('commune2').value = address.commune2;
                    // document.getElementById('street').value = address.street;
                    // document.getElementById('number').value = address.number;
                    // document.getElementById('city').value = address.city;
                    // document.getElementById('region').value = address.region;
                    // document.getElementById('country').value = address.country;
                    // document.getElementById('latitude').value = results[0].geometry.location.lat();
                    // document.getElementById('longitude').value = results[0].geometry.location.lng();
                    // document.getElementById('place_id').value = results[0].place_id;

                    Livewire.emit('setAddress', address);

                }
                
                infowindowContent.children["place-name"].textContent = results[0].formatted_address;
                infowindowContent.children["place-address"].textContent = '';
                infowindow.open(map, marker);
            });
        });
    }
    