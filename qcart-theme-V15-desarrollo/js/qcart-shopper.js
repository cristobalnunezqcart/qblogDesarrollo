<script>
    $(document).ready(function() {
    $('#abrirIframe').on('click', function(e) {
        e.preventDefault();
        
        var src = "https://smkts.qcart.app/cartanywhere.html?add=''";
        const iframe = document.createElement("iframe");
        iframe.className = "qcart-iframe";

        iframe.style.cssText = `
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            z-index: 2147483647;
            border: none;
            background-color: rgba(255,255,255,0.5);
            backdrop-filter: blur(3px);
            background-image: url(https://acegif.com/wp-content/uploads/loading-13.gif);
            background-size: 40px;
            background-repeat: no-repeat;
            background-position: 50%;
        `;

        iframe.onload = () => {
            iframe.style.background = "none";
        }

        iframe.src = src;
        document.body.appendChild(iframe);

        window.addEventListener('message', event => {
            const action = event.data?.action;
            if ("qcart-iframe-close" == action) {
            document.querySelectorAll(".qcart-iframe").forEach(i => i.remove());
            }
            if ("qcart-iframe-href" == action) {
            document.querySelectorAll(".qcart-iframe").forEach(i => i.remove());

            // stackoverflow.com/questions/46286766/cannot-catch-window-open-exception-in-safari
            let x;
            try {
                x = window.open(event.data?.href);
            } catch (e) { }
            if (!x) location.href = event.data?.href;

            }
            if ("qcart-parent-href" == action) {
            return location.href;
            }
        });        
      //  $('#iframeCarrito').attr('src', src);
        //$('#iframeCarrito').show();
    })
    });
</script>