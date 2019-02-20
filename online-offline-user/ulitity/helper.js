'user strict';

const DB = require('./db');
const path = require('path');
const fs = require('fs');

class Helper {

	constructor(app) {
		this.db = DB;
	}

	async selectUserInService(webservice_id){
		try {
			let customer =  await this.db.query(`SELECT DISTINCT TB_USERS.socketId FROM TB_STATIC_DATASOURCE
										INNER JOIN TB_STATIC ON TB_STATIC.static_id = TB_STATIC_DATASOURCE.static_id
										INNER JOIN TB_USERS ON TB_USERS.user_id = TB_STATIC.user_id
										WHERE TB_STATIC_DATASOURCE.webservice_id = ? AND TB_USERS.socketId IS NOT NULL AND TB_USERS.type_user = ?`, [webservice_id,'CUSTOMER']);
			let company = await this.db.query(`SELECT DISTINCT TB_USERS.socketId FROM TB_WEBSERVICE
										INNER JOIN TB_COMPANY ON TB_COMPANY.company_id = TB_WEBSERVICE.company_id
										INNER JOIN TB_USER_COMPANY ON TB_USER_COMPANY.company_id = TB_WEBSERVICE.company_id
										INNER JOIN TB_USERS ON TB_USERS.user_id = TB_USER_COMPANY.user_id
										WHERE TB_WEBSERVICE.webservice_id = ? AND TB_USERS.socketId IS NOT NULL AND  (TB_USERS.type_user = ? || TB_USERS.type_user = ?)`, [webservice_id,'ADMIN','COMPANY']);
			return {
				user :{
					customer : customer,
					company : company
				}
			}
				
		} catch (error) {
			console.log(error);
			return null;
		}
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
