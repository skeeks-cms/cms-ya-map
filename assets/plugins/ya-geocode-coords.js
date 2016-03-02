/*!
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */
(function(sx, $, _)
{
    sx.classes.ya.plugins.GeocodeCoords = sx.classes.ya.plugins._Base.extend({

        _initOnReady: function()
        {
            this.Placemark  = null;
            var self        = this;

            this._initControllSearch();
            this._initScenario();
        },

        _initControllSearch: function()
        {
            var self = this;

            this.SearchControl = new ymaps.control.SearchControl({
                options: {
                    noPlacemark: true
                }
            });

            this.MapObject.YaMap.controls.add(
                this.SearchControl
            );

        // Результаты поиска будем помещать в коллекцию.
            this.SearchResults = new ymaps.GeoObjectCollection(null, {
                hintContentLayout: ymaps.templateLayoutFactory.createClass('$[properties.name]'),
                draggable: true
            });

        // При клике по найденному объекту метка становится красной.
            this.SearchResults.events.add('click', function (e) {
                e.get('target').options.set('preset', 'islands#redIcon');
            });

             // Выбранный результат помещаем в коллекцию.
            self.SearchControl.events.add('resultselect', function (e) {
                var index = e.get('index');
                self.SearchControl.getResult(index).then(function (res)
                {
                    self.setCoordinates(res.geometry.getCoordinates());
                    self.SearchResults.add(res);
                });
            }).add('submit', function ()
            {
                self.SearchResults.removeAll();
            });
        },

        _initScenario: function()
        {
            var self = this;
            // Слушаем клик на карте
            this.MapObject.YaMap.events.add('click', function (e) {
                var coords = e.get('coords');
                self.setCoordinates(coords);
            });

            return this;
        },

        setCoordinates: function(coords)
        {
            var self = this;
            // Если метка уже создана – просто передвигаем ее
            if (self.Placemark)
            {
                self.Placemark.geometry.setCoordinates(coords);
            }
            // Если нет – создаем.
            else
            {
                self.Placemark = self.createPlacemark(coords);
                self.MapObject.YaMap.geoObjects.add(self.Placemark);
                // Слушаем событие окончания перетаскивания на метке.
                self.Placemark.events.add('dragend', function ()
                {
                    self.getAddress(self.Placemark.geometry.getCoordinates());
                });
            }

            this.MapObject.YaMap.panTo(coords);

            self.getAddress(coords);
        },

        createPlacemark: function(coords)
        {
            var self = this;
             return new ymaps.Placemark(coords, {
                iconContent: 'поиск...'
            }, {
                preset: 'islands#violetStretchyIcon',
                draggable: true
            });
        },

        getAddress: function(coords)
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
                self.MapObject.trigger('select', data);

                self.Placemark.properties
                    .set({
                        iconContent: firstGeoObject.properties.get('name'),
                        balloonContent: firstGeoObject.properties.get('text')
                    });
            });
        },
    });

})(sx, sx.$, sx._);