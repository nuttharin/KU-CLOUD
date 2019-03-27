class iotService {
    constructor(iotName,iotAlias,iotdescription,status,OutputData,jsonencode)
    {
        let nameiot = iotName  ;
        let keyiot;
        let alias = iotAlias;
        let description = iotdescription ;
        let stats = status;
        let time ;
        let companyID;
        let showJsonstr = OutputData;
        let pinfilds = jsonencode;
        let strUrlInsert = ""

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

            //register DB
            $.ajax({
                url: "http://localhost:8000/api/iot/addOutputRegisIotService",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {
                    strUrl: 'ss',
                    alias: alias,
                    ServiceName: nameiot,
                    description: description,
                    valueCal: '1',
                    stats: stats,
                    pinfilds : pinfilds,
                    showJsonstr:showJsonstr,
                    type: 'output',
                    
                },
                success: (res) => {
                    // toastr["success"]("Success");
                    console.log("success DB")
                },
                error: (res) => {
                    console.log(res);
                }
            });


        }
        

        let increaseDataTableDWFristTime = () => {
            let nametable = 'IoT.Output.'+nameiot+'.'+companyID
            $.ajax({
                url: "http://localhost:8081/iotService/insertOutputIot",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {                    
                    nameDW: nametable,
                    strJson:jsonencode,
                },
                success: (res) => {
                    // toastr["success"]("Success");
                    swal("Success!", "You clicked the button!", "success");
                    console.log("success DW")
                },
                error: (res) => {
                    console.log(res);
                }
            });
        }

        this.showDetail = () => {
            $('#Nameiot').val(nameiot);
            $('#URLiot').val('http://localhost:8081/iotService/getOutputIot?keyIot='+keyiot+'&nameDW=IoT.Output.'+nameiot+'.'+companyID);
            // $('#Keyiot').val(keyiot);            
            $('#Dataformat').val(pinfilds);
            //strUrlInsert = 'http://localhost:8081/iotService/getOutputIot?keyIot='+keyiot+'&nameDW=IoT.Output.'+nameiot+'.'+companyID ;
            $('#ShowDetailiotModal').modal('show');
            $('#close-modal-show').click(function(){
                increaseDataTableDWFristTime();
                location.reload();
            })

        }  
    }       
}

class cronTap {
    constructor()
    {
        this.exampleCron = () => {
             // example cron
            $("#every_minute").click(function () {
                $("#minute_input").val("*");
                $("#hour_input").val("*");
                $("#description_time").html("At every minute.");
            })
            $("#every_30_minute").click(function () {
                $("#minute_input").val("*/30");
                $("#hour_input").val("*");
                $("#description_time").html("At every 30th minute.");

            })
            $("#every_3_hour").click(function () {
                $("#minute_input").val("0");
                $("#hour_input").val("*/3");
                $("#description_time").html("At minute 0 past every 3rd hour.");
            })
            $("#every_day").click(function () {
                $("#minute_input").val("0");
                $("#hour_input").val("0");
                $("#description_time").html("At 00:00.");
            })
            $("#every_day_at_1am").click(function () {
                $("#minute_input").val("0");
                $("#hour_input").val("1");
                $("#description_time").html("At 01:00.");
            })
            $("#between_certain_hours").click(function () {
                $("#minute_input").val("0");
                $("#hour_input").val("9-17");
                $("#description_time").html("At minute 0 past every hour from 9 through 17.");
            })
        }
        
 
    }       
}

class Validation{
    constructor(iotName,iotAlias,iotdescription,status,OutputData,jsonencode,fields,nameoutput,valueoutput)
    {
        
        this.validate = () =>{
            let chkData = true ;
            if(iotdescription == ""){
                iotdescription = "";
            }
            if(iotName == "" || iotAlias =="")
            {
                
                if(iotName == ""){
                    swal("คุณไม่ได้กรอก IoT Name  !", "", "error");
                }
                else if(iotAlias ==""){
                    console.log("ll" + iotAlias)
                    swal("คุณไม่ได้กรอก Alias  !", "", "error");
                }                
            }            
            if(iotName != "" || iotAlias !="")
            {
                chkData = true ;
                for(let i =0 ;i< nameoutput.length; i++)
                {
                    if(nameoutput[i] == "" || valueoutput[i] == "")
                    {
                        chkData = false ;
                        break ;
                    }                        

                }
               
                if(chkData) {
                    console.log(status)
                    // let iot = new iotService(iotName,iotAlias,iotdescription,status,fields);
                    // //iot.getDataforInsert();                    
                    // iot.showSelectValueCal();
                }
                else {
                    swal(" Others Output ไม่ถุกต้อง !", "", "error");
                }
            }
            console.log("ldddl" + iotAlias)
            if(chkData)
            {
                console.log("ll" + iotAlias)
                chkData = true ;
                for(let i =0 ;i<fields.length; i++)
                {
                    if(fields[i] == "")
                    {
                        chkData = false ;
                        break;
                    }                        

                }
               
                if(chkData) {
                    console.log(status)
                    let iot = new iotService(iotName,iotAlias,iotdescription,status,OutputData,jsonencode);
                    iot.getDataforInsert();
                    iot.showDetail();
                    
                }
                else {
                    swal("Pin Names ไม่ถุกต้อง !", "", "error");
                }
              
            }  

        }

    }
}


