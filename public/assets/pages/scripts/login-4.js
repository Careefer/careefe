var Login = function () {

	
    
    return {
        //main function to initiate the module
        init: function () {
        	
            // init background slide images
		    $.backstretch([
		        "http://projects.thesparxitsolutions.com/SIS554/public/assets/pages/media/bg/4.jpg",
		        "http://projects.thesparxitsolutions.com/SIS554/public/assets/pages/media/bg/3.jpg",
		        "http://projects.thesparxitsolutions.com/SIS554/public/assets/pages/media/bg/1.jpg",
		        "http://projects.thesparxitsolutions.com/SIS554/public/assets/pages/media/bg/2.jpg",
		        ], {
		          fade: 1000,
		          duration: 8000
		    	}
        	);
        }
    };

}();

jQuery(document).ready(function() {
    Login.init();
});