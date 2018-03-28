function addFormItem(id, data) {
	if (typeof data == "undefined") {
		data = {};
	};
	data.id = id;
	var source = $("#item-template").html();
	var template = Handlebars.compile(source);
	var html = template(data);
	$('#items-container').append(html);
}

function addProjectItem(id, department) {
		data = {};
	data.id = id;
	data.department = department;
	var source = $("#item-template").html();
	var template = Handlebars.compile(source);
	var html = template(data);
	$('#items-container-'+department).append(html);
}

function removeFormItem(id) {
	$("#item-"+id).remove();
}

function calculte_items() {
	window.total_item_value = 0;
	$(".item-quantity").each(function(){
		window.total_item_value += $(this).val()*$(this).attr("data-value");
	});

	$("#budget").val(fixate(window.total_item_value)).change();
}

function fixate($num) {
	return $num.toFixed(2);
}


$(document).on('click', '.edit-btn', function(){

	var destination = $.attr(this, 'href');

	$(this).closest("tr").find(".orig").each(function(){
		$(destination).find("#"+$.attr(this, 'data-mirror')).val($(this).html());
	});

    $('html, body').animate({
        scrollTop: $( destination ).offset().top
    }, 500);
    return false;
});

$(document).on('click', '.clear-btn', function(){

	var destination = $.attr(this, 'href');

	$(destination).find(".clearable").val("");
	return false;
});

$(document).on('click', '#edit', function() {
	$(".edit").toggle();
	$(".non-edit").toggle();
});

$(document).on('click', '.printer, .submitter', function() {
	$(".holder").show("fast");
});

$(document).on('click', '#add-item', function() {
	var itemId = parseInt($('#items-container').attr('data-items'))+1;
	addFormItem(itemId);
	$('#items-container').attr('data-items', itemId);
});


$(document).on('click', '.add-item', function() {
	var department = $(this).attr('data-department');
	var itemId = parseInt($('#items-container-'+department).attr('data-items'))+1;
	addProjectItem(itemId, department);
	$('#items-container-'+department).attr('data-items', itemId);
});

$(document).on('click', '.remove-item', function(){
	removeFormItem($(this).attr('data-item-id'));
});

$(document).on('change', '#from-hotel', function(){
	var company_id = $('option:selected', this).attr('data-company');
	$('#from-company').val(company_id);
});

$(document).on('change', '#to-hotel', function(){
	var company_id = $('option:selected', this).attr('data-company');
	$('#to-company').val(company_id);
});

$(document).on('change', '.unique-plan', function(){
	$('#message-area').html("").hide();
	var hotel_id = $('#hotel').val();
	var year = $('#year').val();
	if (hotel_id > 0 && year > 0) {
		$.ajax({
			url:"/plans/check/"+hotel_id+"/"+year,
			success: function(data) {
				if (data) {
					$('#message-area').html("Budget for this hotel already exists, and signed for year "+year).show();
					$('#submit').hide();
				} else {
					$('#message-area').html("").hide();
					$('#submit').show();
				}
			}
		});
	};
});


//budget_calculations//

$(document).on('change', '.budget-calc', function(){
	eur = $("#budget_eur").val()*$("#eur_ex").val();
	usd = $("#budget_usd").val()*$("#usd_ex").val();
	egp = $("#budget_egp").val();

	$("#budget").val(Number(eur)+Number(usd)+Number(egp));
});

///budget calculations///


//cost_calculations//

$(document).on('change', '.cost-calc', function(){
	eur = $("#cost_eur").val()*$("#eur_ex").val();
	usd = $("#cost_usd").val()*$("#usd_ex").val();
	egp = $("#cost_egp").val();

	$("#cost").val(Number(eur)+Number(usd)+Number(egp));
});

///cost calculations///

//true_calculations//

$(document).on('change', '.true-calc', function(){
	eur = $("#true_eur").val()*$("#eur_ex").val();
	usd = $("#true_usd").val()*$("#usd_ex").val();
	egp = $("#true_egp").val();

	$("#true").val(Number(eur)+Number(usd)+Number(egp));
});

///true calculations///

//item calculation//

$(document).on('change', '.item-quantity', function(){
	$(this).parent().next().html( $(this).val()*$(this).attr("data-value") + " EGP");
	calculte_items();
});


$(document).ready(function(){
	$(".chooosen").chosen();
	if (!$.isEmptyObject(document.items)) {
		removeFormItem(1);
		for (i in document.items) {
			addFormItem(i, document.items[i]);
		}
	};
});