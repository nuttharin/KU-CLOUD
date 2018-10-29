class Customer {
    constructor() {
        let CustomerDATATABLE = null;
        let CustomerList = [];
        let ModalDetail = null;
        let ModalEdit = null;
        let ModalBlock = null;
        let ModalUnBlock = null;
        let ModalDelete = null;
        const FormAddEmail = `
                                <div class="input-group mb-2">
                                    <input type="text" class="add_email_val form-control mt-1" value={email} disabled>
                                        <div class="input-group-append">
                                            <button class="btn btn-danger mt-1 btn-delete-email" type="button"><i class="fas fa-times"></i></button>  
                                        </div>
                                </div>
                              `;
        const FormAddPhone = `  <div class="input-group mb-2">
                                    <input type="text" class="add_phone_val form-control mt-1" value={phone} disabled>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger mt-1 btn-delete-phone" type="button"><i class="fas fa-times"></i></button>  
                                    </div>
                                </div>`;
        let that = this;


        let onSaveUserClick = () => {
            let email_input = $("#add_email_val").val();
            let pwd_input = $("#add_pwd_val").val();
            let fname_input = $("#add_fname_val").val();
            let lname_input = $("#add_lname_val").val();
            let phone_input = $("#add_phone_val").val();
            $.ajax({
                url: "http://localhost:8000/api/company/customers",
                dataType: 'json',
                method: "POST",
                data: {
                    email: email_input,
                    password: pwd_input,
                    fname: fname_input,
                    lname: lname_input,
                    phone: phone_input,
                },
                success: (res) => {
                    this.showLastestDatatable();
                    $("#addUser").modal('hide');
                },
                error: (res) => {
                    console.log(res);
                }
            });
        };

        let updateDatatableData = (customerList) => {
            let Datatable = [];
            CustomerDATATABLE.fnClearTable();
            $.each(customerList.customer, function (index, item) {
                let ret = [];
                let btnBlock = `                            
                <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index} data-toggle="tooltip" data-placement="top" title="Block">
                    <i class="fas fa-times"></i>
                </button>`;
                if (item.block) {
                    btnBlock = `                            
                    <button type="button" class="btn btn-info btn-sm btn-unblock-user" index=${index} data-toggle="tooltip" data-placement="top" title="UnBlock">
                        <i class="fas fa-unlock"></i>
                    </button>`;
                }
                ret[0] = item.fname + " " + item.lname;
                ret[1] = item.phone.split(',')[0];
                ret[2] = item.email.split(',')[0];
                ret[3] = item.block ? 'Block' : 'Unblock';
                ret[4] = `<center>
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
            CustomerDATATABLE.fnAddData(Datatable);

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

            $('[data-toggle="tooltip"]').tooltip();
        };

        let onDetailClick = (key) => {
            if (ModalDetail === null) {
                ModalDetail = `
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
                                            <button type="button" id="" class="btn btn-success btn-block">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                              `;
                $('body').append(ModalDetail);
            }

            $('#title-user').html(CustomerList[key].email.split(',')[0]);
            $('#name-user').html(CustomerList[key].fname + " " + CustomerList[key].lname);
            $('#phone-user').html(CustomerList[key].phone);
            $('#email-user').html(CustomerList[key].email);

            $("#detailUser").modal('show');
        };

        let onEditClick = (key) => {
            if (ModalEdit === null) {
                ModalEdit = `
                            <div class="modal fade" id="editUser">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit User Customer</h4>
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
                                            <button type="button" id="btn-edit-submit" class="btn btn-success btn-block">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                $('body').append(ModalEdit);
            }

            $("#btn-edit-submit").unbind().click(function () {
                onSubmitEditclick(key);
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

            let phoneList = CustomerList[key].phone.split(',');
            let inputPhone = null;
            inputPhone = phoneList.map(phone => {
                return FormAddPhone.replace('{phone}', phone);
            });

            let emailList = CustomerList[key].email.split(',');
            let inputEmail = null;
            inputEmail = emailList.map(email => {
                return FormAddEmail.replace('{email}', email);
            });

            $('#edit-fname').val(CustomerList[key].fname);
            $('#edit-lname').val(CustomerList[key].lname);
            $('#input-add-phone').html(inputPhone.join(''));
            $('#input-add-email').html(inputEmail.join(''));
            $('#editUser').modal('show');
        };

        let onSubmitEditclick = (index) => {
            let fname = $("#edit-fname").val();
            let lname = $("#edit-lname").val();
            let phone = $(".add_phone_val").map(function () {
                return $(this).val();
            }).get();
            let email = $(".add_email_val").map(function () {
                return $(this).val();
            }).get();
            $.ajax({
                url: "http://localhost:8000/api/company/users/edit",
                method: "PUT",
                data: {
                    user_id: UsersList[index].user_id,
                    fname: fname,
                    lname: lname,
                    phone_user: phone,
                    email_user: email
                },
                success: (res) => {
                    $("#editUser").modal('hide');
                    this.showLastestDatatable();
                },
                error: (res) => {
                    console.log(res);
                }
            });
        };

        let onBlockClick = (key) => {
            if (ModalBlock === null) {
                ModalBlock = `
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
    
                                        <div class="modal-footer">
                                            <button type="button" id="btn-block-submit" class="btn btn-danger btn-block">Block</button>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                $('body').append(ModalBlock);
            }

            $('#btn-block-submit').unbind().click(function () {
                onSubmitBlockUser(key);
            });


            $("#span-text-confirm-block").html("Are you sure to block " + CustomerList[key].fname + " " + CustomerList[key].lname + " ?");
            $("#BlockUser").modal('show');
        };

        let onUnBlockClick = (key) => {
            if (ModalUnBlock === null) {
                ModalUnBlock = `
                <div class="modal fade" id="UnBlockUser">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Block User Company</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="form-unblock-user">
                                    <h6 id="span-text-confirm-unblock"></h6>
                                </form>
                            </div>
    
                            <div class="modal-footer">
                                <button type="button" id="btn-unblock-submit" class="btn btn-info btn-block">UnBlock</button>
                            </div>
                        </div>
                    </div>
                </div>`;

                $('body').append(ModalUnBlock);
            }

            $('#btn-unblock-submit').unbind().click(function () {
                onSubmitUnBlockUser(key);
            });

            $("#span-text-confirm-unblock").html("Are you sure to unblock " + CustomerList[key].fname + " " + CustomerList[key].lname + " ?");
            $("#UnBlockUser").modal('show');

        };

        let onSubmitBlockUser = (key) => {
            showLoadingModal($("#BlockUser"), true);
            $.ajax({
                url: "http://localhost:8000/api/company/users/block",
                method: "put",
                data: {
                    user_id: CustomerList[key].user_id,
                    block: 1
                },
                success: (res) => {
                    $("#BlockUser").modal('hide');
                    showLoadingModal($("#BlockUser"), false);
                    that.showLastestDatatable();
                },
                error: (res) => {
                    console.log(res);
                }
            });
        };

        let onSubmitUnBlockUser = (key) => {
            showLoadingModal($("#UnBlockUser"), true);
            $.ajax({
                url: "http://localhost:8000/api/company/users/block",
                method: "put",
                data: {
                    user_id: CustomerList[key].user_id,
                    block: 0
                },
                success: (res) => {
                    $("#UnBlockUser").modal('hide');
                    showLoadingModal($("#UnBlockUser"), false);
                    that.showLastestDatatable();
                },
                error: (res) => {
                    console.log(res);
                }
            });
        };

        let onDeleteClick = (key) => {
            if (ModalDelete === null) {
                ModalDelete = `
                            <div class="modal fade" id="DeleteUser">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Delete User Customer</h4>
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
                $('body').append(ModalDelete);
            }

            $('#span-text-confirm').html("Are you sure to delete " + CustomerList[key].email + " ? ");
            $('#DeleteUser').modal('show');
        };

        let initialDatatable = () => {
            if (CustomerDATATABLE !== null) {
                return false;
            }

            CustomerDATATABLE = $('#example').dataTable();
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

        this.initialAndRun = () => {
            this.showLastestDatatable();

            $('#btn-add-customer').unbind().click(function () {
                $('#addUser').modal('show');
            });

            $('#btn-save-add-user').unbind().click(function () {
                onSaveUserClick($(this));
            });
        };

        this.showLastestDatatable = () => {
            showDatatableLoadingStatus(true);
            $.ajax({
                url: "http://localhost:8000/api/company/customers",
                method: 'GET',
                success: function (result) {
                    initialDatatable();
                    CustomerList = result.customer;
                    showDatatableLoadingStatus(false);
                    updateDatatableData(result);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        };
    }
}

$(document).ready(function () {
    let TB_USER_CUSTOMER = new Customer();
    TB_USER_CUSTOMER.initialAndRun({});
});