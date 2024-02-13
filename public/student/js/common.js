 
/** ================================ Helper Functions ================================*/
function swalLoader(title = null) {
    swal.fire({
        title: title ?? 'Please wait...',
        showConfirmButton: false,
        willOpen: () => {
            swal.showLoading();
        }
    });
}

function swalConfirm(message, title = null, options = {}) {

    
    return swal.fire($.extend({
        icon: 'question',
        title: title,
        html: message,
        showCancelButton: true,
        confirmButtonText: 'Yes',
        allowOutsideClick: false,
        cancelButtonText: 'No',
        reverseButtons: true,
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: 'btn btn-light-primary'
        }
    }, options));
}

function swalSuccess(message, title = null, options = {}) {
    return swal.fire($.extend({
        icon: 'success',
        title: title,
        html: message,
        customClass: {
            confirmButton: "btn btn-primary",
        }
    }, options));
}

function swalError(message, title = null, options = {}) {
    return swal.fire($.extend({
        icon: 'error',
        title: title,
        html: message,
        customClass: {
            confirmButton: "btn btn-primary",
        }
    }, options));
}

function __(text, args) {
    // console.log("Update text",text);
    // console.log("Update args",args);

    

    // if (window.LaravelTranslations[text]) {
    //     return window.LaravelTranslations[text].replace(/:(\w+)/g, function (match, key) {
    //         return typeof args[key] != 'undefined' ? args[key] : match;
    //     });
    // }
    return text;
}
