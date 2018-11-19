var WebserviceRepository = new (function () {
    var webserviceList = [];
    var datatableObject = null;
    var modalDetail = null;
    var modalEdit = null;
    var modalDelete = null;

    this.initialAndRun = () => {
        this.refreshDatatable();
    };

    this.refreshDatatable = () => {
        showLoadingStatus(true);
        $.ajax({
            url: "http://localhost:8000/api/admin/webservicedata",
            method: 'GET',
            success: function (result) {
                initialDatatable();
                webserviceList = result.webService;
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

        datatableObject = $('#datatable-webservice').dataTable();
    }

    var showLoadingStatus = (show) => {
        if (show) {
            $('#datatable-webservice').hide();
            $('#total-webservice').hide();
        }
        else {
            $('#datatable-webservice').show();
            $('.text-static').show();
            $('#total-webservice').show();
            $('.lds-roller').hide();
            $('.text-loading').hide();
        }
    }

    //-----------------------------------------------------------//
    var updateDatatableData = (webserviceList) => {
        var Datatable = new Array();
        datatableObject.fnClearTable();
        let total_company = 0;
        $.each(webserviceList.webService, function (index, item) {
            var ret = [];
            ret[0] = item.name;
            ret[1] = item.alias;
            ret[2] = item.description;
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
            total_company++;
        });
        datatableObject.fnAddData(Datatable);
        $("#total-webservice").html(`Total ${total_company} Webservices`);
        $('#datatable-webservice').on('click', '.btn-detail', function () {
            onDetailClick($(this).attr('index'));
        });

        $('#datatable-webservice').on('click', '.btn-edit', function () {
            onEditClick($(this).attr('index'));
        });


        $('#datatable-webservice').on('click', '.btn-delete', function () {
            onDeleteClick($(this).attr('index'));
        });

        $('[data-toggle="tooltip"]').tooltip();
        
    }

    /* Action Function */
    var onDetailClick = (key) => {

        if (modalDetail === null) {
            modalDetail =
                `<div class="modal fade" id="detailCompany">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="title-company">Webservice Details</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <h6>Service Name : <span id="name-company"><span></h6>
                            <h6>Alias : <span id="alias-company"><span></h6>
                            <h6>URL : <span id="address-company"><span></h6>
                            <h6>Description : <span id="note-company"><span></h6>
                            <h6>Create Date : <span id="create-company"><span></h6>
                            <h6>Update Date : <span id="update-company"><span></h6>
                        </div>
                    </div>
                </div>
            </div>`;

            $('body').append(modalDetail);
        }

        $('#name-company').html(webserviceList[key].name);
        $('#alias-company').html(webserviceList[key].alias);
        $('#address-company').html(webserviceList[key].URL);
        $('#note-company').html(webserviceList[key].description);
        $('#create-company').html(webserviceList[key].created_at);
        $('#update-company').html(webserviceList[key].updated_at);

        $("#detailCompany").modal('show');
    }
    

});
$(document).ready(function () {
    var webserviceTable = WebserviceRepository;
    webserviceTable.initialAndRun({});
});