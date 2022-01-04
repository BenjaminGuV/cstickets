console.log( "validation" );

class Validation {

handleFormSubmit(form, constraints, input) {
    // validate the form against the constraints
    var errors = validate(form, constraints);
    // then we update the form to reflect the results
    this.showErrors(form, errors || {});
    if (!errors) {
        this.showSuccess();
    }
}

// Updates the inputs with the validation errors
showErrors(form, errors) {
    console.log("form", form);
    console.log("errors", errors);

    var temp_obj = this;

    console.log( "temp_obj", temp_obj );

    // We loop through all the inputs and show the errors for that input
    _.each(form.querySelectorAll("input[type=text], select[name], textarea"), function(input) {
        // Since the errors can be null if no errors were found we need to handle
        // that
        console.log( "input", input );
        console.log( "errors", errors );
        console.log( "temp_obj", temp_obj );
        this.showErrorsForInput(input, errors && errors[input.name]);
    }, this);

}

// Shows the errors for a specific input
showErrorsForInput(input, errors) {
    console.log("-showErrorsForInput-");
    console.log("input", input, errors);
    // This is the root of the input
    var formGroup = this.closestParent(input.parentNode, "form-group")
        // Find where the error messages will be insert into
        , messages = formGroup.querySelector(".messages");
    // First we remove any old messages and resets the classes
    this.resetFormGroup(formGroup);
    // If we have errors
    if (errors) {
        console.log("errors int", errors);
        // we first mark the group has having errors
        formGroup.classList.add("has-error");
        // then we append all the errors
        _.each(errors, function(error) {
            this.addError(messages, error);
        }, this);

    } else {
        // otherwise we simply mark it as success
        formGroup.classList.add("has-success");
    }
}

errorHandler( error ){
    console.log("messages ->", messages);
    this.addError(messages, error);
}

// Recusively finds the closest parent that has the specified class
closestParent(child, className) {
    if (!child || child == document) {
        return null;
    }
    if (child.classList.contains(className)) {
        return child;
    } else {
        return this.closestParent(child.parentNode, className);
    }
}

resetFormGroup(formGroup) {
    // Remove the success and error classes
    formGroup.classList.remove("has-error");
    formGroup.classList.remove("has-success");
    // and remove any old messages
    _.each(formGroup.querySelectorAll(".help-block.error"), function(el) {
        el.parentNode.removeChild(el);
    });

}

// Adds the specified error with the following markup
// <p class="help-block error">[message]</p>
addError(messages, error) {
    var block = document.createElement("p");
    block.classList.add("help-block");
    block.classList.add("error");
    block.innerText = error;
    messages.appendChild(block);
}

showSuccess() {
    // We made it \:D/
    alert("Success!");
}

}