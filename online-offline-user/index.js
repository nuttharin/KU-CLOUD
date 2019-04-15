'use strict';

const express = require('express');
const http = require('http');
const socketio = require('socket.io');
const socketEvents = require('./ulitity/socket');
const helper = require('./ulitity/helper');
const bodyParser = require('body-parser');

class Server {
    constructor() {
        this.port = process.env.PORT || 3000;
        this.host = process.env.HOST || `localhost`;

        this.app = express();
        this.http = http.Server(this.app);
        this.socket = socketio(this.http);
    }

    appRun() {

        this.socketEvents = new socketEvents(this.socket);
        this.socketEvents.socketConfig();
        this.app.use(express.static(__dirname + '/uploads'));

        this.app.use(bodyParser.urlencoded({
            extended: false
        }));

        this.app.use(bodyParser({
            limit: '50mb'
        }));

        this.app.use(bodyParser.json());

        this.app.use((req, res, next) => {
            res.header('Access-Control-Allow-Origin', '*');
            res.header('Access-Control-Allow-Headers', 'Orgin, X-Requested-With, Content-Type, Accept,Authorization');
            if (req.method === 'OPTIONS') {
                res.header('Access-Control-Allow-Methods', 'PUT,POST,PATCH,DELETE,GET');
                return res.status(200).json({});
            }
            next();
        })



        this.app.use((req, res, next) => {
            res.io = this.socket;
            res.socketEvents = this.socketEvents;
            res.userInDashboards = this.socketEvents.userInDashboard;
            res.userInDashboardPublic = this.socketEvents.userInDashboardPublic;
            //console.log(this.socketEvents.userInDashborad);
            // res.io = this.socket.io;
            next();
        });


        this.http.listen(this.port, () => {
            console.log(`Listening on http://${this.host}:${this.port}`);
        });

        this.app.post('/socket/alert', (req, res) => {
            // console.log('private', res.userInDashboards);
            // console.log('public', res.userInDashboardPublic);
            // console.log(req.body);
            
            res.userInDashboards.map(_user => {
                _user.datasources.web_services.map(_web => {
                    if (_web == req.body.service_id) {
                        res.io.of('dashboards').to(_user.socket_id).emit("broadcast", {
                            service_id: req.body.service_id,
                            type: req.body.type,
                            data: req.body.data,
                        });
                        // res.io.of('dashboardsPublic').to(_user.socket_id).emit("broadcast", {
                        //     service_id: req.body.service_id,
                        //     type: req.body.type,
                        //     data: req.body.data,
                        // });
                    }
                });

                _user.datasources.iot_services.map(_iot => {
                    if (_iot == req.body.service_id) {
                        res.io.of('dashboards').to(_user.socket_id).emit("broadcast", {
                            service_id: req.body.service_id,
                            type: req.body.type,
                            data: req.body.data,
                        });
                    }
                    // res.io.of('dashboardsPublic').to(_user.socket_id).emit("broadcast", {
                    //     service_id: req.body.service_id,
                    //     type: req.body.type,
                    //     data: req.body.data,
                    // });
                });

            })



            res.userInDashboardPublic.map(_user => {
                _user.datasources.web_services.map(_web => {
                    if (_web == req.body.service_id) {
                        res.io.of('dashboardsPublic').to(_user.socket_id).emit("broadcast", {
                            service_id: req.body.service_id,
                            type: req.body.type,
                            data: req.body.data,
                        });
                    }
                });

                _user.datasources.iot_services.map(_iot => {
                    if (_iot == req.body.service_id) {
                        res.io.of('dashboardsPublic').to(_user.socket_id).emit("broadcast", {
                            service_id: req.body.service_id,
                            type: req.body.type,
                            data: req.body.data,
                        });
                    }
                   
                });


                // _user.datasources.iot_services.map(_iot => {

                // });

            })


            res.status(201).json({
                test: 'hi'
            });
        })


        // this.app.route('/api/alert').post( async(req,res) =>{
        //     console.log('api',res.userInDashboards);
        //     res.userInDashboards.map(_user => {
        //         _user.datasources.web_services.map(_web => {
        //             if(_web ==  req.body.service_id){
        //                 res.io.of('dashboards').to(_user.socket_id).emit("broadcast", 
        //                 {
        //                     service_id : req.body.service_id,
        //                     type : req.body.type,
        //                     data : req.body.data,
        //                 });
        //             }
        //         });

        //         // _user.datasources.iot_services.map(_iot => {

        //         // });

        //     })
        //     res.status(201).json({test:'hi'});
        // })
    }
}

const app = new Server();
app.appRun();
