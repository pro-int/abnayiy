// Add new role Modal JS
//------------------------------------------------------------------
(function () {
  var addRoleForm = $('#addRoleForm');

  // add role form validation
  if (addRoleForm.length) {
    addRoleForm.validate({
      rules: {
        name: {
          required: true
        },
        display_name: {
          required: true
        },
        color: {
          required: true
        },
        "permission[]": {
          required: true,
          minlength: 1
        }
      },
      submitHandler: function (form) {
        form.submit();
      }
    });
  }

  // reset form on modal hidden
  $('.modal').on('hidden.bs.modal', function () {
    $(this).find('form')[0].reset();
  });

  // Select All checkbox click
  const selectAll = document.querySelector('#selectAll'),
    checkboxList = document.querySelectorAll('[type="checkbox"]');
  selectAll.addEventListener('change', t => {
    checkboxList.forEach(e => {
      e.checked = t.target.checked;
    });
  });
})();
