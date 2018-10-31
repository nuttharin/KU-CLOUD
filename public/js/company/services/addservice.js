class Service{
    constructor(){
        let dataFromUrl;
        let dataHeader ;
        let str ="";
        let check = false;
        let par ;

        this.initService = (url) =>{
            console.log("init service")
            let treeView = new TreeView();
            treeView.clearValue();
            dataFromUrl = treeView.getDataFormUrl();
            dataHeader = treeView.getHeaderFormData(dataFromUrl);
            let x =[]
            x.push(dataHeader)
            //createList(dataHeader);
            
           

            //console.log(dataFromUrl);
            console.log(JSON.stringify(dataHeader))
            for(let i =0 ;i<dataHeader.length ;i++)
            {
                
                let re =(data,pa) =>{

                    console.log(data)
                    Object.keys(data).forEach(function(key){
                        if(data[key].child !== null)
                        {
                            if(check === true)
                            {  
                                    check = false;
                                    str = str + '</ul></li>';
                            }
                            
                            console.log("if "+data[key].header)
                            str = str + '<li>' + data[key].header+'<ul>' ;
                            check = true ;
                            
                            re(data[key].child,data[key].header )
                        }
                        else 
                        {
                            
                            console.log("else  "+data[key].header)
                            console.log("else  -- "+pa)

                            // console.log("else  -- "+pa)
                            if(pa === par)
                            {
                                str = str + '</ul><li>'+ data[key].header + '</li>';
                            }
                            else
                                str = str + '<li>'+ data[key].header + '</li>';
                            
                            //check = false;
                        }

                        
                    })
                    
                }
                if(dataHeader[i].child !== null)
                {
                    
                    console.log(dataHeader[i].header)
                    str = str + '<ul>' + dataHeader[i].header  ;
                    re(dataHeader[i].child,dataHeader[i].header);
                    str = str + '</ul>';
                }
                    
            }
        $('.treeView-list').html(str)
            console.log(str)    
        }

        let createList = (data) => {
            let temp ;
            //console.log(typeof(data[0]));
            //if()
            Object.keys(data).forEach(function(key){
                //console.log(data[key].header+"  "+typeof(data[key].child));

                if(data[key].child !== null ){
                   console.log(data[key].header);
                   createList(data[key].child);
                }
                else 
                {
                    console.log(data[key].header);
                    console.log(data);
                }
                console.log("-----------------")
                
            })
            str =str+"</h3>"

        }

        
    }

     

}

class TreeView{
    constructor()
    {
        
        //this.strUrl = this.url;
        
        let arrData = [] ;
        let dataChild = [];

        let dataHeaderAll = [];
        let num =0 ;
        let num2 =1 ;
        //let num2 =1 ;
        //this.dataFromUrl;

        this.clearValue = () => {
            arrData = [] ;
            dataChild = [] ;
        }

        this.getDataFormUrl = () =>{
            let dataTemp ;
            $.ajax({ 
                url: "http://data.tmd.go.th/api/Weather3Hours/V1/?type=json", 
                method: "GET", 
                dataType: "json",
                async : false,
                success: function (data) { 
                    //console.log("Get Json Com")                    
                    dataTemp = data ;
                       
                }, 
                error: function (data) { 
                    console.log("Error Get Json");
                } 
            })  
            return dataTemp ;

        }

        this.getHeaderFormData = (data) => {
            let dataTemp ;
            arrData = [] ;
            
           
            if( typeof(data) !== 'object')
            {

            }
            else {
                let temp ;
                Object.keys(data).forEach(function(key){
                    if(Array.isArray(data[key]))
                    {
                        temp  = data[key][0];
                    }
                    else {
                        temp = data[key];
                    }
                    dataHeaderAll.push({'id': num2,'data' :key , 'parent' : ''});
                    num = num2;
                    
                    getHeader(temp,key);  
                    arrData.push({ 'id': num2,'text' : key , 'children' : dataChild });
                    num2++;
                   

                    
                    dataChild = [];


                });
            }
            dataTemp = arrData ;
            arrData = [] ;
            return dataTemp ;
            //return dataHeaderAll;
        }      

        let getHeader = (dataIn,pa) =>{

            let arrDataIn = [] ;
            if(typeof(dataIn) !== 'object')
            {

            }
            else 
            {
                Object.keys(dataIn).forEach(function(key){

                    if(typeof(dataIn[key]) === 'object')
                    {
                        // dataHeaderAll.push({'id': num2, 'data' :key , 'parent' : num});
                        // num2++;
                        num2++;
                        getHeader(dataIn[key],key);
                        arrDataIn.push({  'id': num2 ,'text' : key , 'children' : dataChild });
                        
                       
                        

                    }
                    else {
                        // dataHeaderAll.push({'id': num2 ,'data' :key , 'parent' : num});
                        // num2++;
                        arrDataIn.push({ 'id': num2,'text' : key , 'children' : null });
                        num2++;
                        ///num++;

                    }
                    

                });
                dataChild = arrDataIn ;
                arrDataIn = [] ;
                return dataChild ;
                //return arrDataIn;

            }

        }

    }
    




    


}

$(document).ready(function(){

    $(".show-header").click(function(){
        //console.log("kuy");
        let url  = $("#url-webservice").val();
        //console.log(url);
        let service = new Service();
        service.initService();


    })

    $(".show-header").click(function(){
       

    })



})
