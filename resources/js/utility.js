
export const showLoadingModal = (el, status) => {
    let loading = ` <div id="loading-save" style="display:none;">
                        <div class="lds-ring">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <h6 class='text-center'>Saving Data ...</h6>
                    </div>`;
    let _el = el;

    if (!_el.find("#loading-save").length) {
        _el.find(".modal-body").after(loading);
    }

    if (status) {
        _el.find("form").hide();
        _el.find(".modal-footer").hide();
        _el.find("#loading-save").show();
    }
    else {
        _el.find("form").show();
        _el.find(".modal-footer").show();
        _el.find("#loading-save").hide();
    }
};

export const deepCopy = (data) => {
    return data.map((item) => {
        return Object.assign({}, item);
    });
};

let resetText = null;

export const LOADING = {
    set: (el) => {
        resetText = el.html();
        let textLoading = el.attr('data-loading-text');
        el.html(textLoading);
        el.prop('disabled', true);
    },
    reset: (el) => {
        el.html(resetText);
        el.prop('disabled', false);
    }
};

export const ERROR_INPUT = {
    set: (target, errorList) => {
        $(".text-alert").remove();
        Object.keys(target).map(key => {
            if (errorList[key]) {
                $(target[key].el).removeClass('input-error');
                $(target[key].el).addClass('input-error');
                $(target[key].el).after(`<p class="text-alert small" style="color:red">${errorList[key]}</p>`);

                $(target[key].el).focus(function () {
                    $(target[key].el).removeClass('input-error');
                    $(target[key].el).next(".text-alert").remove();
                });

                setTimeout(() => {
                    $(target[key].el).removeClass('input-error');
                    $(".text-alert").remove();
                }, 6000);
            }
        });

    },
    reset: (el) => {
        $(el).removeClass('input-error');
        $(".text-alert").remove();
    }
} 
