function confirming(id) {
  var txt;
  if (confirm("are you sure you want to delete this pet?")) {
    txt = "You pressed OK!";
    document.getElementById(id).submit();
  } else {
    txt = "You pressed Cancel!";
  }
}
