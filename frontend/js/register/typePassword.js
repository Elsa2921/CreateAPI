if(document.querySelector('.eye_area')){
    pass()
}


function pass(){
    let eyes = document.querySelectorAll('.eye_area')
    eyes.forEach((eye)=>{
        let count=  0;
        eye.addEventListener('click',function(){
            count++;
            let num=  eye.getAttribute('data-num')
            let pass= document.querySelector(`input[data-num="${num}"]`)
            let e = document.querySelector(`div[data-num="${num}"]`)
            if(count%2==1){
                pass.type = 'text'
                e.innerHTML = '<i class="fa-regular fa-eye-slash"></i>'
            }
            else{
                pass.type=  'password'
                e.innerHTML = '<i class="fa-regular fa-eye"></i>'
            }
        })
    })
}