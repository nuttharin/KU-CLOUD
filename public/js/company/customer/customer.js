var Customer = new (function () {
    var CustomerDATATABLE = null
    var CustomerList = [];
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


    var onSaveUserClick = () => {
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
        })
    }

    var updateDatatableData = (customerList) => {
        var Datatable = new Array();
        CustomerDATATABLE.fnClearTable();
        $.each(customerList.customer, function (index, item) {
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
        CustomerDATATABLE.fnAddData(Datatable);

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

        $('#title-user').html(CustomerList[key].email.split(',')[0]);
        $('#name-user').html(CustomerList[key].fname + " " + CustomerList[key].lname);
        $('#phone-user').html(CustomerList[key].phone);
        $('#email-user').html(CustomerList[key].email);

        $("#detailUser").modal('show');
    }

    var onEditClick = (key) => {
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
            if ($(".btn-delete-email").length <= 2)
                $("#input-add-email").append(FormAddEmail.replace('{email}', ''));
        })

        let phoneList = CustomerList[key].phone.split(',');
        let inputPhone = null;
        inputPhone = phoneList.map(phone => {
            return FormAddPhone.replace('{phone}', phone);
        })

        let emailList = CustomerList[key].email.split(',');
        let inputEmail = null;
        inputEmail = emailList.map(email => {
            return FormAddEmail.replace('{email}', email);
        })

        $('#edit-fname').val(CustomerList[key].fname);
        $('#edit-lname').val(CustomerList[key].lname);
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
                                        <h4 class="modal-title">Block User Customer</h4>
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
        $("#span-text-confirm-block").html("Are you sure to block " + CustomerList[key].fname + " " + CustomerList[key].lname + " ?");
        $("#BlockUser").modal('show');
    }

    var onDeleteClick = (key) => {
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
                        </div>`
            $('body').append(ModalDelete);
        }

        $('#span-text-confirm').html("Are you sure to delete " + CustomerList[key].email + " ? ")
        $('#DeleteUser').modal('show');
    }

    var initialDatatable = () => {
        if (CustomerDATATABLE !== null) {
            return false;
        }

        CustomerDATATABLE = $('#example').dataTable();
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

    this.initialAndRun = () => {
        this.showLastestDatatable();

        $('#btn-add-customer').unbind().click(function () {
            $('#addUser').modal('show');
        })

        $('#btn-save-add-user').unbind().click(function () {
            onSaveUserClick($(this));
        })
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


});

$(document).ready(function () {
    var TB_USER_CUSTOMER = Customer;
    TB_USER_CUSTOMER.initialAndRun({});
});