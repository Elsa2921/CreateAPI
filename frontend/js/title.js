document.getElementsByTagName('title')[0].innerHTML = 'CreateAPI'
const links = [
    {
        'rel':'apple-touch-icon',
        'href':'/frontend/images/favicon.png'
    },
    {
        'rel':'icon',
        'href':'/frontend/images/favicon.png'
    }
]

links.forEach(element => {
    let link = document.createElement('link')
    link.rel = element.rel
    link.href = element.href
    document.head.appendChild(link)
});
