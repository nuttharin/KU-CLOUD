import Account from '../../../models/Account/Account';
import * as accountView from '../../../views/company/account/accountView';
import {
    elements
} from '../../../views/company/account/base';

const state = {};

const controlAccount = {
    index: async () => {
        state.account = new Account();
        await state.account.getAccount();
        accountView.renderResult(state.account.result);


    },

    addEmail: async () => {
        await state.account.addEmail(accountView.getInputEmail());
        await state.account.getAccount();
        accountView.renderResult(state.account.result);
    },

    deleteEmail: async (el) => {
        try {
            await state.account.deleteEmail(el.attr('email'));
            accountView.removeEamil(el);
        } catch (error) {

        }
    },

    addPhone: async () => {
        await state.account.addPhone(accountView.getInputPhone());
        await state.account.getAccount();
        accountView.renderResult(state.account.result);
    }

}

$(document).ready(function () {
    controlAccount.index();

    elements.btnAddEmail.on('click', function () {
        controlAccount.addEmail();
    })

    $('#list-email').on('click', elements.btnDeleteEmail, function () {
        let email = $(this).attr('email');
        swal({
            title: "Are you sure",
            text: `to delete this email address ${email} ?`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                controlAccount.deleteEmail($(this));
            } else {
                return;
            }
        });
    })


    elements.btnAddPhone.on('click', function () {
        controlAccount.addPhone();
    })

});
