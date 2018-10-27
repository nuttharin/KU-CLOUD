'user strict';

const DB = require('./db');
const path = require('path');
const fs = require('fs');

class Helper {

	constructor(app) {
		this.db = DB;
	}

	async addSocketId(userId, userSocketId) {
		try {
			return await this.db.query(`UPDATE users SET socket_id = ?, online= ? WHERE id = ?`, [userSocketId, 'Y', userId]);
		} catch (error) {
			console.log(error);
			return null;
		}
	}

	async selectUser() {
		return await this.db.query('SELECT user_id FROM TB_USERS where TB_USERS.online = ?', [true]);
	}

	async addUserOnline(userId, userSocketId) {
		try {
			return await this.db.query(`UPDATE TB_USERS SET online = ? ,socketId= ? WHERE user_id = ?`, [true, userSocketId, userId]);
		} catch (error) {
			console.log(error);
			return null;
		}
	}


	async logoutUser(userSocketId) {
		return await this.db.query(`UPDATE TB_USERS SET online = ? ,socketId = ? WHERE socketId = ?`, [false, null, userSocketId]);
	}

}
module.exports = new Helper();
