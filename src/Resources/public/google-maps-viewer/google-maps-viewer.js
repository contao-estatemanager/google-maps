/**
 * Google Maps Viewer
 *
 * @author Daniele Sciannimanica <https://github.com/doishub>
 * @version 0.0.10
 * @licence https://github.com/doishub/google-maps-viewer/blob/master/LICENSE
 */
var GoogleMapsViewer = (function () {

    'use strict';

    var Constructor = function (mapId, settings) {
        var pub = {};
        var viewer = {};
        var useClustering = false;
        var useSpiderfier = false;

        var defaults = {
            initInstant: false,
            source: {
                id: 'source',
                type: 'geojson',
                path: false,
                param: null,
            },
            marker: {
                icon: null,
                options: null
            },
            popup: {
                showEvent: 'click',
                hideEvent: false,
                options: null,
                propSelector: 'template',
                source: {
                    path: false,
                    param: null,
                    loader: true,
                    loaderMarkup: '<span class="loader"></span>'
                }
            },
            spider: {
                spiderfier: false,
                closePopupOnUnspiderfy: true,
                format: null,
                options: {
                    keepSpiderfied: true,
                    markersWontMove: true,
                    markersWontHide: true,
                    basicFormatEvents: false
                }
            },
            cluster: {
                clustering: false,
                clusterSteps: null,
                styles: null,
                options: {
                    maxZoom: 14
                }
            },
            map: {
                bounds: false,
                interactive: true,
                mapTypeControl: false,
                fullscreen: true,
                streetview: true,
                scrollwheel: false,
                gestureHandling: 'cooperative',
                style: 'roadmap',
                styles: null,
                zoom: 6,
                minZoom: 3,
                maxZoom: 16,
                lat: null,
                lng: null
            }
        };

        /**
         * Initialize Google Maps Viewer and create a Map
         */
        var init = function () {
            // extend default settings
            viewer.settings = extend(true, defaults, settings);

            // get dom object
            viewer.dom = document.getElementById(mapId);

            // add marker array
            viewer.markers = [];

            if(!viewer.dom){
                console.warn('GoogleMapsViewer: Dom object could not be loaded by ID', mapId);
                return;
            }

            // check if the api ready for use
            if(viewer.settings.initInstant && typeof google !== 'object'){
                console.warn('GoogleMapsViewer: google.maps is not defined. If you load the script by async, use onGoogleMapsApiReady-Callback and set option initInstant to false.');
                return;
            }

            // init on api ready callback
            if(!viewer.settings.initInstant){
                document.addEventListener('googlemaps.onApiReady', createMap);

                // init map directly
            }else{
                createMap();
            }
        };

        var createMap  = function(){
            // create map
            viewer.map = new google.maps.Map(viewer.dom, {
                zoom: parseInt(viewer.settings.map.zoom),
                minZoom: parseInt(viewer.settings.map.minZoom),
                maxZoom: parseInt(viewer.settings.map.maxZoom),

                center: {
                    lat: parseFloat(viewer.settings.map.lat),
                    lng: parseFloat(viewer.settings.map.lng)
                },

                mapTypeControl:    viewer.settings.map.mapTypeControl,
                zoomControl:       viewer.settings.map.controls,
                fullscreenControl: viewer.settings.map.fullscreen,
                streetViewControl: viewer.settings.map.streetview,

                disableDoubleClickZoom: !viewer.settings.map.interactive,
                draggable:               viewer.settings.map.interactive,
                gestureHandling:         viewer.settings.map.gestureHandling,
            });

            // create bounds object
            viewer.bounds = new google.maps.LatLngBounds();

            // create popup object
            viewer.popup = new google.maps.InfoWindow(viewer.settings.popup.options);
            viewer.popupAsync = false;

            if(viewer.settings.popup.source !== null && viewer.settings.popup.source.path) {
                // create an XHR object to load popups asynchronously
                viewer.popupLoader = new XMLHttpRequest();
                viewer.popupAsync = true;
            }

            // add custom styles
            if(viewer.settings.map.styles !== null){
                var customStyle = new google.maps.StyledMapType(viewer.settings.map.styles, {name: 'Normal'});

                viewer.map.mapTypes.set('custom_style', customStyle);
                viewer.map.setMapTypeId('custom_style');
            }

            // load source
            if(viewer.settings.source.path){
                loadSource(viewer.settings.source.path, viewer.settings.source.param);
            }else{
                loadExtensions();
            }
        };

        var loadExtensions = function(){
            // add spiderfier
            if(viewer.settings.spider !== null && viewer.settings.spider.spiderfier){
                addSpiderSupport();
            }

            // add cluster object
            if(viewer.settings.cluster !== null && viewer.settings.cluster.clustering){
                addClusterSupport();
            }
        };

        var addClusterSupport = function(){
            viewer.cluster = new MarkerClusterer(viewer.map, viewer.markers, viewer.settings.cluster.options);

            // set styles
            if(viewer.settings.cluster.styles){
                viewer.cluster.setStyles(viewer.settings.cluster.styles);
            }

            // count to style calculator
            viewer.cluster.setCalculator(function(markers, numStyles) {
                var count = markers.length;
                var steps = viewer.settings.cluster.clusterSteps;
                var index = 0;

                for (var i=0; i<steps.length; i++) {
                    if (count > steps[i])
                    {
                        index++;
                    }
                }

                index = Math.min(index, numStyles);

                return {
                    text: count,
                    index: index
                };
            });

            useClustering = true;
        };

        var addSpiderSupport = function(){
            viewer.spider = new OverlappingMarkerSpiderfier(viewer.map, viewer.settings.spider.options);

            // set marker format
            if(viewer.settings.spider.format !== null) {
                if(viewer.settings.spider.format.length === 3){
                    viewer.spider.addListener('format', function (marker, status) {
                        var p,w,h;
                        var validStatus = [
                            OverlappingMarkerSpiderfier.markerStatus.SPIDERFIED,
                            OverlappingMarkerSpiderfier.markerStatus.SPIDERFIABLE,
                            OverlappingMarkerSpiderfier.markerStatus.UNSPIDERFIABLE
                        ];

                        for(var i=0; i<validStatus.length; i++)
                        {
                            if(status === validStatus[i]){
                                p = viewer.settings.spider.format[i][0];
                                w = viewer.settings.spider.format[i][1];
                                h = viewer.settings.spider.format[i][2];

                                break;
                            }
                        }

                        marker.setIcon({
                            url: p,
                            scaledSize: new google.maps.Size(w, h)
                        });
                    });
                }else{
                    console.warn('GoogleMapsViewer: Wrong parameter for spiderfier:format');
                }
            }

            // close active info windows on unspiderfy
            viewer.spider.addListener('unspiderfy', function (a,b) {
                if(viewer.settings.spider.closePopupOnUnspiderfy){
                    viewer.popup.close();
                }
            });

            useSpiderfier = true;
        };

        var loadSource = function(path, param){
            var url = path;

            if(typeof param === 'object'){
                url += '?' + serialize(param);
            }

            // load source by xhr request
            var sourceLoader = new XMLHttpRequest();

            sourceLoader.open('GET', url, true);
            sourceLoader.onload = function() {

                if (sourceLoader.status >= 200 && sourceLoader.status < 400) {

                    // parse geojson
                    var results = JSON.parse(sourceLoader.responseText);

                    if (results.features === undefined) {
                        return;
                    }

                    // set data
                    viewer.geojson = results;

                    // initialize extensions after all data has been loaded
                    loadExtensions();

                    // create marker by geojson
                    for (var i = 0; i < results.features.length; i++) {

                        // add single marker
                        var coords = results.features[i].geometry.coordinates;
                        var latLng = new google.maps.LatLng(coords[1],coords[0]);

                        pub.addMarker(latLng, results.features[i].properties[ viewer.settings.popup.propSelector ], {}, results.features[i].properties);
                    }

                    // set viewport including all markers
                    if(!viewer.bounds.isEmpty()){
                        viewer.map.fitBounds(viewer.bounds);

                        if(useClustering) {
                            // Cluster fix: #469
                            google.maps.event.addListenerOnce(viewer.map, 'idle', function () {
                                viewer.cluster.repaint();
                            });
                        }
                    }
                }
            };

            sourceLoader.onerror = function() {
                // stuff for error (hide loader etc)
            };

            sourceLoader.send();
        };

        /**
         * Helper methods
         */
        var serialize = function (obj, prefix) {
            var str = [],
                p;
            for (p in obj) {
                if (obj.hasOwnProperty(p)) {
                    var k = prefix ? prefix + "[" + p + "]" : p,
                        v = obj[p];
                    str.push((v !== null && typeof v === "object") ?
                        serialize(v, k) :
                        encodeURIComponent(k) + "=" + encodeURIComponent(v));
                }
            }
            return str.join("&");
        };

        var extend = function () {
            // Variables
            var extended = {};
            var deep = false;
            var i = 0;
            var length = arguments.length;

            // Check if a deep merge
            if ( Object.prototype.toString.call( arguments[0] ) === '[object Boolean]' ) {
                deep = arguments[0];
                i++;
            }

            // Merge the object into the extended object
            var merge = function (obj) {
                for ( var prop in obj ) {
                    if ( Object.prototype.hasOwnProperty.call( obj, prop ) ) {
                        // If deep merge and property is an object, merge properties
                        if ( deep && Object.prototype.toString.call(obj[prop]) === '[object Object]' ) {
                            extended[prop] = extend( true, extended[prop], obj[prop] );
                        } else {
                            extended[prop] = obj[prop];
                        }
                    }
                }
            };

            // Loop through each object and conduct a merge
            for ( ; i < length; i++ ) {
                var obj = arguments[i];
                merge(obj);
            }

            return extended;
        };

        /**
         * Public methods
         */
        pub.addMarker = function(latLng, htmlContent, markerOptions, markerProps){
            // fallback for lat and lng values passed by array
            if(Array.isArray(latLng)){
                latLng = new google.maps.LatLng(latLng[0],latLng[1])
            }

            // set nessesary settings
            var defaultOptions = {
                position: latLng,
                map: viewer.map
            };

            // set icon from settings
            if(viewer.settings.marker !== null && viewer.settings.marker.icon !== null && viewer.settings.marker.icon.imagePath){
                defaultOptions = extend(defaultOptions, {
                    icon: viewer.settings.marker.icon.imagePath
                });
            }

            // create marker
            var marker = new google.maps.Marker(
                extend(defaultOptions, viewer.settings.marker.options, markerOptions || {})
            );

            marker.props = markerProps || null;
            marker.popup = {
                content: htmlContent,
                path: viewer.settings.popup.source.path,
                param: viewer.settings.popup.source.param
            };

            // create info window / popup
            if(htmlContent || viewer.popupAsync) {

                if(viewer.popupAsync){
                    // replace placeholder
                    if(marker.props !== null && viewer.settings.popup.source.path.indexOf('%') !== -1){
                        var url = viewer.settings.popup.source.path.replace(/%\w+%/g, function(token) {
                            token = token.replace(/%+/g, '');
                            return marker.props[token] || token;
                        });

                        if(typeof viewer.settings.popup.source.param === 'object'){
                            url += '?' + serialize(viewer.settings.popup.source.param);
                        }

                        marker.popup.path = url;
                    }
                }

                if(viewer.settings.popup.showEvent){
                    marker.addListener(viewer.settings.popup.showEvent === 'click' && useSpiderfier ? 'spider_click' : viewer.settings.popup.showEvent, function() {
                        // close active popup
                        viewer.popup.close();

                        if(viewer.popupAsync){
                            // cancel current xhr
                            viewer.popupLoader.abort();

                            // add loader
                            if(viewer.settings.popup.source.loader){
                                viewer.popup.setContent(viewer.settings.popup.source.loaderMarkup);
                            }

                            viewer.popupLoader.open('GET', marker.popup.path, true);
                            viewer.popupLoader.onload = function() {

                                if (viewer.popupLoader.status >= 200 && viewer.popupLoader.status < 400) {
                                    // parse json
                                    var results = JSON.parse(viewer.popupLoader.responseText);

                                    viewer.popup.setContent(results.results[0][viewer.settings.popup.propSelector]);
                                }
                            };

                            viewer.popupLoader.onerror = function() {
                                // stuff for error (hide loader etc)
                            };

                            viewer.popupLoader.send();
                        }else{
                            viewer.popup.setContent(marker.popup.content);
                        }

                        viewer.popup.open(viewer.map, marker);
                    });
                }

                if(viewer.settings.popup.hideEvent){
                    marker.addListener(viewer.settings.popup.hideEvent, function() {
                        viewer.popup.close();
                    });
                }
            }

            // push to marker collection
            viewer.markers.push(marker);

            // push marker to cluster object
            if(useClustering){
                viewer.cluster.addMarker(marker);
            }

            // push marker to spider object
            if(useSpiderfier){
                viewer.spider.addMarker(marker);
            }

            // push to bounds object
            if(viewer.settings.map.bounds){
                viewer.bounds.extend(latLng);
            }
        };

        pub.getViewer = function(){
            return viewer;
        };

        init();

        return pub;
    };

    return Constructor;
})();
