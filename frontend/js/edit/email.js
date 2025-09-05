import {alert_message, w_location, regEx_checker, fetchPUT} from "../script.js";


if(document.querySelector('#newEmail_form')){
    email();
}

function email(){
    const form = document.getElementById('newEmail_form')
    form.addEventListener('submit',async (ev) =>{
        ev.preventDefault();
        let email = form.querySelector('#email').value
        let checker=  regEx_checker({'email':email})
        if(checker['email']){
            let data = {
                'edit':true,
                'email':email
            }
            let res = await fetchPUT(data)
            if(res.error){
                alert_message(res.error)
            }
            else if(res.message){
                if(res.message=='ok'){
                    w_location('../../html/edit/verification.html')
                }
            } 
        }
        else{
            alert_message('invalid field')
        }
    })
}

