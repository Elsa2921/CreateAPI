
    const types = [
        'users_api',
        'tasks',
        'notifications_api',
        'products',
        'movies',
        'podcast',
        'blog',
        'wheather',
        'programmin_l',
        'comments',
        'books',
        'quiz',
        'calendar',
        'workout',
        'flight'
    ];
    


export function checker(type){
    let flag = false;
    for(let i of types){
        if(i==type){
            flag = true;
            break;
            
        }
    }
    return flag;
}

