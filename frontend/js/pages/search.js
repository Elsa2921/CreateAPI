import {fetchGET } from "../script.js";
import {drawApi} from "./othersApi.js"
if(document.querySelector('.search')){
    search_form()
}


function search_form(){
    const forms = document.querySelectorAll('.search_form')
    forms.forEach(element =>{
        element.addEventListener('submit',async function(ev){
            ev.preventDefault();
            const input = element.querySelector('.search')
            const v = input.value
            if(v.trim()!==''){
                
                let data = `search=${input.getAttribute('data-value')}&value=${encodeURIComponent(v)}`
                let res = await fetchGET(data)
                if(res.api_search){
                    drawApi(res.api_search,3);
                }
                else if(res.user_search){
                    drawUsers(res.user_search);
                }
                close();
                document.querySelector('.search_res_area').style.left='0'
            }
            
        })
    })
}



function drawUsers(data){
    let str = ``
    if(data.length==0){
        str+=`
            <h4>404</h4>
        `
    }
    else{
        data.forEach(element=>{
            str+= `
                <div data-id='${element['id']}' class="user_p_o d-flex justify-content-between align-items-center flex-wrap">
                    <div class='d-flex justify-content-between align-items-center gap-3'>
                        <i class='fa-solid fa-user'></i>
                        <h5>${element['username']}</h5>
                    </div>
                    <button data-id='${element['id']}' class='visit-user'>Visit</button>
                </div>
            `
        })
    }


    document.querySelector('.search_res_box').innerHTML = str
    visit()
}



function visit(){
    let btns = document.querySelectorAll('.visit-user')
    btns.forEach(element=>{
        element.addEventListener('click', async function(){
            let data = {
                'visit':true,
                'id':element.getAttribute('data-id')
            }
            let res = await fetchGET(data);
            if(res.message){
                if(res.message == 'ok'){
                    window.location.href = '../../html/pages/othersProfile.html'
                }
            }
        })
    })
}

function close(){
    let close = document.getElementById('close_')
    close.addEventListener('click',function(){
        document.querySelector('.search_res_area').style.left='-1000px'
    })
}