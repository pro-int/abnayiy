// Add new role Modal JS
//------------------------------------------------------------------
(function () {
    var adminform = $('#adminform');
  
    // add role form validation
    if (adminform.length) {
      adminform.validate({
        rules: {
          first_name: {
            required: true
          },
          last_name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          phone: {
            required: true,
            number: true,
            min: 11
          },
          country_id: {
            required: true
          },
          password: {
            required: true
          },
          job_title: {
            required: true
          },
          password_confirmation: {
            required: true,
            equalTo: "#password"
          },
          "roles[]": {
            required: true,
            minlength: 1
          }
        },
        messages: {
           
            email: {
              email: 'رجاء ادخال بريد البيتكروني '
            },
            phone: {
              required: true,
              number: true,
              min: 11
            },
            country_id: {
              required: true
            },
            password: {
              required: true
            },
            job_title: {
              required: true
            },
            password_confirmation: {
              required: true,
              equalTo: "#password"
            },
            "roles[]": {
              required: true,
              minlength: 1
            }
          }
        ,
        submitHandler: function (form) {
          form.submit();
        }
      });
    }
  })();
  