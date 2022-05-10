(function ($) {
  // Argument passed from InvokeCommand.
  $.fn.myAjaxCallback = function (argument) {
    console.log('всякая фигня');
  };
})(jQuery);

console.log('файл ajax-example.js подлкючен');