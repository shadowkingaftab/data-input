$(function () {
  const $form = $('#registration-form');
  const namePattern = /^[\p{L}][\p{L}\p{M} .'’-]*$/u;
  const phonePattern = /^\d{10}$/;
  const studentIdPattern = /^\d[A-Z]{2}\d{2}[A-Z]{2}\d{3}$/;
  function validate($field) {
    const name = $field.attr('name'), value = ($field.val() || '').trim(); let message = '';
    if ($field.prop('required') && ($field.is(':checkbox') ? !$field.is(':checked') : !value)) message = 'This field is required.';
    else if (name === 'full_name' && value && !namePattern.test(value)) message = 'Use letters only (spaces, apostrophes, and hyphens are allowed).';
    else if (name === 'email' && value && $field[0].validity.typeMismatch) message = 'Enter a valid email address.';
    else if (name === 'email' && value && value.toLowerCase().split('@').pop() !== 'gmail.com') message = 'Use a Gmail address ending in @gmail.com.';
    else if (name === 'phone' && value && !phonePattern.test(value)) message = 'Phone number must be exactly 10 digits.';
    else if (name === 'dob' && value && new Date(value + 'T00:00:00') > new Date()) message = 'Date of birth cannot be in the future.';
    else if (name === 'student_id' && value && !studentIdPattern.test(value.toUpperCase())) message = 'Use the 10-character format 2KE24CS008.';
    else if (name === 'motivation' && value.length < 50) message = 'Please write at least 50 characters.';
    $field.closest('label').find('.error').first().text(message);
    $field.toggleClass('invalid', Boolean(message)).attr('aria-invalid', message ? 'true' : 'false');
    return !message;
  }
  $form[0].addEventListener('invalid', function (event) { validate($(event.target)); }, true);
  $form.on('focus', 'input, select, textarea', function () { $(this).data('touched', true); });
  $form.on('blur', 'input, select, textarea', function () { validate($(this)); });
  $form.on('input change', 'input, select, textarea', function () {
    if (this.name === 'student_id') this.value = this.value.toUpperCase();
    if ($(this).data('touched') || $(this).hasClass('invalid')) validate($(this));
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
