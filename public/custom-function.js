function buatAngka(num, fraction = 2) {
    num = num || 0;

    const is_negative = num.toString().charAt(0) == "-" ? true : false;

    num = num.toString().replace(/[^\d\.]/g, "");

    return Intl.NumberFormat(
        'en-US', {
        minimumFractionDigits: fraction,
        maximumFractionDigits: fraction,
        },
    ).format(is_negative ? num * -1 : num);
    //.replace(".00",""); //Add replace by RIN 31-05-2021
}

function cleanAngka(str = '') {
    unformated = str.replace(/[^\d\.\-]/g, "");
    if (isNaN(parseFloat(unformated))) {
      return 0;
    } 
  
    return parseFloat(unformated);
}
  
function round(val, dec = 2) {
    return Number(Math.round(val + 'e' + dec) + 'e-' + dec);
}

function formatAngka() {
    $(document).ready(function() {
      $(".format-angka").unbind("change");
      $(".format-angka").change(function() {
        return $(this).val(buatAngka($(this).val()));
      });
  
      $('.format-angka-enter').on('keyup', function(e){
          if (e.keyCode === 13 ) {
            let key = $(this).attr('id').replace(/[A-Za-z$-]/g, "");
            let id_name = $(this).attr('id').replace(/[0-9]/g, "");
            key = parseInt(key)+1;
            $('#'+id_name+key).focus().select();
            return $(this).val(buatAngka($(this).val()));
          }
      });
  
      $('.bukan-angka-enter').on('keyup', function(e){
          if (e.keyCode === 13 ) {
            let key = $(this).attr('id').replace(/[A-Za-z$-]/g, "");
            let id_name = $(this).attr('id').replace(/[0-9]/g, "");
            key = parseInt(key)+1;
            $('#'+id_name+key).focus().select();
            return $(this).val($(this).val());
          }
      });
  
      $(".format-int").unbind("change");
      $(".format-int").change(function() {
        return $(this).val(buatAngka($(this).val(), 0));
      });
  
      $(".format-angka-ratio").unbind("change");
      $(".format-angka-ratio").change(function() {
        return $(this).val(buatAngka($(this).val(), 4));
      });
    });
}