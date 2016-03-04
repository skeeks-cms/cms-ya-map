/*!
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */
(function(sx, $, _)
{
    /**
     * Генерация события измеения карты с задержкой
     */
    sx.classes.ya.plugins.ChangeWithDelay = sx.classes.ya.plugins._Base.extend({

        _init: function()
        {
            var self = this;

            this._lastChangeTime        = new Date().getTime();
            this._triggerEvent          = true;
            this._changeOpenBallon      = false;

            this.applyParentMethod(sx.classes.ya.plugins._Base, '_init');
        },

        _initOnReady: function()
        {
            var self = this;

            this.MapObject.YaMap.events.add('boundschange', function (e) {
                self._changeEvent();
            });

            this.MapObject.YaMap.events.add('boundschange', function (e) {
                if (self._changeOpenBallon === true)
                {
                    self._changeEvent();
                }
            });
        },

        /**
         * @private
         */
        _changeEvent: function()
        {
            var self = this;
            this._lastChangeTime = new Date().getTime();
            var delay = Number(this.get('delay', 500));

            _.delay(function()
            {
                var time = new Date().getTime();

                if (time - self._lastChangeTime >= delay && self._triggerEvent === true)
                {
                    if (!self.MapObject.YaMap.balloon.isOpen())
                    {
                        self._changeOpenBallon = false;
                        self.trigger('change');
                    } else
                    {
                        self._changeOpenBallon = true;
                    }

                }

                self._triggerEvent = true;

            }, delay );
        },

    });

})(sx, sx.$, sx._);