import { showLoadingModal } from './utility';

let modalDetail = null;
let modalEdit = null;
let modalBlock = null;
let modalUnblock = null;
let modalDelete = null;
const FormAddEmail = `
                    <div class="input-group mb-2">
                        <input type="text" class="add_email_val form-control mt-1" value={email} disabled>
                            <div class="input-group-append">
                                <button class="btn btn-danger mt-1 btn-delete-email" type="button"><i class="fas fa-times"></i></button>  
                            </div>
                    </div>
                    `;
const FormAddPhone = ` 
                    <div class="input-group mb-2">
                        <input type="text" class="add_phone_val form-control mt-1" value={phone} disabled>
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

class ModalDetail {
    constructor() {
        if (modalDetail) {
            return modalDetail;
        }

        this.create = (key) => {
            if ($("#detailUser").length === 0) {
                let modal = `
                                <div class="modal fade" id="detailUser">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="title-user"></h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
        
                                            <div class="modal-body">
                                                <h6>Name : <span  id="name-user"><span></h6>
                                                <h6>Phone : <span id="phone-user"><span></h6>
                                                <h6>Email : <span id="email-user"><span></h6>
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

            let phone_list = UsersList[key].phone.map(data => {
                return data.phone_user;
            });
            $('#phone-user').html(phone_list.join(','));
            let email_list = UsersList[key].email.map(data => {
                return data.email_user;
            });
            $('#email-user').html(email_list.join(','));

            $("#detailUser").modal('show');
        };
    }
}

