$(document).ready(function(){

    var countryFrom_ID = $('#country_from :selected').val();
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
        $('#city_from').html('<option value="">Izvēlēlieties valsti vispirms*</option>');
    }

    var countryTo_ID = $('#country_to :selected').val();
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
        $('#city_to').html('<option value="">Izvēlēlieties valsti vispirms*</option>');
    }

    $('#country_from').change(function(){
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
            $('#city_from').html('<option value="">Izvēlēlieties valsti vispirms*</option>');
        }
    });

    $('#country_to').change(function(){
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
            $('#city_to').html('<option value="">Izvēlēlieties valsti vispirms*</option>');
        }
    });
    
});