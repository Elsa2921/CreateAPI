import {alert_message, w_location, regEx_checker, fetchPOST} from "../script.js";

class Verification{
    
    verification(){
        const form = document.getElementById('verification_form')
        form.addEventListener('submit',async (ev) =>{
            ev.preventDefault();
            let code = form.querySelector('#verification').value
            let data = {
                'verification':true,
                'code':code,
                'type':form.getAttribute('data-type')
            }
            let res = await fetchPOST(data) 
            if(res.error){
                alert_message(res.error)
            }
            else if(res.message){
                if(res.message=='ok'){
                    if(form.getAttribute('data-type')=='1'){

                        w_location('../../html/registration/password.html')
                    }
                    else{
                        w_location('../../html/profile/profile.html')
                    }
                }
            } 
        })
    }



    newCode(){
        const btn= document.getElementById('new_code')
        btn.addEventListener('click', async ()=>{
            let data = {
                'new_code':true,
                'type':btn.getAttribute('data-type')
            }
            let res = await fetchPOST(data)
            if(res.error){
                alert_message(res.error)
            }
        })
    }

    


    
}

const c = new Verification();

if(document.querySelector('#verification_form')){
    c.verification();
    c.newCode()
}
