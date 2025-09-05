import { fetchPUT,regEx_checker } from "../script.js"

if(document.getElementById('username_form')){
    usernameForm()
}




function usernameForm(){
    const form= document.getElementById('username_form')
    form.addEventListener('submit', async function(ev) {
        ev.preventDefault()
        const username  = document.getElementById('username').value
    
        if(username.length!=='' && username.length>3 && username.trim()!==''){
            let data = {'username':username}
            const checker = regEx_checker(data)
            if(!checker['username']){
                alert('username can contain lowercase letters numbers and underline')
            }
            else{
                data = {
                    'edit':true,
                    'username':username
                }
                const res = await fetchPUT(data)
                if(res.message){
                    const m = res.message
                    if(m=='no'){
                        alert('username already exists')
                    }
                    else if(m=='ok'){
                        window.location.href='../../html/profile/profile.html'
                    }
                }
            }
        }
        
    })
    // 
}