let content=document.querySelector("#content");
let summary=document.querySelector("#summary");

content.addEventListener("focusout",e=>{
    console.log("sending content...")
    let slug = e.target.getAttribute("data-post-id");
    let content=e.target.innerText;
    msg = postData("api.php?action=updateContent", {"slug": slug,"content":content});
    msg.then(data => {
            console.log(data);
            if (data !== 'success') {
                console.log("publishing failed");
                return;
            }
        }
    );
})

summary.addEventListener("focusout",e=>{
    console.log("sending summary...")
    let slug = e.target.getAttribute("data-post-id");
    let content=e.target.innerText;
    msg = postData("api.php?action=updateSummary", {"slug": slug,"summary":content});
    msg.then(data => {
            console.log(data);
            if (data !== 'success') {
                console.log("publishing failed");
                return;
            }
        }
    );
})

async function postData(url = '', data = {}) {
    // Default options are marked with *
    const response = await fetch(url, {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
            //'Content-Type': 'application/json'
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: toFormUrlEncoded(data) // body data type must match "Content-Type" header
    });
    return response.text(); // parses JSON response into native JavaScript objects
}
function toFormUrlEncoded(object) {
    return Object.entries(object)
        .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`)
        .join('&');
}