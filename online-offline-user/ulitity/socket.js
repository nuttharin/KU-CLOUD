'use strict';

const bcrypt = require('bcrypt');
const crypto = require('crypto');
const moment = require('moment');
const path = require('path');
const fs = require('fs');
const helper = require('./helper');
const jwt = require('jsonwebtoken');
require('dotenv/config');

class Socket {

    constructor(socket) {
        this.io = socket;
        this.userInDashborad = [];
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
                let index = this.userInDashborad.findIndex(_user => {
                    return _user.socket_id == socket.id;
                })

                this.userInDashborad[index].datasources = datasources;
                console.log(this.userInDashborad[index]);
            });
           
           
           socket.on('disconnect', () => {
                let index = this.userInDashborad.findIndex(_user => {
                    return _user.socket_id == socket.id;
                })
                this.userInDashborad.splice(index, 1);
            });
        });
    }

    socketConfig() {

        this.io.set('transports', ['websocket']);
        this.io.use(async (socket, next) => {
            try {
                let token = socket.request._query['id'];
                let buf = Buffer.from(token, 'base64');
                let token_decode = buf.toString('ascii');

          
                let token_id = token_decode.split('.')[0];
                let payload = JSON.parse(token_decode.split('.')[1]);
                let signature =  token_decode.split('.')[2];

                let userRef = await helper.selectUserId(payload.user_id);
              
                let signatureVerify = token_id+"."+token_decode.split('.')[1]+"."+userRef[0].password;

                let hash = crypto.createHmac('sha256', process.env.SOCKET_KEY);
                hash.update(signatureVerify);

               
                if(hash.digest('hex') === signature){
                    //socket.user_id = payload.user_id;
                    let userSocketId = socket.id;
                    const response = await helper.addUserOnline(payload.user_id, userSocketId);
                    if (response && response !== null) {
                        next();
                    } else {
                        console.error(`Socket connection failed, for  user Id ${userId}.`);
                    }
                }
                else{
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
            catch(e){
                console.log(e);
                next();
            }
        });


        this.io.of('dashboards').use(async (socket, next) => {
            try {
                let token = socket.request._query['id'];
                let buf = Buffer.from(token, 'base64');
                let token_decode = buf.toString('ascii');
              
          
                let token_id = token_decode.split('.')[0];
                let payload = JSON.parse(token_decode.split('.')[1]);
                let signature =  token_decode.split('.')[2];

                let userRef = await helper.selectUserId(payload.user_id);
              
                let signatureVerify = token_id+"."+token_decode.split('.')[1]+"."+userRef[0].password;

                let hash = crypto.createHmac('sha256', process.env.SOCKET_KEY);
                hash.update(signatureVerify);

               
                if(hash.digest('hex') === signature){
                    //socket.user_id = payload.user_id;
                    let userSocketId = socket.id;

                    this.userInDashborad.push({
                        user_id :payload.user_id,
                        socket_id : socket.id,
                    });
                    
                    next();
                    
                }
                else{
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
            catch(e){
                console.log(e);
                next();
            }
        });

        this.socketEvents();
    }
}
module.exports = Socket;


