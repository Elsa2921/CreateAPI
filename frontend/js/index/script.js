import { fetchGET, fetchPOST,regEx_checker } from "../script.js"

if(document.querySelector('.bars-btn')){
    btn()
}
function btn(){
    let btns = document.querySelectorAll('.bars-open-close')
    let bar = document.querySelector('.slide-menu')
    btns.forEach((btn)=>{
        btn.addEventListener('click',function(){
            let atr=  btn.getAttribute('data-close')
            if(atr=='1'){
                bar.style.position = 'absolute'          
                bar.style.left = '-400px'
            }
            else{
                bar.style.left = '0'
                bar.style.position =  'fixed'
            }
        })
    })
    
}


if(document.querySelector('.menu_')){
    slide_p()
}


function slide_p(){
    let btn  = document.querySelector('.menu-user')
    let c = 0;
    btn.addEventListener('click',function(){
        const slide = document.querySelector('.profile-slide')
        c++;
        if(c%2==1){
            slide.style.top = '60px'
        }
        else{
            slide.style.top = '-260px'
        }
    })
}



window.onload = async() => {
    let data = {"PageReload" : true}
    let res = await fetchGET(data);
    
    if(document.querySelector('.menu_')){
        draw(res);
    }
    else{
        if(res.message){
            if(res.message=='no'){
                window.location.href  = '../../../index.html'
            }
            else{
                
                user_info(res.message);
            }
        }
    }
}



if(document.getElementById('create_my_api')){
    inAccChecker();
    contactUs()
    
}


if(sessionStorage.getItem('view')){
    sessionStorage.removeItem('view')
}


function inAccChecker(){
    let btn  = document.getElementById('create_my_api');
    btn.addEventListener('click', async function(){
        let data = {"PageReload" : true}
        let res = await fetchGET(data);
        if(res.message){
            let m  = res.message;
            if(m['email']){
                window.location.href = 'frontend/html/pages/ApiName.html'
            }
            else{
                alert('Sign in please!!')
            }
        }
        else{
            alert('Sign in please!!')
        }
    })
}



function contactUs(){
    let form = document.getElementById('contact-form')
    form.addEventListener('submit',async function(ev){
        ev.preventDefault()
        if(sessionStorage.getItem('email')){
            
            let email = document.getElementById('contact-email').value
            let message = document.getElementById('contact-textarea').value;


            let reg  = {
                'email':email
            }
            
            
            let checker = regEx_checker(reg)
            if(!checker['email']){
                alert('invalid email')
            }
            if(message.trim()==''){
                alert('empty message');
            }   
           

            if(checker['email'] && message.trim()!==''){
                let data = {
                    'email':email,
                    'message':message,
                    'messageToDev': true,
                };

                let res = await fetchPOST(data);
                if(res.error){
                    alert(res.error)
                }
                else{
                    if(res.message=='ok'){
                        alert('message sent!')
                        location.reload()
                    }
                }
                
            }

        }
        else{
            alert('Sign in please!')
        }
    })
}

function draw(data){
    if(data.message){
        let div = document.querySelector('.menu_')
        let btn = document.querySelector('.menu-btn')
        if(data.message == 'no'){
            div.style.display = 'none'
            btn.style.display = 'block'
            
        }
        else{
            btn.style.display = 'none'
            div.style.display = 'block'
            user_info(data.message);
        }
    }
    
}


function user_info(data){
    sessionStorage.setItem('id',data['id'])
    sessionStorage.setItem('email',data['email'])
    sessionStorage.setItem('username',data['username'])
    if(document.getElementById('username')){
        document.getElementById('username').innerHTML = data['username']
    }
    
}


