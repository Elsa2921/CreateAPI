import {fetchGET } from "../script.js"
export function copy_link(){
    let btns =  document.querySelectorAll('.links_btn')
    btns.forEach(element => {
        element.addEventListener('click',async function(){
            let data = {
                'getLink':true
            }
            let res = await fetchGET(data);
            let name = element.getAttribute('data-name')
            
            let link = res+''+encodeURIComponent(name)
            
            navigator.clipboard.writeText(link)


            document.querySelector('.cont-info').style.transform = 'scale(1)'
            
            close_info()
        })
    })
}



function close_info(){
    let x = document.querySelector('#close_info')
    x.addEventListener('click',function(){
        document.querySelector('.cont-info').style.transform = 'scale(0)'

    })
}
export function ask(){
    let btns = document.querySelectorAll('.permission_btn')
    btns.forEach(element => {
        element.addEventListener('click',async function(){
            let id = element.getAttribute('data-id')
            let data = {
                'ask_permission':true,
                'id':id
            }

            let res =await fetchGET(data);
            if(res.error){
                alert(res.error)
            }
            else if(res.message){
                if(res.message=='ok'){
                    alert('request sent!')
                }
            }
        })
    });
}