import {fetchPOST} from "../script.js";
if(document.getElementById('apiName_form')){
    apiName()
}


function apiName(){
    const form  = document.getElementById('apiName_form')
    form.addEventListener('submit', async function(ev){
        ev.preventDefault();
        const name = form.querySelector('#apiName').value
        if(name.trim()!==''){
            let p = `api/${name}`
            let data = {
                'newApi':true
            }
            let res = await fetchPOST(p,data);
            if(res.error){
                alert(res.error)
            }
            else{
                if(res.message){
                    if(res.message=='ok'){
                        window.location.href = '../../html/pages/selectApi.html'
                    }
                    else if(res.message=='no'){
                        window.location.href= '../../../index.html';
                    }
                }
            }
        }
    })
}