function gotoEditPage(id)
{
       var pageid = document.getElementById(id).value;
       if(pageid == 0)
      	 location.href="?load=admin&op=pages";
	   else
  		 location.href="?load=admin&op=pages&edit="+pageid;
}