class DataSource
{
    
    constructor()
    {
    }

    DataSourceModel(infoID)
    {  
        let listDatasource = null;
        $("#addDatasource").remove();
        let datasourceModel = `
        <div class="modal fade" id="addDatasource">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">Add Datasource</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="">Name</label>
                                <input type="text" id="name_datasource" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Channel</label>
                                <select name="" id="webservice_id" class="form-control">
                                    <option value="">--Select Channel--</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="">Set time interval (s)</label>
                                <input type="number" id="add-data-time-interval" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <a class="btn btn-success btn-block" id="btn-add-new-datasource" href="#">Save</a>
                    </div>
                </div>
            </div>
        </div>`;

        $('body').append(datasourceModel);
        $("#addDatasource").modal('show');

        $.ajax({
            url: 'http://localhost:8000/api/company/webservices',
            success: (res) => {
                listDatasource = res.data;
                listDatasource.map(data => {
                    $("#webservice_id").append(`<option value="${data.webservice_id}">${data.service_name}</option>`);
                });
            },
            error: (res) => {
                console.log(res);
            }
        });

        $("#btn-add-new-datasource").unbind().click(function () {
            $.ajax({
                url: 'http://localhost:8000/api/admin/infographic/createDatasource',
                method: 'POST',
                data: {
                    info_id: infoID,
                    name: $("#name_datasource").val(),
                    webservice_id: $("#webservice_id").val(),
                    timeInterval: $("#add-data-time-interval").val()
                },
                success: (res) => {
                    $("#addDatasource").modal('hide');
                    $("#addDatasource").remove();
                },
                error: (res) => {
                    console.log(res);
                }
            });
        });
    }


}