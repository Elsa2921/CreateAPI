import { fetchPOST,fetchGET,fetchPUT,fetchDELETE } from "../script.js";
import { checker } from "./apiTypes.js";




if(sessionStorage.getItem('view')){
    document.getElementById('back').href = '/create_api/frontend/html/profile/profile.html'
}

window.onload = async() => {
    let data = {
        "reload1" : true,
        'table' : true
    }
        let res = await fetchGET(data);
    
        if(res.message){
            if(res.message=='no'){
                window.location.href  = '../../../index.html'
            }
            else{
                let data = res.message
                
                // let data = 
                document.getElementById('tableApiName').innerHTML = data['table']['api_name']
                document.getElementById('apiType').innerHTML = "type: "+" "+data['table']['type']
                if(data['table_data']){
                    addLine();
                    draw_table(data);
                    
                }
               
                sessionStorage.setItem('type',data['table']['type'])
                sessionStorage.setItem('id',data['info']['id'])
                sessionStorage.setItem('email',data['info']['email'])
                sessionStorage.setItem('username',data['info']['username'])
            }
        }
}


function draw_table(data){
    let header = data['table_data'][0];
    let str = '';
    str+=`<tr>`
    for(let i in header){
        if(i!=='api_id'){
                            
            str+=`
                <th>${i}</th>
            `
        }
                   
    }
    str+=`
        <th>delete</th>
        `
    str+=`</tr>`


    let api_data = data['table_data']
                    // str+=`<tr>`
    let id = 0;
    api_data.forEach(element => {
        id++
        str += `<tr data-id="${element['id']}">`
        str+= `<td>${id}</td>`
        for(let i in element){
            if(i!=='id' && i!=='api_id'){
                
                str+= `<td contentEditable data-col='${i}' data-id='${element['id']}' class='td'>
                ${element[i]}
                </td>`

            }
        }

        if(id!==1){
            str+= `<td>
                <button data-id="${element['id']}" class='delete_btn'>
                    <i class='fa-solid fa-trash'></i>
                </button>
            </td>`
        }
        
                        
        str += `</tr>`
    });
    document.getElementById('api_table').innerHTML = str
    delete_line();
    edit()
}


function edit(){
    let tds = document.querySelectorAll('.td')
    tds.forEach(element => {
        element.addEventListener('blur',async function () {
            let value = element.innerHTML
            let id = element.getAttribute('data-id')
            let col = element.getAttribute('data-col')
            if(value.trim()!==''){
                let data = {
                    'edit':true,
                    'col':col,
                    'id':id,
                    'value':value,
                    'table':true
                }
                
                let res = await fetchPUT(data)
                if(res.error){
                    alert(error)
                }
            }
            
        })
    });
}

function delete_line(){
    let btns=  document.querySelectorAll('.delete_btn')
    btns.forEach( btn => {
        btn.addEventListener('click', async function(){
            let id = btn.getAttribute('data-id')
            let flag;
            
            if(sessionStorage.getItem('type')){
                
                let type  = sessionStorage.getItem('type')
                // flag = checker(type);
                // if(flag){
                    
                    let data = {
                        'delete_line': true,
                        'table_type': type,
                        'id' : id
                    }
        
                    let res = await fetchDELETE(data)
                    if(res.message){
                        location.reload()
                    }
                // }
            }
            // 
            
           
        })
    })
}


function addLine(){
    let btn = document.getElementById('addLine')
    btn.addEventListener('click',async function() {
        let data=  {
            'addLine':true
        }
        let res = await fetchPOST(data)
        if(res.message){
            
            location.reload()
        }
        else if(res.error){
            alert(res.error)
        }
    })
}