/* Model */
var CompanyRepository = new (function () {
    var usersList       = [];
    var datatableObject = null;
    var modelCreate     = null;
    var modalDetail     = null;
    var modalEdit       = null;
    var modalBlock      = null;
    var modalDelete     = null;
    const formAddEmail  = `
                            <div class="input-group mb-2">
                                <input type="text" class="add_email_val form-control mt-1" value={email}>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger mt-1 btn-delete-email" type="button"><i class="fas fa-times"></i></button>  
                                    </div>
                            </div>`;
    const formAddPhone  = `  <div class="input-group mb-2">
                                <input type="text" class="add_phone_val form-control mt-1" value={phone}>
                                <div class="input-group-append">
                                    <button class="btn btn-danger mt-1 btn-delete-phone" type="button"><i class="fas fa-times"></i></button>  
                                </div>
                            </div>`;

    /* Initial Function */
    this.initialAndRun = () => 
    {
        this.refreshDatatable();
    };

    this.refreshDatatable = () => 
    {
        showLoadingStatus(true);
        $.ajax({
            url: "http://localhost:8000/api/admin/companies",
            method: 'GET',
            success: function (result) 
            {
                initialDatatable();
                usersList = result.users;
                showLoadingStatus(false);
                updateDatatableData(result);
            },
            error: function (error) 
            {
                console.log(error);
            }
        });
    };

    var initialDatatable = () => 
    {
        if (datatableObject !== null) 
        {
            return false;
        }

        $("#btn-create").unbind().click(function () {
            onCreateClick();
        });

        datatableObject = $('#datatable-company').dataTable(); 
    }

    var showLoadingStatus = (show) => 
    {
        if (show) 
        {
            $('#datatable-company').hide();
        }
        else 
        {
            $('#datatable-company').show();
            $('.text-static').show();
            $('.lds-roller').hide();
            $('.text-loading').hide();
        }
    }

    var updateDatatableData = (userList) => 
    {
        var Datatable = new Array();
        datatableObject.fnClearTable();

        $.each(userList.users, function (index, item) {
            var ret = [];
            ret[0]  = item.fname + " " + item.lname;
            ret[1]  = item.phone.split(',')[0];
            ret[2]  = item.email.split(',')[0];
            ret[3]  = item.block ? "No" : "Yes";
            ret[4]  = ` <center>
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

        datatableObject.fnAddData(Datatable);

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

    /* Action Function */
    var onCreateClick = () => 
    {
        if(modelCreate === null)
        {
            modelCreate = 
            `<div class="modal fade" id="addUser">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Create User Company</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="form-add-user">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="">Email</label>
                                        <input type="text" class="form-control" id="add_email_val" />
                                        <label for="">Firstname</label>
                                        <input type="text" class="form-control" id="add_fname_val" />
                                        <label for="">Phone</label>
                                        <input type="text" class="form-control" id="add_phone_val" />
                                    </div>
                                    <div class="col-6">
                                        <label for="">Password</label>
                                        <input type="text" class="form-control" id="add_pwd_val" />
                                        <label for="">Lastname</label>
                                        <input type="text" class="form-control" id="add_lname_val" />
                                        <label for="">Type User</label>
                                        <select id="add_type_user_val" class="form-control">
                                            <option>ADMIN</option>
                                            <option selected>NORMAL</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>              
                        <div class="modal-footer">
                            <button type="button" id="btn-create-save" class="btn btn-success btn-block">Save</button>
                        </div>          
                    </div>
                </div>
            </div>`
            
            $('body').append(modelCreate);
        }

        $("#btn-create-save").unbind().click(function () {
            createSaveChange($(this));
        })

        $('#addUser').modal('show');
    }

    var createSaveChange = () => 
    {
        let email_input     = $("#add_email_val").val();
        let pwd_input       = $("#add_pwd_val").val();
        let fname_input     = $("#add_fname_val").val();
        let lname_input     = $("#add_lname_val").val();
        let type_user_input = $("#add_type_user_val").val();
        let phone_input     = $("#add_phone_val").val();
        $.ajax({
            url: "http://localhost:8000/api/admin/company/create",
            dataType: 'json',
            method: "POST",
            data: 
            {
                email:          email_input,
                password:       pwd_input,
                fname:          fname_input,
                lname:          lname_input,
                phone:          phone_input,
                sub_type_user:  type_user_input
            },
            success: (res) => 
            {
                this.refreshDatatable();
                $("#addUser").modal('hide');
            },
            error: (res) => 
            {
                console.log(res);
            }
        })
    }

    var onDetailClick = (key) => 
    {
        if (modalDetail === null) 
        {
            modalDetail = 
           `<div class="modal fade" id="detailUser">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title-user">Company User Details</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <h6>Name : <span  id="name-user"><span></h6>
                            <h6>Phone : <span id="phone-user"><span></h6>
                            <h6>Email : <span id="email-user"><span></h6>
                            <h6>Active : <span id="active-user"><span></h6>
                            <h6>Create Date : <span id="create-user"><span></h6>
                            <h6>Update Date : <span id="update-user"><span></h6>
                        </div>
                    </div>
                </div>
            </div>`

            $('body').append(modalDetail);
        }

        $('#name-user').html(usersList[key].fname + " " + usersList[key].lname);
        $('#phone-user').html(usersList[key].phone);
        $('#email-user').html(usersList[key].email);
        $('#active-user').html(usersList[key].block ? "No" : "Yes");
        $('#create-user').html(usersList[key].created_at);
        $('#update-user').html(usersList[key].updated_at);

        $("#detailUser").modal('show');
    }

    var onEditClick = (key) => 
    {
        if (modalEdit === null) 
        {
            modalEdit = 
            `<div class="modal fade" id="editUser">
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

            $('body').append(modalEdit);
        }

        $("#btn-add-phone").unbind().click(function () {
            event.preventDefault();
            console.log(formAddPhone)
            if ($(".btn-delete-phone").length <= 2)
                $("#input-add-phone").append(formAddPhone.replace('{phone}', ''));
        })

        $("#btn-add-email").unbind().click(function () {
            event.preventDefault();
            console.log(formAddEmail)
            if ($(".btn-delete-email").length <= 2)
                $("#input-add-email").append(formAddEmail.replace('{email}', ''));
        })

        let phoneList = usersList[key].phone.split(',');
        let inputPhone = null;
        inputPhone = phoneList.map(phone => {
            return formAddPhone.replace('{phone}', phone);
        })

        let emailList = usersList[key].email.split(',');
        let inputEmail = null;
        inputEmail = emailList.map(email => {
            return formAddEmail.replace('{email}', email);
        })

        $('#edit-fname').val(usersList[key].fname);
        $('#edit-lname').val(usersList[key].lname);
        $('#input-add-phone').html(inputPhone.join(''));
        $('#input-add-email').html(inputEmail.join(''));

        $('#editUser').modal('show');
    }

    var onBlockClick = (key) => 
    {
        if (modalBlock === null) 
        {
            modalBlock = 
            `<div class="modal fade" id="BlockUser">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title-text"></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="form-delete-user">
                                <h6 id="span-text-confirm-block"></h6>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-block-submit" class="btn btn-danger btn-block"><span id="btn-text"></span></button>
                        </div>
                    </div>
                </div>
            </div>`
            
            $('body').append(modalBlock);
        }

        if(usersList[key].block)
        {
            $("#span-text-confirm-block").html("Are you sure to unblock " + usersList[key].fname + " " + usersList[key].lname + " ?");
            $("#btn-text").html("Unblock");
            $("#title-text").html("Unblock User Company");
        }
        else
        {
            $("#span-text-confirm-block").html("Are you sure to block " + usersList[key].fname + " " + usersList[key].lname + " ?");
            $("#btn-text").html("Block");
            $("#title-text").html("Block User Company");
        }
       
        $("#btn-block-submit").unbind().click(function () {
            blockSaveChange(key);
        })
        
        $("#BlockUser").modal('show');
    }

    var blockSaveChange = (key) => 
    {
        var urlLink;

        if(usersList[key].block)
        {
            urlLink = "http://localhost:8000/api/admin/users/unblock"
        }
        else
        {
            urlLink = "http://localhost:8000/api/admin/users/block"
        }

        $.ajax({
            url: urlLink,
            method: "PUT",
            data: 
            {
                user_id:   usersList[key].user_id   
            },
            success: () => 
            {
                this.refreshDatatable();
                $("#BlockUser").modal('hide');               
            },
            error: (res) => 
            {
                console.log(res);
            }
        });
    }

    var onDeleteClick = (key) => 
    {
        if (modalDelete === null) 
        {
            modalDelete = 
            `<div class="modal fade" id="DeleteUser">
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

            $('body').append(modalDelete);
        }

        $('#span-text-confirm').html("Are you sure to delete " + usersList[key].email + " ? ")
        
        $('#DeleteUser').modal('show');
    }
})

/* Set initial value */
$(document).ready(function () {
    var companyTable = CompanyRepository;
    companyTable.initialAndRun({});
});