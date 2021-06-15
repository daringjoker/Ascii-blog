let vis_toggle=document.querySelectorAll(".visibility");
let category_select=document.querySelectorAll(".cat");
let dlt_btn=document.querySelectorAll(".delete");
let pub_btn=document.querySelectorAll(".publish");
let post_titles=document.querySelectorAll(".post-title");
let edit_link=document.querySelectorAll(".edit");

// edit_link.forEach((item)=>item.addEventListener("click",
//     function (e) {
//         let slug = e.target.getAttribute("data-post-id");
//         document.location="edit.php?slug="+slug;
//     }));

post_titles.forEach(item=>item.addEventListener('dblclick',(e)=>{
    e.target.setAttribute("contenteditable",'true');
    e.target.focus();
}));
post_titles.forEach(item=>item.addEventListener("focusout",e=>{
    //console.log("blur event triggered");
    if(e.target.getAttribute("contenteditable")!=="true")
    {
        return;
    }
    e.target.removeAttribute("contenteditable");
    let slug=e.target.getAttribute("data-post-id");
    let newTitle=e.target.innerText;
    msg = postData("api.php?action=updateTitle", {"slug": slug, 'title': newTitle});
    msg.then(data => {
            console.log(data);
            if (data !== 'success') {
                console.log("Changing title failed");
                document.location.reload();
            }
        }
    );
}));


vis_toggle.forEach((item)=>item.addEventListener('click',
    function (e){
    let slug=e.target.getAttribute("data-post-id");
    console.log("the value is currently "+e.target.checked);
    let value=(e.target.checked);
    if(value)
        msg=postData("api.php?action=show",{"slug":slug});
    else
        msg=postData("api.php?action=hide",{"slug":slug});
    msg.then(data=>{
        if(data!=='success')
        {
            e.target.checked=!e.target.checked;
        }
    }
    );
    }
    ))

category_select.forEach((item)=>item.addEventListener("change",
    function (e) {
        let slug = e.target.getAttribute("data-post-id");
        let newCat = e.target.value;
        msg = postData("api.php?action=updateCategory", {"slug": slug, 'category': newCat});
        msg.then(data => {
                console.log(data);
                if (data !== 'success') {
                    console.log("Changing category failed");
                    document.location.reload();
                }
            }
        );
    }));

dlt_btn.forEach((item)=>item.addEventListener("click",
    function (e){
        let slug=e.target.getAttribute("data-post-id");
        let decision=confirm("Are you sure you want to delete this post?");
        if (decision)
        {
            msg = postData("api.php?action=delete", {"slug": slug});
            msg.then(data => {
                    console.log(data);
                    if (data !== 'success') {
                        console.log("Changing category failed");
                        return;
                    }
                    document.location.reload();
                }
            );
        }
    }
));
pub_btn.forEach((item)=>item.addEventListener("click",
    function (e){
        console.log("publishing...")
        let slug = e.target.getAttribute("data-post-id");
        msg = postData("api.php?action=publish", {"slug": slug});
        msg.then(data => {
            console.log('data');
            if (data !== 'success') {
                console.log("publishing failed");
                return;
            }
            document.location.reload();
            }
        );
    }
))

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