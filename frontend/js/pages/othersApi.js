import { fetchGET } from "../script.js"
import {copy_link,ask} from "./link.js"


window.onload = async () => {
   
   
    setSession();
    
    loadMore();
    let load = sessionStorage.getItem('loadMore') || false;
    let type = sessionStorage.getItem('type') || false;
    let data = {
        'others_api':true,
        'Oprofile': false,
        'Oreload': true,
        'loadApis': load,
        'type': type
    }

    let res = await fetchGET(data);
    if(res.message){
        let m = res.message;
        
       

        status_()
        drawApi(m['api_info'],sessionStorage.getItem('type'));

        if(m['user_info']['email']){
            saveInfo(m['user_info']);
        }

    }
    
}

window.addEventListener('scroll', ()=> {
    sessionStorage.setItem('scrollY',window.scrollY)
})

window.addEventListener('load', function() {
    setTimeout(() => {
        const root = document.scrollingElement || document.documentElement
        root.scrollTo({
            top: sessionStorage.getItem('scrollY') || 0,
            behavior: 'smooth'
        })
    }, 500);
})

function setSession () {
    if(!sessionStorage.getItem('loadMore')){
        sessionStorage.setItem('loadMore',5)
    }else{
        const root = document.scrollingElement || document.documentElement || document.body;
        root.scrollTo(0, root.scrollHeight);


    }
    if(sessionStorage.getItem('type')){
        if(!sessionStorage.getItem('type')){
            sessionStorage.setItem('type',1)
        }
    }
    else{
        sessionStorage.setItem('type',1)
    }
}

function loadMore(){
    let loadCount = parseInt(sessionStorage.getItem('loadMore'))
    let btn =  document.getElementById('loadMore')
    btn.addEventListener('click',function(){
        sessionStorage.setItem('loadMore',loadCount+5)
        location.reload()
    })
}

function status_(){
    let btns = document.querySelectorAll('.status_')
    btns.forEach(element => {
        element.classList.remove('status_active')
        if(element.getAttribute('data-status')==sessionStorage.getItem('type')){
            element.classList.add('status_active')
        }
        element.addEventListener('click',function(){
            sessionStorage.setItem('type',element.getAttribute('data-status'))
            
            location.reload()
        })
        
    });
}
export function saveInfo(data){
    sessionStorage.setItem('id',data['id'])
    sessionStorage.setItem('email',data['email'])
    sessionStorage.setItem('username',data['username'])
}

export function drawApi(data,status){
    let str = '';
    if(data.length!==0){
        data.forEach(element => {
            
            if(status==element['public'] || status==2 || status==3){

                if(element['public']==1){
                    str+= `
                    <div data-id='${element['id']}' class="api_ public d-flex justify-content-between align-items-center flex-column">`
                }
                else{
                    str+= `
                    <div data-id='${element['id']}' class="api_ private d-flex justify-content-between align-items-center flex-column">`
                }
            
                str+=`<h4>
                    ${element['api_name']}
                    </h4>`
                    str+=`
                
                        <span class="w-100 text-start">
                            <i>Type: ${element['type']}</i>
                        </span>
                        <div class="btn-box w-100 d-flex justify-content-between">
                            `
                            if(element['public']==1){
                            str+=`  <button class='links_btn' style="background-color:
                                    rgb(51, 92, 129); border-color: rgb(51, 92, 129);"
                                     data-name=${element['api_name']}>
                                        Copy link <i class="fa-solid fa-paperclip"></i>
                                    </button>`
                            }
                            else{
                                if(element['allow']){
                                    str+=`  <button class='links_btn' style="background-color:
                                    rgb(93,161,234); border-color: rgb(93,161,234);"
                                     data-name=${element['api_name']}>
                                        Copy link <i class="fa-solid fa-paperclip"></i>
                                    </button>`
                                }
                                else{
                                    str+=`<button class='permission_btn'
                                    data-id=${element['id']}>
                                               Ask Permission
                                           </button>`
                                }
                               
                            }
                             str+=`
                             <a href="/create_api/backend/requests/view.php?apiView=${encodeURIComponent(true)}&name=${encodeURIComponent(element['api_name'])}&type=${encodeURIComponent(element['type'])}" 
                                    target="blank">
                                        <button type="submit" class='view_btn'>
                                            <i class="fa-regular fa-eye"></i>
                                            View
                                            
                                        </button>
                                    </a>
                             </div>
                             `          
                        str+=`
                           
                                <div class="btn-box w-100 d-flex justify-content-between flex-wrap gap-3">
                                    <i class='d-flex align-items-center gap-2'>  
                                        <b>Creator:  </b>
                                        <h5 class='m-0'>  ${element['username']}</h5>
                                    </i>
                                    <span>
                                        <i>${element['date']}</i>
                                    </span>
                                </div>
                            `
                str+= ` </div>`

            }
               
        });
    }
    
    else{
        str+=`
        <h4>404</h4>`
    }
    
    if(status!==3){
        document.getElementById('api_box').innerHTML = str
    }
    else{
        document.querySelector('.search_res_box').innerHTML = str
    }
    
    
    copy_link();
    ask()
   
}


