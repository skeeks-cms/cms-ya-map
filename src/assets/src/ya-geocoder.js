/*!
 * Геокодирование адресов и координат для виджетов yandex карт.
 *
 * Яндекс разделил продукты: ключ «JavaScript API» больше не даёт доступ к геокодеру,
 * для него нужен отдельный ключ «API Геокодера». Если он задан в настройках компонента
 * (YaMapComponent::$geocoder_apikey), запросы идут напрямую в HTTP Геокодер,
 * иначе — по-старому через ymaps.geocode().
 *
 * Результат всегда один и тот же: {coords: [lat, lon], text, name, object}.
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright 2010 SkeekS
 */
(function(sx, $, _)
{
    sx.YaGeocoder = {

        apikey: '',
        lang: 'ru_RU',
        url: 'https://geocode-maps.yandex.ru/1.x/',

        /**
         * @param {string|Array} query адрес строкой или координаты [lat, lon]
         * @returns {jQuery.Promise}
         */
        geocode: function(query)
        {
            if (this.apikey) {
                return this._geocodeHttp(query);
            }

            return this._geocodeJsApi(query);
        },

        _geocodeHttp: function(query)
        {
            var dfd = $.Deferred();

            //Для обратного геокодирования HTTP Геокодер ждёт порядок «долгота,широта»
            var geocode = $.isArray(query) ? query[1] + ',' + query[0] : query;

            $.ajax({
                url: this.url,
                dataType: 'json',
                data: {
                    apikey: this.apikey,
                    geocode: geocode,
                    format: 'json',
                    results: 1,
                    lang: this.lang
                }
            }).done(function(response) {
                var members = response && response.response && response.response.GeoObjectCollection
                    ? response.response.GeoObjectCollection.featureMember : [];

                if (!members || !members.length) {
                    dfd.reject('Адрес не найден');
                    return;
                }

                var geoObject = members[0].GeoObject;
                var pos = geoObject.Point.pos.split(' ');

                dfd.resolve({
                    coords: [parseFloat(pos[1]), parseFloat(pos[0])],
                    text: geoObject.metaDataProperty.GeocoderMetaData.text,
                    name: geoObject.name,
                    object: geoObject
                });
            }).fail(function(xhr) {
                var message = 'Геокодер Яндекса недоступен';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = message + ': ' + xhr.responseJSON.message;
                }
                dfd.reject(message + '. Проверьте ключ API Геокодера в настройках yandex карт.');
            });

            return dfd.promise();
        },

        _geocodeJsApi: function(query)
        {
            var dfd = $.Deferred();

            ymaps.geocode(query, {results: 1}).then(function(res) {
                var geoObject = res.geoObjects.get(0);
                if (!geoObject) {
                    dfd.reject('Адрес не найден');
                    return;
                }

                dfd.resolve({
                    coords: geoObject.geometry.getCoordinates(),
                    text: geoObject.properties.get('text'),
                    name: geoObject.properties.get('name'),
                    object: geoObject
                });
            }, function(error) {
                dfd.reject('Геокодер Яндекса недоступен. Укажите ключ API Геокодера в настройках yandex карт.');
            });

            return dfd.promise();
        }
    };

})(sx, sx.$, sx._);
