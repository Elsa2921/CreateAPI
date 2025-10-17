import { checker } from "./apiTypes.js";
import { fetchPOST } from "../script.js";
if(document.getElementById('selectApi_form')){
    select();
}


if(sessionStorage.getItem('continue')){
    document.getElementById('back').href = '/frontend/html/profile/profile.html'
}



function select(){
    const form = document.getElementById('selectApi_form')
    form.addEventListener('submit', async function(ev){
        ev.preventDefault();
        let radio = form.querySelector('input[name="api"]:checked')
        if(radio){
            let p = `api/${radio.value}`
            let data = {
                'apiType':true
            }

            let res = await fetchPOST(p,data);
            if(res.error){
                alert(res.error)
            }
            else if(res.message){
                let m  = res.message
                if(m=='ok'){
                    window.location.href = '../../html/pages/table.html';
                }
            }
        }
        else{
            alert('select from below')
        }
             
    })
}
// let c  = checker('notifications');