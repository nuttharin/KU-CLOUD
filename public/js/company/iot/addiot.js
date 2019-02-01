class iotService {
    constructor()
    {
        let Nameiot ;
        let keyiot;
        let Alias;
        let Description;
        let time ;
        let companyID;

        this.getDataforInsert = () => {
            // get id company
            $.ajax({
                url: "http://localhost:8000/api/company/webservice/getCompanyID",
                dataType: 'json',
                method: "GET",
                async: false,
                success: (res) => {
                    companyID = res.companyID ;
                },
                error: (res) => {                
                    console.log(res);
                }
            });

            // create token
            $.ajax({
                url: "http://localhost:8081/iotService/getKeyiot",
                dataType: 'json',
                method: "POST",
                async: false,
                headers: {"Authorization": getCookie('token')},
                data:
                {                
                    companyID : companyID                    
                },
                success: (res) => { 
                    keyiot = res.key
                    //console.log(res);                        
                },
                error: (res) => {
                    console.log(res);
                }
            });


        }

        this.increaseDataTableDB = () => {
            //console.log('cccccc')    
        }

        this.showDetail = () => {
            $('#Nameiot').val('xxxx');
            $('#Apiiot').val('http://localhost:8081/iotService/insertData');
            $('#Keyiot').val(keyiot);
        }
    

    }
    
    
    
}

$(document).ready(function () {
    //var clipboard = new ClipboardJS('#Keyiot');

    $('#showvalue').click(function(){
        let iot = new iotService();
        iot.getDataforInsert();
        iot.showDetail();
        //iot.increaseDataTableDB();
        // let keyiot ;
        // $.ajax({
        //     url: "http://localhost:8000/api/company/iot/getkeyiot",
        //     dataType: 'json',
        //     method: "GET",
        //     async: false,
        //     success: (res) => {
            
        //         console.log(res.key) ;
        //         keyiot = res.key ;

        //     },
        //     error: (res) => {
                
        //         console.log(res);
        //     }
        // });
        // $('#Nameiot').val('xxxx');
        // $('#Apiiot').val('xxxx');
        // $('#Keyiot').val('dsdsdsd');

    })
})



