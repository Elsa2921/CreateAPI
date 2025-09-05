import {alert_message, w_location, regEx_checker, fetchPOST} from "../script.js";

class Email{
    
    email(){
        const form = document.getElementById('email_form')
        form.addEventListener('submit',async (ev) =>{
            ev.preventDefault();
            let email = form.querySelector('#email').value
            let checker=  regEx_checker({'email':email})
            if(checker['email']){
                let data = {
                    'email1':true,
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

const c = new Email();

if(document.querySelector('.register_')){
    c.email();
}

