import {alert_message, w_location, regEx_checker, fetchPOST} from "../script.js";

class Password{
    
    password(){
        const form = document.getElementById('password_form')
        form.addEventListener('submit',async (ev) =>{
            ev.preventDefault();
            let password = form.querySelector('#password').value
            let c_password = form.querySelector('#c_password').value
            let checker = regEx_checker({'password':password})
            if(checker['password']){
                if(password==c_password){
                    let data = {
                        'password':password,
                        'c_password':c_password
                    }
                    let p = 'users'
                    let res = await fetchPOST(p,data)
                    if(res.error){
                        alert_message(res.error)
                    }
                    else if(res.message){
                        if(res.message=='ok'){
                            w_location('../../html/registration/message.html')
                        }
                    } 
                }
                else{
                    alert_message('password and confirm password are not the same')
                }
                
            }
            else{
                alert_message('password is not strong enough')
            }
        })
    }

}

const c = new Password();

if(document.querySelector('.register_')){
    c.password();
}
