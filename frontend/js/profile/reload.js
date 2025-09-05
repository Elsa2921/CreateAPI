import { fetchGET,fetchDELETE, fetchPUT, fetchPOST} from "../script.js"
import {copy_link} from "../pages/link.js"


window.onload = async() => {
    let data = {
        "reload1" : true,
        'profile':true
    }
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
                        <div class="btn-box w-100 d-flex justify-content-start gap-4">
                            <button type="submit" class='deny' data-id=${element['id']}
                            data-api-id=${element['api_id']} data-from=${element['from_']}
                            >
                            Deny
                            </button>

                            <button type="submit" class='allow' data-id=${element['id']}
                            data-api-id=${element['api_id']} data-from=${element['from_']}
                            style="background-color: rgb(93,161,234); border-color: rgb(93,161,234);"
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
                        <div class="btn-box w-100 d-flex justify-content-end gap-4">`
                        if(element['type_']!==1){
                            str+=`<button type="submit" class="read_notif" data-id=${element['id']}>Read</button>`
                        }
                            str+=`<span class="w-100 text-end mt-2">
                                <i style="color: gray;">2025-06-10</i>
                            </span>
                        </div>`
                        
                    
                    
                str+= `</div>`
            
        })
        all_readed();
    }
    else{
        str+= `
        <h4>No notifications</h4>
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
        let data = {
            'all_read_notif':true,
        }
        fetchPOST(data);
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
            let data = {
                'allow_notif':true,
                'id':id,
                'api_id':api_id,
                'from':from
            }

            fetchPOST(data);
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
            let data = {
                'deny_notif':true,
                'id':id,
                'api_id':api_id,
                'from':from
            }

            fetchPOST(data);
            location.reload()
        })  
    })
}

function read_(){
    let btns =  document.querySelectorAll('.read_notif')
    btns.forEach(element => {
        element.addEventListener('click',async function(){
            let id = element.getAttribute('data-id');
            let data = {
                'read_notif':true,
                'id':id
            }

            fetchPOST(data);
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
                    str+=`<h4 data-id=${element['id']}  contentEditable class='api_name_'>
                        ${element['api_name']}
                    </h4>`
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
                        
                                <div class="btn-box w-100 pb-3 d-flex justify-content-between flex-wrap gap-2">
    
                                    <button class='links_btn' type="submit" style="background-color:
                                    rgb(51, 92, 129); border-color: rgb(51, 92, 129);"
                                     data-name=${element['api_name']}>
                                        Copy link <i class="fa-solid fa-paperclip"></i>
                                    </button>
    
                                    <a href="/create_api/backend/requests/view.php?apiView=${encodeURIComponent(true)}&name=${encodeURIComponent(element['api_name'])}&type=${encodeURIComponent(element['type'])}" 
                                    target="blank">
                                        <button type="submit" class='view_btn'>
                                            <i class="fa-regular fa-eye"></i>
                                            View
                                            
                                        </button>
                                    </a>
                                    <button type="submit" class='edit_btn'
                                     data-id=${element['id']} data-type=${element['type']} data-name=${element['api_name']}>
                                        Edit
                                    </button>
                                    
                                </div>
                                <div class="btn-box w-100 d-flex justify-content-between">
                                    <button type="submit" class="delete_btn" data-id=${element['id']} data-type=${element['type']}>
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
                            <div class="btn-box w-100 d-flex justify-content-between pb-3">
                                <button type="submit" style="background-color:
                                rgb(51, 92, 129); border-color: rgb(51, 92, 129);" 
                                class='continue_btn'
                                data-id=${element['id']} data-name=${element['api_name']}>
                                    Continue
                                </button>
                                <button type="submit" class="delete_btn" data-id=${element['id']} data-type=${element['type']}>
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

        str+= `<h3>You dont have any API</h3>`
        document.getElementById('api_box').innerHTML = str
    }

    
}



function delete_api(){
    let btns = document.querySelectorAll('.delete_btn')
    btns.forEach(element => {
        element.addEventListener('click',async function() {
            let id = element.getAttribute('data-id')
            let type = element.getAttribute('data-type')
            let data = {
                'delete_api':true,
                'id':id,
                'type': type
            }

            let res = await fetchDELETE(data);
            if(res.message){
                location.reload()
            }
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
            let data = {
                'edit_api':true,
                'id':id,
                'type': type,
                'name':name
            }
            sessionStorage.setItem('view',true)
            let res = await fetchPUT(data); 
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
            let data = {
                'continue_api':true,
                'id':id,
                'name':name
            }
            sessionStorage.setItem('continue',true)
            let res = await fetchPUT(data);
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
            let data = {
                'api_status':check,
                'id':id,
            
            }
            fetchPUT(data);
        })
    })
}





function api_name_edit(){
    let hs =  document.querySelectorAll('.api_name_')
    hs.forEach(element => {
        element.addEventListener('blur',async function(){
            let id = element.getAttribute('data-id')
            let data = {
                'apiNameEdit':true,
                'id':id,
                'name': element.innerHTML
            }
            fetchPUT(data);            
        })
    })
}

