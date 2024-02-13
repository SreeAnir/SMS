//Global holder for all component related init scripts
let missingFunction = () => {
    console.log('Missing component function!')
}
window.BladeComponents = {
    initClockPicker: missingFunction,
    initDatePicker: missingFunction,
    initDateRangePicker: missingFunction,
    initDateRangeTimePicker: missingFunction,
    initDateTimePicker: missingFunction,
    initIntTel: missingFunction,
    initSelect2: missingFunction,
    initTinyMCE: missingFunction,
};

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

/** ================================ Helper Functions ================================*/

$(() => {
    //Script to toggle open sub menu panel when a main menu item is clicked
    $('.aside-nav .nav a').click(() => {
        $('body').attr('data-kt-aside-minimize', 'off');
    })

    //Include csrf token on all ajax calls by default
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Script for switching dark mode
    let switchDarkMode = function (mode, cb) {
        // Load css file
        let loadCssFile = function (fileName, newFileName) {
            return new Promise(function (resolve, reject) {
                let oldLink = document.querySelector("link[href*='" + fileName + "']");
                if (!oldLink) {
                    resolve();
                    return;
                }
                let link = document.createElement('link');
                let href = oldLink.href.replace(fileName, newFileName);

                link.rel = 'stylesheet';
                link.type = 'text/css';
                link.href = href;

                document.head.insertBefore(link, oldLink);

                // Important success and error for the promise
                link.onload = function () {
                    resolve(href);
                    oldLink.remove();
                };

                link.onerror = function () {
                    reject(href);
                };
            });
        };

        if (mode === 'dark') {
            Promise.all([
                loadCssFile('plugins.bundle.css', 'plugins.dark.bundle.css'),
                loadCssFile('plugins.bundle.rtl.css', 'plugins.dark.bundle.rtl.css'),
                loadCssFile('style.bundle.css', 'style.dark.bundle.css'),
                loadCssFile('style.bundle.rtl.css', 'style.dark.bundle.rtl.css'),
            ]).then(function () {
                // Set dark mode class
                document.body.classList.add("dark-mode");

                if (cb instanceof Function) {
                    cb();
                }
            }).catch(function () {
                // error
            });
        } else if (mode === 'light') {
            Promise.all([
                loadCssFile('plugins.dark.bundle.css', 'plugins.bundle.css'),
                loadCssFile('plugins.dark.bundle.rtl.css', 'plugins.bundle.rtl.css'),
                loadCssFile('style.dark.bundle.css', 'style.bundle.css'),
                loadCssFile('style.dark.bundle.rtl.css', 'style.bundle.rtl.css'),
            ]).then(function () {
                // Remove dark mode class
                document.body.classList.remove("dark-mode");

                // Callback
                if (cb instanceof Function) {
                    cb();
                }
            }).catch(function () {
                // error
            });
        }
    }
    $('#user_menu_dark_mode_toggle').click(e => {
        let checked = $(e.currentTarget).prop('checked');
        if (checked) {
            switchDarkMode("dark", function () {
                console.log("changed to dark mode");
            }); // set dark mode
        } else {
            switchDarkMode("light", function () {
                console.log("changed to light mode");
            }); // set light mode
        }
        $.get(route('admin.users.switch.dark_mode', {'boolean': checked}))
            .then(response => {
                console.log(response);
            })
    })
});
