import {fetchDELETE} from "../script.js"

if(document.querySelector('.notif_x')){
    notif()
    user()
    logout()
}


if(sessionStorage.getItem('view')){
    sessionStorage.removeItem('view')
}

if(sessionStorage.getItem('continue')){
    sessionStorage.removeItem('continue')
}


window.addEventListener('resize', () =>{
    document.documentElement.scrollLeft = 0
})



function user(){
    let n=  document.querySelectorAll('.user_x')
    // let count=  0;
    let u=  document.querySelector('.gear-area')
    n.forEach((e)=>{
        e.addEventListener('click',function(){
            if(e.getAttribute('data-close')==0){
                u.style.right=  '20px';
            }
            else{
                u.style.right=  '-450px';
            }
        })
    })
}


function notif(){
    let n=  document.querySelectorAll('.notif_x')
    // let count=  0;
    let notif=  document.querySelector('.notif_area')
    n.forEach((e)=>{
        e.addEventListener('click',function(){
            if(e.getAttribute('data-close')==0){
                notif.style.right=  '20px';
            }
            else{
                notif.style.right=  '-450px';
            }
        })
    })
    
}

if(sessionStorage.getItem('username')){
    drawE();
}


function drawE(){
    let username= document.getElementById('username')
    let email = document.getElementById('email')


    let s_u=  sessionStorage.getItem('username')
    let e_u = sessionStorage.getItem('email')

    username.innerHTML = s_u
    email.innerHTML=  e_u
}


function logout(){
    document.getElementById('logout').addEventListener('click',async function(){
        sessionStorage.clear();

        await fetchDELETE('logout')
        location.reload();

    })
}