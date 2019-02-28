import {
    showLoadingModal,
    LOADING,
    ERROR_INPUT,
    addEventValidate,
    resetInputValidate,
    checkError,
    checkAuthRes
} from './utility';

const language = {
    "sProcessing": `<div class="lds-roller text-center">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>`,
    "oPaginate": {
        "sNext": "<i class='mdi mdi-chevron-right'></i>",
        "sPrevious": "<i class='mdi mdi-chevron-left'></i>"
    },
};

let modalCreate = null;
let modalDetail = null;
let modalEdit = null;
let modalBlock = null;
let modalDelete = null;

const FormAddEmail = `
                    <div class="input-group">
                        <input type="text" name="email" class="add_email_val form-control mt-1" value={email}  disabled>
                            <div class="input-group-append">
                                <button class="btn btn-danger mt-1 btn-delete-email" type="button"><i class="fas fa-times"></i></button>  
                            </div>
                    </div>
                    `;
const FormAddPhone = ` 
                    <div class="input-group">
                        <input type="text" name="phone" class="add_phone_val form-control mt-1" value={phone}  disabled>
                        <div class="input-group-append">
                            <button class="btn btn-danger mt-1 btn-delete-phone" type="button"><i class="fas fa-times"></i></button>  
                        </div>
                    </div>`;

toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

const END_POINT = 'http://localhost:8000/api/';

validate.validators.presence.message = "is required";

let validateInput = {
    create: {
        parent: "form#form-add-user",
        validate: {
            email: {
                presence: true,
                email: true
            },
            username: {
                presence: {
                    allowEmpty: false,
                },
                format: {
                    pattern: "[a-zA-Z0-9]+",
                    flags: "i",
                    message: "can only contain a-Z and 0-9"
                },
                length: {
                    minimum: 4,
                    message: "must be at least 6 characters"
                }
            },
            firstname: {
                presence: {
                    allowEmpty: false
                },
                length: {
                    maximum: 50,
                },
            },
            lastname: {
                presence: {
                    allowEmpty: false
                },
                length: {
                    maximum: 50,
                },
            },
            phone: {
                presence: {
                    allowEmpty: false
                },
                format: {
                    pattern: "[0-9]+",
                    flags: "i",
                    message: "can only contain 0-9"
                },
                length: {
                    minimum: 10,
                    maximum: 10,
                },
            }
        }
    },
    edit: {
        parent: "form#form-edit-user",
        validate: {
            email: {
                email: true
            },
            firstname: {
                presence: {
                    allowEmpty: false
                },
                length: {
                    maximum: 50,
                },
            },
            lastname: {
                presence: {
                    allowEmpty: false
                },
                length: {
                    maximum: 50,
                },
            },
            phone: {
                format: {
                    pattern: "[0-9]+",
                    flags: "i",
                    message: "can only contain 0-9"
                },
                length: {
                    minimum: 10,
                    maximum: 10,
                },
            }
        }
    }
}

class ModalCreate {
    constructor(config) {
        if (modalCreate) {
            return modalCreate;
        }

        this.resetModal = () => {
            $("#add_email_val").val('');
            $("#add_fname_val").val('');
            $("#add_phone_val").val('');
            $("#add_pwd_val").val('');
            $("#add_lname_val").val('');
        };
    }
}

