
//kad se promeni ukupan broj soba kreiraj dodatna polja za sobe
$( "#broj_soba" ).change(function() {
var $sobe_html="";
for (let i = 0; i < $("#broj_soba").val(); i++) { 
 
 var $sobe_html=$sobe_html+'<div class="input-field col s6"><input id="soba" type="text" name="soba" class="validate soba" value="soba '+(i+1)+'"></div>';
 
}	
$( "#imena_soba" ).html($sobe_html);  
});


// aktivira se kada je forma submitovana


$(document).on('click', '#submit', function(){	

form_data=this;

var l = $('.soba').length;
//pripremi niz za sve brojeve soba
var sobe = [];
for (i = 0; i < l; i++) { 
  //Pushuj sve sobe u jedan niz
  sobe.push($('.soba').eq(i).val());
}

var form_data={'naziv':$('#naziv').val(),'skraceni_naziv':$('#skraceni_naziv').val(),'broj_soba':$('#broj_soba').val(),'opis':$('#opis').val(),'cena':$('#cena').val(),'soba':sobe};	
form_data= JSON.stringify(form_data);
console.log('podaci sa forme:');
console.log(form_data);
// posalji podatke apiju
$.ajax({
    url: "http://localhost/zadatak/api/tip_sobe/create.php",
    type : "POST",
    contentType : 'application/json',
	dataType: "json",
    crossDomain: true,
    data : form_data,
    success : function(result) {
    // tip sobe je kreiran, refreshuj tabelu
	alert('podatak uspesno unet');
       showRooms();
    },
    error: function(xhr, resp, text) {
        // prikazi gresku u konzoli
        console.log(xhr, resp, text);
		showRooms();		
    }

});

return false;

});


// funkcija za serijalizaciju podataka
$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

// funkcija da prikaze listu tipova soba
function showRooms(){
	
    json_url="http://localhost/zadatak/api/tip_sobe/read.php";
    // preuzmi listu tipova soba iz APIja
    $.getJSON(json_url, function(data){
 
        // html za listu tipova soba
        readRoomTypeTemplate(data, "");       
 
    });
}
function readRoomTypeTemplate(data){
	
    var read_products_html=`
        
    
 
        <!-- start table -->
        <table class='table table-bordered table-hover' style='margin-left:center;margin-right:center'>
 
            <!-- creating our table heading -->
            <tr>
				<th></th>
                <th class='w-25-pct'>Naziv</th>
                <th class='w-10-pct'>Skraceni naziv</th>
                <th class='w-15-pct'>Opis</th>
				<th class='w-15-pct'>Cena</th>
				<th class='w-15-pct'>Broj soba</th>
                <th class='w-25-pct text-align-center'>Akcija</th>
            </tr>`;
 
    // loop kroz vracene podatke
    $.each(data.records, function(key, val) {
 
        // cita redove podataka
        read_products_html+=`<tr>
            <td><i class="medium material-icons">airline_seat_individual_suite</i></td>
            <td>` + val.naziv + `</td>
            <td>` + val.skraceni_naziv + `</td>
            <td>` + val.opis + `</td>
			<td>` + val.cena + `</td>
			<td>` + val.broj_soba + `</td>
            <!-- 'action' buttons -->
            <td>
 
                <!-- delete button -->
                <button class='btn btn-danger delete-room-type-button' data-id='` + val.id + `'>
                    <span class='glyphicon glyphicon-remove'></span> Obrisi
                </button>				 
            </td>
        </tr>`;
    });
 
    // kraj tabele
    read_products_html+=`</table>`;
	$("#tipovi_soba").html(read_products_html);
}

$(document).ready(function(){
// aktivira se kad se klikne na dugme za brisanje
    $(document).on('click', '.delete-room-type-button', function(){	
 	
        // preuzmi id tipa sobe
	var room_type_id = $(this).attr('data-id');	
	console.log(JSON.stringify({ id: room_type_id }));
    // posalji delete request serveru	
    $.ajax({
        url: "http://localhost/zadatak/api/tip_sobe/delete.php",
        type : "DELETE",
        dataType : 'json',
        data : JSON.stringify({ id: room_type_id }),
        success : function(result) {
		alert('podatak uspesno obrisan');
        // osvezi listu tipova soba			  
            showRooms();
        },
        error: function(xhr, resp, text) {
 			
            console.log(xhr, resp, text);			
        }
    });
	});
	
});


