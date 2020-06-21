$(document).ready(()=>{
	console.log("ok");
	const base_url = `http://localhost/sipenda`;
	$.ajax({
		url : `${base_url}/get_all_peserta`,
		dataType : "json",
		success : (rest)=>{
			console.log(rest);
		},
		error : (err) => {
			console.log(err)
		}
	});
	$(".tbody-peserta").html()
});
