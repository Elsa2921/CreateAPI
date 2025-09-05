export function alert_message(mes){
    alert(mes)
}


export function w_location(loc){
    window.location = loc
}


export function regEx_checker(data){
    const patterns = regex_p();
    let result = [];

    for(const key in data){
        if(patterns[key]){
            result[key] = patterns[key].test(data[key])
        }
    }

    return result;
}




function regex_p(){
    const patterns =  {
        email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
        password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^!&*(),.?":{}<>]).{8,}$/,
        username: /^[a-z0-9_]{3,12}$/
    };
    return patterns;
}



async function fetchAPI(url, data = {}, method = "GET") {
    try {
        let options = { method, headers: {} };
        let finalURL = url;

        if (["GET", "DELETE"].includes(method)) {
            const params = new URLSearchParams(data).toString();
            if (params) finalURL += `?${params}`;
        } else {
            options.headers["Content-Type"] = "application/json";
            options.body = JSON.stringify(data);
        }

        const res = await fetch(finalURL, options);

        const contentType = res.headers.get("content-type") || "";
        const responseData = contentType.includes("application/json")
            

        return await res.json();
    } catch (error) {
        console.error(`${method} request error:`, error.message);
        return null;
    }
}
const link = '/create_api/backend/index.php'

export const fetchGET = (data) => fetchAPI(link, data, 'GET');
export const fetchPOST = (data) => fetchAPI(link, data, 'POST');
export const fetchPUT = (data) => fetchAPI(link, data, 'PUT');
export const fetchDELETE = (data) => fetchAPI(link, data, 'DELETE');


