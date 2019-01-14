import {
    elements
} from './base';

export const getInputFname = () => $(elements.fnameInput).val();
export const getInputLname = () => $(elements.lnameInput).val();

export const getInputEmail = () => $(elements.addEmailInput).val();
export const getInputPriEmail = () => $(elements.changePriEmailInput).val();

export const getInputPhone = () => $(elements.addPhoneInput).val();
export const getInputPriPhone = () => $(elements.changePriPhoneInput).val();

const renderEmail = account => {
    let email_select = "";
    let email_list = account.email.map((data, index) => {
        status = "";
        if (data.is_primary) {
            status += `<span class="badge badge-pill badge-primary d-flex justify-content-center align-items-center">Primary</span>`;
        }
        if (data.is_verify && !data.is_primary) {
            email_select += `<option value=${data.email_user}>${data.email_user}</option>`;
            status += `<span class="badge badge-pill badge-success d-flex justify-content-center align-items-center">Verify success</span> 
                               <i class="far fa-trash-alt text-danger ml-3 btn-delete-email"  style="cursor:pointer" email="${data.email_user}" index="${index}"></i>`;
        } else if (data.is_verify && data.is_primary) {
            status += `<span class="badge badge-pill badge-success d-flex justify-content-center align-items-center">Verify success</span> `;
        } else {
            status += `<span class="badge badge-pill badge-danger d-flex justify-content-center align-items-center">Verify not success</span> 
                               <i class="fas fa-paper-plane text-primary  ml-3" style="cursor:pointer" email="${data.email_user}"></i> 
                               <i class="far fa-trash-alt text-danger ml-3 btn-delete-email"  style="cursor:pointer" email="${data.email_user}" index="${index}"></i> `;
        }
        return `<li class="list-group-item mt-1" id="email-${index}" style="padding:.375rem .75rem;">
                            <div class="row">
                                <div class="col-6">
                                ${data.email_user} 
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                ${status}
                                </div>
                            </div>
                        </li>`;
    });
    elements.listEmail.html(email_list.join(''));
}

const renderPhone = account => {
    let phone_select = "";
    let phone_list = account.phone.map((data, index) => {
        status = "";
        if (data.is_primary) {
            status = `<span class="badge badge-pill badge-primary d-flex justify-content-center align-items-center">Primary</span>`;
        }
        if (data.is_verify && !data.is_primary) {
            phone_select += `<option value=${data.phone_user}>${data.phone_user}</option>`;
            status += `<span class="badge badge-pill badge-success d-flex justify-content-center align-items-center">Verify success</span> 
                               <i class="far fa-trash-alt text-danger ml-3 btn-delete-phone"  style="cursor:pointer" phone="${data.phone_user}" index="${index}"></i>`;
        } else if (data.is_verify && data.is_primary) {
            status += `<span class="badge badge-pill badge-success d-flex justify-content-center align-items-center">Verify success</span> `;
        } else {
            status += `<span class="badge badge-pill badge-danger d-flex justify-content-center align-items-center">Verify not success</span>
                               <i class="fas fa-paper-plane text-primary  ml-3" style="cursor:pointer" phone="${data.phone_user}"></i> 
                               <i class="far fa-trash-alt text-danger ml-3 btn-delete-phone"  style="cursor:pointer" phone="${data.phone_user}" index="${index}"></i> `;
        }
        return `<li class="list-group-item mt-1" id="phone-${index}"  style="padding:.375rem .75rem;">
                            <div class="row">
                                <div class="col-6">
                                ${data.phone_user} 
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                ${status}
                                </div>
                            </div>
                        </li>`;
    });
    elements.listPhone.html(phone_list.join(''));
}

export const removeEamil = (el) => {
    $(`#email-${el.attr('index')}`).remove();
}

export const renderResult = account => {
    renderEmail(account);
    renderPhone(account);
}