class ModalDetail {
    constructor() {
        if (modalDetail) {
            return modalDetail;
        }

        this.create = (key) => {
            if ($("#detailUser").length === 0) {
                let modal = `
                                <div class="modal fade" id="detailUser">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="title-user"></h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
        
                                            <div class="modal-body">
                                                <h6>Name : <span  id="name-user"><span></h6>
                                                <h6>Phone</h6>
                                                <ul class="list-group" id="phone-user">
                                                    
                                                </ul>
                                                <hr/>
                                                <h6>Email</h6>
                                                <ul class="list-group" id="email-user" >
                                                    
                                                </ul>
                                            </div>
        
                                            <div class="modal-footer">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                  `;
                $('body').append(modal);
            }

            $('#title-user').html(UsersList[key].email[0].email_user);
            $('#name-user').html(UsersList[key].fname + " " + UsersList[key].lname);
            let status = "";
            let phone_list = UsersList[key].phone.map(data => {
                status = "";
                if (data.is_primary) {
                    status = `<span class="badge badge-pill badge-primary d-flex justify-content-center align-items-center">Primary</span>`;
                }
                if (data.is_verify) {
                    status += `<span class="badge badge-pill badge-success d-flex justify-content-center align-items-center">Verify success</span>`;
                } else {
                    status += `<span class="badge badge-pill badge-danger d-flex justify-content-center align-items-center">Verify not success</span>`;
                }
                return `<li class="list-group-item mt-1" style="padding:.375rem .75rem;">
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

            $('#phone-user').html(phone_list.join(''));
            let email_list = UsersList[key].email.map(data => {
                status = "";
                if (data.is_primary) {
                    status += `<span class="badge badge-pill badge-primary d-flex justify-content-center align-items-center">Primary</span>`;
                }
                if (data.is_verify) {
                    status += `<span class="badge badge-pill badge-success d-flex justify-content-center align-items-center">Verify success</span>`;
                } else {
                    status += `<span class="badge badge-pill badge-danger d-flex justify-content-center align-items-center">Verify not success</span>`;
                }
                return `<li class="list-group-item mt-1" style="padding:.375rem .75rem;">
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
            $('#email-user').html(email_list.join(''));

            $("#detailUser").modal('show');
        };
    }
}

class ModalEdit {
    constructor(config) {
        let count_phone = 0;
        let count_email = 0;

        if (modalEdit) {
            return modalEdit;
        }

        this.create = (key) => {
            if ($("#editUser").length === 0) {
                let modal = `
                <div class="modal fade" id="editUser">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Edit User Company</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                <form id="form-edit-user">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>Firstname <span class="text-danger">*</span></label>
                                            <input type="text" name="firstname" id="edit-fname" class="form-control"/>
                                            <button class="btn btn-primary btn-sm btn-radius mt-2" id="btn-add-email"><i class="fas fa-plus"></i> add email</button>
                                            <div id="input-add-email">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label>Lastname <span class="text-danger">*</span></label>
                                            <input type="text" name="lastname" id="edit-lname" class="form-control"/>
                                            <button class="btn btn-primary btn-sm btn-radius mt-2" id="btn-add-phone"><i class="fas fa-plus"></i> add phone</button>
                                            <div id="input-add-phone">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" id="btn-edit-submit" class="btn btn-success btn-block btn-submit-edit" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">Save</button>
                            </div>
                        </div>
                    </div>
                </div>`;
                $('body').append(modal);

                addEventValidate(validateInput.edit);
            }

            count_phone = 0;
            count_email = 0;

            $("#btn-edit-submit").unbind().click(function () {
                onSubmitEditClick(key);
            });

            let phoneList = UsersList[key].phone;
            count_phone = phoneList.length;
            let inputPhone = null;
            inputPhone = phoneList.map((phone, index) => {
                if (phone.is_primary) {
                    return `<li class="list-group-item mt-1" style="padding:.375rem .75rem;">
                                <div class="row">
                                    <div class="col-6">
                                    ${phone.phone_user} 
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <span class="badge badge-pill badge-primary d-flex justify-content-center align-items-center">Primary</span>
                                    </div>
                                </div>
                            </li>`;
                }
                return `<li class="list-group-item mt-1" id="phone-${phone.phone_user}" style="padding:.375rem .75rem;">
                            <div class="row">
                                <div class="col-6">
                                ${phone.phone_user} 
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    <div class="form-submit-delete-phone" style="display:none">
                                        <button type="button" class="btn btn-success btn-sm btn-radius btn-submit-delete-phone" phone="${phone.phone_user}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-radius btn-cancel-delete-phone">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <i class="far fa-trash-alt btn-confirm-delete-phone" style="color:#e65251;cursor:pointer"></i>
                                </div>
                            </div>
                        </li>`;
                //return FormAddPhone.replace('{phone}', phone.phone_user);
            });

            let emailList = UsersList[key].email;
            count_email = emailList.length;
            let inputEmail = null;
            inputEmail = emailList.map((email, index) => {
                if (email.is_primary) {
                    return `<li class="list-group-item mt-1"  style="padding:.375rem .75rem;">
                                <div class="row">
                                    <div class="col-6">
                                    ${email.email_user} 
                                    </div>
                                    <div class="col-6 d-flex justify-content-end">
                                        <span class="badge badge-pill badge-primary d-flex justify-content-center align-items-center">Primary</span>
                                    </div>
                                </div>
                            </li>`;
                }
                return `<li class="list-group-item mt-1" id="email-${index}" style="padding:.375rem .75rem;">
                            <div class="row">
                                <div class="col-6">
                                ${email.email_user} 
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    <div class="form-submit-delete-email" style="display:none">
                                        <button type="button" class="btn btn-success btn-sm btn-radius btn-submit-delete-email" email="${email.email_user}" item="email-${index}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-radius btn-cancel-delete-email">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <i class="far fa-trash-alt btn-confirm-delete-email" style="color:#e65251;cursor:pointer"></i>
                                </div>
                            </div>
                        </li>`;
                //return FormAddEmail.replace('{email}', email.email_user);
            });

            $("#btn-add-phone").unbind().click(function () {
                event.preventDefault();
                let addPhone = FormAddPhone.replace('disabled', '');
                addPhone = addPhone.replace('{phone}', '');
                if (count_phone <= 2) {
                    count_phone++;
                    $("#input-add-phone").append(addPhone);
                }
                addEventValidate(validateInput.edit);
            });


            $("#btn-add-email").unbind().click(function () {
                event.preventDefault();
                let addEmail = FormAddEmail.replace('disabled', '');
                addEmail = addEmail.replace('{email}', '');
                if (count_email <= 2) {
                    count_email++;
                    $("#input-add-email").append(addEmail);
                }
                addEventValidate(validateInput.edit);
            });

            $('body').unbind().on('click', ".btn-delete-email ,.btn-delete-phone", function () {
                if ($(this).hasClass('btn-delete-email')) {
                    --count_email;
                } else if ($(this).hasClass('btn-delete-phone')) {
                    --count_phone;
                }
                $(this).parent().parent().remove();
            });

            $('#edit-fname').val(UsersList[key].fname);
            $('#edit-lname').val(UsersList[key].lname);
            $('#input-add-phone').html(inputPhone.join(''));
            $('#input-add-email').html(inputEmail.join(''));

            $('#editUser').modal('show');
            resetInputValidate();

            $(".btn-confirm-delete-email").unbind().click(function () {
                $(this).hide();
                $(this).parent().find('.form-submit-delete-email').show();
            });

            $(".btn-cancel-delete-email").unbind().click(function () {
                $(this).parent().hide();
                $(this).parent().parent().find('.btn-confirm-delete-email').show();
            });

            $(".btn-submit-delete-email").unbind().click(function () {
                onSubmitDeleteEmail($(this).attr('email'), $(this).attr('item'));
            });

            $(".btn-confirm-delete-phone").unbind().click(function () {
                $(this).hide();
                $(this).parent().find('.form-submit-delete-phone').show();
            });

            $(".btn-cancel-delete-phone").unbind().click(function () {
                $(this).parent().hide();
                $(this).parent().parent().find('.btn-confirm-delete-phone').show();
            });

            $(".btn-submit-delete-phone").unbind().click(function () {
                onSubmitDeletePhone($(this).attr('phone'));
            });
        };

        let onSubmitDeleteEmail = (email, item) => {
            $.ajax({
                url: END_POINT + "company/users/email",
                method: "DELETE",
                headers: {
                    authorization: 'bearer ' + getCookie('token'),
                },
                data: {
                    email_user: email,
                },
                success: (res, textStatus, xhr) => {
                    checkAuthRes(xhr);
                    $("#" + item).remove();
                    ManagementUsers.refreshData();
                },
                error: (res) => {
                    console.log(res);
                }

            });
        };

        let onSubmitDeletePhone = (phone) => {
            $.ajax({
                url: END_POINT + "company/users/phone",
                method: "DELETE",
                headers: {
                    authorization: 'bearer ' + getCookie('token'),
                },
                data: {
                    phone_user: phone,
                },
                success: (res, textStatus, xhr) => {
                    checkAuthRes(xhr);
                    $("#phone-" + phone).remove();
                    ManagementUsers.refreshData();
                },
                error: (res) => {
                    console.log(res);
                }

            });
        };

        let onSubmitEditClick = (index) => {
            if (checkError(validateInput.edit)) return;
            LOADING.set($("#btn-edit-submit"));
            let fname = $("#edit-fname").val();
            let lname = $("#edit-lname").val();
            let phone = $(".add_phone_val:enabled").map(function () {
                if ($(this).val().replace(' ', '') != '') {
                    return $(this).val();
                }
            }).get();
            let email = $(".add_email_val:enabled").map(function () {
                if ($(this).val().replace(' ', '') != '') {
                    return $(this).val();
                }
            }).get();

            $.ajax({
                url: END_POINT + config.edit,
                method: "PUT",
                headers: {
                    authorization: 'bearer ' + getCookie('token'),
                },
                data: {
                    user_id: UsersList[index].user_id,
                    fname: fname,
                    lname: lname,
                    phone_user: phone,
                    email_user: email
                },
                success: (res,textStatus,xhr) => {
                    checkAuthRes(xhr);
                    toastr["success"]("Success");
                    LOADING.reset($("#btn-edit-submit"));
                    $("#editUser").modal('hide');
                    ManagementUsers.refreshData();
                },
                error: (res) => {
                    LOADING.reset($("#btn-edit-submit"));
                    console.log(res);
                }
            });
        };
    }
}

class ModalToggleActive {
    constructor(config) {
        if (modalBlock) {
            return modalBlock;
        }

        this.create = (key) => {
            if ($("#BlockUser").length === 0) {
                let modal = `
                <div class="modal fade" id="BlockUser">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="title-block">Block </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                <form id="form-block-user">
                                    <h6 id="span-text-confirm-block"></h6>
                                </form>
                            </div>

                            <div class="modal-footer" id="btn-toggle-active-footer">
                                
                            </div>
                        </div>
                    </div>
                </div>`;

                $('body').append(modal);
            }
            let active = UsersList[key].block ? 'unblock' : 'block';
            $("#title-block").html(`${active} User`);
            if (UsersList[key].block) {
                $("#btn-toggle-active-footer").html(`<button type="button" id="btn-toggle-active-submit" class="btn btn-info btn-block" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">UnBlock</button>`);
            } else {
                $("#btn-toggle-active-footer").html(`<button type="button" id="btn-toggle-active-submit" class="btn btn-danger btn-block" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">Block</button>`);
            }

            $('#btn-toggle-active-submit').unbind().click(function () {
                onSubmitToggleActiveUser(key);
            });

            $("#span-text-confirm-block").html(`Are you sure to ${active} this account name : ${UsersList[key].fname} ${UsersList[key].lname} ?`);
            $("#BlockUser").modal('show');
        };

        let onSubmitToggleActiveUser = (key) => {
            LOADING.set($("#btn-toggle-active-submit"));
            $.ajax({
                url: END_POINT + config.block,
                method: "put",
                headers: {
                    authorization: 'bearer ' + getCookie('token'),
                },
                data: {
                    user_id: UsersList[key].user_id,
                    block: UsersList[key].block ? 0 : 1
                },
                success: (res,textStatus,xhr) => {
                    checkAuthRes(xhr);
                    toastr["success"]("Success");
                    $("#BlockUser").modal('hide');
                    LOADING.reset($("#btn-toggle-active-submit"));
                    ManagementUsers.refreshData();
                },
                error: (res) => {
                    LOADING.reset($("#btn-toggle-active-submit"));
                    console.log(res);
                }
            });
        };
    }
}

class ModalDelete {
    constructor(config) {
        if (modalDelete) {
            return modalDelete;
        }

        this.create = (key) => {
            if ($("#DeleteUser").length === 0) {
                let modal = `<div class="modal fade" id="DeleteUser">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete User Company</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
    
                                        <div class="modal-body">
                                            <form id="form-delete-user">
                                                <h6 id="span-text-confirm"></h6>
                                            </form>
                                        </div>
    
                                        <div class="modal-footer">
                                            <button type="button" id="btn-delete-submit" class="btn btn-danger btn-block" data-loading-text="<i class='fas fa-circle-notch fa-spin'></i> Saving . . .">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                $("body").append(modal);
            }
            $('#span-text-confirm').html("Are you sure to delete this account name : " + UsersList[key].email[0].email_user + " ? ");
            $('#DeleteUser').modal('show');
        };


    }
}

let UsersList = [];

export class ManagementUsers {
    constructor(config) {
        this.config = {
            getUsers: config.getUsers,
            getOnlineUsers: config.OnlineUsers,
            create: config.create,
            edit: config.edit,
            block: config.block,
            unblock: config.unblock,
            delete: config.delete,
            type: config.type,
        };

        let ModalDeleteEmail = null;
        let ModalDeletePhone = null;

        let UsersDATATABLE = null;

        let input_bind_email = null;


        let initialDatatable = () => {
            if (UsersDATATABLE !== null) {
                return false;
            }

            UsersDATATABLE = $('#example').dataTable({});
        };

        let showDatatableLoadingStatus = (showOrHide) => {
            if (showOrHide) {
                $(".dataTables_wrapper").hide();
                $('#example').hide();
                $('#loading').show();
                $('#card_table').height('100px');
            } else {
                $('#card_table').height('auto');
                $(".dataTables_wrapper").show();
                $('#loading').hide();
                $('.text-loading').hide();
                $('#example').show();
                $('.text-static').show();
            }
        };

        let createTableUsersCompany = async() => {
            if (UsersDATATABLE != null) {
                let page = UsersDATATABLE.page.info().page;
                UsersDATATABLE.ajax.reload();
                UsersDATATABLE.page(page).draw('page');
            } else {
                UsersDATATABLE = $('#example').on('xhr.dt', function (e, settings, json, xhr) {
                    checkAuthRes(xhr);
                }).DataTable({
                    "processing": true,
                    "serverSide": true,
                    "destroy": true,
                    "responsive": true,
                    "language": language,
                    "ajax": {
                        url: END_POINT + config.getUsers,
                        headers: {
                            authorization: 'bearer ' + getCookie('token'),
                        },
                        "dataSrc": function (json) {
                            UsersList = json.data;
                            return json.data;
                        }
                    },
                    "columns": [
                        {
                            "mRender": function (data, type, row) {
                                return row.fname + " " + row.lname;
                            }
                        },
                        {
                            "mRender": function (data, type, row) {
                                return row.phone[0].phone_user;
                            }
                        },
                        {
                            "mRender": function (data, type, row) {
                                return row.email[0].email_user;
                            },
                           
                        },
                        {
                            "mData": "block",
                            "mRender": function (data, type, row) {
                                return data ? '<b class="text-danger">Block</b>' : 'Unblock';
                            }
                        },
                        {
                            data: 'sub_type_user',
                        },
                        {
                            "mData": "online",
                            "mRender": function (data, type, row) {
                                return data ? '<b class="text-success">online <i class="fas fa-circle text-success fa-xs"></i></b>' : '<span class="text-secondary">offline <i class="fas fa-circle text-secondary fa-xs"></i></span>';
                            },
                        },
                        {
                            "mRender": function (data, type, row, index) {
                                let btnBlock = `                            
                            <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index.row} data-toggle="tooltip" data-placement="top" title="Block">
                                <i class="fas fa-times"></i>
                            </button>`;
                                if (row.block) {
                                    btnBlock = `                            
                                <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index.row} data-toggle="tooltip" data-placement="top" title="UnBlock">
                                    <i class="fas fa-unlock"></i>
                                </button>`;
                                }
                                return `<center>
                                            <button type="button" class="btn btn-primary btn-sm btn-detail" index=${index.row} data-toggle="tooltip"
                                                data-placement="top" title="Detail">
                                                <i class="fas fa-list"></i>
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm btn-edit" index=${index.row}  data-toggle="tooltip"
                                                data-placement="top" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            ${btnBlock}
                                            <button type="button" class="btn btn-danger btn-sm btn-delete"  index=${index.row}  data-toggle="tooltip"
                                                data-placement="top" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </center>`;
                            },
                            "orderable":false,
                        }
                    ]
                });

                $('#example').tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            }

            // let Datatable = [];
            // UsersDATATABLE.fnClearTable();
            // $.each(UsersList, function (index, item) {
            //     let ret = [];
            //     let btnBlock = `                            
            //     <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index} data-toggle="tooltip" data-placement="top" title="Block">
            //         <i class="fas fa-times"></i>
            //     </button>`;
            //     if (item.block) {
            //         btnBlock = `                            
            //         <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index} data-toggle="tooltip" data-placement="top" title="UnBlock">
            //             <i class="fas fa-unlock"></i>
            //         </button>`;
            //     }
            //     ret[0] = item.fname + " " + item.lname;
            //     ret[1] = item.phone[0].phone_user;
            //     ret[2] = item.email[0].email_user;
            //     ret[3] = item.block ? '<b class="text-danger">Block</b>' : 'Unblock';
            //     ret[4] = item.sub_type_user;
            //     ret[5] = item.online ? '<b class="text-success">online <i class="fas fa-circle text-success fa-xs"></i></b>' : '<span class="text-secondary">offline <i class="fas fa-circle text-secondary fa-xs"></i></span>';
            //     ret[6] = `<center>
            //                     <button type="button" class="btn btn-primary btn-sm btn-detail" index=${index} data-toggle="tooltip"
            //                         data-placement="top" title="Detail">
            //                         <i class="fas fa-list"></i>
            //                     </button>
            //                     <button type="button" class="btn btn-success btn-sm btn-edit" index=${index}  data-toggle="tooltip"
            //                         data-placement="top" title="Edit">
            //                         <i class="fas fa-edit"></i>
            //                     </button>
            //                     ${btnBlock}
            //                     <button type="button" class="btn btn-danger btn-sm btn-delete"  index=${index}  data-toggle="tooltip"
            //                         data-placement="top" title="Delete">
            //                         <i class="fas fa-trash-alt"></i>
            //                     </button>
            //                 </center>`;
            //     Datatable.push(ret);
            // });
            // UsersDATATABLE.fnAddData(Datatable);

            return;
        };

        let createTableUsersCustomer = async() => {
            if (UsersDATATABLE != null) {
                let page = UsersDATATABLE.page.info().page;
                UsersDATATABLE.ajax.reload();
                UsersDATATABLE.page(page).draw('page');
            } else {
                UsersDATATABLE = $('#example').on('xhr.dt', function (e, settings, json, xhr) {
                    checkAuthRes(xhr);
                }).DataTable({
                    "processing": true,
                    "serverSide": true,
                    "destroy": true,
                    "responsive": true,
                    "language": language,
                    "ajax": {
                        url: END_POINT + config.getUsers,
                        headers: {
                            authorization: 'bearer ' + getCookie('token'),
                        },
                        "dataSrc": function (json) {

                            UsersList = json.data;
                            return json.data;
                        }
                    },
                    "columns": [{
                            "mRender": function (data, type, row) {
                                return row.fname + " " + row.lname;
                            }
                        },
                        {
                            "mRender": function (data, type, row) {
                                return row.phone[0].phone_user;
                            }
                        },
                        {
                            "mRender": function (data, type, row) {
                                return row.email[0].email_user;
                            }
                        },
                        {
                            "mData": "block",
                            "mRender": function (data, type, row) {
                                return data ? '<b class="text-danger">Block</b>' : 'Unblock';
                            }
                        },
                        {
                            "mData": "online",
                            "mRender": function (data, type, row) {
                                return data ? '<b class="text-success">online <i class="fas fa-circle text-success fa-xs"></i></b>' : '<span class="text-secondary">offline <i class="fas fa-circle text-secondary fa-xs"></i></span>';
                            }
                        },
                        {
                            "mRender": function (data, type, row, index) {
                                let btnBlock = `                            
                            <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index.row} data-toggle="tooltip" data-placement="top" title="Block">
                                <i class="fas fa-times"></i>
                            </button>`;
                                if (row.block) {
                                    btnBlock = `                            
                                <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index.row} data-toggle="tooltip" data-placement="top" title="UnBlock">
                                    <i class="fas fa-unlock"></i>
                                </button>`;
                                }
                                return `<center>
                                            <button type="button" class="btn btn-primary btn-sm btn-detail" index=${index.row} data-toggle="tooltip"
                                                data-placement="top" title="Detail">
                                                <i class="fas fa-list"></i>
                                            </button>
                                            <button type="button" class="btn btn-success btn-sm btn-edit" index=${index.row}  data-toggle="tooltip"
                                                data-placement="top" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            ${btnBlock}
                                            <button type="button" class="btn btn-danger btn-sm btn-delete"  index=${index.row}  data-toggle="tooltip"
                                                data-placement="top" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </center>`;
                            },
                            "orderable":false,
                        }
                    ]
                });

                $('#example').tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            }

            return;
            // let Datatable = [];
            // UsersDATATABLE.fnClearTable();
            // $.each(UsersList, function (index, item) {
            //     let ret = [];
            //     let btnBlock = `                            
            //     <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index} data-toggle="tooltip" data-placement="top" title="Block">
            //         <i class="fas fa-times"></i>
            //     </button>`;
            //     if (item.block) {
            //         btnBlock = `                            
            //         <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index} data-toggle="tooltip" data-placement="top" title="UnBlock">
            //             <i class="fas fa-unlock"></i>
            //         </button>`;
            //     }
            //     ret[0] = item.fname + " " + item.lname;
            //     ret[1] = item.phone[0].phone_user;
            //     ret[2] = item.email[0].email_user;
            //     ret[3] = item.block ? '<b class="text-danger">Block</b>' : 'Unblock';
            //     ret[4] = item.online ? '<b class="text-success">online <i class="fas fa-circle text-success fa-xs"></i></b>' : '<span class="text-secondary">offline <i class="fas fa-circle text-secondary fa-xs"></i></span>';
            //     ret[5] = `<center>
            //                     <button type="button" class="btn btn-primary btn-sm btn-detail" index=${index} data-toggle="tooltip"
            //                         data-placement="top" title="Detail">
            //                         <i class="fas fa-list"></i>
            //                     </button>
            //                     <button type="button" class="btn btn-success btn-sm btn-edit" index=${index}  data-toggle="tooltip"
            //                         data-placement="top" title="Edit">
            //                         <i class="fas fa-edit"></i>
            //                     </button>
            //                     ${btnBlock}
            //                     <button type="button" class="btn btn-danger btn-sm btn-delete"  index=${index}  data-toggle="tooltip"
            //                         data-placement="top" title="Delete">
            //                         <i class="fas fa-trash-alt"></i>
            //                     </button>
            //                 </center>`;
            //     Datatable.push(ret);
            // });
            // UsersDATATABLE.fnAddData(Datatable);
        };

        let onSaveUserClick = (el) => {
            if (checkError(validateInput.create)) return;
            LOADING.set(el);
            let username_input = $("#add_username").val();
            let email_input = $("#add_email_val").val();
            let fname_input = $("#add_fname_val").val();
            let lname_input = $("#add_lname_val").val();
            let phone_input = $("#add_phone_val").val();
            let type_user_input = null;
            if (config.type === 'COMPANY') {
                type_user_input = $("#add_type_user_val").val();
            }
            $.ajax({
                url: END_POINT + config.create,
                dataType: 'json',
                method: "POST",
                headers: {
                    authorization: 'bearer ' + getCookie('token'),
                },
                data: {
                    username:username_input,
                    email: email_input,
                    fname: fname_input,
                    lname: lname_input,
                    phone: phone_input,
                    sub_type_user: type_user_input,
                },
                success: (res,textStatus,xhr) => {
                    checkAuthRes(xhr);
                    console.log(res);
                    toastr["success"]("Success");
                    this.showLastestDatatable();
                    LOADING.reset(el);
                    $("#addUser").modal('hide');
                },
                error: (res) => {
                    console.log(res);
                    LOADING.reset(el);
                }
            });
        };

        let onDetailClick = (key) => {
            modalDetail = new ModalDetail();
            modalDetail.create(key);
        };

        let onEditClick = (key) => {
            modalEdit = new ModalEdit(config);
            modalEdit.create(key);
        };

        let onBlockClick = (key) => {
            modalBlock = new ModalToggleActive(config);
            modalBlock.create(key);
        };

        let onDeleteClick = (key) => {
            modalDelete = new ModalDelete(config);
            modalDelete.create(key);
        };

        let updateDatatableData = async () => {
            if (config.type === "COMPANY") {
                await createTableUsersCompany();
            } else if (config.type === "CUSTOMER") {
                await createTableUsersCustomer();
            }

            $('#example').on('click', '.btn-detail', function () {
                onDetailClick($(this).attr('index'));
            });

            $('#example').on('click', '.btn-edit', function () {
                onEditClick($(this).attr('index'));
            });

            $('#example').on('click', '.btn-block-user', function () {
                onBlockClick($(this).attr('index'));
            });

            $('#example').on('click', '.btn-unblock-user', function () {
                onUnBlockClick($(this).attr('index'));
            });

            $('#example').on('click', '.btn-delete', function () {
                onDeleteClick($(this).attr('index'));
            });


        };

        let createModalDelete = () => {
            if (ModalDeleteEmail == null && ModalDeletePhone == null) {
                ModalDeleteEmail = `
                                    <div class="modal" id="modal-delete-email">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
        
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete Email</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
            
                                            <div class="modal-body">
                                                Are you sure to delete this email account : <span id="email-delete"></span> ?
                                            </div>
            
                                            <div class="modal-footer">
                                                <button type="button" id="modal-btn-delete-email" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        
                                            </div>
                                        </div>
                                    </div>`;

                ModalDeletePhone = `
                                    <div class="modal" id="modal-delete-phone">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete Phone</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                            Are you sure to delete this phone number : <span id="phone-delete"></span> ?
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button"  id="modal-btn-delete-phone" class="btn btn-danger btn-block">Delete</button>
                                            </div>
                                        
                                            </div>
                                        </div>
                                    </div>`;
                $('body').append(ModalDeleteEmail);
                $('body').append(ModalDeletePhone);
            }
        };

        let getAllEmailCustomer = () => {
            $.ajax({
                url: END_POINT + config.getAllEmailCustomer,
                method: "GET",
                headers: {
                    authorization: 'bearer ' + getCookie('token'),
                },
                success: (res,textStatus,xhr) => {
                    checkAuthRes(xhr);
                    input_bind_email = $('#input_bind_email');
                    input_bind_email.empty();
                    if (input_bind_email.data('fastselect')) {
                        input_bind_email.data('fastselect').destroy();
                    }
                    res.data.map(data => {
                        input_bind_email.append(`<option value="${data.user_id}">${data.email_user}</option>`);
                    })
                    input_bind_email.fastselect();
                },
                error: (res) => {

                }
            });
        };

        let addCustomerInCompany = () => {
            LOADING.set($("#btn_save_bind_user"));
            $.ajax({
                url: END_POINT + config.addCustomerInCompany,
                method: "POST",
                headers: {
                    authorization: 'bearer ' + getCookie('token'),
                },
                data: {
                    userList: input_bind_email.val(),
                },
                success: (res,textStatus,xhr) => {
                    checkAuthRes(xhr);
                    $("#bindUser").modal('hide');
                    getAllEmailCustomer();
                    LOADING.reset($("#btn_save_bind_user"));
                    this.showLastestDatatable();
                },
                error: (res) => {
                    console.log(res);
                }
            });
        };

        this.initialAndRun = () => {
            showDatatableLoadingStatus(true);
            this.showLastestDatatable();
            //createModalDelete();
            $('#btn-add-user').unbind().click(function () {
                resetInputValidate();
                modalCreate = new ModalCreate(config);
                modalCreate.resetModal();
                $("#addUser").modal('show');
            });

            $('#btn-save-add-user').unbind().click(function () {
                onSaveUserClick($(this));
            });

            if (config.type === 'CUSTOMER') {

                $('#btn_bind_user').unbind().click(function () {
                    $("#bindUser").modal('show');
                });

                $("#btn_save_bind_user").unbind().click(function () {
                    addCustomerInCompany();
                });

                getAllEmailCustomer();
            }

            addEventValidate(validateInput.create);
        };


        this.showLastestDatatable = async () => {
            await updateDatatableData();
            await $.ajax({
                url: END_POINT + config.getOnlineUsers,
                method: 'GET',
                headers: {
                    authorization: 'bearer ' + getCookie('token'),
                },
                data: {
                    type_user: config.type,
                },
                success: function (result, textStatus, xhr) {
                    checkAuthRes(xhr);
                    let sum = 0;
                    for (let i in result.users) {
                        sum += Number(result.users[i].count);
                        if (result.users[i].online === "online") {
                            $("#total-user-online").html(`${result.users[i].count} user`);
                        } else {
                            $("#total-user-offline").html(`${result.users[i].count} user`);
                        }
                    }
                    $("#total-user").html(`${sum} user`);
                },
                error: function (error) {
                    console.log(error);
                }
            });

            showDatatableLoadingStatus(false);
        };

       
    }



    static refreshData() {
        return managementUsers.showLastestDatatable();
    }
}


let managementUsers = null;

export function FatoryCreateManagmentUser(config) {
    managementUsers = new ManagementUsers(config);
    managementUsers.initialAndRun();
}
