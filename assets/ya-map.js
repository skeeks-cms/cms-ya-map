/*!
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */
(function(sx, $, _)
{
    sx.createNamespace('classes.ya', sx);
    sx.createNamespace('classes.ya.plugins', sx);
    /**
     * {
     *      'id' : 'map-id-container',
     *      'ya' : { //Опции инициализации карты
     *          'center' : [],
     *          'zoom' : 10,
     *      }
     * }
     * this.YaMap = new ymaps.Map();
     */
    sx.classes.ya.MapObject = sx.classes.Component.extend({

        construct: function (id, opts)
        {
            var self = this;
            opts = opts || {};
            opts['id'] = id;
            this.isReady = false
            //this.parent.construct(opts);
            this.applyParentMethod(sx.classes.Component, 'construct', [opts]); // TODO: make a workaround for magic parent calling

            sx.registerMapObject(this);
        },

        _init: function()
        {
            var self = this;
            this.YaMap  = null;

            var onReady = self.get('onReady');
            if (onReady)
            {
                this.bind('ready', function(e, data)
                {
                    onReady(e, self);
                });
            }

            ymaps.ready(function()
            {
                self.YaMap   = new ymaps.Map(self.get('id'), self.get('ya'));
                self.isReady    = true;

                self.trigger("ready", self);
            });
        },

        /**
         *
         * @param callback
         * @returns {sx.classes.ya.MapObject}
         */
        onReady: function(callback)
        {
            var self = this;

            if (this.isReady)
            {
                callback(this);
            } else
            {
                this.bind("ready", function(e, data)
                {
                    callback(self)
                });
            }

            return this;
        }
    });

    /**
     *
     */
    sx.classes.ya.plugins._Base = sx.classes.Component.extend({

        construct: function (MapObject, opts)
        {
            var self = this;
            opts = opts || {};

            if (!(MapObject instanceof sx.classes.ya.MapObject))
            {
                throw new Error("Instance of sx.classes.ya.MapObject was expected.");
            }

            this.MapObject  = MapObject;
            this.YaMap      = null; //ya map instance
            this.applyParentMethod(sx.classes.Component, 'construct', [opts]); // TODO: make a workaround for magic parent calling


        },

        _init: function()
        {
            var self = this;

            if (this.MapObject.isReady)
            {
                self.YaMap = self.MapObject.YaMap;
                self._initOnReady();
            } else
            {
                this.MapObject.bind('ready', function()
                {
                    self.YaMap = self.MapObject.YaMap;
                    self._initOnReady();
                });
            }
        },

        _initOnReady: function()
        {

        }
    });
    /**
     * sx.yaMaps.get('idMap');
     */
    sx.yaMaps = new sx.classes.Entity();

    // register function
    sx.registerMapObject = function(component)
    {
        if (!(component instanceof sx.classes.ya.MapObject))
        {
            throw new Error("Instance of sx.classes.ya.MapObject was expected.");
        }

        sx.yaMaps.set(component.get('id'), component);

        return component;
    };

})(sx, sx.$, sx._);