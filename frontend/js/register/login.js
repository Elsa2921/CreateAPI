import {alert_message, w_location, fetchPOST} from "../script.js";

class Login{
    
    signin(){
        const form = document.getElementById('signin_form')
        form.addEventListener('submit',async (ev) =>{
            ev.preventDefault();
            let email = form.querySelector('#email').value
            let password = form.querySelector('#password').value
            let rememberMe = form.querySelector('#remember-me').checked
            if(email.trim()!=='' && password.trim()!==''){
                let p = 'users'
                let data = {
                    'login':true,
                    'email':email,
                    'password':password,
                    'rememberMe':rememberMe
                }
                let res =await fetchPOST(p,data)
                if(res.error){
                    alert_message(res.error)
                }
                else if(res.message){
                    if(res.message=='ok'){
                        w_location('../../../index.html')
                    }
                    else if(res.message=='no'){
                        alert_message('registration is incomlete')
                        w_location('../../html/registration/email.html');
                    }
                } 
            }
            else{
                alert_message('empty field')
            }
        })
    }

}

const c = new Login();

if(document.querySelector('.login_')){
    c.signin();
}

