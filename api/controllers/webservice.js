const MongoClient = require('mongodb').MongoClient
const url = "mongodb://localhost:27017/test"
exports.products_get_all = (req, res, next) =>{
    MongoClient.connect(url,function(err,db){
        db.collection("test")
        .find({})
        .toArray(function(err ,result)
        {
            if(err) throw err ;
            /*const output =
            {
                status:"OK",
                message  : result
            }*/
            res.json({
                message : result
            });
            console.log(result);
            //res.json(output);
             db.close();
        });
    });
};
exports.products_add = (req, res, next) =>{
    var temp ;
    axios.get('http://data.tmd.go.th/api/Weather3Hours/V1/?type=json' , { responseType: 'json' })
    .then(response => {
        /*temp = JSON.parse(response.data);*/
        //temp = JSON.stringify(response);
        temp = response.data ;
        //console.log(temp.data.t);
        //console.log(temp.Stations[0]);
        data = temp.Stations ; 
        console.log(data.length);
        MongoClient.connect(url,function (err , db){
            for(var i = 0 ;i <data.length ; i++)
            {
                db.collection('test').insertOne(data[i],(err ,result)=>{
                    if(err) throw err ;
                });
            }
        db.close    
        });
      })
    .catch(error => {
        console.log(error);
      });
    res.end("complete1");
};
exports.products_find_id = (req, res, next) =>{
    var id = req.params.id;
    MongoClient.connect(url,function (err , db){        
        db.collection('test').findOne({WmoNumber:id}, function(err, docs) {
            res.json(docs);
    });
        /*res.status(200).json({
            message : 'Get Product /:Id = '+id
        });*/   
    db.close    
    });
};
exports.products_find_columns = (req, res, next) =>{
    var name = {
        name: req.body.name
    };
    var query={};
    var x="";
    var i;
    for(i=0 ;i<name.name.length;i++)
        { 
                x=name.name[i];
                query[x] = 1;
        }
    console.log(query);
    MongoClient.connect(url,function (err , db){
        db.collection('test').find({}, query).toArray(function(err, docs) {
            res.json(docs);
        });
        /*res.status(200).json({
            message : 'Get Column /: = '+id
        });*/
    db.close    
    });
};
exports.products_find_rows = (req, res, next) =>{
    var name = {
        name: req.body.name
    };
    //console.log(name.name[1]);
    var data ;
    var query =[];
    for(var i=0 ;i<name.name.length;i++)
    {
        data = name.name[i];
        query.push(data);
    }
    //console.log(query);
    MongoClient.connect(url ,function (err , db){
        db.collection('test').find({Province :{ $in : query} }).toArray(function(err, docs) {
            res.json(docs);
        });
    });
};