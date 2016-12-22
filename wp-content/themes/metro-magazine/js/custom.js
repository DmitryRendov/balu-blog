jQuery(document).ready(function($){

    	$('#responsive-menu-button').sidr({
    		  name: 'sidr-main',
    		  source: '#site-navigation'
    	});

        $('#secondary-responsive-menu-button').sidr({
            name: 'responsive-sidr-main',
            source: '.secondary-menu'
        });
    
        // Get the modal
        var modal = document.getElementById('formModal');
        
        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");
        
        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];
        
        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }
        
        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        } 
});