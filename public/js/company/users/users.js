
var Users = new (function () {
    var UsersDATATABLE = null;
    var that = this;

    var initialDatatable = () => {
        if (UsersDATATABLE != null) {
            return false;
        }

        UsersDATATABLE = $('#example').dataTable();


        $("#btn-save-add-user").unbind().click(function () {
            onSaveUserClick();
        });
    }

    var showDatatableLoadingStatus = (showOrHide) => {
        if (showOrHide) {
            $('.lds-roller').show();
            $('#example').hide();
        }
        else {
            $('#example').show();
            $('.lds-roller').hide();
        }
    }

    var updateDatatableData = (userList) => {
        var Datatable = new Array();
        UsersDATATABLE.fnClearTable();
        $.each(userList.users, function (index, item) {
            var ret = [];
            ret[0] = item.name;
            ret[1] = item.phone;
            ret[2] = item.email;
            ret[3] = `<center>
                            <button type="button" class="btn btn-primary btn-sm" onclick="" data-toggle="tooltip"
                                data-placement="top" title="Detail">
                                <i class="fas fa-list"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm" onclick="" data-toggle="tooltip"
                                data-placement="top" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="" data-toggle="tooltip"
                                data-placement="top" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </center>`;
            Datatable.push(ret);
        });
        UsersDATATABLE.fnAddData(Datatable);
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
            error: function (xhr) {

            },
            success: function (result) {
                showDatatableLoadingStatus(false);
                updateDatatableData(result);
            }
        });
    };
})


$(document).ready(function () {
    var TB_USERS = Users;
    TB_USERS.initialAndRun({});
});