class iotService {
    constructor(iotName,iotAlias,iotdescription,status,fields)
    {
        let nameiot = iotName  ;
        let keyiot;
        let alias = iotAlias;
        let description = iotdescription ;
        let stat = status;
        let time ;
        let companyID;
        let pinfilds = fields;
        

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
                url: "http://localhost:8000/api/company/iot/addOutputRegisIotService",
                dataType: 'json',
                method: "POST",
                async: false,
                data:
                {
                    strUrl: 'ss',
                    alias: alias,
                    ServiceName: nameiot,
                    description: description,
                    // header: '1',                   
                    valueCal: '1',
                    status: stat,
                    pinfilds : pinfilds,
                    type:"output"
                    
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

        this.increaseDataTableDB = () => {
            //console.log('cccccc')    
            //get company id
            $.ajax({
                url: "http://localhost:8000/api/company/webservice/getCompanyID",
                dataType: 'json',
                method: "GET",
                async: false,
                success: (res) => {
                    //console.log(res.companyID);
                    companyID = res.companyID ;

                },
                error: (res) => {
                    
                    console.log(res);
                }
            });
        }

        this.showDetail = () => {
            $('#Nameiot').val('xxxx');
            $('#Apiiot').val('http://localhost:8081/iotService/insertData');
            $('#Keyiot').val(keyiot);
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
    $('#showvalue').click(function(){
        
        let iotName = $('#name-iotservice').val();
        let iotAlias = $('#alias-iotservice').val();
        let iotdescription = $('#description-iotservice').val();
        let status = $('#status-iotservice').prop( "checked" );
        let inputs = document.getElementsByClassName("fields");
        let fields  = [].map.call(inputs, function( input ) {
            return input.value;
        }).join( ',' );
        //console.log(fields);

        if(status == true)
        {
            status="public";
            console.log('sssss')
        }
        else
        {
            status="private";
        }

       
        let iot = new iotService(iotName,iotAlias,iotdescription,status,fields);
        iot.getDataforInsert();
        iot.showDetail();
      

    })
    
   


})




