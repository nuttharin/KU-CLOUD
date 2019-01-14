import axios from 'axios';

const END_POINT = 'http://localhost:8000/api/';

const API = {
    getAccount: 'account',
    changePrimaryEmail: 'account/email',
    addEmail: 'account/email',
    deleteEmail: 'account/email',
    changePrimaryPhone: 'account/phone',
    addPhone: 'account/phone'
};

export default class Account {
    async getAccount() {
        try {
            const res = await axios.get(`${END_POINT}${API.getAccount}`);
            this.result = res.data.data;
        } catch (error) {

        }
    }

    async addEmail(email) {
        try {
            await axios.post(`${END_POINT}${API.addEmail}`, {
                email: email
            });
        } catch (error) {

        }
    }

    async deleteEmail(email) {
        try {
            $.ajax({
                url: END_POINT + API.deleteEmail,
                method: 'DELETE',
                data: {
                    email: email
                }
            });
        } catch (error) {

        }
    }

    async addPhone(phone) {
        try {
            await axios.post(`${END_POINT}${API.addPhone}`, {
                phone: phone
            });
        } catch (error) {

        }
    }
};
