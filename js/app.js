/**
 * ==============================================
 *  APP.JS
 * ==============================================
 * Default JS
 *
 * @since    0.1
 * @author    Chris Carvache
 */

(function ($) {
  if ($('.budget-slider').length) {
    $('.budget-slider').each(function () {
      me = $(this);
      slider = me.find('input[type="range"]');
      leads = me.find('.leads .number');
      jobs = me.find('.jobs .number');
      revenue = me.find('.revenue .number');

      slider.on('input', function () {
        val = slider.val();
        leads.html(me.attr('data-' + val + '-number_of_leads'));
        jobs.html(me.attr('data-' + val + '-number_of_jobs'));
        revenue.html(me.attr('data-' + val + '-potential_revenue'));
      });

      slider.trigger('input');

      // fix budget width
      item_width = (100 / me.attr('data-number-sections'));
      $('.budgets ul li').attr('style', 'width: ' + item_width + '%');

    });
  }
})(jQuery);
