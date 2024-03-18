window.addEventListener("message", function(event){
    try {
        var recipes = JSON.parse(JSON.parse(event.data).localStorage.qcart_recipes).length;
        console.log("recipes", recipes);
    } catch(e) {}    
});
var iframe = document.createElement("iframe");
iframe.style.display = "none";
iframe.src = "https://qcart.app/track.html";
document.body.appendChild(iframe);