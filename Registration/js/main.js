$(function () {
  const $form = $('#registration-form'), phonePattern = /^[0-9+().\s-]{7,20}$/;
  function validate($field) {
    const name = $field.attr('name'), value = ($field.val() || '').trim(); let message = '';
    if ($field.prop('required') && ($field.is(':checkbox') ? !$field.is(':checked') : !value)) message = 'This field is required.';
    else if (name === 'email' && value && !$field[0].validity.valid) message = 'Enter a valid email address.';
    else if (name === 'phone' && value && !phonePattern.test(value)) message = 'Enter a valid phone number.';
    else if (name === 'dob' && value && new Date(value + 'T00:00:00') > new Date()) message = 'Date of birth cannot be in the future.';
    else if (name === 'motivation' && value.length < 50) message = 'Please write at least 50 characters.';
    $field.closest('label').find('.error').first().text(message);
    $field.toggleClass('invalid', Boolean(message)).attr('aria-invalid', message ? 'true' : 'false');
    return !message;
  }
  $form.on('input change', 'input, select, textarea', function () {
    if ($(this).hasClass('invalid')) validate($(this));
    if (this.name === 'motivation') $('#char-count').text(this.value.length);
  });
  $('#char-count').text($('[name="motivation"]').val().length);
  $form.on('submit', function (event) {
    let valid = true;
    $form.find('input[required], select[required], textarea[required]').each(function () { if (!validate($(this))) valid = false; });
    if (!valid) { event.preventDefault(); const $first = $form.find('.invalid').first(); $first.trigger('focus'); $first[0].scrollIntoView({ behavior: 'smooth', block: 'center' }); }
    else $form.find('button[type="submit"]').prop('disabled', true).html('TRANSMITTING… <span>↗</span>');
  });
  $('a[href^="#"]').on('click', function (event) { const target = $(this.getAttribute('href'))[0]; if (target) { event.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); } });
});
