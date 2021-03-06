/*!
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2017
 * @version   3.1.5
 *
 * Client actions for yii2-grid CheckboxColumn
 * 
 * Author: Kartik Visweswaran
 * Copyright: 2015, Kartik Visweswaran, Krajee.com
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Yii related demos visit http://demos.krajee.com
 */var kvSelectRow,kvSelectColumn;!function(e){"use strict";kvSelectRow=function(i,n){var c=e("#"+i),t=function(e,i){var c=e.closest("tr"),t=i||e;t.is(":checked")&&!e.attr("disabled")?c.removeClass(n).addClass(n):c.removeClass(n)},l=function(i,n){return n===!0?void c.find(".kv-row-select input").each(function(){t(e(this),i)}):void t(i)};c.find(".kv-row-select input").on("change",function(){l(e(this))}).each(function(){l(e(this))}),c.find(".kv-all-select input").on("change",function(){l(e(this),!0)})},kvSelectColumn=function(i,n){var c,t,l,o="#"+i,d=e(o);n.multiple&&n.checkAll&&(c=o+" input[name='"+n.checkAll+"']",t=n["class"]?"input."+n["class"]:"input[name='"+n.name+"']",l=o+" "+t+":enabled",e(document).off("click.yiiGridView",c).on("click.yiiGridView",c,function(){d.find(t+":enabled").prop("checked",this.checked)}),e(document).off("click.yiiGridView",l).on("click.yiiGridView",l,function(){var e=d.find(t).length==d.find(t+":checked").length;d.find("input[name='"+n.checkAll+"']").prop("checked",e)}))}}(window.jQuery);