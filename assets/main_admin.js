window.addEventListener("load", function () {
    //store tabs variables
    var tabs = this.document.querySelectorAll("ul.nav-tabs > li");

    //click tab
    for (i = 0; i < tabs.length; i++) {
        tabs[i].addEventListener("click", switchTab);
    }
    //remove active class from all else
    function switchTab(event) {
        console.log(event);
        event.preventDefault();

        document.querySelector("ul.nav-tabs li.active").classList.remove("active");
        document.querySelector(".tab-pane.active").classList.remove("active");

        var clickedTab = event.currentTarget;
        var anchor = event.target;
        var activePaneID = anchor.getAttribute("href");

        clickedTab.classList.add("active");

        document.querySelector(activePaneID).classList.add("active");

        console.log(clickedTab);
        console.log(anchor);
        console.log(activePaneID);
        // document.querySelector(clickedTab.id)
    }

    //add class to tab clicked


});


