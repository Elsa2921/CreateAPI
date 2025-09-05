function handleCredentialResponse(response) {
    const idToken = response.credential;

    fetch("/create_api/backend/index.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ id_token: idToken,google_auth:true})
    }).then(res => res.json())
      .then(data => {
          if(data['status']){
            if(data['status']=='success'){
                sessionStorage.setItem('email',data['email'])
                sessionStorage.setItem('username',data['username'])
                window.location.href = '/create_api/frontend/html/profile/profile.html';
            }
          }
          else if(data['error']){
            alert(data['error'])
          }
      });
}


