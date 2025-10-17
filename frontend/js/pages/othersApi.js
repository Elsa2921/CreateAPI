import { fetchGET } from "../script.js"
import {copy_link,ask} from "./link.js"


window.onload = async () => {
   
   
    setSession();
    
    loadMore();
    let load = sessionStorage.getItem('loadMore') || false;
    let type = sessionStorage.getItem('type') || false;
    let p = 'api'
    let data = {
        'Oprofile': false,
        'loadApis': load,
        'type': type
    }

    let res = await fetchGET(p,data);
    if(res.message){
        let m = res.message;
        
       

        status_()
        drawApi(m['api_info'],sessionStorage.getItem('type'));
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
            
                str+=`<h5 class="lightBlue-color">
                    ${element['api_name']}
                    </h5>`
                    str+=`
                
                        <span class="w-100 text-start">
                            <i>Type: ${element['type']}</i>
                        </span>
                        <div class="w-100 d-flex justify-content-between">
                            `
                            if(element['public']==1){
                            str+=`  <button class='links_btn middleBlue-btn'
                                     data-name=${element['api_name']}>
                                        Copy link <i class="fa-solid fa-paperclip"></i>
                                    </button>`
                            }
                            else{
                                if(element['allow']){
                                    str+=`  <button class='links_btn lightBlue-btn'
                                     data-name=${element['api_name']}>
                                        Copy link <i class="fa-solid fa-paperclip"></i>
                                    </button>`
                                }
                                else{
                                    str+=`<button class='permission_btn pink-btn'
                                    data-id=${element['id']}>
                                        Ask Permission
                                    </button>`
                                }
                               
                            }
                             str+=`
                             <a href="/create_api/backend/index.php/view/${element['id']}" 
                                    target="blank">
                                        <button type="submit" class='view_btn yellow-btn'>
                                            <i class="fa-regular fa-eye"></i>
                                            View
                                            
                                        </button>
                                    </a>
                             </div>
                             `          
                        str+=`
                           
                                <div class=" w-100 d-flex justify-content-between flex-wrap gap-3">
                                    <i class='d-flex align-items-center gap-2'>  
                                        <b>Creator:  </b>
                                        <h6 class='m-0 middleBlue-color'>  ${element['username']}</h6>
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
        <h5>404</h5>`
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


