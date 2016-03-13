$(function() {
  $('*[data-toggle="tooltip"]').tooltip();
  data_confirm();
  mask_fields();
  toogle_contact_message();
  auto_complete();
});

/*** Confirm dialog **/
var data_confirm = function () {
  $('a[data-confirm], button[data-confirm]').click( function () {
    var msg = $(this).data('confirm');
    return confirm(msg); 
  });
};

//var data_confirm = function () {
//  $('a[data-confirm], button[data-confirm]').click( function () {
//    var msg = $(this).data('confirm');
//    return confirm(msg);
//  });
//};

/*
 * Show fields with 
 * https://github.com/plentz/jquery-maskmoney
 * **/
 var mask_fields = function () {
  if ($('.mask_money').length == 0) return false;

  $('.mask_money').maskMoney({
    prefix:'R$ ',
    thousands: '.',
    decimal: ','
  });
  $('.mask_money').maskMoney('mask');
};

/*
* Show and hide contact message **/
var toogle_contact_message = function () {
 $('#contacts table tbody a').on('click', function (event) {
  event.preventDefault();
  var id = $(this).attr('href');
  var msg = $(this).closest('tbody').find(id);
  msg.toggleClass('hidden');
});
};

/*
 * https://github.com/devbridge/jQuery-Autocomplete
 */

 var auto_complete = function () {

  var url = $('#autocomplete_clients').data('url');
  console.log(url);
  $('#autocomplete_clients').autocomplete({
    serviceUrl: url,
    onSelect: function (suggestion) {
      console.log(suggestion.data);
      $('#service_order_clients_id').val(suggestion.data)
    }
  });

}
