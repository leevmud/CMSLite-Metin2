// Modal Login-Register
const modalRegister = document.querySelector(".modal-register")
const modalLogin = document.querySelector(".modal-login")
//Register
document.querySelectorAll(".btn-register").forEach(function(btn){
    btn.addEventListener("click", function(){      
        if(modalRegister.classList.contains("active")){
            modalRegister.classList.remove("active")
            modalLogin.classList.add("active")
            document.querySelectorAll('.response-form').forEach(function(btn){
                btn.innerHTML = ''
            })
            
        }
        
    })
})

//Login
document.querySelectorAll(".btn-login").forEach(function(btn){
    btn.addEventListener("click", function(){
        if(modalLogin.classList.contains("active")){
            modalLogin.classList.remove("active")
            modalRegister.classList.add("active")
            document.querySelectorAll('.response-form').forEach(function(btn){
                btn.innerHTML = ''
            })
        }
    })
})

//CloseModal
document.querySelectorAll(".fa-times").forEach(function(btn){
    btn.addEventListener("click", function(){
        modalRegister.classList.add("active")
        modalLogin.classList.add("active")

        document.querySelector('#username').value = ''
        document.querySelector('#password').value = ''
        document.querySelector('#re-password').value = ''
        document.querySelector('#email').value = ''
        document.querySelector('#re-email').value = ''

        //login
        document.querySelector('#login').value = ''
        document.querySelector('#pass').value = ''
    })
})


//////////////////////////////////////////////////////////////////
//Form Register - Login
//Register
document.registerForm.onsubmit = async e =>{
    e.preventDefault()

    const disableBtn = document.querySelector('#btn-send-form-register')
    disableBtn.setAttribute('disabled', 'disabled')
    disableBtn.classList.add('grayscale')
    setTimeout(function(){
        disableBtn.removeAttribute('disabled')
        disableBtn.classList.remove('grayscale')
    }, 3000)

    const msg = document.querySelector('.response-form')
    msg.classList.remove('failed-create')
    msg.classList.remove('success-create')  
    
    sendFormRegister()
} 

//Login
document.loginForm.onsubmit = async e =>{
    e.preventDefault()

    const disableBtn = document.querySelector('#btn-send-form-login')
    disableBtn.setAttribute('disabled', 'disabled')
    disableBtn.classList.add('grayscale')
    setTimeout(function(){
        disableBtn.removeAttribute('disabled')
        disableBtn.classList.remove('grayscale')
    }, 3000)

    const msg = document.querySelector('.response-form')
    msg.classList.remove('failed-create')
    msg.classList.remove('success-create')  
    
    sendFormLogin()
} 

function sendFormRegister(){
    const xhr = new XMLHttpRequest()
    const url = '/criar-conta'

    const username = document.querySelector('#username')
    const password = document.querySelector('#password')
    const rePassword = document.querySelector('#re-password')
    const email = document.querySelector('#email')
    const reEmail = document.querySelector('#re-email')
    const accept = document.querySelector('#accept')
    const gCaptcha = document.querySelector('#g-recaptcha-response')


    let data = `username=${username.value}&password=${password.value}&re-password=${rePassword.value}&email=${email.value}&re-email=${reEmail.value}&accept=${accept.value}&gcaptcha=${gCaptcha.value}`
    xhr.open('POST', url)
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            var returned_data = xhr.responseText
            setMsg(returned_data)
            grecaptcha.reset(widgetRegister);
        }
    }

    xhr.send(data)
}

function sendFormLogin(){
    const xhr = new XMLHttpRequest()
    const url = '/login'

    const username = document.querySelector('#login')
    const password = document.querySelector('#pass')
    const token = document.querySelector('#__token')
    const gCaptcha = document.querySelector('#g-recaptcha-response-1')

    let data = `username=${username.value}&password=${password.value}&token=${token.value}&gcaptcha=${gCaptcha.value}`
    xhr.open('POST', url)
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            var returned_data = xhr.responseText
            const resultado = JSON.parse(returned_data)
            if(resultado.redirect == true){
                window.location.href = "/minha-conta"
            }else{
                setMsg(returned_data)
                token.value = resultado.__token
                grecaptcha.reset(widgetLogin);
            }
        }
    }

    xhr.send(data)
}

function setMsg(mensagem){
    document.querySelectorAll('.response-form').forEach(function(btn){
        const result = JSON.parse(mensagem)
        btn.classList.add(result.type)
        btn.innerHTML = (result.msg)
    })
 
}

CKEDITOR.replace('textEditor')