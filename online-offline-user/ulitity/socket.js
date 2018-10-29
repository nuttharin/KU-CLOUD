'use strict';

const moment = require('moment');
const path = require('path');
const fs = require('fs');
const helper = require('./helper');
const jwt = require('jsonwebtoken');
require('dotenv/config');

class Socket {

    constructor(socket) {
        this.io = socket;
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
    }

    socketConfig() {
        this.io.use(async (socket, next) => {
            try {
                let token = socket.request._query['id'];
                const decoded = jwt.verify(token.replace(' ', ''), process.env.JWT_KEY);
                let userId = decoded.sub;
                let userSocketId = socket.id;
                const response = await helper.addUserOnline(userId, userSocketId);
                if (response && response !== null) {
                    next();
                } else {
                    console.error(`Socket connection failed, for  user Id ${userId}.`);
                }
            }
            catch{
                next();
            }

        });
        this.socketEvents();
    }
}
module.exports = Socket;
