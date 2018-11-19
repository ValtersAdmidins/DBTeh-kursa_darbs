$(document).ready(function(){
    
    $('#country_from').on('change', function(){
        var countryFrom_ID = $(this).val();
        if(countryFrom_ID) {
            $.ajax({
                type: 'POST',
                url: 'ajax/locationSelection.php',
                data: 'country_from_ID=' + countryFrom_ID,
                success: function(html) {
                    $('#city_from').html(html);
                }
            });
        } else {
            $('#city_from').html('<option value="">Izvēlēlieties valsti vispirms</option>');
        }
    });

    $('#country_to').on('change', function(){
        var countryTo_ID = $(this).val();
        if(countryTo_ID) {
            $.ajax({
                type: 'POST',
                url: 'ajax/locationSelection.php',
                data: 'country_to_ID=' + countryTo_ID,
                success: function(html) {
                    $('#city_to').html(html);
                }
            });
        } else {
            $('#city_to').html('<option value="">Izvēlēlieties valsti vispirms</option>');
        }
    });
    
});