/* Model */
var CompanyRepository = new (function () {
    var companyList = [];
    var datatableObject = null;
    var modelCreate = null;
    var modalDetail = null;
    var modalEdit = null;
    var modalDelete = null;

    /* Initial Function */
    this.initialAndRun = () => {
        this.refreshDatatable();
    };

    this.refreshDatatable = () => {
        showLoadingStatus(true);
        $.ajax({
            url: "http://localhost:8000/api/admin/companydata",
            method: 'GET',
            success: function (result) {
                initialDatatable();
                companyList = result.company;
                showLoadingStatus(false);
                updateDatatableData(result);
            },
            error: function (error) {
                console.log(error);
            }
        });
    };

    var initialDatatable = () => {
        if (datatableObject !== null) {
            return false;
        }

        $("#btn-create").unbind().click(function () {
            onCreateClick();
        });

        datatableObject = $('#datatable-company').dataTable();
    }

    var showLoadingStatus = (show) => {
        if (show) {
            $('#datatable-company').hide();
        }
        else {
            $('#datatable-company').show();
            $('.text-static').show();
            $('.lds-roller').hide();
            $('.text-loading').hide();
        }
    }

    var updateDatatableData = (companyList) => {
        var Datatable = new Array();
        datatableObject.fnClearTable();

        $.each(companyList.company, function (index, item) {
            var ret = [];
            ret[0] = item.name;
            ret[1] = item.alias;
            ret[2] = item.address;
            ret[3] = ` <center>
                            <button type="button" class="btn btn-primary btn-sm btn-detail" index=${index} data-toggle="tooltip"
                                data-placement="top" title="Detail">
                                <i class="fas fa-list"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm btn-edit" index=${index}  data-toggle="tooltip"
                                data-placement="top" title="Edit">
                                <i class="fas fa-edit"></i>
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

        $(".btn-delete").unbind().click(function () {
            onDeleteClick($(this).attr('index'));
        });

        $('[data-toggle="tooltip"]').tooltip();
    }

    /* Action Function */
    var onCreateClick = () => {
        if (modelCreate === null) {
            modelCreate =
                `<div class="modal fade" id="addUser">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Create Company</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="form-add-user">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="">Company Name</label>
                                        <input type="text" class="form-control" id="add_company_name_val" />
                                        <label for="">Address</label>
                                        <input type="text" class="form-control" id="add_address_val" />
                                    </div>
                                    <div class="col-6">
                                        <label for="">Alias</label>
                                        <input type="text" class="form-control" id="add_alias_val" />
                                        <label for="">Note</label>
                                        <input type="text" class="form-control" id="add_note_val" />
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

    var createSaveChange = () => {
        let company_name_input = $("#add_company_name_val").val();
        let alias_input = $("#add_alias_val").val();
        let address_input = $("#add_address_val").val();
        let note_input = $("#add_note_val").val();

        $.ajax({
            url: "http://localhost:8000/api/admin/companydata/create",
            dataType: 'json',
            method: "POST",
            data:
            {
                company_name: company_name_input,
                alias: alias_input,
                address: address_input,
                note: note_input
            },
            success: (res) => {
                this.refreshDatatable();
                $("#addUser").modal('hide');
            },
            error: (res) => {
                console.log(res);
            }
        })
    }

    var onDetailClick = (key) => {
        if (modalDetail === null) {
            modalDetail =
                `<div class="modal fade" id="detailCompany">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title-company">Company Details</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <h6>Company Name : <span id="name-company"><span></h6>
                            <h6>Alias : <span id="alias-company"><span></h6>
                            <h6>Address : <span id="address-company"><span></h6>
                            <h6>Note : <span id="note-company"><span></h6>
                            <h6>Create Date : <span id="create-company"><span></h6>
                            <h6>Update Date : <span id="update-company"><span></h6>
                        </div>
                    </div>
                </div>
            </div>`;

            $('body').append(modalDetail);
        }

        $('#name-company').html(companyList[key].name);
        $('#alias-company').html(companyList[key].alias);
        $('#address-company').html(companyList[key].address);
        $('#note-company').html(companyList[key].note);
        $('#create-company').html(companyList[key].created_at);
        $('#update-company').html(companyList[key].updated_at);

        $("#detailCompany").modal('show');
    }

    var onEditClick = (key) => {
        if (modalEdit === null) {
            modalEdit =
                `<div class="modal fade" id="editCompany">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Company</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form id="form-edit-user">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="">Company Name</label>
                                        <input type="text" class="form-control" id="company_name" />
                                        <label for="">Address</label>
                                        <input type="text" class="form-control" id="address_val" />
                                    </div>
                                    <div class="col-6">
                                        <label for="">Alias</label>
                                        <input type="text" class="form-control" id="alias_val" />
                                        <label for="">Note</label>
                                        <input type="text" class="form-control" id="note_val" />
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

        $('#company_name').val(companyList[key].name);
        $('#alias_val').val(companyList[key].alias);
        $('#address_val').val(companyList[key].address);
        $('#note_val').val(companyList[key].note);

        $('#editCompany').modal('show');
    }

    var onDeleteClick = (key) => {
        if (modalDelete === null) {
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

        $('#span-text-confirm').html("Are you sure to delete " + companyList[key].name + " ? ")

        $('#DeleteUser').modal('show');
    }
})

/* Set initial value */
$(document).ready(function () {
    var companyTable = CompanyRepository;
    companyTable.initialAndRun({});
});