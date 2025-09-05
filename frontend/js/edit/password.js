import { fetchPUT } from "../script.js"

if(document.querySelector('#edit_password_form')){
    passwordChecker()
}


function passwordChecker(){
    const form = document.querySelector('#edit_password_form')
    form.addEventListener('submit',async function(ev){
        ev.preventDefault()
        let pass = form.querySelector("#password").value
        if(pass.trim()!==''){
            let data = {
                'edit':true,
                'password':pass
            }
            const res = await fetchPUT(data);
            if(res.message){
                let m  = res.message
                if(m== 'no'){
                    alert('password is wrong');
                }
                else if(m=='ok'){
                    window.location.href = '../../html/edit/newEmail.html'
                }
            }
        }
    })
}