/**
 * Bootstrap Grid plugin for Craft CMS
 *
 * @author    NTH media
 * @copyright Copyright (c) 2020 NTH media
 * @link      https://nthmedia.nl
 * @package   BootstrapGrid
 * @since     1.0.0
 */

;(function($){

    Craft.BootstrapGrid = Garnish.Base.extend({

        $el: $(),

        init : function(settings){
            this.settings = $.extend({}, Craft.BootstrapGrid.defaults, settings);
            this.$el = this.settings.$el;

            var self = this;

            // More padding in actions block in Matrix block titlebar
            this.$el.find('.titlebar').css('padding-right',function() {
                return parseInt($('.titlebar').css('padding-right').replace(/px/, "")) + 30;
            });

            // Add col description to titlebar
            this.addTitleBarDescriptions(this.$el.find('.matrixblock'));

            // Update titlebar when value changes
            $(document).on('change', '.bootstrap-grid-col-field select', function () {
                self.updateTitleBarDescription($(this).closest('.matrixblock'));
            })
        },


        addTitleBarDescriptions: function($blocks){
            var self = this;

            $blocks.each(function(i, block){
                self.updateTitleBarDescription($(block));
            });
        },

        updateTitleBarDescription: function($block){
            var value = $block.find('.bootstrap-grid-col-field select option').filter(":selected");
            var icon = $block.find('.actions .bootstrap-grid-matrixblock-icon');

            if (!value.length) {
                return;
            }

            value = value.attr('value')
            value = value === '12' ? '' : 'col-' + value;

            if (icon.length) {
                return icon.text(value);
            }

            return $('<a href="#" class="bootstrap-grid-matrixblock-icon icon">' + value + '</a>').prependTo($block.find('.actions'));
        },

    });

    // Initialise the expanded matrix after the matrix input has initialised
    var CraftMatrixInputInit = Craft.MatrixInput.prototype.init;
    Craft.MatrixInput.prototype.init = function(id, blockTypes, inputNamePrefix, maxBlocks){
        CraftMatrixInputInit.apply(this, arguments);
        new Craft.BootstrapGrid({$el: this.$container});
    };

})(jQuery);