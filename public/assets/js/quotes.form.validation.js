  $(function () {
        $("#start_date").datepicker({
            numberOfMonths: 2,
            dateFormat: 'yy-mm-dd',
            onSelect: function(selected) {
                $("#end_date").datepicker("option","minDate", selected)
            }
        });
        $("#end_date").datepicker({
          dateFormat: 'yy-mm-dd',
          numberOfMonths: 2,
          onSelect: function(selected) {
              $("#start_date").datepicker("option","maxDate", selected)
          }
      });
});


function isEmail(email) {
  		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  		if(regex.test(email)){
  			return true;
  		}
  		return false;
}
function isDate(date) {
  		var regex = /^\d{4}-\d{1,2}-\d{1,2}$/;
  		if(regex.test(date)){
  			return true;
  		}
  		return false;
}
function isCompanySymbol(symbol) {

  	     if( $.inArray(symbol, companySymbol) >= 0)
                  return true;
            return false;
}



$('#company_symbol').on('change', function() {
          if(isCompanySymbol( this.value)){
              $(this).next().text('');
           }
           else{
              $(this).next().text('Please insert a valid company  symbo.');
            }
});
$('#email').on('change', function() {
		if(isEmail( this.value)){
			$(this).next().text('');
		}
		else{
			$(this).next().text('Please insert a valid email address.');
		}
});
$('.date').on('change', function() {
		if(isDate( this.value)){
			$(this).next().text('');
                  if( this.id==="end_date" )
                  {
                      startDate = $("#start_date").val();
                      if(new Date(startDate).getTime()  > new Date(this.value).getTime() )
                      {
                            $(this).next().text('The end date must be a date after ' + startDate + '.');
                      }
                  }
		}
		else{
			$(this).next().text('Please insert a valid date (yyyy-mm-dd).');
		}

});



$("#search_quotes").submit(function() {
            //return true; // check the server side validation
  		var error = false;
  		$('input.required').each(function() {
    			if ($(this).attr('id') == 'company_symbol' && !isCompanySymbol($(this).val())) {
    				error = true;
    			}
    			if ($(this).attr('id') == 'email' && !isEmail($(this).val())) {
    				error = true;
    			}

    			if ($(this).attr('class') == 'date' && !isDate($(this).val())) {
    				error = true;
    			}
        });


			if(error){
				if($("#error-alert").length ){
					$("#error-alert").text('Please fill the form with correct value');
				}else{
					$("#search_quotes").append('<div id="error-alert" class="alert alert-danger"></div>');
					$("#error-alert").text('Please fill the form with correct value');
				}
				$('#search_quotes > input[type="submit"]').addClass("disabled");
				$("#error-alert").fadeTo(2000, 500).slideUp(500, function(){
    						$('#search_quotes > input[type="submit"]').removeClass('disabled');});
				return false;
			}else{
				return true;
  			}
  			return false;
});