class Managememt{
    constructor()
    {
        this.checkFormTime = () => {
            $(".set-time").hide()
            $('#checktime-iotservice').change(function(){
                let checkUpTime = $('#checktime-iotservice').prop("checked");
                if(checkUpTime==true)
                {
                    $(".set-time").slideDown("fast");            
                }
                else 
                {
                    $(".set-time").hide()
                    $("#time-webservice-minute").val("")
                    $("#time-webservice-hour").val("")
                    //onsole.log('scvv')

                }
                
            })
        }
    }
}



$(document).ready(function () {
    //var clipboard = new ClipboardJS('#Keyiot');
    let cron = new cronTap();
    let manage = new Managememt();
    cron.exampleCron();
    manage.checkFormTime();

    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.controls form:first'),
        currentEntry = $(this).parents('.entry:first'),
        newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span>-</span>');
        }).on('click', '.btn-remove', function(e)
        {
            $(this).parents('.entry:first').remove();

            e.preventDefault();
            return false;
    });

    $(document).on('click', '.btn-adds', function(e)
    {
        e.preventDefault();

        var controlForm = $('.controlsoutput form:first'),
        currentEntry = $(this).parents('.entry:first'),
        newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-adds')
            .removeClass('btn-adds').addClass('btn-removes')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span>-</span>');
        }).on('click', '.btn-removes', function(e)
        {
            $(this).parents('.entry:first').remove();

            e.preventDefault();
            return false;
    });

    $('#showvalue').click(function(){
        
        let iotName = $('#name-iotservice').val();
        let iotAlias = $('#alias-iotservice').val();
        let iotdescription = $('#description-iotservice').val();
        let status = $('#status').val();
        let inputs = document.getElementsByClassName("fields");
        //pin
        let fields  = [].map.call(inputs, function( input ) {
            return input.value;
        });
        // orther output
        let nameout = document.getElementsByClassName("nameoutput");
        let valueout = document.getElementsByClassName("valueoutput");
        let valueoutput  = [].map.call(valueout, function( input ) {
            return input.value;
        });
        let nameoutput  = [].map.call(nameout, function( input ) {
            return input.value;
        });
        let otheroutput={};
        let dataOutput ={} ;
        let showJson={};
        //console.log(nameoutput)
        if(nameoutput == "" || nameoutput == null)
        {
        }
        else
        {
            for(let i=0;i<nameoutput.length;i++)
            {
                showJson[nameoutput[i]] = valueoutput[i];
                otheroutput[nameoutput[i]] = valueoutput[i];
            }
            dataOutput['other'] = otheroutput ;
            otheroutput = {}
            if(fields.length>0){
                for(let i=0;i<fields.length;i++)
                {
                    showJson[fields[i]] = 0;
                    otheroutput[fields[i]] = 0;
                    console.log(otheroutput)
                }
            }
            dataOutput['pin'] = otheroutput ;

        }
        //console.log(showJson)
        let OutputData = JSON.stringify(dataOutput, undefined, 2);
        let jsonencode = JSON.stringify(showJson, undefined, 2);
        //console.log(jsonencode);

       
        // console.log(fields)
        // console.log(valueoutput)
        // console.log(nameoutput)
        // console.log(OutputData)
        // console.log(jsonencode)
        
        let validate = new Validation(iotName,iotAlias,iotdescription,status,OutputData,jsonencode,fields,nameoutput,valueoutput);
        validate.validate();        
        // let iot = new iotService(iotName,iotAlias,iotdescription,status,OutputData,jsonencode);
        // iot.getDataforInsert();
        // iot.showDetail();
      

    })
    
   


})




