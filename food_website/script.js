window.onscroll = function() { stickySubmenu() };

var submenu = document.querySelector('.subcategory-count-container');
var sticky = submenu.offsetTop;

function stickySubmenu() {
  if (window.pageYOffset > sticky) {
    submenu.classList.add('fixed');
  } else {
    submenu.classList.remove('fixed');
  }
}



