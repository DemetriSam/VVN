(function ($) {
  // Argument passed from InvokeCommand.
  $.fn.myAjaxCallback = function (argument) {
    console.log(argument);
  };
})(jQuery);