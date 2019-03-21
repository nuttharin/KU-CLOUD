const helper = require('./helper');
const crypto = require('crypto');
class Token {
    constructor() {
       
    }

    async verify(token){
        try {
            let buf = Buffer.from(token, 'base64');
            let token_decode = buf.toString('ascii');

            let token_id = token_decode.split('.')[0];
            let payload = JSON.parse(token_decode.split('.')[1]);
            let signature = token_decode.split('.')[2];

            let userRef = await helper.selectUserId(payload.user_id);

            let signatureVerify = token_id + "." + token_decode.split('.')[1] + "." + userRef[0].password;

            let hash = crypto.createHmac('sha256', process.env.SOCKET_KEY);
            hash.update(signatureVerify);


            if (hash.digest('hex') === signature) {
                return true;
            } else {
                return false;
            }
        } catch (e) {
            console.log(e);
        }
    }

    getPayload(token){     
        let buf = Buffer.from(token, 'base64');
        let token_decode = buf.toString('ascii');
        let token_id = token_decode.split('.')[0];
        let payload = JSON.parse(token_decode.split('.')[1]);
        let signature =  token_decode.split('.')[2];
        return payload;
    }
}
module.exports = new Token();