class ModalEdit {
    constructor(config) {
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
                                            <label>Firstname</label>
                                            <input type="text" id="edit-fname" class="form-control"/>
                                            <button class="btn btn-primary btn-sm btn-radius mt-2" id="btn-add-email"><i class="fas fa-plus"></i> add email</button>
                                            <div id="input-add-email">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label>Lastname</label>
                                            <input type="text" id="edit-lname" class="form-control"/>
                                            <button class="btn btn-primary btn-sm btn-radius mt-2" id="btn-add-phone"><i class="fas fa-plus"></i> add phone</button>
                                            <div id="input-add-phone">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" id="btn-edit-submit" class="btn btn-success btn-block btn-submit-edit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>`;
                $('body').append(modal);

                $("#btn-edit-submit").unbind().click(function () {
                    onSubmitEditClick(key);
                });

                $("#btn-add-phone").unbind().click(function () {
                    event.preventDefault();
                    let addPhone = FormAddPhone.replace('disabled', '');
                    addPhone = addPhone.replace('{phone}', '');
                    if ($(".btn-delete-phone").length <= 2) {
                        $("#input-add-phone").append(addPhone);
                    }
                });

                $("#btn-add-email").unbind().click(function () {
                    event.preventDefault();
                    let addEmail = FormAddEmail.replace('disabled', '');
                    addEmail = addEmail.replace('{email}', '');
                    if ($(".btn-delete-email").length <= 2)
                        $("#input-add-email").append(addEmail);
                });
            }

            let phoneList = UsersList[key].phone;
            let inputPhone = null;
            inputPhone = phoneList.map(phone => {
                return FormAddPhone.replace('{phone}', phone.phone_user);
            });

            let emailList = UsersList[key].email;
            let inputEmail = null;
            inputEmail = emailList.map(email => {
                return FormAddEmail.replace('{email}', email.email_user);
            });

            $('#edit-fname').val(UsersList[key].fname);
            $('#edit-lname').val(UsersList[key].lname);
            $('#input-add-phone').html(inputPhone.join(''));
            $('#input-add-email').html(inputEmail.join(''));
            $('#editUser').modal('show');
        };

        let onSubmitEditClick = (index) => {
            let fname = $("#edit-fname").val();
            let lname = $("#edit-lname").val();
            let phone = $(".add_phone_val").map(function () {
                return $(this).val();
            }).get();
            let email = $(".add_email_val").map(function () {
                return $(this).val();
            }).get();
            showLoadingModal($("#editUser"), true);
            $.ajax({
                url: END_POINT + config.edit,
                method: "PUT",
                data: {
                    user_id: UsersList[index].user_id,
                    fname: fname,
                    lname: lname,
                    phone_user: phone,
                    email_user: email
                },
                success: (res) => {
                    toastr["success"]("Edit user success");
                    showLoadingModal($("#editUser"), false);
                    $("#editUser").modal('hide');
                    ManagementUsers.refreshData();
                },
                error: (res) => {
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
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Block User Company</h4>
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
            let active = UsersList[key].block ? 'block' : 'unblock';
            if (UsersList[key].block) {
                $("#btn-toggle-active-footer").html(`<button type="button" id="btn-toggle-active-submit" class="btn btn-info btn-block">UnBlock</button>`);
            }
            else {
                $("#btn-toggle-active-footer").html(`<button type="button" id="btn-toggle-active-submit" class="btn btn-danger btn-block">Block</button>`);
            }

            $('#btn-toggle-active-submit').unbind().click(function () {
                onSubmitToggleActiveUser(key);
            });

            $("#span-text-confirm-block").html("Are you sure to " + active + " " + UsersList[key].fname + " " + UsersList[key].lname + " ?");
            $("#BlockUser").modal('show');
        };

        let onSubmitToggleActiveUser = (key) => {
            showLoadingModal($("#BlockUser"), true);
            $.ajax({
                url: END_POINT + config.block,
                method: "put",
                data: {
                    user_id: UsersList[key].user_id,
                    block: UsersList[key].block ? 0 : 1
                },
                success: (res) => {
                    toastr["success"]("Blcok user success");
                    $("#BlockUser").modal('hide');
                    showLoadingModal($("#BlockUser"), false);
                    ManagementUsers.refreshData();
                },
                error: (res) => {
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
                                <div class="modal-dialog">
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
                                            <button type="button" id="btn-delete-submit" class="btn btn-danger btn-block">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                $("body").append(modal);
            }
            $('#span-text-confirm').html("Are you sure to delete " + UsersList[key].email[0].email_user + " ? ");
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

        let UsersDATATABLE = null;


        let initialDatatable = () => {
            if (UsersDATATABLE !== null) {
                return false;
            }

            UsersDATATABLE = $('#example').dataTable({});


            $("#btn-save-add-user").unbind().click(function () {
                onSaveUserClick($(this));
            });
        };

        let showDatatableLoadingStatus = (showOrHide) => {
            if (showOrHide) {
                $('#example').hide();
                $('.lds-roller').show();
            }
            else {
                $('.lds-roller').hide();
                $('.text-loading').hide();
                $('#example').show();
                $('.text-static').show();
            }
        };

        let createTableUsersCompany = () => {
            let Datatable = [];
            UsersDATATABLE.fnClearTable();
            $.each(UsersList, function (index, item) {
                let ret = [];
                let btnBlock = `                            
                <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index} data-toggle="tooltip" data-placement="top" title="Block">
                    <i class="fas fa-times"></i>
                </button>`;
                if (item.block) {
                    btnBlock = `                            
                    <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index} data-toggle="tooltip" data-placement="top" title="UnBlock">
                        <i class="fas fa-unlock"></i>
                    </button>`;
                }
                ret[0] = item.fname + " " + item.lname;
                ret[1] = item.phone[0].phone_user;
                ret[2] = item.email[0].email_user;
                ret[3] = item.block ? '<b class="text-danger">Block</b>' : 'Unblock';
                ret[4] = item.sub_type_user;
                ret[5] = item.online ? '<b class="text-success">online <i class="fas fa-circle text-success fa-xs"></i></b>' : '<span class="text-secondary">offline <i class="fas fa-circle text-secondary fa-xs"></i></span>';
                ret[6] = `<center>
                                <button type="button" class="btn btn-primary btn-sm btn-detail" index=${index} data-toggle="tooltip"
                                    data-placement="top" title="Detail">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm btn-edit" index=${index}  data-toggle="tooltip"
                                    data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                ${btnBlock}
                                <button type="button" class="btn btn-danger btn-sm btn-delete"  index=${index}  data-toggle="tooltip"
                                    data-placement="top" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </center>`;
                Datatable.push(ret);
            });
            UsersDATATABLE.fnAddData(Datatable);

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

        let createTableUsersCustomer = () => {
            let Datatable = [];
            UsersDATATABLE.fnClearTable();
            $.each(UsersList, function (index, item) {
                let ret = [];
                let btnBlock = `                            
                <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index} data-toggle="tooltip" data-placement="top" title="Block">
                    <i class="fas fa-times"></i>
                </button>`;
                if (item.block) {
                    btnBlock = `                            
                    <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index} data-toggle="tooltip" data-placement="top" title="UnBlock">
                        <i class="fas fa-unlock"></i>
                    </button>`;
                }
                ret[0] = item.fname + " " + item.lname;
                ret[1] = item.phone[0].phone_user;
                ret[2] = item.email[0].email_user;
                ret[3] = item.block ? '<b class="text-danger">Block</b>' : 'Unblock';
                ret[4] = item.online ? '<b class="text-success">online <i class="fas fa-circle text-success fa-xs"></i></b>' : '<span class="text-secondary">offline <i class="fas fa-circle text-secondary fa-xs"></i></span>';
                ret[5] = `<center>
                                <button type="button" class="btn btn-primary btn-sm btn-detail" index=${index} data-toggle="tooltip"
                                    data-placement="top" title="Detail">
                                    <i class="fas fa-list"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm btn-edit" index=${index}  data-toggle="tooltip"
                                    data-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                ${btnBlock}
                                <button type="button" class="btn btn-danger btn-sm btn-delete"  index=${index}  data-toggle="tooltip"
                                    data-placement="top" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </center>`;
                Datatable.push(ret);
            });
            UsersDATATABLE.fnAddData(Datatable);

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

        let onSaveUserClick = () => {
            let email_input = $("#add_email_val").val();
            let pwd_input = $("#add_pwd_val").val();
            let fname_input = $("#add_fname_val").val();
            let lname_input = $("#add_lname_val").val();
            let phone_input = $("#add_phone_val").val();
            let type_user_input = null
            if (config.type === 'COMPANY') {
                type_user_input = $("#add_type_user_val").val();
            }
            showLoadingModal($("#addUser"), true);
            $.ajax({
                url: END_POINT + config.create,
                dataType: 'json',
                method: "POST",
                data: {
                    email: email_input,
                    password: pwd_input,
                    fname: fname_input,
                    lname: lname_input,
                    phone: phone_input,
                    sub_type_user: type_user_input,
                },
                success: (res) => {
                    toastr["success"]("Create user success");
                    this.showLastestDatatable();
                    showLoadingModal($("#addUser"), false);
                    $("#addUser").modal('hide');
                },
                error: (res) => {
                    console.log(res);
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

        let updateDatatableData = () => {
            if (config.type === "COMPANY") {
                createTableUsersCompany();
            }
            else if (config.type === "CUSTOMER") {
                createTableUsersCustomer();
            }
            $('[data-toggle="tooltip"]').tooltip();
        };

        this.initialAndRun = () => {
            this.showLastestDatatable();


            $('#btn-add-user').unbind().click(function () {
                $('#addUser').modal('show');
            });

            $('#btn-save-add-user').unbind().click(function () {
                onSaveUserClick($(this));
            });
        };

        this.showLastestDatatable = () => {
            showDatatableLoadingStatus(true);
            $.ajax({
                url: END_POINT + config.getUsers,
                method: 'GET',
                success: function (result) {
                    console.log(result);
                    initialDatatable();
                    UsersList = result.data;
                    showDatatableLoadingStatus(false);
                    updateDatatableData();
                },
                error: function (error) {
                    console.log(error);
                }
            });

            $.ajax({
                url: END_POINT + config.getOnlineUsers,
                method: 'GET',
                data: {
                    type_user: config.type,
                },
                success: function (result) {
                    let sum = 0;
                    for (let i in result.users) {
                        sum += Number(result.users[i].count);
                        if (result.users[i].online === "online") {
                            $("#total-user-online").html(`${result.users[i].count} user`);
                        }
                        else {
                            $("#total-user-offline").html(`${result.users[i].count} user`);
                        }
                    }
                    $("#total-user").html(`${sum} user`);
                },
                error: function (error) {
                    console.log(error);
                }
            });
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

// let config = {
//     getUsers: "company/users",
//     getOnlineUsers: "company/users/online",
//     create: "",
//     edit: "company/users/edit",
//     block: "",
//     unblock: "",
//     delete: "",
//     type: "COMPANY",
// };

// let managementUsers = null;

// $(document).ready(function () {
//     managementUsers = new ManagementUsers(config);
//     managementUsers.initialAndRun();
// });