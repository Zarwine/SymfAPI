class CommentAPI
{
    constructor()
    {
        this.APIUrl = document.getElementById("server-url").innerHTML + "api/"        
        this.commentContainer = document.getElementById("commentAPI")
        this.initComment()
    }

    async initComment()
    {
        const response = await fetch(this.APIUrl  + "comments")
        const comments = await response.json()
        {
            console.log(comments)
        }
    }
}

let commentAPI = new CommentAPI()