import $ from 'jquery';

$('#location_add').css('display', 'none')

$('#location_add_contrat').val(0)


$('.card').on('click', function() {
	let active
	if (!$(this).hasClass('active')) active = false
	else active = true

	$('.card').removeClass('active')

	if (!active) $(this).addClass('active')
	else $(this).removeClass('active')

	$('#location_add_contrat').val($(this).attr('data'))
})