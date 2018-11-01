class Service {
    constructor() {
        let dataFromUrl;
        let dataHeader;
        let dataHeaderList;



        this.initService = (url) => {
            console.log("init service")
            let treeView = new TreeView();
            treeView.clearValue();
            dataFromUrl = treeView.getDataFormUrl();
            dataHeader = treeView.getHeaderFormData(dataFromUrl);
            dataHeaderList = treeView.getDataHeaderAll();
            dataHeader = JSON.stringify(dataHeader);

            this.createTreeView();
            //console.log(dataHeader);
            // console.log(dataHeaderList);
        }

        this.createTreeView = () => {
            //console.log("Sssssss");
            //console.log(dataHeader);
            let str = "<a href='select'></a><div id='select'><form id='search'><input class='mb-2 mr-2' type='search' id='id_search' placeholder='Search'/><button class='btn btn-primary' type='submit'>Search</button></form><div id='check'></div><div id='submitcheck'></div>"
            document.getElementById('checkshow').innerHTML = str;
            $('#check').jstree({
                'core': {
                    'data': JSON.parse(dataHeader),
                    'themes': {
                        'name': 'proton',
                        "icons": false,
                        'responsive': true
                    },
                },
                "plugins": ["checkbox", "wholerow", "search"]
            });
            $("#check").jstree("check_all");
            $('#check').jstree("check_node", "#top_level_node_id");
            document.getElementById('submitcheck').innerHTML = "<button id='submit' class='btn btn-primary' type='submit'>Submit</button></div>";
            $('#submit').on("click", function () {
                var selectedElmsIds = $('#check').jstree("get_selected", true);
                console.log(selectedElmsIds);
                //instance.deselect_all();
                //instance.select_node('1');
            });
            $("#search").submit(function (e) {
                e.preventDefault();
                $("#check").jstree(true).search($("#id_search").val());
            });
        }
    }
}

class TreeView {
    constructor() {

        //this.strUrl = this.url;

        let arrData = [];
        let dataChild = [];

        let dataHeaderAll = [];
        let num = 0;
        let num2 = 0;
        //let num2 =1 ;
        //this.dataFromUrl;

        this.clearValue = () => {
            arrData = [];
            dataChild = [];
        }

        this.getDataHeaderAll = () => {
            return dataHeaderAll;
        }

        this.getDataFormUrl = () => {
            let dataTemp;
            $.ajax({
                url: "http://data.tmd.go.th/api/Weather3Hours/V1/?type=json",
                method: "GET",
                dataType: "json",
                async: false,
                success: function (data) {
                    //console.log("Get Json Com")                    
                    dataTemp = data;

                },
                error: function (data) {
                    console.log("Error Get Json");
                }
            })
            return dataTemp;

        }

        this.getHeaderFormData = (data) => {
            let dataTemp;
            arrData = [];
            if (typeof (data) !== 'object') {

            }
            else {
                let temp;
                Object.keys(data).forEach(function (key) {
                    if (Array.isArray(data[key])) {
                        temp = data[key][0];
                    }
                    else {
                        temp = data[key];
                    }

                    //num = num2;

                    getHeader(temp, key);
                    num2++;
                    arrData.push({ 'id': num2, 'text': key, 'children': dataChild });
                    dataHeaderAll.push({ 'id': num2, 'text': key });
                    dataChild = [];
                });
            }
            dataTemp = arrData;
            arrData = [];
            return dataTemp;
            //return dataHeaderAll;
        }

        let getHeader = (dataIn) => {

            let arrDataIn = [];
            if (typeof (dataIn) !== 'object') {

            }
            else {
                Object.keys(dataIn).forEach(function (key) {

                    if (typeof (dataIn[key]) === 'object') {
                        // 
                        // num2++;

                        getHeader(dataIn[key]);
                        num2++;
                        arrDataIn.push({ 'id': num2, 'text': key, 'children': dataChild });
                        dataHeaderAll.push({ 'id': num2, 'text': key });
                    }
                    else {
                        // 
                        // num2++;
                        num2++;
                        arrDataIn.push({ 'id': num2, 'text': key, 'children': null });
                        dataHeaderAll.push({ 'id': num2, 'text': key });
                        ///num++;
                    }
                });
                dataChild = arrDataIn;
                arrDataIn = [];
                return dataChild;
                //return arrDataIn;

            }

        }

    }
}

$(document).ready(function () {

    $(".show-header").click(function () {
        //console.log("kuy");
        let url = $("#url-webservice").val();
        //console.log(url);

        let service = new Service();
        service.initService();
    })

    // $(".show-header").click(function(){

    // })



})

