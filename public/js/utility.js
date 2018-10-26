
showLoadingModal = (el, status) => {
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
        _el.find("#loading-save").show();
    }
    else {
        _el.find("form").show();
        _el.find("#loading-save").hide();
    }
};

deepCopy = (data) => {
    let obj = data.map((item) => {
        return Object.assign({}, item);
    });
    return obj;
};