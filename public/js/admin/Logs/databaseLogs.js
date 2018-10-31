class DatabaseLogs {
    constructor() {

        let datatableObject = null;
        let datatableFileLogObject = null;
        let datatableLogViewer = null;
        let fileLogList = [];
        let folderLogList = [];
        let fileLogViewer = [];
        let ModalFileLog = null;

        let showLoadingStatus = (show, datatable) => {
            if (show) {
                datatable.hide();
                $('.lds-roller').show();
            }
            else {
                datatable.show();
                $('.lds-roller').hide();
            }
        };

        let updateDatatableData = (folder) => {
            let Datatable = [];
            datatableObject.fnClearTable();
            if (folder.length > 0) {
                $.each(folder, function (index, item) {
                    var ret = [];
                    ret[0] = item.company_name;
                    ret[1] = item.folder_log;
                    ret[2] = item.size;
                    ret[3] = ` <center>
                                    <button type="button" class="btn btn-warning btn-sm btn-look" index=${index}  data-toggle="tooltip"
                                        data-placement="top" title="Look">
                                        <i class="fas fa-folder"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete"  index=${index}  data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </center>`;
                    Datatable.push(ret);
                });
                datatableObject.fnAddData(Datatable);
            }

            $('#datatable-folder-log').on('click', '.btn-look', function () {
                onlookClick($(this).attr('index'));
            });


            $('#datatable-folder-log').on('click', '.btn-delete', function () {
                onDeleteClick($(this).attr('index'));
            });

            $('[data-toggle="tooltip"]').tooltip();
        };

        let onlookClick = (index) => {
            if (ModalFileLog === null) {
                ModalFileLog = `
                                <div class="modal fade" id="modal-file-log">
                                <div class="modal-dialog modal-lg" width:"900px">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="title-user"></h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <table class="table table-striped table-bordered table-hover" id="table-file-log">
                                                <thead>
                                                    <th>File</th>
                                                    <th>Size</th>
                                                    <th>Action</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            <table>
                                        </div>

                                        <div class="modal-footer">
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                $('body').append(ModalFileLog);
            }

            if (datatableFileLogObject === null) {
                datatableFileLogObject = $('#table-file-log').dataTable({});
            }
            $('#modal-file-log').modal('show');
            getFileLogByFolder(folderLogList[index].folder_log);


        };

        let updateDatatableFileLog = () => {
            let Datatable = [];
            datatableFileLogObject.fnClearTable();

            if (fileLogList.length > 0) {
                $.each(fileLogList, function (index, item) {
                    var ret = [];
                    ret[0] = item.file;
                    ret[1] = item.size;
                    ret[2] = ` <center>
                                    <button type="button" class="btn btn-warning btn-sm btn-look-file" index=${index}  data-toggle="tooltip"
                                        data-placement="top" title="Look">
                                        <i class="fas fa-file"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete-file"  index=${index}  data-toggle="tooltip"
                                        data-placement="top" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </center>`;
                    Datatable.push(ret);
                });
                datatableFileLogObject.fnAddData(Datatable);
            }


            $('#table-file-log').on('click', '.btn-look-file', function () {
                onlookFileClick($(this).attr('index'));
            });


            $('#table-file-log').on('click', '.btn-delete-file', function () {
                onDeleteFileClick($(this).attr('index'));
            });

            $('[data-toggle="tooltip"]').tooltip();
        };

        let onlookFileClick = (index) => {
            $("#modal-file-log").modal('hide');
            $(".log-viewer").show();
            $(".folder-log-viewer").hide();
            if (datatableLogViewer === null) {
                datatableLogViewer = $('#table-log').dataTable({
                    fixedHeader: true
                });
            }

            $("#btn-back").unbind().click(function () {
                onBtnBackClick();
            });

            getFileLogViewer(fileLogList[index].folder, fileLogList[index].file);
        };

        let onBtnBackClick = () => {
            $(".log-viewer").hide();
            $(".folder-log-viewer").show();
            //this.refreshDatatable();
        };

        let updateDatatableFileLogViewer = () => {
            let Datatable = [];
            datatableLogViewer.fnClearTable();
            if (fileLogViewer.logs.length > 0) {
                $("#path-file").html(`${fileLogViewer.current_folder}/${fileLogViewer.current_file}`);
                $("#file-size").html(`${fileLogViewer.size}`);
                $.each(fileLogViewer.logs, function (index, item) {
                    var ret = [];
                    ret[0] = `<i class="${item.level_img}" style="color:${item.level_color}"></i> <span class="text-${item.level_class}">${item.level}</span>`;
                    ret[1] = item.date;
                    ret[2] = `<div class='text-wrap width-200'>${item.text}</div>`;
                    ret[3] = item.stack ? `<button class='btn btn-danger btn-sm btn-radius'>stack</button>` : '';
                    Datatable.push(ret);
                });
                datatableLogViewer.fnAddData(Datatable);
            }
        };

        let getFileLogViewer = (folder, file) => {
            showLoadingStatus(true, $('#table-log'));
            $.ajax({
                url: 'http://localhost:8000/api/admin/database/logfile',
                data: {
                    folder: folder,
                    file: file
                },
                success: (res) => {
                    fileLogViewer = res.data;
                    setTimeout(() => {
                        updateDatatableFileLogViewer();
                        showLoadingStatus(false, $('#table-log'));
                    }, 600);
                },
                error: (error) => {
                    console.log(error);
                },
            });
        };

        let getFileLogByFolder = (folder_log) => {
            $.ajax({
                url: 'http://localhost:8000/api/admin/database/log/file',
                data: {
                    folder_log: folder_log,
                },
                success: (res) => {
                    fileLogList = res.file_log;
                    updateDatatableFileLog();
                },
                error: (error) => {
                    console.log(error);
                },
            });
        };

        let initialDatatable = () => {
            if (datatableObject !== null) {
                return false;
            }
            datatableObject = $('#datatable-folder-log').dataTable();
        };

        this.initialAndRun = () => {
            this.refreshDatatable();
        };

        this.refreshDatatable = () => {
            showLoadingStatus(true, $('#datatable-folder-log'));
            $.ajax({
                url: "http://localhost:8000/api/admin/database/log/folder",
                method: 'GET',
                success: function (result) {
                    initialDatatable();
                    folderLogList = result.folder_log;
                    showLoadingStatus(false, $('#datatable-folder-log'));
                    updateDatatableData(result.folder_log);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        };
    }
}

$(document).ready(function () {
    let databaseLogs = new DatabaseLogs();
    databaseLogs.initialAndRun();
});