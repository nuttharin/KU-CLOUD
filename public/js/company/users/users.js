
var Users = new (function () {
    var UsersDATATABLE = null;
    var UsersList = [];
    var ModalDetail = null;
    var ModalEdit = null;
    var ModalBlock = null;
    var ModalDelete = null;
    const FormAddEmail = `
                            <div class="input-group mb-2">
                                <input type="text" class="add_email_val form-control mt-1" value={email}>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger mt-1 btn-delete-email" type="button"><i class="fas fa-times"></i></button>  
                                    </div>
                            </div>
                          `;
    const FormAddPhone = `  <div class="input-group mb-2">
                                <input type="text" class="add_phone_val form-control mt-1" value={phone}>
                                <div class="input-group-append">
                                    <button class="btn btn-danger mt-1 btn-delete-phone" type="button"><i class="fas fa-times"></i></button>  
                                </div>
                            </div>`;
    var that = this;


    var initialDatatable = () => {
        if (UsersDATATABLE !== null) {
            return false;
        }

        UsersDATATABLE = $('#example').dataTable();


        $("#btn-save-add-user").unbind().click(function () {
            onSaveUserClick($(this));
        });


    }

    var showDatatableLoadingStatus = (showOrHide) => {
        if (showOrHide) {
            $('#example').hide();
        }
        else {
            $('.lds-roller').hide();
            $('.text-loading').hide();
            $('#example').show();
            $('.text-static').show();
        }
    }

    var updateDatatableData = (userList) => {
        var Datatable = new Array();
        UsersDATATABLE.fnClearTable();
        $.each(userList.users, function (index, item) {
            var ret = [];
            ret[0] = item.fname + " " + item.lname;
            ret[1] = item.phone.split(',')[0];
            ret[2] = item.email.split(',')[0];
            ret[3] = `<center>
                            <button type="button" class="btn btn-primary btn-sm btn-detail" index=${index} data-toggle="tooltip"
                                data-placement="top" title="Detail">
                                <i class="fas fa-list"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm btn-edit" index=${index}  data-toggle="tooltip"
                                data-placement="top" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-secondary btn-sm btn-block-user" index=${index} data-toggle="tooltip"
                                data-placement="top" title="Block">
                                <i class="fas fa-times"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-delete"  index=${index}  data-toggle="tooltip"
                                data-placement="top" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </center>`;
            Datatable.push(ret);
        });
        UsersDATATABLE.fnAddData(Datatable);

        $(".btn-detail").unbind().click(function () {
            onDetailClick($(this).attr('index'));
        });

        $(".btn-edit").unbind().click(function () {
            onEditClick($(this).attr('index'));
        });

        $(".btn-block-user").unbind().click(function () {
            onBlockClick($(this).attr('index'));
        })

        $(".btn-delete").unbind().click(function () {
            onDeleteClick($(this).attr('index'));
        });
        $('[data-toggle="tooltip"]').tooltip();
    }

    var onSaveUserClick = () => {
        let email_input = $("#add_email_val").val();
        let pwd_input = $("#add_pwd_val").val();
        let fname_input = $("#add_fname_val").val();
        let lname_input = $("#add_lname_val").val();
        let type_user_input = $("#add_type_user_val").val();
        let phone_input = $("#add_phone_val").val();
        $.ajax({
            url: "http://localhost:8000/api/company/users",
            dataType: 'json',
            method: "POST",
            data: {
                email: email_input,
                password: pwd_input,
                fname: fname_input,
                lname: lname_input,
                phone: phone_input,
                sub_type_user: type_user_input
            },
            success: (res) => {
                this.showLastestDatatable();
                $("#addUser").modal('hide');
            },
            error: (res) => {
                console.log(res);
            }
        })
    }

    var onDetailClick = (key) => {
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
                          `
            $('body').append(ModalDetail);
        }

        $('#title-user').html(UsersList[key].email.split(',')[0]);
        $('#name-user').html(UsersList[key].fname + " " + UsersList[key].lname);
        $('#phone-user').html(UsersList[key].phone);
        $('#email-user').html(UsersList[key].email);

        $("#detailUser").modal('show');
    }

    var onEditClick = (key) => {
        if (ModalEdit === null) {
            ModalEdit = `
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
                                        <button type="button" id="btn-edit-submit" class="btn btn-success btn-block">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>`
            $('body').append(ModalEdit);

        }

        $("#btn-add-phone").unbind().click(function () {
            event.preventDefault();
            console.log(FormAddPhone)
            if ($(".btn-delete-phone").length <= 2)
                $("#input-add-phone").append(FormAddPhone.replace('{phone}', ''));
        })

        $("#btn-add-email").unbind().click(function () {
            event.preventDefault();
            console.log(FormAddEmail)
            if ($(".btn-delete-email").length <= 2)
                $("#input-add-email").append(FormAddEmail.replace('{email}', ''));
        })

        let phoneList = UsersList[key].phone.split(',');
        let inputPhone = null;
        inputPhone = phoneList.map(phone => {
            return FormAddPhone.replace('{phone}', phone);
        })

        let emailList = UsersList[key].email.split(',');
        let inputEmail = null;
        inputEmail = emailList.map(email => {
            return FormAddEmail.replace('{email}', email);
        })

        $('#edit-fname').val(UsersList[key].fname);
        $('#edit-lname').val(UsersList[key].lname);
        $('#input-add-phone').html(inputPhone.join(''));
        $('#input-add-email').html(inputEmail.join(''));
        $('#editUser').modal('show');
    }

    var onBlockClick = (key) => {
        if (ModalBlock === null) {
            ModalBlock = `
                        <div class="modal fade" id="BlockUser">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Delete User Company</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <form id="form-delete-user">
                                            <h6 id="span-text-confirm-block"></h6>
                                        </form>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" id="btn-block-submit" class="btn btn-danger btn-block">Block</button>
                                    </div>
                                </div>
                            </div>
                        </div>`
            $('body').append(ModalBlock);
        }
        $("#span-text-confirm-block").html("Are you sure to block " + UsersList[key].fname + " " + UsersList[key].lname + " ?");
        $("#BlockUser").modal('show');
    }

    var onDeleteClick = (key) => {
        if (ModalDelete === null) {
            ModalDelete = `
                        <div class="modal fade" id="DeleteUser">
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
                        </div>`
            $('body').append(ModalDelete);
        }

        $('#span-text-confirm').html("Are you sure to delete " + UsersList[key].email + " ? ")
        $('#DeleteUser').modal('show');
    }

    this.initialAndRun = () => {
        this.showLastestDatatable();
    };

    this.showLastestDatatable = () => {
        initialDatatable();
        showDatatableLoadingStatus(true);
        $.ajax({
            url: "http://localhost:8000/api/company/users",
            async: false,
            method: 'GET',
            success: function (result) {
                UsersList = result.users;
                showDatatableLoadingStatus(false);
                updateDatatableData(result);
            },
            error: function (error) {

            }
        });
    };
})


$(document).ready(function () {
    var TB_USERS = Users;
    TB_USERS.initialAndRun({});
});