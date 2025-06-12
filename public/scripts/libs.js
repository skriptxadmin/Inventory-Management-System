jQuery.validator.setDefaults({
    errorClass: 'text-danger small mt-1',
    errorElement: 'div',
    highlight: function (element, errorClass, validClass) {
        const element$ = jQuery(element);
        element$.addClass('is-invalid');
        element$.closest("div.form-group").find("label.form-label").addClass("text-danger");
    },
    unhighlight: function (element, errorClass, validClass) {
        const element$ = jQuery(element);
        element$.removeClass('is-invalid');
        element$.closest("div.form-group").find("label.form-label").removeClass("text-danger");

    },
    errorPlacement: function (error, element) {
        const element$ = jQuery(element);
        element$.closest('div.form-group').append(error);
    }
});



jQuery(document).on("ajaxSend", function (event, request, settings) {

    const token =  jQuery("meta[name='X-CSRF-TOKEN']").attr("content"); 

    request.setRequestHeader('X-CSRF-TOKEN', token)

    settings.url = window.app.baseurl+settings.endpoint;

    jQuery(document).find("body").addClass('has-loader');
    
});

jQuery(document).on("ajaxSuccess", function (event, request, settings) {

    const swalmessage = _.get(request, 'responseJSON.swalmsg', null);
    const redirect = _.get(request, 'responseJSON.redirect', null);
    if(swalmessage){
        Swal.fire({
            title: "Success",
            text:swalmessage,
            showConfirmButton: true,
            confirmButtonText: "Ok",
            icon: 'success',
          }).then((result) => {
            if (result.isConfirmed) {
              if(redirect){
                window.location.href = redirect;
              }
            }
          });
          return;
    }

       

   
    if(!swalmessage && redirect){

       window.location.href = redirect;
        return;
    }

});


jQuery(document).on("ajaxError", function (event, request, settings) {

    const messages = _.get(request, 'responseJSON.messages', {});

    let errors = _.values(messages);

    if(_.isEmpty(errors)){

        errors = [_.get(request, 'responseJSON.error', 'Unidentified Error')];
    }

    if(_.isEmpty(errors)){

        errors = [_.get(request, 'responseJSON.message', 'Unidentified Error')];
    }

    const errors$ = errors.map(item => {
        return `<div>${item}</div>`;
    })
   
Swal.fire({
    title: 'Error!',
    html: errors$,
    icon: 'error',
    showCloseButton: true,
    allowOutsideClick:false
  })
    
});

jQuery(document).on("ajaxComplete", function (event, request, settings) {

    jQuery(document).find("body").removeClass('has-loader');
});

