/*!
 * @package   yii2-export
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2017
 * @version   1.2.8
 *
 * Export Columns Selector Validation Module.
 *
 * Author: Kartik Visweswaran
 * Copyright: 2015, Kartik Visweswaran, Krajee.com
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */!function(n){var t=function(t,o){var e=this;e.$element=n(t),e.options=o,e.listen()};t.prototype={constructor:t,listen:function(){var n=this,t=n.$element,o=t.find('input[name="export_columns_toggle"]');t.off("click").on("click",function(n){n.stopPropagation()}),o.off("change").on("change",function(){var n=o.is(":checked");t.find('input[name="export_columns_selector[]"]:not([disabled])').prop("checked",n)})}},n.fn.exportcolumns=function(o){var e=Array.apply(null,arguments);return e.shift(),this.each(function(){var c=n(this),i=c.data("exportcolumns"),a="object"==typeof o&&o;i||c.data("exportcolumns",i=new t(this,n.extend({},n.fn.exportcolumns.defaults,a,n(this).data()))),"string"==typeof o&&i[o].apply(i,e)})},n.fn.exportcolumns.defaults={}}(window.jQuery);