$(function() {
	$("#wrap").removeClass("hide");
	margin();
	$(window).resize(margin);
	
	$("#search_form").submit(function() {
		location.href = "/w/" + $("#search_input", this).val();
		return false;
	});
	$("#newform").submit(function() {
		var d = $(this).attr("new");
		
		$.ajax({
			type: "post",
			url: $(this).attr("action"),
			data: {make: d, con: $("#content", this).val()},
			dataType: "json",
			success:function(r) {
				if (r.type == "err") {
					alert(r.data);
					return false;
				}
				location.replace('/w/' + d);
			}
		});
		return false;
	});
	$("#search_input").keydown(function() {
		var i = $(this).val();
		var list = $("#search #sslist");
		list.html("");
		
		$.ajax({
			type:'post',
			url: '/handle/search',
			data: {search: i},
			dataType: 'json',
			success: function(r) {
				
				for (var i=0; i<r.length; i++) {
					var s = r[i].subject;
					list.append("<a href='/w/"+s+"'>" + s+"</a>");
				}
			}
		});
	});
});
function search() {
	$("#search").slideToggle();
}
function margin() {
	var h = $("#header");
	var b = $("#body");
	
	var resize = h.height() + 100;
	
	b.css("margin-top", resize + "px");
}