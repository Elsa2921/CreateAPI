import { fetchGET,fetchDELETE, fetchPUT, fetchPOST} from "../script.js"
import {copy_link} from "../pages/link.js"


window.onload = async() => {
    let p = 'profile'
    let res = await fetchGET(p);
    if(document.querySelector('.menu_')){
        draw(res);
    }
    else{
        if(res.message){
            if(res.message=='no'){
                window.location.href  = '../../../index.html'
            }
            else{
                let data = res.message;
                user_info(data['user_info']);
                drawApi(data['api_data']);
                drawNotif(data['notif']);
            }
        }
    }
}



function drawNotif(data){
    let str = ''
    if(data.length!==0){
        notif_count(data.length)
        data.forEach(element => {
            str+= `
                <div class="notif py-3 px-4  w-100 gap-4 gap-sm-3 d-flex justify-content-between align-items-start flex-column">
                    <div class="d-flex gap-3 mb-2 justify-content-start align-items-center other-user">
                        <i class="fa-solid fa-user"></i>
                        <h5>${element['username']}</h5>
                    </div>`
                    if(element['type_']==1){
                        str+= `
                        <p>wants to access to your API : ${element['api_name']}</p>
                        <div class="w-100 d-flex justify-content-start gap-4">
                            <button type="submit" class='deny yellow-btn' data-id=${element['id']}
                            data-api-id=${element['api_id']} data-from=${element['from_']}
                            >
                            Deny
                            </button>

                            <button type="submit" class='allow lightBlue-btn' data-id=${element['id']}
                            data-api-id=${element['api_id']} data-from=${element['from_']}
                            >Allow
                        </button>
                        </div>
                        `
                    }
                    else if(element['type_']==2){
                        str+= `
                        <p style='color:green;'>allowed your access to API : ${element['api_name']}</p>
                        `
                    }
                    else if(element['type_']==3){
                        str+= `
                        <p style='color:red;'>denied your access to API : ${element['api_name']}</p>
                        `
                    }
                    
                        str+= `
                        <div class="w-100 d-flex justify-content-end gap-4">`
                        if(element['type_']!==1){
                            str+=`<button type="submit" class="read_notif yellow-btn" data-id=${element['id']}>Read</button>`
                        }
                            str+=`<span class="w-100 text-end mt-2">
                                <i color="gray-color">2025-06-10</i>
                            </span>
                        </div>`
                        
                    
                    
                str+= `</div>`
            
        })
        all_readed();
    }
    else{
        str+= `
        <h6>No notifications</h6>
        `
    }


    document.querySelector('.only-notif').innerHTML = str
    read_();
    allow();
    deny();
    
}



function notif_count(d){
    let bell = document.getElementById('notif_bell')
    bell.classList.add('fa-shake')
    let c = document.getElementById('notif_count')
    c.style.display = 'block'
    c.innerHTML = d
    if(d>99){
        c.innerHTML = '99+'
    }
}

function all_readed(){
    document.getElementById('readAll_notif').addEventListener('click',async function(){
        let p = `notification`
        let data = {
            'readAll':true
        }
        fetchPOST(p,data);
        location.reload()
    })
}

function allow(){
    let btns =  document.querySelectorAll('.allow')
    btns.forEach(element => {
        element.addEventListener('click',async function(){
            let id = element.getAttribute('data-id');
            let api_id = element.getAttribute('data-api-id');
            let from = element.getAttribute('data-from');
            let p = `notification/${id}`
            let data = {
                'notif':true,
                'api_id':api_id,
                'from':from
            }

            fetchPOST(p,data);
            location.reload()
        })  
    })
}


function deny(){
    let btns =  document.querySelectorAll('.deny')
    btns.forEach(element => {
        element.addEventListener('click',async function(){
            let id = element.getAttribute('data-id');
            let api_id = element.getAttribute('data-api-id');
            let from = element.getAttribute('data-from');
            let p = `notification/${id}`
            let data = {
                'notif':false,
                'api_id':api_id,
                'from':from
            }

            fetchPOST(p,data);
            location.reload()
        })  
    })
}

function read_(){
    let btns =  document.querySelectorAll('.read_notif')
    btns.forEach(element => {
        element.addEventListener('click',async function(){
            let id = element.getAttribute('data-id');
            let p = `notification/${id}`
            let data = {
                'readAll':false
            }

            fetchPOST(p,data);
            location.reload()
        })  
    })
}

function user_info(data){
    sessionStorage.setItem('id',data['id'])
    sessionStorage.setItem('email',data['email'])
    sessionStorage.setItem('username',data['username'])
    
}


