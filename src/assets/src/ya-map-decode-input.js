(function(sx, $, _)
{
    sx.classes.YaMapDecodeWidget = sx.classes.Component.extend({

        _init: function()
        {
            var self = this;
            self.YaMap = null;

            self.isSelectEvent = true;
            self.changeEvent = null;

            ymaps.ready(function () {
                self.YaMap = new ymaps.Map(self.get('yaMapId'), {
                    center: [55.751574, 37.573856],
                    zoom: 13,
                    controls: ['zoomControl']
                });

                self.SuggestView = new ymaps.SuggestView(self.get("id"));

                self.SuggestView.events.add("select", function(e) {
                    console.log("select!!!");
                    self.isSelectEvent = true;
                    self.setPlacemark(self.getJValueElement().val());
                    
                    if (self.changeEvent === null) {
                        self.getJValueElement().trigger("change", {
                            'after_select' : true
                        });
                    } else {
                        self.changeEvent = null;
                    }

                    //self.getJValueElement().trigger("change");
                });
                //По клику на карту установка точки + установка нового адреса в поле адреса
                self.YaMap.events.add('click', function (e) {
                    var coords = e.get('coords');
                    self
                        .setCoordinates(coords)
                        .setAddress(coords)
                    ;
                });
            });
        },

        createPlacemark: function(coords) {
            var self = this;
             return new ymaps.Placemark(coords, {
                iconContent: 'поиск...'
            }, {
                preset: 'islands#violetStretchyIcon',
                draggable: true
            });
        },

        setCoordinates: function(coords) {
            var self = this;
            // Если метка уже создана – просто передвигаем ее
            if (self.Placemark) {
                self.Placemark.geometry.setCoordinates(coords);
            }
            // Если нет – создаем.
            else
            {
                self.Placemark = self.createPlacemark(coords);
                self.YaMap.geoObjects.add(self.Placemark);
                // Слушаем событие окончания перетаскивания на метке.
                self.Placemark.events.add('dragend', function ()
                {
                    self.setAddress(self.Placemark.geometry.getCoordinates());
                });
            }
            
            $('#' + self.get("latitude_element")).val(coords[0]);
            $('#' + self.get("longitude_element")).val(coords[1]);

            this.YaMap.panTo(coords);
            return this;
        },

        setAddress: function(coords)
        {
            var self = this;
             self.Placemark.properties.set('iconContent', 'поиск...');
             ymaps.geocode(coords).then(function (res)
             {
                var firstGeoObject = res.geoObjects.get(0);

                 var data = {
                    'object'        : firstGeoObject,
                    'address'       : firstGeoObject.properties.get('text'),
                    'address_name'  : firstGeoObject.properties.get('name'),
                    'coords'        : coords,
                };
                self.trigger('select', data);

                self.getJValueElement().val(data.address);
                $('#' + self.get("latitude_element")).val(data.coords[0]);
                $('#' + self.get("longitude_element")).val(data.coords[1]);

                self.getJValueElement().focus();

                 /*console.log("new value");
                 setTimeout(function() {
                     self.getJHiddenInput().focus();
                     console.log(self.getJHiddenInput());
                     console.log("focusout");
                 }, 2000);*/

                self.Placemark.properties
                    .set({
                        iconContent: firstGeoObject.properties.get('name'),
                        balloonContent: firstGeoObject.properties.get('text')
                    });
            });
        },

        getJValueElement: function() {
            return $('#' + this.get("id"));
        },
        getJMap: function() {
            return $('#' + this.get('yaMapId'));
        },
        getJMapWrapper: function() {
            return this.getJMap().closest(".sx-map-wrapper");
        },
        getJWidget: function() {
            return this.getJMap().closest(".sx-ya-map-decode-input");
        },
        getJShowMap: function() {
            return $(".sx-trigger-show-map", this.getJWidget());
        },
        getJHiddenInput: function() {
            return $(".sx-hidden-input", this.getJWidget());
        },

        setPlacemark: function(address, isSetAddress = false) {
            var self = this;

            ymaps.geocode(address, {
                results: 1
            }).then(function (res) {
                // Выбираем первый результат геокодирования.
                var firstGeoObject = res.geoObjects.get(0),
                    // Координаты геообъекта.
                    coords = firstGeoObject.geometry.getCoordinates(),
                    // Область видимости геообъекта.
                    bounds = firstGeoObject.properties.get('boundedBy');

                self.setCoordinates(coords);
                if (isSetAddress) {
                    self.setAddress(coords);
                }

                self.Placemark.properties.set('iconContent', address);
            });
        },

        _onDomReady: function()
        {
            var self = this;
            //Когда изменилось значение адреса в поле
            self.getJValueElement().on("change", function(e, data) {
                console.log("change!!!");
                if (data && data.after_select) {
                    return true;
                }
                
                self.changeEvent = e;

                self.isSelectEvent = false;
                var address = $(this).val();
                
                setTimeout(function() {
                    if (self.isSelectEvent) {
                        console.log("Уже сработало событие select!");
                        return false;
                    }

                    self
                        .setPlacemark(address, true)
                    ;
                }, 200);
                
            });


            //Если значение указано надо нанести его на карту
            if (self.getJValueElement().val()) {
                if (self.YaMap !== null) {
                    self.setPlacemark(self.getJValueElement().val());
                } else {
                    ymaps.ready(function () {
                        self.setPlacemark(self.getJValueElement().val());
                    });
                }
            }

            //По умолчанию карта отражается или нет
            if (self.get("isOpenedMap")) {
                self.getJMapWrapper().show();
                self.getJShowMap().empty().text(self.getJShowMap().data("close-text"));
            } else {
                self.getJShowMap().empty().text(self.getJShowMap().data("open-text"));
            }

            //Открыть закрыть карту
            self.getJShowMap().on("click", function() {
                if (self.getJMapWrapper().is(":visible")) {
                    self.getJMapWrapper().slideUp();
                    self.getJShowMap().empty().text(self.getJShowMap().data("open-text"));
                } else {
                    self.getJMapWrapper().slideDown();
                    self.getJShowMap().empty().text(self.getJShowMap().data("close-text"));
                }
            });
        },
    });
})(sx, sx.$, sx._);