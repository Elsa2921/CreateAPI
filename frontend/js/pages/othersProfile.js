import { fetchGET } from "../script.js"
import {saveInfo,drawApi} from "./othersApi.js"


window.onload = async () => {
    let p  = 'api'
    let data = {
        'Oprofile': true,
        'loadApis':true,
        'type':''
    }

    let res = await fetchGET(p,data);
    if(res.message){
        let m = res.message;

        drawApi(m['api_info'],2);

        if(m['user_info']['email']){
            saveInfo(m['user_info']);
        }
        if(m['u']){
            document.getElementById('username').innerHTML = m['u']
        }

    }
    
}