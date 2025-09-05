import {alert_message, w_location, regEx_checker, fetchPOST} from "../script.js";

class Registration{
    
    signup(){
        const form = document.getElementById('signup_form')
        form.addEventListener('submit',async (ev) =>{
            ev.preventDefault();
            let username = form.querySelector('#username').value
            let email = form.querySelector('#email').value
            let checker=  regEx_checker({'username':username,'email':email})
            if(!checker['username'] || !checker['email']){
                alert_message('invalid field')
            }
            else if(checker['username'] && checker['email']){
                let data = {
                    'signup1':true,
                    'username':username,
                    'email':email
                }

                let res = await fetchPOST(data)
                if(res.error){
                    alert_message(res.error)
                }
                else if(res.message){
                    if(res.message=='ok'){
                        w_location('../../html/registration/verification.html')
                    }
                } 
            }
            else{
                alert_message('invalid field')
            }
        })
    }
    
}

const c = new Registration();

if(document.querySelector('.register')){
    c.signup();
}

