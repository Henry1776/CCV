'use strict';

(function($) {
  const form = $('.contact__form');
  const message = $('.contact__msg');

  // Consolidated function for both success and failure
  function handleResponse(response, isSuccess) {
    message.fadeIn();
    message.removeClass(isSuccess ? 'alert-danger' : 'alert-success');
    message.addClass(isSuccess ? 'alert-success' : 'alert-danger'); // Corrected class for failure
    message.text(response);

    setTimeout(() => {
      message.fadeOut();
    }, 5000);

    if (isSuccess) {
      form.find('input:not([type="submit"]), textarea').val('');
    }
  }

  form.submit(function(e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.ajax({
      type: 'POST',
      url: form.attr('action'),
      data: formData,
      dataType: 'text' // Explicitly set dataType to handle text responses consistently
    })
    .done(response => handleResponse(response, true))
    .fail(jqXHR => handleResponse(jqXHR.responseText || "An error occurred.", false)); // Provide a default message
  });

})(jQuery);