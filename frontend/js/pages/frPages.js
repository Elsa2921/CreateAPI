import {fetchGET} from "../script.js";
window.onload = async() => {
    let data = {"PageReload" : true}
    let res = await fetchGET(data);

    if(res.message){
        if(res.message=='no'){
            window.location.href  = '../../../index.html'
        }
        else{
            let data = res.message
            sessionStorage.setItem('id',data['id'])
            sessionStorage.setItem('email',data['email'])
            sessionStorage.setItem('username',data['username'])
        }
    }
    
}