'use strict';

const bcrypt = require('bcrypt');
const crypto = require('crypto');
const moment = require('moment');
const path = require('path');
const fs = require('fs');
const helper = require('./helper');
const jwt = require('jsonwebtoken');
const tokenSocket = require('./Token');
require('dotenv/config');

class Socket {

    constructor(socket) {
        this.io = socket;
        this.userInDashboard = [];
        this.userInDashboardPublic = [];
    }

    socketEvents() {
        this.io.on('connection', (socket) => {
            /**
             * get the user's Chat list
             */
            socket.on('UserList', async (userId) => {
                const result = await helper.selectUser();
                this.io.to(socket.id).emit('UserListRes', {
                    data: result,
                });
            });

            socket.on('chatList', async (userId) => {
                const result = await helper.getChatList(userId);
                this.io.to(socket.id).emit('chatListRes', {
                    userConnected: false,
                    chatList: result.chatlist
                });

                socket.broadcast.emit('chatListRes', {
                    userConnected: true,
                    userId: userId,
                    socket_id: socket.id
                });
            });

            socket.on('disconnect', async () => {
                const isLoggedOut = await helper.logoutUser(socket.id);
                socket.broadcast.emit('chatListRes', {
                    userDisconnected: true,
                    socket_id: socket.id
                });
            });
        });

        this.io
            .of('dashboards')
            .on('connection', (socket) => {

                socket.on('update-datasources', async (datasources) => {

                    let index = this.userInDashboard.findIndex(_user => {
                        return _user.socket_id == socket.id;
                    })
                    this.userInDashboard[index].datasources = datasources;
                    console.log(this.userInDashboard[index]);
                });

                socket.on('disconnect', () => {
                    let index = this.userInDashboard.findIndex(_user => {
                        return _user.socket_id == socket.id;
                    })
                    this.userInDashboard.splice(index, 1);
                });
            });

        this.io
            .of('dashboardsPublic')
            .on('connection', (socket) => {


                this.userInDashboardPublic.push({
                    socket_id: socket.id,
                });


                socket.on('update-datasources', async (datasources) => {
                    let index = this.userInDashboardPublic.findIndex(_user => {
                        return _user.socket_id == socket.id;
                    })

                    this.userInDashboardPublic[index].datasources = datasources;
                    console.log(this.userInDashboardPublic[index]);
                });

                socket.on('disconnect', () => {
                    let index = this.userInDashboardPublic.findIndex(_user => {
                        return _user.socket_id == socket.id;
                    })
                    this.userInDashboardPublic.splice(index, 1);
                    console.log(this.userInDashboardPublic);
                });
            });

    }

    socketConfig() {

        this.io.set('transports', ['websocket']);
        this.io.use(async (socket, next) => {
            try {
                console.log(typeof (socket.request._query['id']))
                if (typeof (socket.request._query['id']) != 'undefined') {
                    let token = socket.request._query['id'];
                    let check = await tokenSocket.verify(token);

                    if (check) {
                        //socket.user_id = payload.user_id;
                        let userSocketId = socket.id;
                        let payload = tokenSocket.getPayload(token);
                        const response = await helper.addUserOnline(payload.user_id, userSocketId);
                        
                        if (response && response !== null) {
                            next();
                        } else {
                            console.error(`Socket connection failed, for  user Id ${userId}.`);
                        }
                    } else {
                        console.log(false);
                    }



                    // const decoded = jwt.verify(token.replace(' ', ''), process.env.JWT_KEY);
                    // let userId = decoded.sub;
                    // let userSocketId = socket.id;
                    // const response = await helper.addUserOnline(userId, userSocketId);
                    // if (response && response !== null) {
                    //     next();
                    // } else {
                    //     console.error(`Socket connection failed, for  user Id ${userId}.`);
                    // }
                } 
                else{
                    next();
                }
            } catch (e) {
                console.log(e);
                //next();
            }
        });


        this.io.of('dashboards').use(async (socket, next) => {
            try {
                let token = socket.request._query['id'];
                let check = await tokenSocket.verify(token);

                if (check) {
                    //socket.user_id = payload.user_id;
                    //let userSocketId = socket.id;
                    let payload = tokenSocket.getPayload(token);
                    this.userInDashboard.push({
                        user_id: payload.user_id,
                        socket_id: socket.id,
                    });
                    next();

                } else {
                    console.log(false);
                }


                // const decoded = jwt.verify(token.replace(' ', ''), process.env.JWT_KEY);
                // let userId = decoded.sub;
                // let userSocketId = socket.id;
                // const response = await helper.addUserOnline(userId, userSocketId);
                // if (response && response !== null) {
                //     next();
                // } else {
                //     console.error(`Socket connection failed, for  user Id ${userId}.`);
                // }
            } catch (e) {
                console.log(e);
                //next();
            }
        });

        this.socketEvents();
    }
}
module.exports = Socket;
