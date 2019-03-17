var a = '';
function filterFunction(x) {
    var filter, ul, li, a, i;
    filter = x.toUpperCase();
    items = document.getElementsByClassName("searchableItem");    
    for (i = 0; i < items.length; i++) {
        txtValue = items[i].id
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            items[i].style.display = "";
        } else {
            items[i].style.display = "none";
        }
    }
}


function search() {
    newValue = document.getElementById('searchBox').value;
    if (a != newValue) {
        a = newValue;
        filterFunction(a);
    }
}
setInterval(search, 50)