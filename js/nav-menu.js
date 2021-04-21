$(function(){
  let navMenuToggler  = $("nav button.navbar-toggler");
  let dropdownToggler = $("a.nav-link.dropdown-toggle");

  navMenuToggler.on("click", function(e){
    e.preventDefault();
    let navigation = $(this).attr("data-target");
    $(navigation).toggleClass("open");
  });

  dropdownToggler.on("click", function(e){
    e.preventDefault();
    $(this).siblings().toggleClass("open");
  });
});
