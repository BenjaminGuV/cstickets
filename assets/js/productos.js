console.log("template 2");

const ValidationClass = new Validation();

var errors_valid = [];

(function() {
    // Before using it we must add the parse and format functions
    // Here is a sample implementation using moment.js
    validate.extend(validate.validators.datetime, {
      // The value is guaranteed not to be null or undefined but otherwise it
      // could be anything.
      parse: function(value, options) {
        return +moment.utc(value);
      },
      // Input is a unix timestamp
      format: function(value, options) {
        var format = options.dateOnly ? "YYYY-MM-DD" : "YYYY-MM-DD hh:mm:ss";
        return moment.utc(value).format(format);
      }
    });

    // These are the constraints used to validate the form
    var constraints = {
        name_provider: {
            presence: true,        
        },
        name_commercial_provider: {
            presence: true,        
        },
        rfc_provider: {
            presence: true,        
        },
        direction: {
            presence: true,        
        },
    };

    // Hook up the form so we can prevent it from being posted
    var form = document.querySelector("form#form-s-providers");
    form.addEventListener("submit", function(ev) {
      ev.preventDefault();
      ValidationClass.handleFormSubmit(form, constraints);
    });

    // Hook up the inputs to validate on the fly
    var inputs = document.querySelectorAll("input[type=text], select[name], textarea");
    console.log("inputs...........", inputs);
    for (var i = 0; i < inputs.length; ++i) {
      console.log("iss", i);
      inputs.item(i).addEventListener("change", function(ev) {
        console.log("change event", i)
        errors_valid = validate(form, constraints) || {};
        ValidationClass.showErrorsForInput(this, errors_valid[this.name])
      });
    }

    
  })();
