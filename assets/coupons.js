jQuery(document).ready(function($) {
  if (Array.isArray(pos_coupon_presets)) {
    $('#modal-order_discount #coupon_tab .wrap-button').before('<div class="wrap-button wrap-custom-button-discount" ></div>');
    var wrapper = $('#modal-order_discount #coupon_tab .wrap-custom-button-discount');
    for (var i = 0; i < pos_coupon_presets.length; i++) {
      $(wrapper).append('<button class="button button-primary wp-button-large alignright" type="button" name="' + pos_coupon_presets[i] + '"> ' + pos_coupon_presets[i] + '</button></div>');
    }
    $('#modal-order_discount #coupon_tab .wrap-custom-button-discount button').each(function(a) {
      $(this).click(function(e) {
        CART.add_discount($(this).attr('name'));
      });
    });
  }
});