function drawApi(data){
    // let box = document.getElementById('api_box')
    let str = ''
    if(data.length!==0){
        data.forEach(element => {
           

                str+= `
                    <div data-id='${element['id']}' class="api_  d-flex justify-content-between align-items-center flex-column">`
                    str+=`<h5 data-id=${element['id']}  contentEditable class='api_name_ lightBlue-color'>
                        ${element['api_name']}
                    </h5>`
                        if(element['type']!==null){
                            str+=`
                                <div class="w-100 d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="w-auto">
                                        <i>Type: ${element['type']}</i>
                                    </span>
                            
                            
                                   <label for="status${element['id']}">`
                                   if(element['public']==1){
                                    str+=`  <input  type="checkbox" 
                                    id="status${element['id']}" checked 
                                    class="api_status" data-id="${element['id']}">
                                    Public`
                                    }
                                    else{
                                        str+=`  <input type="checkbox" 
                                        id="status${element['id']}" 
                                        class="api_status" data-id="${element['id']}">
                                        Public`
                                    }
                                       
                                    str+=`</label>`
                        str+=`
                                </div>
                        
                                <div class="w-100 pb-3 d-flex justify-content-between flex-wrap gap-2">
    
                                    <button class='links_btn middleBlue-btn' type="submit"
                                     data-name=${element['api_name']}>
                                        Copy link <i class="fa-solid fa-paperclip"></i>
                                    </button>
    
                                    <a href="/create_api/backend/index.php/view/${element['id']}" 
                                    target="blank">
                                        <button type="submit" class='yellow-btn view_btn'>
                                            <i class="fa-regular fa-eye"></i>
                                            View
                                            
                                        </button>
                                    </a>
                                    <button type="submit" class='edit_btn pink-btn'
                                     data-id=${element['id']} data-type=${element['type']} data-name=${element['api_name']}>
                                        Edit
                                    </button>
                                    
                                </div>
                                <div class="w-100 d-flex justify-content-between">
                                    <button type="submit" data-name=${element['api_name']} class="delete_btn lightBlue-btn" data-id=${element['id']} data-type=${element['type']}>
                                       <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                    <span>
                                        <i>${element['date']}</i>
                                    </span>
                                </div>
                            `
                        }

                        else{
                            str+=`
                            <div class="w-100 d-flex justify-content-between pb-3">
                                <button type="submit"
                                class='continue_btn middleBlue-btn'
                                data-id=${element['id']} data-name=${element['api_name']}>
                                    Continue
                                </button>
                                <button type="submit" class="delete_btn lightBlue-btn" data-name=${element['api_name']} data-id=${element['id']} data-type=${element['type']}>
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                                
                            </div>
                            <span>
                                <i>${element['date']}</i>
                            </span>
                            `
                        }

                str+= ` </div>`
        });

        document.getElementById('api_box').innerHTML = str
        delete_api();
        edit_api();
        continue_();
        api_status();
        api_name_edit();
        copy_link();
        // view_btn()
    }
    else{

        str+= `<h6>You dont have any API</h6>`
        document.getElementById('api_box').innerHTML = str
    }

    
}



function delete_api(){
    let btns = document.querySelectorAll('.delete_btn')
    btns.forEach(element => {
        element.addEventListener('click',async function() {
            let id = element.getAttribute('data-id')
            let type = element.getAttribute('data-type')
            const name = element.getAttribute('data-name')
            const prom = await del_promission(name);
            
            console.error(prom=="1" ? 'yesss' : 'ni')
            if(prom=="1"){
                let p = `api/${id}`
                let data = {
                    'delete_api':type
                }

                let res = await fetchDELETE(p,data);
                if(res.message){
                    location.reload()
                }
            }
           
        })
    })
}

function del_promission(name){
    return new Promise((resolve)=>{
        let parent = document.querySelector('.delete_permission_cont')
        parent.style.transform = "scale(1)"
        parent.querySelector('.delete_permission_area').querySelector('b').innerHTML = name
        
        let btns = document.querySelectorAll('.promise_btns')
        btns.forEach(btn=>{
            btn.addEventListener('click', function(){
                parent.style.transform = "scale(0)"
                resolve(btn.getAttribute('data-status'));
            })  
        })
    })
}


function edit_api(){
    let btns = document.querySelectorAll('.edit_btn')
    btns.forEach(element => {
        element.addEventListener('click',async function() {
            let id = element.getAttribute('data-id')
            let type = element.getAttribute('data-type')
            let name = element.getAttribute('data-name')
            let p = `api/${id}`
            let data = {
                'type': type,
                'name':name
            }
            sessionStorage.setItem('view',true)
            let res = await fetchPUT(p,data); 
            if(res.message){
                window.location.href='/create_api/frontend/html/pages/table.html'
            }
        })
    })
}




function continue_(){
    let btns = document.querySelectorAll('.continue_btn')
    btns.forEach(element => {
        element.addEventListener('click',async function() {
            let id = element.getAttribute('data-id')
            let name = element.getAttribute('data-name')
            let p = `api/${id}`
            let data = {
                'continue_api':true,
                'name':name
            }
            sessionStorage.setItem('continue',true)
            let res = await fetchPUT(p,data);
            if(res.message){
                window.location.href='/create_api/frontend/html/pages/selectApi.html'
            }
        })
    })
}






function api_status(){
    let btns = document.querySelectorAll('.api_status')
    btns.forEach(element => {
        element.addEventListener('click',async function() {
            let id = element.getAttribute('data-id')
            let check = element.checked ? 1 : 0;
            let p = `api/${id}`
            let data = {
                'api_status':check
            
            }
            fetchPUT(p,data);
        })
    })
}





function api_name_edit(){
    let hs =  document.querySelectorAll('.api_name_')
    hs.forEach(element => {
        element.addEventListener('blur',async function(){
            let id = element.getAttribute('data-id')
            let p = `api/${id}`
            let data = {
                'apiNameEdit':element.innerHTML
            }
            fetchPUT(p,data);            
        })
    })
}

