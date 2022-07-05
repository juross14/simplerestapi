<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HTML 5 Boilerplate</title>
  </head>
  <body>
    <div class="container-fluid">
        <section class="apicol ">
            <div class="container">
                <h2>GET</h2>
                <button class="btn btn-primary mb-4 fetchBtn">Fetch Posts</button>
                <div id="getValues" class="getData">      
                </div>
            </div>   
        </section>

        <section class="apicol ">
            <div class="container">
                <h2>POST</h2>
                <form name="fetch">
                    <div class="rendered-form">
                        <div class="formbuilder-text form-group field-postitle">
                            <label for="postitle" class="formbuilder-text-label">Title</label>
                            <input type="text" class="form-control" name="title" access="false" id="postitle">
                        </div>
                        <div class="formbuilder-textarea form-group field-postbody">
                            <label for="postbody" class="formbuilder-textarea-label">Body</label>
                            <textarea type="textarea" class="form-control" name="content" access="false" id="postbody"></textarea>
                            <input type="hidden" class="form-control" name="status" access="false" id="postitle" value="publish">
                        </div>
                        <div class="formbuilder-button form-group field-Submit">
                            <button type="submit" class="btn-default btn" name="Submit" access="true" style="default" id="Submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>   
        </section>


        <section class="apicol ">
            <div class="container">
                <h2>UPDATE</h2>
                <form name="updatefetch">
                    <div class="rendered-form">
                        <div class="formbuilder-text form-group field-postitle">
                            <label for="postitle" class="formbuilder-text-label">id</label>
                            <input type="text" class="form-control" name="id" access="false" id="postID">
                        </div>    
                        <div class="formbuilder-text form-group field-postitle">
                            <label for="postitle" class="formbuilder-text-label">Title</label>
                            <input id="putIDtitle" type="text" class="form-control" name="title" access="false" id="postitle">
                        </div>
                        <div class="formbuilder-textarea form-group field-postbody">
                            <label for="postbody" class="formbuilder-textarea-label">Body</label>
                            <textarea id="putIDbody" type="textarea" class="form-control" name="content" access="false"></textarea>
                            <input type="hidden" class="form-control" name="status" access="false" id="putStatus" value="publish">
                        </div>
                        <div class="formbuilder-button form-group field-Submit">
                            <button type="submit" class="btn-default btn" name="Submit" access="true" style="default" id="Submit">Submit</button>
                        </div>
                    </div>
                </form>                
            </div>   
        </section>


        <section class="apicol ">
            <div class="container">
                <h2>DELETE</h2>
                <form name="deletefetch">
                    <div class="rendered-form">
                        <div class="formbuilder-text form-group field-postitle">
                            <label for="postitle" class="formbuilder-text-label">id</label>
                            <input type="text" class="form-control" name="id" access="false" id="postIDdel">
                        </div>    
                        <div class="formbuilder-button form-group field-Submit">
                            <button type="submit" class="btn-default btn" name="Submit" access="true" style="default" id="Submit">Submit</button>
                        </div>
                    </div>
                </form>                 
            </div>   
        </section>
    </div>


	<script>

    const globalurl = 'https://jsonplaceholder.typicode.com/posts';
    const wpResturl = 'http://localhost/offdev/wp-json/wp/v2/posts';

    async function apiGet() {

    let headers = new Headers();
        headers.append('Accept', 'application/json');
        headers.append("Authorization", "Basic YWRtaW46WkJwVyB4QWVlIEEwcEEga3AwTSB0aDdwIFFUdHI=");        
        
        const response = await fetch(wpResturl, {
            method: 'GET',
            headers: headers,
            mode: 'cors'
        });
        const results = await response.json();
            if (!response.ok) {
                // get error message from body or default to response status
                const error = (data && data.message) || response.status;
                return Promise.reject(error);
            }

        return results;
    }

    function fetchPosts(){
        apiGet().then(res => {
            document.getElementById('getValues').innerHTML =  res.slice(0, 5).map(item => 
                `<div class="col-ge">
                    <div class="bodyrest">id: ${item.id}</div>
                    <div class="titlerest">Title: ${item.title.rendered}</div>
                    <div class="bodyrest">Body: ${item.content.rendered}</div>
                </div>`
            ).join('')
        }).catch( err => {
                console.log('Please Fix your Error');
                console.log(err);
            }
        ); }

    document.querySelector('.fetchBtn').addEventListener('click', fetchPosts);    

    //POST
    const formPost = document.forms.fetch;
    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const body = JSON.stringify(Object.fromEntries(new FormData(e.target)));
                const response = await postForm(body);
                const data = await response.json();
                    if (!response.ok) {
                        // get error message from body or default to response status
                        const error = (data && data.message) || response.status;
                        return Promise.reject(error);
                    }

                console.log(data); 
                alert("Your Data Is Added");
                formPost.reset();
                //location.reload();
        }
        catch(err){
            console.log(err);
            console.log("Custom Error")
        }

    };

    const postForm = (body) => {
        let username = 'admin';
        let password = 'ZBpW xAee A0pA kp0M th7p QTtr';

        let headers = new Headers();
            headers.append("Authorization", "Basic YWRtaW46WkJwVyB4QWVlIEEwcEEga3AwTSB0aDdwIFFUdHI=");
            //headers.append('Authorization', 'Basic ' + base64.encode(username + ":" + password));
            headers.append("Content-Type", "application/json");

            const PostURL = fetch(wpResturl, {
                method: 'POST',
                headers: headers,
                body: body,
                redirect: 'follow'
            });
        return PostURL;
    };

    formPost.addEventListener('submit', handleSubmit);

    //PUT
    const formPut = document.forms.updatefetch;
    const handleSubmitPut = async (e) => {
        e.preventDefault();
        try {
            //const bodyPut = JSON.stringify(Object.fromEntries(new FormData(e.target)));
            const valuesPut = { 
                                "title": document.querySelector("#putIDtitle").value,
                                "content": document.querySelector("#putIDbody").value,
                                "status":document.querySelector("#putStatus").value
                            };
            const bodyPut = JSON.stringify(valuesPut);
            console.log(bodyPut);             

                const response = await putForm(bodyPut);
                alert("Your Data Is Update");
                const data = await response.json();
                    if (!response.ok) {
                        // get error message from body or default to response status
                        const error = (data && data.message) || response.status;
                        return Promise.reject(error);
                    }

               
                formPut.reset();
                //location.reload();
        }
        catch(err){
            console.log(err);
            console.log("Custom Error")
        }

    };
 
    function putForm(bodyPut) {
        let headers = new Headers();
            headers.append("Authorization", "Basic YWRtaW46WkJwVyB4QWVlIEEwcEEga3AwTSB0aDdwIFFUdHI=");
            headers.append("Content-Type", "application/json");

            let idselector = document.querySelector("#postID").value;

            const wpResturlPut = `http://localhost/offdev/wp-json/wp/v2/posts/${idselector}`;

            const PutURL = fetch(wpResturlPut, {
                method: 'PUT',
                headers: headers,
                body: bodyPut,
                redirect: 'follow'
            });
        return PutURL;
    };

    formPut.addEventListener('submit', handleSubmitPut);

    //DELETE
    const formDel = document.forms.deletefetch;
    const handleSubmitDel = async (e) => {
        e.preventDefault();
        try {

                const response = await delForm();

                const data = await response.json();
                console.log("Your Data Is Deleted");
                alert("Your Data Is Deleted");
                
                    if (!response.ok) {
                        // get error message from body or default to response status
                        const error = (data && data.message) || response.status;
                        return Promise.reject(error);
                    }

               
                formDel.reset();
                //location.reload();
        }
        catch(err){
            console.log(err);
            console.log("Custom Error")
        }

    };

    const delForm = () => {
        let headers = new Headers();
            headers.append("Authorization", "Basic YWRtaW46WkJwVyB4QWVlIEEwcEEga3AwTSB0aDdwIFFUdHI=");
            headers.append("Content-Type", "application/json");
            let idselector = document.querySelector("#postIDdel").value;
            const wpResturlPut = `http://localhost/offdev/wp-json/wp/v2/posts/${idselector}`;

            const DelURL = fetch(wpResturlPut, {
                method: 'DELETE',
                headers: headers
            });
        return DelURL;
    };

    formDel.addEventListener('submit', handleSubmitDel);   





    </script>
    <style>
        .col-ge {
            padding: 20px;
            border: 1px solid;
            margin-bottom: 10px;
        }

        .titlerest {
            margin-bottom: 10px;
            font-size: 20px;
            font-weight: bold;
        }

        .bodyrest {
            font-size: 15px;
        }
    </style>    
  </body>
</html>